<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

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
    return $this->twig->render('couleur.html.twig');
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
}
