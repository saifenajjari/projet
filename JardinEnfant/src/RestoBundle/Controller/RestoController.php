<?php

namespace RestoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RestoController extends Controller
{


    public function listeAction()
    {

        return $this->render('@Resto/Resto/liste.html.twig');

    }
}
