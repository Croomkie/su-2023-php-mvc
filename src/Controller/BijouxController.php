<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use PDO;
use App\Routing\Attribute\Authorize;


class BijouxController extends AbstractController
{

    /*--------------------------------------------- Ajout de bijoux --------------------------------------------*/

    /* Form controller */

    #[Authorize('Admin')]
    #[Route(path: '/formAjout', name: 'formAjout', httpMethod: "GET")]
    public function formAjout()
    {

        /* Préparation de la requête */
        $query = "SELECT * from categorie ";

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        // Fetch the results
        $listCategories = $statement->fetchAll(PDO::FETCH_ASSOC);

        /* Préparation de la requête */
        $query = "SELECT id,nom from couleur ";

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        // Fetch the results
        $listCouleur = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->renderTemplate('form_ajout.html.twig', ['listCategories' => $listCategories, 'listCouleur' => $listCouleur]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/addBijoux', name: 'addBijoux', httpMethod: "POST")]
    public function addBijoux()
    {
        $jewelName = $_POST['jewelName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $categoryID = $_POST['categoryID'];
        $colorID = $_POST['colorID'];

        /* Préparation de la requête */
        $query = "INSERT INTO bijoux (nom, description, prix, image, id_categorie, id_couleur) 
        VALUES (:nom, :description, :prix, :image, :id_categorie, :id_couleur)";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $jewelName);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':prix', $price);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':id_categorie', $categoryID);
        $statement->bindParam(':id_couleur', $colorID);

        $statement->execute();

        $message = 'Le bijou a été ajouté avec succès';

        // TODO Retourner la bonne view
        $this->renderTemplate('board_admin.html.twig', ['message' => $message]);
    }


    #[Authorize('Admin')]
    #[Route(path: '/updateBijou/{id}', name: 'updateBijou', httpMethod: "POST")]
    public function updateJewel($id)
    {
        
        
        
        
        var_dump($id);
        
        $jewelName = $_POST['jewelName'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $categoryID = $_POST['categoryID'];
        $colorID = $_POST['colorID'];


        /* Préparation de la requête */
        $query = "UPDATE bijoux SET nom = :nom, description = :description, prix = :prix, image = :image, 
        id_categorie = :id_categorie, id_couleur = :id_couleur, type=:type, WHERE id = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $jewelName);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':prix', $price);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':id_categorie', $categoryID);
        $statement->bindParam(':id_couleur', $colorID);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':type', $type);

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
        $query = "DELETE FROM bijoux WHERE id_bijou = :id";
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
        $queryBijoux = "SELECT * FROM bijoux";
        $statementBijoux = $this->pdo->prepare($queryBijoux);
        $statementBijoux->execute();
        $bijoux = $statementBijoux->fetchAll();

        // Retourne la bonne view avec les trois listes de bijoux
        $this->renderTemplate('precieuse.html.twig', ['bijouxRana' => $bijouxRana, 'bijouxTrilogy' => $bijouxTrilogy, 'bijouxPearl' => $bijouxPearl, 'bijouxFamily' => $bijouxFamily]);
    }

    #[Route(path: '/recupererCouleur', name: 'recupererCouleur', httpMethod: "GET")]
    public function recupererCouleurs()
    {
        /* Préparation de la requête pour récupérer les couleurs */
        $queryCouleurs = "SELECT * FROM couleur";
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
        $query = "UPDATE couleur SET nom = :nom, description = :description WHERE id_couleur = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $colorName);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':id',
            $id
        );

        $statement->execute();

        $message = 'La couleur a été mise à jour avec succès';


