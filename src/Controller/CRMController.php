<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CRMController extends BaseController
{
    /**
     * @Route("/", name="crm_index")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}
