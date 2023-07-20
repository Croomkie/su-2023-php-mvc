<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use PDO;
use App\Routing\Attribute\Authorize;


class BijouxController extends AbstractController
{



    /* Form controller */
    #[Route(path: '/formAjout', name: 'formAjout', httpMethod: "GET")]
    public function formAjout()
    {
        $this->renderTemplate('form_ajout.html.twig');
    }

    #[Authorize('Admin')]
    #[Route(path: '/addColor', name: 'addColor', httpMethod: "POST")]
    public function addColor()
    {
        $colorName = $_POST['colorName'];
        $description = $_POST['description'];

        /* Préparation de la requête */
        $query = "INSERT INTO Couleurs (Nom, Description) VALUES (:nom, :description)";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $colorName);
        $statement->bindParam(':description', $description);

        $statement->execute();

        $message = 'La couleur a été ajoutée avec succès';

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/updateColor/{id}', name: 'updateColor', httpMethod: "POST")]
    public function updateColor($id)
    {
        $colorName = $_POST['colorName'];
        $description = $_POST['description'];

        /* Préparation de la requête */
        $query = "UPDATE Couleurs SET Nom = :nom, Description = :description WHERE CouleurID = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $colorName);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':id', $id);

        $statement->execute();

        $message = 'La couleur a été mise à jour avec succès';


        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/deleteColor/{id}', name: 'deleteColor', httpMethod: "POST")]
    public function deleteColor($id)
    {
        /* Préparation de la requête */
        $query = "DELETE FROM Couleurs WHERE CouleurID = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':id', $id);

        $statement->execute();

        $message = 'La couleur a été supprimée avec succès';


        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }


    /* Ajout de bijoux */
    #[Authorize('Admin')]
    #[Route(path: '/addBijou', name: 'addBijou', httpMethod: "POST")]
    public function addJewel()
    {
        $jewelName = $_POST['jewelName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $categoryID = $_POST['categoryID'];
        $colorID = $_POST['colorID'];

        /* Préparation de la requête */
        $query = "INSERT INTO Bijoux (Nom, Description, Prix, Image, CatégorieID, CouleurID) 
              VALUES (:nom, :description, :prix, :image, :categorieID, :couleurID)";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $jewelName);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':prix', $price);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':categorieID', $categoryID);
        $statement->bindParam(':couleurID', $colorID);

        $statement->execute();

        $message = 'Le bijou a été ajouté avec succès';

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/updateBijou/{id}', name: 'updateBijou', httpMethod: "POST")]
    public function updateJewel($id)
    {
        $jewelName = $_POST['jewelName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $categoryID = $_POST['categoryID'];
        $colorID = $_POST['colorID'];

        /* Préparation de la requête */
        $query = "UPDATE Bijoux SET Nom = :nom, Description = :description, Prix = :prix, Image = :image, 
              CatégorieID = :categorieID, CouleurID = :couleurID WHERE BijouID = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $jewelName);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':prix', $price);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':categorieID', $categoryID);
        $statement->bindParam(':couleurID', $colorID);
        $statement->bindParam(':id', $id);

        $statement->execute();
        // TODO Retourner la bonne view
        $message = 'Le bijou a été mis à jour avec succès';

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/deleteBijou/{id}', name: 'deleteBijou', httpMethod: "POST")]
    public function deleteJewel($id)
    {
        /* Préparation de la requête */
        $query = "DELETE FROM Bijoux WHERE BijouID = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':id', $id);

        $statement->execute();

        $message = 'Le bijou a été supprimé avec succès';

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    #[Route(path: '/recupererBijoux', name: 'recupererBijoux', httpMethod: "GET")]
    public function recupererBijoux()
    {
        /* Préparation de la requête pour récupérer les bijoux */
        $queryBijoux = "SELECT * FROM Bijoux";
        $statementBijoux = $this->pdo->prepare($queryBijoux);
        $statementBijoux->execute();
        $bijoux = $statementBijoux->fetchAll();

        // TODO Retourner la bonne view
        $this->renderTemplate('precieuse.html.twig', ['bijoux' => $bijoux]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/recupererCouleurs', name: 'recupererCouleurs', httpMethod: "GET")]
    public function recupererCouleurs()
    {
        /* Préparation de la requête pour récupérer les couleurs */
        $queryCouleurs = "SELECT * FROM Couleurs";
        $statementCouleurs = $this->pdo->prepare($queryCouleurs);
        $statementCouleurs->execute();
        $couleurs = $statementCouleurs->fetchAll();

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['couleurs' => $couleurs]);
    }

    /* Ajouter une commande */
    #[Authorize('Admin')]
    #[Route(path: '/ajouter-commande', name: 'ajouterCommande', httpMethod: "POST")]
    public function ajouterCommande()
    {
        /* Récupérer les informations de la commande depuis le formulaire */
        $clientId = $_POST['clientId'];

        /* Préparation de la requête */
        $query = "INSERT INTO Commandes (ClientID) VALUES (:clientId)";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':clientId', $clientId);

        /* Exécution de la requête */
        $statement->execute();

        // TODO Retourner la bonne view
        return $this->twig->render('.html.twig');
    }

    /* Récupérer une commande */
    #[Authorize('Admin')]
    #[Route(path: '/recuperer-commande/{id}', name: 'recupererCommande', httpMethod: "GET")]
    public function recupererCommande($id)
    {
        /* Préparation de la requête */
        $query = "SELECT * FROM Commandes WHERE CommandeID = :id";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':id', $id);

        /* Exécution de la requête */
        $statement->execute();
        $commande = $statement->fetch();

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['commande' => $commande]);
    }

    /* Récupérer toutes les commandes */
    #[Authorize('Admin')]
    #[Route(path: '/recuperer-commandes', name: 'recupererCommandes', httpMethod: "GET")]
    public function recupererCommandes()
    {
        /* Préparation de la requête */
        $query = "SELECT * FROM Commandes";
        $statement = $this->pdo->prepare($query);

        /* Exécution de la requête */
        $statement->execute();
        $commandes = $statement->fetchAll();


        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['commandes' => $commandes]);
    }

