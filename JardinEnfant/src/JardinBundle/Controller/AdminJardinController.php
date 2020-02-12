<?php

namespace JardinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminJardinController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Jardin/AdminJardin/index.html.twig');
    }
}
