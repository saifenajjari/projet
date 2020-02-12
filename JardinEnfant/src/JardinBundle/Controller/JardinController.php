<?php

namespace JardinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JardinController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Jardin/Jardin/index.html.twig');
    }
}
