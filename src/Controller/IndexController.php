<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Routing\Attribute\Authorize;

class IndexController extends AbstractController
{

  #[Route("/", name: "homepage")]
  public function home()
  {
    $this->renderTemplate('index.html.twig');
  }

  #[Route("/precieuse", name: "precieusepage")]
  public function precieuse()
  {
    $this->renderTemplate('precieuse.html.twig');
  }

  #[Route("/impertinentes", name: "impertinentes")]
  public function impertinentes()
  {
    $this->renderTemplate('impertinentes.html.twig');
  }

  #[Route("/unique", name: "unique")]
  public function unique()
  {
    $this->renderTemplate('unique.html.twig');
  }

  #[Route("/couleur", name: "couleur")]
  public function couleur()
  {

    $this->renderTemplate('Couleur.html.twig');
  }

  #[Route("/contact", name: "contact")]
  public function contact()
  {
    $this->renderTemplate('contact.html.twig');
  }

  #[Route("/panier", name: "panier")]
  public function panier()
  {
    $this->renderTemplate('panier.html.twig');
  }

  #[Route("/blog", name: "blog")]
  public function blog()
  {
    $this->renderTemplate('blog.html.twig');
  }

  #[Route("/presentation", name: "presentation")]
  public function presentation()
  {
    $this->renderTemplate('presentation.html.twig');
  }

  #[Route("/paiement", name: "paiement")]
  public function paiement()
  {
    $this->renderTemplate('paiement.html.twig');
  }

  #[Route("/confirmation", name: "confirmation")]
  public function confirmation()
  {
    $this->renderTemplate('confirmation.html.twig');
  }
}