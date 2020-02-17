<?php

namespace ClubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClubBundle\Entity\Club;
use ClubBundle\Form\ClubType;
use Symfony\Component\HttpFoundation\Request;

class MainAdminController extends Controller
{
    public function ajouterAction(Request $request)
    {

        $club = new Club();

        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager(); //entity manager
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
        }

        return $this->render('@Club/AdminClub/ajouter1.html.twig', [
            'form' => $form->createView()
        ]);


    }

    public function afficherAction(Request $request)
    {
        $clubs = $this->getDoctrine()->getRepository('ClubBundle:Club')->findAll();
        return $this->render('@Club/Club/afficher.html.twig', [
            'clubs' => $clubs,
        ]);


    }
    public function afficher1Action(Request $request)
    {
        $clubs = $this->getDoctrine()->getRepository('ClubBundle:Club')->findAll();
        return $this->render('@Club/AdminClub/afficher1.html.twig', [
            'clubs' => $clubs,
        ]);


    }
    public function supprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$this->getDoctrine()->getRepository(Club::class)->find($id);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("club_afficher1");
    }

    public function modifierAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$this->getDoctrine()->getRepository(Club::class)->find($id);

        $form=$this->createForm(ClubType::class,$club );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em -> persist($club);
            $em->flush();
            return $this->redirectToRoute('club_afficher1');
        }
        return $this->render('@Club/AdminClub/ajouter1.html.twig',array('form'=> $form->createView()));

    }


}