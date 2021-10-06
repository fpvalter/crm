<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CRMController extends AbstractController
{
    /**
     * @Route("/", name="crm")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}