    /* Modifier une commande */
    #[Authorize('Admin')]
    #[Route(path: '/modifier-commande/{id}', name: 'modifierCommande', httpMethod: "PUT")]
    public function modifierCommande($id)
    {
        /* Récupérer les nouvelles informations de la commande depuis le formulaire */
        $nouveauStatut = $_POST['nouveauStatut'];

        /* Préparation de la requête */
        $query = "UPDATE Commandes SET Statut = :nouveauStatut WHERE CommandeID = :id";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':nouveauStatut', $nouveauStatut);
        $statement->bindParam(':id', $id);

        /* Exécution de la requête */
        $statement->execute();

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig');
    }

    /* Supprimer une commande */
    #[Authorize('Admin')]
    #[Route(path: '/supprimer-commande/{id}', name: 'supprimerCommande', httpMethod: "DELETE")]
    public function supprimerCommande($id)
    {
        /* Préparation de la requête */
        $query = "DELETE FROM Commandes WHERE CommandeID = :id";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':id', $id);

        /* Exécution de la requête */
        $statement->execute();

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig');
    }

    #[Route("/produit", name: "produit")]
    public function produit()
    {
        return $this->renderTemplate('produit.html.twig');
    }

    #[Authorize('Admin')]
    #[Route(path: '/ajouter-categorie', name: 'ajouterCategorie', httpMethod: "POST")]
    public function ajouterCategorie()
    {
        /* Récupérer les informations de la catégorie depuis le formulaire */
        $nomCategorie = $_POST['nom'];

        /* Préparation de la requête */
        $query = "INSERT INTO Categories (Nom) VALUES (:nom)";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':nom', $nomCategorie);

        /* Exécution de la requête */
        $statement->execute();

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig');
    }

    #[Authorize('Admin')]
    #[Route(path: '/recuperer-categorie/{id}', name: 'recupererCategorie', httpMethod: "GET")]
    public function recupererCategorie($id)
    {
        /* Préparation de la requête */
        $query = "SELECT * FROM Categories WHERE CategorieID = :id";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':id', $id);

        /* Exécution de la requête */
        $statement->execute();
        $categorie = $statement->fetch();
        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['categorie' => $categorie]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/supprimer-categorie/{id}', name: 'supprimerCategorie', httpMethod: "DELETE")]
    public function supprimerCategorie($id)
    {
        /* Préparation de la requête */
        $query = "DELETE FROM Categories WHERE CategorieID = :id";
        $statement = $this->pdo->prepare($query);

        /* Liaison des paramètres */
        $statement->bindParam(':id', $id);

        /* Exécution de la requête */
        $statement->execute();

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig');
    }
}

//test
