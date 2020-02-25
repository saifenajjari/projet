<?php

namespace JardinBundle\Controller;

use JardinBundle\Entity\Jardin;
use JardinBundle\Form\JardinType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class JardinController extends Controller
{

    public function afficheAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $jardins = $em->getRepository('JardinBundle:Jardin')->findAll();
        if ($request->isMethod('POST')) {
            $dest=$request->get('address');
            $nom=$request->get('nom');

            if(!empty($nom)&&$nom!=""){
                if (!empty($dest)&&$dest!=""){
                    $jardins = $em->getRepository('JardinBundle:Jardin')
                        ->findBynomadress($dest,$nom);
                }else{
                    $jardins = $em->getRepository('JardinBundle:Jardin')
                        ->findBynom($nom);
                }
            }else{
                if (!empty($dest)&&$dest!=""){
                    $jardins = $em->getRepository('JardinBundle:Jardin')
                        ->findByadress($dest);
                }else{
                    $jardins = $em->getRepository('JardinBundle:Jardin')
                        ->findAll();
                }
            }

        }
        return $this->render('@Jardin/Jardin/jardin.html.twig', array(
            'jardins' => $jardins,
        ));
    }




    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $jardin = $em->getRepository('JardinBundle:Jardin')->find($id);
        return $this->render('@Jardin/Jardin/detail.html.twig', array(
            'jardin' => $jardin,
        ));
    }
