<?php

namespace ClubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClubBundle\Entity\Activite;
use ClubBundle\Form\ActiviteType;
use Symfony\Component\HttpFoundation\Request;
use ClubBundle\Entity\Club;
class MainActController extends Controller
{
    public function ajouter2Action(Request $request)
    {

        $activite = new Activite();

        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager(); //entity manager
        if ($form->isSubmitted() && $form->isValid()) {
            $club = $form['club']->getData();
            $club ->setNbAct($club->getNbAct() +1);

            $em->persist($club);
            $em = $activite->getPhoto();
            $fileName = md5(uniqid()).'.'.$em->guessExtension();
            $em->move($this->getParameter('photos_directory'), $fileName);
            $activite->setPhoto($fileName);


            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
            $this->addFlash("success", "votre ajout a été fait avec succées");

        }

        return $this->render('@Club/AdminClub/ajouter2.html.twig', [
            'form' => $form->createView()
        ]);


    }


    public function afficher2Action(Request $request)
    {
        $activites = $this->getDoctrine()->getRepository('ClubBundle:Activite')->findAll();
        return $this->render('@Club/AdminClub/afficher2.html.twig', [
            'activites' => $activites,
        ]);


    }


    public function afficherActAction($id)
    {
        $activites = $this->getDoctrine()->getRepository('ClubBundle:Activite')->findClub($id);
        return $this->render('@Club/activite/afficherAct.html.twig', [
            'activites' => $activites,
        ]);


    }

    public function supprimer1Action(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $activite=$em->getRepository('ClubBundle:Activite')->find($id);
        $club=$activite->getClub();
        $club ->setNbAct($club->getNbAct() -1);

        $em->persist($club);
        $em->remove($activite);
        $em->flush();
        return $this->redirectToRoute('club_afficher2');
    }

    public function modifier1Action(Request $request,$id)
    {

        $activite = $this->getDoctrine()->getRepository(Activite::class)->find($id);
        $form = $this->createForm(ActiviteType::class, $activite);





        $form = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $activite->getPhoto();
            $fileName = md5(uniqid()).'.'.$em->guessExtension();
            $em->move($this->getParameter('photos_directory'), $fileName);
            $activite->setPhoto($fileName);


            $activite = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
            return $this->redirectToRoute('club_afficher2');
        }
        return $this->render('@Club/AdminClub/ajouter2.html.twig', [
            'form' => $form->createView()
        ]);


    }



}
