<?php

namespace PlanningBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;;

use SqlSrvBundle\Entity\Item;
use SqlSrvBundle\Entity\Saledocument;
use SqlSrvBundle\Entity\Saledocumentline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="premiere-page")
     */
    public function indexAction()
    {
        return $this->render('pages/page-accueil.html.twig');
    }

    /**
     * @Route("/consultation", name="consultation-planning")
     */
    public function consultationAction()
    {
        return $this->render('pages/consulter-le-planning.html.twig');
    }

    /**
     * @Route("/planification", name="planifier-une-commande")
     */
    public function planificationAction(Request $request)
    {
        $commandes = $this->getDoctrine()->getRepository(Saledocument::class, 'customer')
            ->findSafeDoc();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $commandes,
            $request->query->getInt('page', 1),
            30
        );

        return $this->render('pages/planifier-une-commande.html.twig', [
            'commandes' => $commandes,
            "pagination"=> $pagination
        ]);
    }


    /**
     * @Route("/details/{id}", name="details-commandes")
     */
    public function detailCommandes($id)
    {
        $details = $this->getDoctrine()->getRepository(Saledocumentline::class, 'customer')
            ->findBy([
                'documentid' => $id,
                ]
            );


        return $this->render('pages/details-commandes.html.twig', [
            'details' => $details,
        ]);
    }

    /**
     * @Route("/planification_produits", name="planification-produits")
     */
    public function planificationProduits()
    {
        return $this->render('pages/planification-produit.html.twig');
    }

    /**
     * @Route("/listes", name="listes-commandes")
     */
    public function listeCommandes(Request $request)
    {
        $commandes = $this->getDoctrine()->getRepository(Saledocument::class, 'customer')
            ->findSafeDoc();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $commandes,
            $request->query->getInt('page', 1),
            30
        );

        return $this->render('pages/listes-des-commandes.html.twig', [
            'commandes' => $commandes,
            "pagination"=> $pagination
        ]);
    }

    /**
     * @Route("/consultation-par-taches", name="consultation-taches")
     */
    public function consultationParTaches()
    {
        return $this->render('pages/consulter-planning-par-taches.html.twig');
    }

    /**
     * @Route("/consultation-par-acteurs", name="consultation-acteurs")
     */
    public function consultationParActeurs()
    {
        return $this->render('pages/consulter-planning-par-acteurs.html.twig');
    }
}
