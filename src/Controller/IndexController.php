<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Routing\Attribute\Authorize;

class IndexController extends AbstractController
{
  #[Route("/", name: "homepage")]
  public function home(): string
  {
    return $this->twig->render('index.html.twig');
  }

  #[Route("/precieuse", name: "precieusepage")]
  public function precieuse(): string
  {
    return $this->twig->render('precieuse.html.twig');
  }

  #[Route("/impertinentes", name: "impertinentes")]
  public function impertinentes(): string
  {
    return $this->twig->render('impertinentes.html.twig');
  }

  #[Route("/unique", name: "unique")]
  public function unique(): string
  {
    return $this->twig->render('unique.html.twig');
  }

  #[Route("/couleur", name: "couleur")]
  public function couleur(): string
  {

    return $this->twig->render('Couleur.html.twig');
  }

  #[Route("/contact", name: "contact")]
  public function contact(): string
  {
    return $this->twig->render('contact.html.twig');
  }

  #[Route("/panier", name: "panier")]
  public function panier(): string
  {
    return $this->twig->render('panier.html.twig');
  }

  #[Route("/blog", name: "blog")]
  public function blog(): string
  {
    return $this->twig->render('blog.html.twig');
  }

  #[Route("/presentation", name: "presentation")]
  public function presentation(): string
  {
    return $this->twig->render('presentation.html.twig');
  }

  #[Route("/paiement", name: "paiement")]
  public function paiement(): string
  {
    return $this->twig->render('paiement.html.twig');
  }

  #[Route("/confirmation", name: "confirmation")]
  public function confirmation(): string
  {
    return $this->twig->render('confirmation.html.twig');
  }

  /* Form controller */
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
    return $this->twig->render('.html.twig', ['message' => $message]);
  }

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
    return $this->twig->render('.html.twig', ['message' => $message]);
  }

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
    return $this->twig->render('.html.twig', ['message' => $message]);
  }


  /* Ajout de bijoux */
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
    return $this->twig->render('.html.twig', ['message' => $message]);
  }

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

    return $this->twig->render('.html.twig', ['message' => $message]);
  }

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
    return $this->twig->render('.html.twig', ['message' => $message]);
  }

  #[Route(path: '/recupererBijoux', name: 'recupererBijoux', httpMethod: "GET")]
  public function recupererBijoux()
  {
    /* Préparation de la requête pour récupérer les bijoux */
    $queryBijoux = "SELECT * FROM Bijoux";
    $statementBijoux = $this->pdo->prepare($queryBijoux);
    $statementBijoux->execute();
    $bijoux = $statementBijoux->fetchAll();

    return $this->twig->render('afficherBijoux.html.twig', ['bijoux' => $bijoux]);
  }

  #[Route(path: '/recupererCouleurs', name: 'recupererCouleurs', httpMethod: "GET")]
  public function recupererCouleurs()
  {
    /* Préparation de la requête pour récupérer les couleurs */
    $queryCouleurs = "SELECT * FROM Couleurs";
    $statementCouleurs = $this->pdo->prepare($queryCouleurs);
    $statementCouleurs->execute();
    $couleurs = $statementCouleurs->fetchAll();

    return $this->twig->render('afficherCouleurs.html.twig', ['couleurs' => $couleurs]);
  }

  /* Ajouter une commande */
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

    return $this->twig->render('confirmationCommande.html.twig');
  }

  /* Récupérer une commande */
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

    return $this->twig->render('afficherCommande.html.twig', ['commande' => $commande]);
  }

  /* Récupérer toutes les commandes */
  #[Route(path: '/recuperer-commandes', name: 'recupererCommandes', httpMethod: "GET")]
  public function recupererCommandes()
  {
    /* Préparation de la requête */
    $query = "SELECT * FROM Commandes";
    $statement = $this->pdo->prepare($query);

    /* Exécution de la requête */
    $statement->execute();
    $commandes = $statement->fetchAll();

    return $this->twig->render('afficherCommandes.html.twig', ['commandes' => $commandes]);
  }

  /* Modifier une commande */
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

    return $this->twig->render('confirmationModificationCommande.html.twig');
  }

  /* Supprimer une commande */
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

    return $this->twig->render('confirmationSuppressionCommande.html.twig');
  }

  #[Route("/produit", name: "produit")]
  public function produit(): string
  {
    return $this->twig->render('produit.html.twig');
  }
}

//test
