<?php

namespace App\Controller;

use Twig\Environment;
use PDO;
use PDOException;

abstract class AbstractController
{
  protected PDO $pdo;
  protected Environment $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
    $this->pdo = $this->connexion();
  }

  public function renderTemplate($template, $variables = null)
  {
    // Check session status
    $isUserLoggedIn = isset($_SESSION['user']);

    // Add isUserLoggedIn to the variables array
    $variables['isUserLoggedIn'] = $isUserLoggedIn;

    // Render Twig template
    echo $this->twig->render($template, $variables);
  }

  private function connexion()
  {
    // Connexion à la DB
    [
      'DB_HOST'     => $host,
      'DB_PORT'     => $port,
      'DB_NAME'     => $dbname,
      'DB_CHARSET'  => $charset,
      'DB_USER'     => $user,
      'DB_PASSWORD' => $password
    ] = $_ENV;

    $dsn = "mysql:dbname=$dbname;host=$host:$port;charset=$charset";

    try {
      $pdo = new PDO($dsn, $user, $password);
    } catch (PDOException $ex) {
      echo "Erreur lors de la connexion à la base de données : " . $ex->getMessage();
      exit;
    }

    return $pdo;
  }
}
