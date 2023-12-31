<?php

namespace App\Routing;

use App\Routing\Attribute\Authorize;
use App\Routing\Attribute\Route as RouteAttribute;
use App\Utils\Filesystem;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Router
{
  private const CONTROLLERS_GLOB_PATH = __DIR__ . "/../Controller/*Controller.php";

  public function __construct(
    private ContainerInterface $container,
    private ArgumentResolver $argumentResolver
  ) {
  }

  /** @var Route[] */
  private array $routes = [];

  public function addRoute(Route $route): self
  {
    $this->routes[] = $route;

    return $this;
  }

  public function getRoute(string $uri, string $httpMethod): ?Route
  {
    foreach ($this->routes as $route) {
      if ($this->argumentResolver->match($uri, $route) && $route->getHttpMethod() === $httpMethod) {
        $params = $this->argumentResolver->resolveUrlParams($uri, $route);

        $route->setUrlParams($params);
        return $route;
      }
    }

    return null;
  }

  /**
   * @param string $requestUri
   * @param string $httpMethod
   * @return void
   * @throws RouteNotFoundException
   */
  public function execute(string $requestUri, string $httpMethod)
  {
    $route = $this->getRoute($requestUri, $httpMethod);

    if ($route === null) {
      throw new RouteNotFoundException($requestUri, $httpMethod);
    }

    $controllerClass = $route->getController();
    $method = $route->getMethod();

    $this->verifyRole($controllerClass, $method);

    $constructorParams = $this->getMethodParams($controllerClass . '::__construct');
    $controllerInstance = new $controllerClass(...$constructorParams);

    $serviceParams = $this->getMethodParams($controllerClass . '::' . $method);

    $params = array_merge($serviceParams, $route->getUrlParams());

    echo call_user_func_array([$controllerInstance, $method], $params);
  }

  /**
   * Get an array containing services instances guessed from method signature
   *
   * @param string $method Format : FQCN::method
   * @return array The services to inject
   */
  private function getMethodParams(string $method): array
  {
    $params = [];

    try {
      $methodInfos = new ReflectionMethod($method);
    } catch (ReflectionException $e) {
      return [];
    }
    $methodParams = $methodInfos->getParameters();

    foreach ($methodParams as $methodParam) {
      $paramName = $methodParam->getName();
      $paramType = $methodParam->getType();

      // Add this check:
      if ($paramType === null) {
        continue; // Skip this iteration of the loop if the parameter type is not defined
      }

      $paramTypeName = $paramType->getName();
      if ($this->container->has($paramTypeName)) {
        $params[$paramName] = $this->container->get($paramTypeName);
      }
    }


    return $params;
  }

  public function registerRoutes(): void
  {
    // Explorer le dossier des classes de contrôleurs
    // Pour chacun d'eux, enregistrer les méthodes
    // donc les contrôleurs portant un attribut Route
    $classNames = Filesystem::getClassNames(self::CONTROLLERS_GLOB_PATH);

    foreach ($classNames as $class) {
      $fqcn = "App\\Controller\\" . $class;
      $classInfos = new ReflectionClass($fqcn);

      if ($classInfos->isAbstract()) {
        continue;
      }

      $methods = $classInfos->getMethods(ReflectionMethod::IS_PUBLIC);

      foreach ($methods as $method) {
        if ($method->isConstructor()) {
          continue;
        }

        $attributes = $method->getAttributes(RouteAttribute::class);

        if (!empty($attributes)) {
          $routeAttribute = $attributes[0];
          /** @var RouteAttribute */
          $routeAttribute = $routeAttribute->newInstance();
          $this->addRoute(new Route(
            $routeAttribute->getPath(),
            $fqcn,
            $method->getName(),
            $routeAttribute->getHttpMethod(),
            $routeAttribute->getName()
          ));
        }
      }
    }
  }

  private function verifyRole(string $controllerClass, string $method)
  {
    $reflection = new ReflectionMethod($controllerClass, $method);
    $authorizeAttributes = $reflection->getAttributes(Authorize::class);

    if (!empty($authorizeAttributes)) {
      // Vérifier si l'utilisateur est connecté
      if (!isset($_SESSION['user'])) {
        header("Location: /");
      }

      $authorizeAttribute = $authorizeAttributes[0];
      $roleRequired = $authorizeAttribute->newInstance()->role;

      // Vérifier si l'utilisateur a un rôle
      if (!isset($_SESSION['user']->role)) {
        header("Location: /");
      }

      if ($_SESSION['user']->role !== $roleRequired) {
        header("Location: /");
      }
    }
  }
}
