<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use PDO;
use App\Model\User;
use App\Routing\Attribute\Authorize;

class LoginController extends AbstractController
{

    #[Route("/login", name: "loginPage", httpMethod: "GET")]
    public function login()
    {
        $this->renderTemplate('login.html.twig');
    }

    #[Route('/registerPage', name: "registerPage", httpMethod: "GET")]
    public function registerPage()
    {
        $this->renderTemplate('register.html.twig');
    }

    #[Authorize('Admin')]
    #[Route('/board', name: "board", httpMethod: "GET")]
    public function board()
    {
        $this->renderTemplate('board_admin.html.twig');
    }

    #[Route('/logout', name: "logout", httpMethod: "GET")]
    public function logout()
    {
        session_destroy();
        return $this->twig->render('login.html.twig');
    }

    #[Route(path: '/register', name: 'register', httpMethod: "POST")]
    public function register()
    {
        $userName = $_POST['_username'];
        $password = $_POST['_password'];
        $role = User::userRole;

        // Hashage du mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        /* Préparation de la requête */
        $query = "INSERT INTO clients (nom, motDePasse, Role) VALUES (:nom, :motDePasse, :Role)";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $userName);
        $statement->bindParam(':motDePasse', $passwordHash);
        $statement->bindParam(':Role', $role);

        $statement->execute();

        $inscription = 'Votre inscription à bien été enregistré, vous pouvez désormais vous connecter';

        return $this->twig->render('login.html.twig', ['inscription' => $inscription]);
    }

    #[Route(path: '/signIn', name: 'signIn', httpMethod: "POST")]
    public function signIn()
    {
        $userName = $_POST['_username'];
        $password = $_POST['_password'];

        /* Préparation de la requête */
        $query = "SELECT * FROM clients WHERE nom = :nom";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $userName);

        $statement->execute();

        // Fetch the results
        $user = $statement->fetch(PDO::FETCH_OBJ);
        if (empty($user) || !password_verify($password, $user->MotDePasse)) {
            $error = 'Le mot de passe ou le pseudo indiqué est erronée';
            return $this->twig->render('login.html.twig', ['error' => $error]);
        }
        else{
            unset($user->password);
            $_SESSION['user'] = $user;

            if ($user->Role == User::userRole) {
                $this->renderTemplate('index.html.twig');
            } elseif ($user->Role == User::adminRole) {
                $this->renderTemplate('board_admin.html.twig');
            }
        }
    }
}
