<?php

namespace App\Controller;

use App\Entity\Negocio;
use App\Entity\NegocioEtapa;
use App\Entity\Vendedor;
use App\Enum\DiaEntrega;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/negocio")
 */
class NegocioController extends AbstractController
{

    public function __advancedFilter()
    {

        $vendedorRepo = $this->getDoctrine()->getRepository(Vendedor::class);
        $vendedores = $vendedorRepo->findBy([], ["nome" => "ASC"]);

        return $this->render('negocio/_advanced_filter.html.twig', [
            'diasEntrega' => DiaEntrega::$choices,
            'vendedores' => $vendedores
        ]);
    }

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

    /**
     * @Route("/change-etapa", name="negocio_change_etapa", methods="POST")
     */
    public function changeEtapa(Request $request): JsonResponse
    {

        $success = true;
        $msg = "";

        try {

            $idNegocio = $request->request->get('negocio');
            $idEtapa = $request->request->get('etapa');

            $negocio = $this->getDoctrine()->getRepository(Negocio::class)->find($idNegocio);
            $etapa = $this->getDoctrine()->getRepository(NegocioEtapa::class)->find($idEtapa);
            if(!$negocio || !$etapa) {
                throw new \Exception("Negocio ou Etapa inválido");
            }

            $negocio->setNegocioEtapa($etapa);
            $em = $this->getDoctrine()->getManager();
            $em->persist($negocio);
            $em->flush();

            $success = true;
        } catch(\Exception $ex) {
            $success = true;
            $msg = "Não foi possível mudar o Negocio para outra etapa. " . $ex->getMessage();
        }

        return $this->json(["success" => $success, "msg" => $msg]);

    }
}
