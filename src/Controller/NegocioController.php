<?php

namespace App\Controller;

use App\Entity\NegocioEtapa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/negocio")
 */
class NegocioController extends AbstractController
{
    /**
     * @Route("/", name="negocio")
     */
    public function index(): Response
    {
        return $this->render('negocio/index.html.twig');
    }

    /**
     * @Route("/kanban", name="negocio_kanban")
     */
    public function indexKanban(): Response
    {

        $negocioEtapaRepo = $this->getDoctrine()->getRepository(NegocioEtapa::class);
        $etapas = $negocioEtapaRepo->findBy([], ['ordem' => 'ASC']);

        return $this->render('negocio/index_kanban.html.twig', [
            'etapas' => $etapas
        ]);
    }
}
