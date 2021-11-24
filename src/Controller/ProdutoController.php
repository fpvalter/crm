<?php

namespace App\Controller;

use App\Entity\Familia;
use App\Entity\Grupo;
use App\Entity\Marca;
use App\Entity\Produto;
use App\Entity\Subfamilia;
use App\Repository\ProdutoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produto")
 */
class ProdutoController extends BaseController
{

    private ProdutoRepository $repository;

    public function __construct(ProdutoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __advancedFilter()
    {

        $familiaRepo = $this->getDoctrine()->getRepository(Familia::class);
        $familias = $familiaRepo->findBy([], ["descricao" => "ASC"]);

        $subfamiliaRepo = $this->getDoctrine()->getRepository(Subfamilia::class);
        $subfamilias = $subfamiliaRepo->findBy([], ["descricao" => "ASC"]);

        $grupoRepo = $this->getDoctrine()->getRepository(Grupo::class);
        $grupos = $grupoRepo->findBy([], ["descricao" => "ASC"]);

        $marcaRepo = $this->getDoctrine()->getRepository(Marca::class);
        $marcas = $marcaRepo->findBy([], ["descricao" => "ASC"]);

        return $this->render('produto/_advanced_filter.html.twig', [
            'familias' => $familias,
            'subfamilias' => $subfamilias,
            'grupos' => $grupos,
            'marcas' => $marcas
        ]);
    }

    public function __header(Produto $produto)
    {
       

        return $this->render('produto/_header.html.twig');
    }

    /**
     * @Route("/", name="produto")
     */
    public function index(): Response
    {
        return $this->render('produto/index.html.twig');
    }

    /**
     * @Route("/produto_list", name="produto_list", methods="POST")
     */
    public function list(Request $request): JsonResponse
    {

        $draw = intval($request->request->get('draw'));
        $start = $request->request->get('start');
        $length = $request->request->get('length');
        $search = $request->request->get('search');
        $order = $request->request->get('order');
        //$columns = $request->request->get('columns');
        $advanced_filter['filtro_familia'] = $request->request->get('filtro_familia');
        $advanced_filter['filtro_subfamilia'] = $request->request->get('filtro_subfamilia');
        $advanced_filter['filtro_grupo'] = $request->request->get('filtro_grupo');
        $advanced_filter['filtro_marca'] = $request->request->get('filtro_marca');
        
        $action_filter = null;
        
        $results = $this->repository->listDataTable($start, $length, $order, $search, $action_filter, $advanced_filter);

        foreach ($results["results"] as &$r) {
            $r['action_column'] = '<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações <b class="caret"></b></button>
                                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 99999">
                                        <a class="dropdown-item" href="' . $this->generateUrl('produto_detail', ['produto' => $r['id']]) . '"><i class="fa fa-fw icon-info"></i> Info</a>
                                        </div>
                                    </div>
                                ';
        }

        $total_objects_count = $this->repository->countProdutos();
        $filtered_objects_count = $results["countResult"];

        return $this->json([
            "draw" => $draw,
            "recordsTotal" => $total_objects_count,
            "recordsFiltered" => $filtered_objects_count,
            "data" => $results["results"]
        ]);
    }

    /**
     * @Route("/{produto}/detail", name="produto_detail")
     */
    public function detail(Request $request, Produto $produto): Response
    {
        return $this->render('produto/detail.html.twig', [
            'produto' => $produto
        ]);
    }
    
}
