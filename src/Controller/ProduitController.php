<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index(ProduitRepository $repo)
    {
        $produits=$repo->findAll();
        //dump($produit);
        return $this->render('produit/produits.html.twig', [
            'X' => $produits,
        ]);
    }
    /**
     * @Route("/produit/{id}", name="produit")
     */
    public function show(Produit $produit)
    {

        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }

}
