<?php

namespace JardinBundle\Controller;

use JardinBundle\Entity\Enfant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Enfant controller.
 *
 */
class EnfantController extends Controller
{


    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository(Enfant::class)->findby(["parent"=>$this->getUser()->getId()]);
        return $this->render('@Jardin/Enfant/enfants.html.twig', array(
            'enfants' => $enfants,
        ));
    }

    public function modifAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $enfant= $em->getRepository(Enfant::class)->find($id);
        if($request->isMethod("POST")){

            $enfant->setNom($request->get('nom'));
            $enfant->setPrenom($request->get('prenom'));
            $enfant->setCategorie($request->get('categorie'));
            $enfant->setAge($request->get('age'));
            $enfant->setSexe($request->get('sexe'));
            $enfant->setParent($this->getUser());

            $em->flush();

            return $this->redirectToRoute("enfant_liste");
        }

        return $this->render('@Jardin/Enfant/modif.html.twig',[
            "enfant"=>$enfant
            ]);
    }

    public function suppAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $enfant=$em->getRepository(Enfant::class)->find($id);
        $em->remove($enfant);
        $em->flush();
        return $this->redirectToRoute("enfant_liste");
    }

    public function ajoutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod("POST")){
            $enfant= new Enfant();
            $enfant->setNom($request->get('nom'));
            $enfant->setPrenom($request->get('prenom'));
            $enfant->setCategorie($request->get('categorie'));
            $enfant->setAge($request->get('age'));
            $enfant->setSexe($request->get('sexe'));
            $enfant->setParent($this->getUser());

            $em->persist($enfant);
            $em->flush();

            return $this->redirectToRoute("enfant_liste");
        }

        return $this->render('@Jardin/Enfant/ajout.html.twig');
    }
}
