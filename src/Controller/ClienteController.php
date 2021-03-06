<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Estabelecimento;
use App\Entity\NotaFiscal;
use App\Entity\Transportadora;
use App\Entity\Vendedor;
use App\Enum\ClienteTipoCompra;
use App\Repository\ClienteRepository;
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

        $transportadoraRepo = $this->getDoctrine()->getRepository(Transportadora::class);
        $transportadoras = $transportadoraRepo->findBy([], ["razaoSocial" => "ASC"]);

        $vendedorRepo = $this->getDoctrine()->getRepository(Vendedor::class);
        $vendedores = $vendedorRepo->findBy([], ["nome" => "ASC"]);

        return $this->render('cliente/_advanced_filter.html.twig', [
            'transportadoras' => $transportadoras,
            'vendedores' => $vendedores
        ]);
    }

    public function __header(Cliente $cliente, bool $edit = false)
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
            "edit" => $edit,
            'tiposCompra' => ClienteTipoCompra::$choices,
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
        $advanced_filter['filtro_transportadora'] = $request->request->get('filtro_transportadora');
        $advanced_filter['filtro_vendedor'] = $request->request->get('filtro_vendedor');        
        
        $action_filter = null;
        
        $results = $this->repository->listDataTable($start, $length, $order, $search, $action_filter, $advanced_filter);

        foreach ($results["results"] as &$r) {

            $r['cidade'] = $r['cidade'] . "-" . $r['uf'];

            $r['action_column'] = '<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">A????es <b class="caret"></b></button>
                                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 99999">
                                            <a class="dropdown-item" href="' . $this->generateUrl('cliente_detail', ['cliente' => $r['id']]) . '"><i class="fa fa-fw icon-info"></i> Info</a>

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

    /**
     * @Route("/save-tipo-compra", name="cliente_save_tipo_compra", methods="POST")
     */
    public function saveTipoCompra(Request $request): JsonResponse
    {

        $cliente_id = $request->request->get('cliente_id');
        $tipoCompra = $request->request->get('tipo_compra');

        $cliente = $this->repository->find($cliente_id);

        if($tipoCompra == "") {
            $cliente->setTipoCompra([]);
        } else {
            $cliente->setTipoCompra($tipoCompra);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

        return $this->json(['success' => true]);
    }
    
}
