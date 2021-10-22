<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Repository\ContatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliente/contato")
 */
class ContatoController extends AbstractController
{

    private ContatoRepository $repository;

    public function __construct(ContatoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/{cliente}", name="contato")
     */
    public function index(Cliente $cliente): Response
    {
        return $this->render('contato/index.html.twig', [
            'cliente' => $cliente
        ]);
    }

    /**
     * @Route("/{cliente}/contato_list", name="contato_list", methods="POST")
     */
    public function list(Request $request, Cliente $cliente): JsonResponse
    {

        $draw = intval($request->request->get('draw'));
        $start = $request->request->get('start');
        $length = $request->request->get('length');
        $search = $request->request->get('search');
        $order = $request->request->get('order');
        //$columns = $request->request->get('columns');
        
        $action_filter = null;
        
        $results = $this->repository->listDataTable($cliente->getId(), $start, $length, $order, $search, $action_filter);

        foreach ($results["results"] as &$r) {
            $r['action_column'] = '<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações <b class="caret"></b></button>
                                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 99999">
                                            
                                        </div>
                                    </div>
                                ';
        }

        $total_objects_count = $this->repository->countContatosCliente($cliente->getId());
        $filtered_objects_count = $results["countResult"];

        return $this->json([
            "draw" => $draw,
            "recordsTotal" => $total_objects_count,
            "recordsFiltered" => $filtered_objects_count,
            "data" => $results["results"]
        ]);
    }
}
