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
}

//test
