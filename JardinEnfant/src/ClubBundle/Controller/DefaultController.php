<?php

namespace ClubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $clubs=[1,2];
        return $this->render('@Club/Default/index.html.twig',[
            "clubs"=>$clubs
        ]);
    }
}