        // TODO Retourner la bonne view
        $this->renderTemplate('board_admin.html.twig', ['message' => $message]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/deleteColor/{id}', name: 'deleteColor', httpMethod: "POST")]
    public function deleteColor($id)
    {
        /* Préparation de la requête */
        $query = "DELETE FROM couleur WHERE id_couleur = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':id', $id);

        $statement->execute();

        $message = 'La couleur a été supprimée avec succès';


        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    #[Authorize('Admin')]
    #[Route(path: '/addColor', name: 'addColor', httpMethod: "POST")]
    public function addColor()
    {
        $colorName = $_POST['colorName'];
        $description = $_POST['description'];

        /* Préparation de la requête */
        $query = "INSERT INTO couleur (nom, description) VALUES (:nom, :description)";
        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':nom', $colorName);
        $statement->bindParam(':description', $description);

        $statement->execute();

        $message = 'La couleur a été ajoutée avec succès';

        // TODO Retourner la bonne view
        $this->renderTemplate('.html.twig', ['message' => $message]);
    }

    // #[Route(path: '/recupererBijoux', name: 'recupererBijoux', httpMethod: "GET")]
    // public function recupererBijoux()
    // {
    //     /* Préparation de la requête pour récupérer les bijoux */
    //     $queryBijoux = "SELECT * FROM bijoux";
    //     $statementBijoux = $this->pdo->prepare($queryBijoux);
    //     $statementBijoux->execute();
    //     $bijoux = $statementBijoux->fetchAll();

    //     // Retourne la bonne view avec les trois listes de bijoux
    //     $this->renderTemplate('precieuse.html.twig', ['bijouxRana' => $bijouxRana, 'bijouxTrilogy' => $bijouxTrilogy, 'bijouxPearl' => $bijouxPearl, 'bijouxFamily' => $bijouxFamily]);
    // }


    // #[Authorize('Admin')]
    // #[Route(path: '/recupererCouleurs', name: 'recupererCouleurs', httpMethod: "GET")]
    // public function recupererCouleurs()
    // {
    //     /* Préparation de la requête pour récupérer les couleurs */
    //     $queryCouleurs = "SELECT * FROM couleur";
    //     $statementCouleurs = $this->pdo->prepare($queryCouleurs);
    //     $statementCouleurs->execute();
    //     $couleurs = $statementCouleurs->fetchAll();

    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig', ['couleurs' => $couleurs]);
    // }

    // /* Ajouter une commande */
    // #[Authorize('Admin')]
    // #[Route(path: '/ajouter-commande', name: 'ajouterCommande', httpMethod: "POST")]
    // public function ajouterCommande()
    // {
    //     /* Récupérer les informations de la commande depuis le formulaire */
    //     $clientId = $_POST['clientId'];

    //     /* Préparation de la requête */
    //     $query = "INSERT INTO commmande (id_client) VALUES (:id_client)";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':id_client', $clientId);

    //     /* Exécution de la requête */
    //     $statement->execute();

    //     // TODO Retourner la bonne view
    //     return $this->twig->render('.html.twig');
    // }

    // /* Récupérer une commande */
    // #[Authorize('Admin')]
    // #[Route(path: '/recuperer-commande/{id}', name: 'recupererCommande', httpMethod: "GET")]
    // public function recupererCommande($id)
    // {
    //     /* Préparation de la requête */
    //     $query = "SELECT * FROM commande WHERE id_commande = :id";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':id', $id);

    //     /* Exécution de la requête */
    //     $statement->execute();
    //     $commande = $statement->fetch();

    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig', ['commande' => $commande]);
    // }

    // /* Récupérer toutes les commandes */
    // #[Authorize('Admin')]
    // #[Route(path: '/recuperer-commandes', name: 'recupererCommandes', httpMethod: "GET")]
    // public function recupererCommandes()
    // {
    //     /* Préparation de la requête */
    //     $query = "SELECT * FROM commande";
    //     $statement = $this->pdo->prepare($query);

    //     /* Exécution de la requête */
    //     $statement->execute();
    //     $commandes = $statement->fetchAll();


    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig', ['commandes' => $commandes]);
    // }

    // /* Modifier une commande */
    // #[Authorize('Admin')]
    // #[Route(path: '/modifier-commande/{id}', name: 'modifierCommande', httpMethod: "PUT")]
    // public function modifierCommande($id)
    // {
    //     /* Récupérer les nouvelles informations de la commande depuis le formulaire */
    //     $nouveauStatut = $_POST['nouveauStatut'];

    //     /* Préparation de la requête */
    //     $query = "UPDATE commande SET status = :nouveauStatut WHERE id_commande = :id";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':nouveauStatut', $nouveauStatut);
    //     $statement->bindParam(':id', $id);

    //     /* Exécution de la requête */
    //     $statement->execute();

    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig');
    // }

    // /* Supprimer une commande */
    // #[Authorize('Admin')]
    // #[Route(path: '/supprimer-commande/{id}', name: 'supprimerCommande', httpMethod: "DELETE")]
    // public function supprimerCommande($id)
    // {
    //     /* Préparation de la requête */
    //     $query = "DELETE FROM commande WHERE id_commande = :id";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':id', $id);

    //     /* Exécution de la requête */
    //     $statement->execute();

    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig');
    // }

    // #[Route(path: '/produit', name: 'produit', httpMethod: "GET")]
    // public function produit()
    // {
    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('produit.html.twig');
    // }

    #[Route(path: '/produit/{id}', name: 'recupererBijou', httpMethod: "GET")]
    public function recupererBijou($id)
    {
        var_dump($id);
        /* Préparation de la requête pour récupérer le bijou */
        $queryBijou = "SELECT * FROM Bijoux WHERE id = :id";
        $statementBijou = $this->pdo->prepare($queryBijou);
        $statementBijou->bindParam(':id', $id);
        $statementBijou->execute();
        $bijou = $statementBijou->fetch();

        // TODO Retourner la bonne view
        $this->renderTemplate('produit.html.twig', ['bijou' => $bijou]);
    }


    // #[Authorize('Admin')]
    // #[Route(path: '/ajouter-categorie', name: 'ajouterCategorie', httpMethod: "POST")]
    // public function ajouterCategorie()
    // {
    //     /* Récupérer les informations de la catégorie depuis le formulaire */
    //     $nomCategorie = $_POST['nom'];

    //     /* Préparation de la requête */
    //     $query = "INSERT INTO categorie (nom) VALUES (:nom)";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':nom', $nomCategorie);

    //     /* Exécution de la requête */
    //     $statement->execute();

    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig');
    // }

    // #[Authorize('Admin')]
    // #[Route(path: '/recuperer-categorie/{id}', name: 'recupererCategorie', httpMethod: "GET")]
    // public function recupererCategorie($id)
    // {
    //     /* Préparation de la requête */
    //     $query = "SELECT * FROM categorie WHERE id_categorie = :id";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':id', $id);

    //     /* Exécution de la requête */
    //     $statement->execute();
    //     $categorie = $statement->fetch();
    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig', ['categorie' => $categorie]);
    // }

    // #[Authorize('Admin')]
    // #[Route(path: '/supprimer-categorie/{id}', name: 'supprimerCategorie', httpMethod: "DELETE")]
    // public function supprimerCategorie($id)
    // {
    //     /* Préparation de la requête */
    //     $query = "DELETE FROM categorie WHERE id_categorie = :id";
    //     $statement = $this->pdo->prepare($query);

    //     /* Liaison des paramètres */
    //     $statement->bindParam(':id', $id);

    //     /* Exécution de la requête */
    //     $statement->execute();

    //     // TODO Retourner la bonne view
    //     $this->renderTemplate('.html.twig');
    // }
}

//test
