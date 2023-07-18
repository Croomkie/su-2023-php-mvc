<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use PDO;

class LoginController extends AbstractController
{
    #[Route("/login", name: "loginPage", httpMethod: "GET")]
    public function login()
    {
        return $this->twig->render('login.html.twig');
    }

    #[Route('/registerPage', name: "registerPage", httpMethod: "GET")]
    public function registerPage()
    {
        return $this->twig->render('register.html.twig');
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

        // Hashage du mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        /* Préparation de la requête */
        $query = "INSERT INTO clients (nom, motDePasse) VALUES (:nom, :motDePasse)";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $userName);
        $statement->bindParam(':motDePasse', $passwordHash);

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
        
        /* Si c'est un Admin TODO */
        else {
            /* On stocke en session les infos du user connecté */
            unset($user->password);
            $_SESSION['user'] = $user;

            return $this->twig->render('board_admin.html.twig');
        }
    }
}