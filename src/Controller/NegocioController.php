<?php

namespace App\Controller;

use App\Entity\Negocio;
use App\Entity\NegocioEtapa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/get-negocios", name="negocio_get", methods="POST")
     */
    public function getNegocios(Request $request): Response
    {
        $etapa = $request->request->get('negocio_etapa');
        $vendedor = $request->request->get('vendedor');
        $diaEntrega = $request->request->get('dia_entrega');

        $negocioRepo = $this->getDoctrine()->getRepository(Negocio::class);
        $negocios = $negocioRepo->findByEtapaVendedorDiaEntrega($etapa, $vendedor, $diaEntrega);

        return $this->render('negocio/_kanban.html.twig', [
            'negocios' => $negocios
        ]);
    }
}
