<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Estabelecimento;
use App\Entity\NotaFiscal;
use App\Entity\Vendedor;
use App\Enum\DiaEntrega;
use App\Repository\ClienteRepository;
use App\Repository\NotaFiscalRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliente")
 */
class ClienteController extends BaseController
{

    private ClienteRepository $repository;

    public function __construct(ClienteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __advancedFilter()
    {

        $vendedorRepo = $this->getDoctrine()->getRepository(Vendedor::class);
        $vendedores = $vendedorRepo->findBy([], ["nome" => "ASC"]);

        return $this->render('cliente/_advanced_filter.html.twig', [
            'diasEntrega' => DiaEntrega::$choices,
            'vendedores' => $vendedores
        ]);
    }

    public function __header(Cliente $cliente)
    {
        
        $ultimaNotaEstabelecimentos = [];

        $notaFiscalRepo = $this->getDoctrine()->getRepository(NotaFiscal::class);

        $estabelecimentoRepo = $this->getDoctrine()->getRepository(Estabelecimento::class);
        $estabelecimentos = $estabelecimentoRepo->findAll();
        foreach($estabelecimentos as $estab) {
            $nota = $notaFiscalRepo->findLastNotaFiscalByClienteEstabelecimento($cliente->getId(), $estab->getId());
            if($nota) {
                $ultimaNotaEstabelecimentos[] = $nota;
            }
        }

        return $this->render('cliente/_header.html.twig', [
            "cliente" => $cliente,
            "ultimaNotaEstabelecimentos" => $ultimaNotaEstabelecimentos
        ]);
    }

    /**
     * @Route("/", name="cliente")
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
        $advanced_filter['filtro_dia_entrega'] = $request->request->get('filtro_dia_entrega');
        $advanced_filter['filtro_vendedor'] = $request->request->get('filtro_vendedor');        
        
        $action_filter = null;
        
        $results = $this->repository->listDataTable($start, $length, $order, $search, $action_filter, $advanced_filter);

        foreach ($results["results"] as &$r) {
            $r['action_column'] = '<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações <b class="caret"></b></button>
                                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 99999">
                                            <a class="dropdown-item" href="' . $this->generateUrl('cliente_detail', ['cliente' => $r['id']]) . '"><i class="fa fa-fw icon-info"></i> Ver</a>

                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="' . $this->generateUrl('contato', ['cliente' => $r['id']]) . '"><i class="fa fa-fw fa-comments-o"></i> Contatos</a>

                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="' . $this->generateUrl('negocio_new_cliente', ['cliente' => $r['id']]) . '"><i class="fa fa-fw icon-like"></i> Novo Negocio</a>
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
     * @Route("/{cliente}/detail", name="cliente_detail")
     */
    public function detail(Request $request, Cliente $cliente): Response
    {

        $ultimaNotaEstabelecimentos = [];

        $notaFiscalRepo = $this->getDoctrine()->getRepository(NotaFiscal::class);

        $estabelecimentoRepo = $this->getDoctrine()->getRepository(Estabelecimento::class);
        $estabelecimentos = $estabelecimentoRepo->findAll();
        foreach($estabelecimentos as $estab) {
            $nota = $notaFiscalRepo->findLastNotaFiscalByClienteEstabelecimento($cliente->getId(), $estab->getId());
            if($nota) {
                $ultimaNotaEstabelecimentos[] = $nota;
            }
        }

        return $this->render('cliente/detail.html.twig', [
            "cliente" => $cliente,
            "ultimaNotaEstabelecimentos" => $ultimaNotaEstabelecimentos
        ]);
    }
    
}
