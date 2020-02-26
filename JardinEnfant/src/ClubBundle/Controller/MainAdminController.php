<?php

namespace ClubBundle\Controller;

use ClubBundle\Form\ActiviteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClubBundle\Entity\Club;
use ClubBundle\Form\ClubType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Response;


class MainAdminController extends Controller
{
    public function ajouterAction(Request $request)
    {

        $club = new Club();

        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager(); //entity manager
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $club->getPhoto();
            $fileName = md5(uniqid()).'.'.$em->guessExtension();
            $em->move($this->getParameter('photos_directory'), $fileName);
            $club->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            $this->addFlash("success", "votre ajout a été fait avec succées");
        }

        return $this->render('@Club/AdminClub/ajouter1.html.twig', [
            'form' => $form->createView()
        ]);


    }

    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql="select bp from ClubBundle:Club bp ";
        $query=$em->createQuery($dql);
        /**
         * @var $paginator \knp\component\pager\paginator
         *
         *
         */
        $paginator  = $this->get('knp_paginator');



        $clubs=$paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 3)/*limit per page*/
        );




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
            $p= $em->getRepository('ClubBundle:Club')->find($id);
            $form=$this->createForm(ClubType::class,$p);
            $form->handleRequest($request);
            if($form->isSubmitted()){
                $file = $p->getPhoto();
                $filename= md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('photos_directory'), $filename);
                $p->setPhoto($filename);

                $em= $this->getDoctrine()->getManager();
                $em->persist($p);
                $em->flush();
                return $this->redirectToRoute('club_afficher1');

            }
            return $this->render('@Club/AdminClub/ajouter1.html.twig', array(
                "form"=> $form->createView()
            ));
        }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $clubs=  $em->getRepository('ClubBundle:Club')->findEntitiesByString($requestString);
        if(!$clubs) {
            $result['clubs']['error'] = "Post Not found :( ";
        } else {
            $result['clubs'] = $this->getRealEntities($clubs);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($clubs){
        foreach ($clubs as $clubs){
            $realEntities[$clubs->getId()] = [$clubs->getPhoto(),$clubs->getNom()];

        }
        return $realEntities;
    }

}