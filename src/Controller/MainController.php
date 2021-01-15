<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/",name="app_homepage")
     */
    public function home()
    {
        return $this->render('mainht/main.html.twig');
    }
}