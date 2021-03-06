<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Negocio;
use App\Entity\NegocioEtapa;
use App\Entity\Transportadora;
use App\Entity\Vendedor;
use App\Enum\FollowupTipo;
use App\Enum\NegocioStatus;
use App\Form\NegocioClienteType;
use App\Repository\NegocioRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/negocio")
 */
class NegocioController extends BaseController
{

    private NegocioRepository $repository;

    public function __advancedFilter()
    {

        $transportadoraRepo = $this->getDoctrine()->getRepository(Transportadora::class);
        $transportadoras = $transportadoraRepo->findBy([], ["razaoSocial" => "ASC"]);

        $vendedorRepo = $this->getDoctrine()->getRepository(Vendedor::class);
        $vendedores = $vendedorRepo->findBy([], ["nome" => "ASC"]);

        return $this->render('negocio/_advanced_filter.html.twig', [
            'transportadoras' => $transportadoras,
            'vendedores' => $vendedores
        ]);
    }

    public function __construct(NegocioRepository $repository)
    {
        $this->repository = $repository;
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
     * @Route("/negocio_list", name="negocio_list", methods="POST")
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

            $r['action_column'] = '<div class="btn-group">
                                        <a class="btn btn-info" href="' . $this->generateUrl('negocio_detail', ['negocio' => $r['id']]) . '"><i class="fa fa-fw icon-info"></i> Info</a>
                                    </div>
                                ';
        }

        $total_objects_count = $this->repository->countNegocios();
        $filtered_objects_count = $results["countResult"];

        return $this->json([
            "draw" => $draw,
            "recordsTotal" => $total_objects_count,
            "recordsFiltered" => $filtered_objects_count,
            "data" => $results["results"]
        ]);
    }

    /**
     * @Route("/{cliente}/new", name="negocio_new_cliente")
     */
    public function newCliente(Request $request, Cliente $cliente): Response
    {
        $negocio = new Negocio();
        $negocio->setCliente($cliente);
        $negocio->setStatus(NegocioStatus::ABERTO);
        
        $etapaRepo = $this->getDoctrine()->getRepository(NegocioEtapa::class);
        $etapa = $etapaRepo->findOneBy([], ['ordem' => 'ASC']);
        $negocio->setNegocioEtapa($etapa);

        $form = $this->createForm(NegocioClienteType::class, $negocio, ['cliente_id' => $cliente->getId()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();

            try {
                $em->persist($negocio);
                $em->flush();

                FollowupController::add($em, $this->getUser(), $negocio, "Neg??cio adicionado", FollowupTipo::INFO);

                $em->getConnection()->commit();

                $this->addFlash('info', 'Neg??cio adicionado com sucesso');


            } catch(Exception $ex) {
                $em->getConnection()->rollBack();
                $this->addFlash('danger', 'Erro ao adicionar negocio.' . PHP_EOL . $ex->getMessage());
            }

            return $this->redirectToRoute('negocio_kanban');

        }

        return $this->renderForm('negocio/new.html.twig', [
            'form' => $form,
            'cliente' => $cliente
        ]);
    }

    /**
     * @Route("/{negocio}/detail", name="negocio_detail")
     */
    public function detail(Request $request, Negocio $negocio): Response
    {
        return $this->render('negocio/detail.html.twig', [
            "negocio" => $negocio
        ]);
    }

    /**
     * @Route("/get-negocios", name="negocio_get", methods="POST")
     */
    public function getNegocios(Request $request): Response
    {
        $etapa = $request->request->get('negocio_etapa');
        $vendedor = $request->request->get('vendedor');
        $transportadora = $request->request->get('transportadora');

        $negocios = $this->repository->findByEtapaVendedorTransportadora($etapa, $vendedor, $transportadora);

        return $this->render('negocio/_kanban.html.twig', [
            'negocios' => $negocios
        ]);
    }

    /**
     * @Route("/change-etapa", name="negocio_change_etapa", methods="POST")
     */
    public function changeEtapa(Request $request): JsonResponse
    {

        $success = false;
        $msg = "";

        $em = $this->getDoctrine()->getManager();   
        $em->getConnection()->beginTransaction();     
        try {

            $idNegocio = $request->request->get('negocio');
            $idEtapa = $request->request->get('etapa');

            $negocio = $this->getDoctrine()->getRepository(Negocio::class)->find($idNegocio);
            $etapa = $this->getDoctrine()->getRepository(NegocioEtapa::class)->find($idEtapa);
            if(!$negocio || !$etapa) {
                throw new \Exception("Negocio ou Etapa inv??lido");
            }

            $negocio->setNegocioEtapa($etapa);

            $em->persist($negocio);
            $em->flush();

            FollowupController::add($em, $this->getUser(), $negocio, "Negocio #" . $negocio->getId() . " - Etapa alterada para " . $etapa->getDescricao(), FollowupTipo::INFO);
            $em->getConnection()->commit();

            $success = true;
        } catch(\Exception $ex) {

            $em->getConnection()->rollBack();

            $success = false;
            $msg = "N??o foi poss??vel mudar o Negocio para outra etapa. " . $ex->getMessage();
        }

        return $this->json(["success" => $success, "msg" => $msg]);

    }

    /**
     * @Route("/change-status", name="negocio_change_status", methods="POST")
     */
    public function changeStatus(Request $request): JsonResponse
    {

        $success = false;
        $msg = "";

        $em = $this->getDoctrine()->getManager();   
        $em->getConnection()->beginTransaction();   
          
        try {

            $idNegocio = $request->request->get('negocio_id');
            $status = $request->request->get('status');

            $negocio = $this->getDoctrine()->getRepository(Negocio::class)->find($idNegocio);

            if($negocio->getStatus() != NegocioStatus::ABERTO) {
                throw new \Exception("S?? ?? poss??vel mudar status de negocios abertos");
            }
            if(!in_array($status, NegocioStatus::$choices)) {
                throw new \Exception("Informe um status valido. [" . implode(", ", NegocioStatus::$choices) . "]");
            }

            $negocio->setStatus($status);

            $em->persist($negocio);
            $em->flush();

            FollowupController::add($em, $this->getUser(), $negocio, "Negocio #" . $negocio->getId() . " " . $status, FollowupTipo::INFO);
            $em->getConnection()->commit();

            $success = true;
        } catch(\Exception $ex) {

            $em->getConnection()->rollBack();

            $success = false;
            $msg = "N??o foi poss??vel mudar o status do Negocio. " . $ex->getMessage();
        }

        return $this->json(["success" => $success, "msg" => $msg]);

    }
}
