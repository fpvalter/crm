<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{

    private ClienteRepository $repository;

    public function __construct(ClienteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/cliente", name="cliente")
     */
    public function index(): Response
    {
        return $this->render('cliente/index.html.twig');
    }

    /**
     * @Route("/cliente_list", name="cliente_list", methods="POST")
     */
    public function list(Request $request): JsonResponse
    {

        $draw = intval($request->request->get('draw'));
        $start = $request->request->get('start');
        $length = $request->request->get('length');
        $search = $request->request->get('search');
        $order = $request->request->get('order');
        //$columns = $request->request->get('columns');
        
        $action_filter = null;
        
        $results = $this->repository->listDataTable($start, $length, $order, $search, $action_filter);

        foreach ($results["results"] as &$r) {
            $r['action_column'] = '<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações <b class="caret"></b></button>
                                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 99999">
                                            <a class="dropdown-item" href="' . $this->generateUrl('cliente_show', ['cliente' => $r['id']]) . '"><i class="fa fa-fw icon-info"></i> Ver</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="' . $this->generateUrl('cliente_contato', ['cliente' => $r['id']]) . '"><i class="fa fa-fw fa-comments-o"></i> Contatos</a>
                                        </div>
                                    </div>
                                ';
        }

        $total_objects_count = $this->repository->countClientes();
        $filtered_objects_count = $results["countResult"];

        return $this->json([
            "draw" => $draw,
            "recordsTotal" => $total_objects_count,
            "recordsFiltered" => $filtered_objects_count,
            "data" => $results["results"]
        ]);
    }

    /**
     * @Route("{cliente}/show", name="cliente_show")
     */
    public function show(Request $request, Cliente $cliente): Response
    {
        return $this->render('cliente/index.html.twig');
    }

    /**
     * @Route("/contato", name="cliente_contato")
     */
    public function contatos(): Response
    {
        return $this->render('cliente/index.html.twig');
    }

    
}
