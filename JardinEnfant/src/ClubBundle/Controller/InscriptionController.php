<?php

namespace ClubBundle\Controller;

use ClubBundle\Entity\Inscription;
use ClubBundle\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use ClubBundle\Entity\Activite;
use ClubBundle\Form\ActiviteType;

class InscriptionController extends Controller
{
    public function ajouterInsAction(Request $request ,$id)
    {
        $activite = $this->getDoctrine()->getRepository('ClubBundle:Activite')-> find($id);
        $inscription = new Inscription();

        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager(); //entity manager
        if ($form->isSubmitted() && $form->isValid()) {
            $inscription->setMontant($activite->getMontantp() * $inscription->getNbmois());
            $inscription->setActivite($activite);

            $em = $inscription->getPhoto();
            $fileName = md5(uniqid()).'.'.$em->guessExtension();
            $em->move($this->getParameter('photos_directory'), $fileName);
            $inscription->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();
            $this->addFlash("success", "votre demande a été envoyé avec succées");
        }

        return $this->render('@Club/AdminClub/ajouterIns.html.twig', [
            'form' => $form->createView()
        ]);


    }

    public function afficherInsAction(Request $request)
    {
        $inscriptions = $this->getDoctrine()->getRepository('ClubBundle:Inscription')->findBy(['confirmed'=>false]);
        return $this->render('@Club/AdminClub/afficherIns.html.twig', [
            'inscription' => $inscriptions,
        ]);


    }

    public function supp_inscriptionAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $inscription=$this->getDoctrine()->getRepository(Inscription::class)->find($id);
        $mail =  $inscription->getEmail();

        $sujet='Inscription au club réfusée ';
        $em->remove($inscription);
        $em->flush();
        $mailer = $this->container->get('mailer');
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com',465,'ssl')
            ->setUsername('meyssen.fekihhssinesnene@esprit.tn')
            ->setPassword('182JMT2358');

        $mailer=\Swift_Mailer::newInstance($transport);
        $message=\Swift_Message::newInstance('')
            ->setSubject($sujet)
            ->setFrom('meyssen.fekihhssinesnene@esprit.tn')
            ->setTo($mail)
            ->setBody("l'administration a refusé votre demande d'inscription à l'activité choisie et merci . ");
        $this->get('mailer')->send($message);
        return $this->redirectToRoute("club_afficherIns");
    }
    public function accept_inscriptionAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $inscription=$this->getDoctrine()->getRepository(Inscription::class)->find($id);
        $inscription->setConfirmed(true);
       $mail =  $inscription->getEmail();
        $sujet='Inscription au club acceptée ';
        $activite=$inscription->getActivite();
        $activite ->setNbDispo($activite->getNbDispo() -1);

        $em->persist($activite);
        $em->persist($inscription);
        $em->flush();
        $mailer = $this->container->get('mailer');
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com',465,'ssl')
            ->setUsername('meyssen.fekihhssinesnene@esprit.tn')
            ->setPassword('182JMT2358');

        $mailer=\Swift_Mailer::newInstance($transport);
        $message=\Swift_Message::newInstance('')
            ->setSubject($sujet)
            ->setFrom('meyssen.fekihhssinesnene@esprit.tn')
            ->setTo($mail)
            ->setBody("l'administration a accepté votre demande d'inscription à l'activité choisie et merci . ");
        $this->get('mailer')->send($message);

        return $this->redirectToRoute("club_afficherIns");
    }

    public function afficherInsActAction(Request $request)
    {
        $inscriptions = $this->getDoctrine()->getRepository('ClubBundle:Inscription')->findall();
        return $this->render('@Club/AdminClub/afficherInsAct.html.twig', [
            'inscription' => $inscriptions,
        ]);


    }
    public function supprimerInsActAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $inscription=$this->getDoctrine()->getRepository(Inscription::class)->find($id);
        $activite=$inscription->getActivite();
        $activite ->setNbDispo($activite->getNbDispo() +1);

        $em->persist($activite);
        $em->remove($inscription);
        $em->flush();
        return $this->redirectToRoute("club_afficherInsAct");
    }
}
