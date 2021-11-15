<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Contato;
use App\Form\ContatoType;
use App\Repository\ContatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliente/contato")
 */
class ContatoController extends BaseController
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
                                            <a class="dropdown-item" href="' . $this->generateUrl('contato_edit', ['contato' => $r['id']]) . '"><i class="fa fa-fw fa-edit"></i> Editar</a>
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

    /**
     * @Route("/{cliente}/new", name="contato_new")
     */
    public function new(Request $request, Cliente $cliente): Response
    {
        $contato = new Contato();
        $contato->setCliente($cliente);

        $form = $this->createForm(ContatoType::class, $contato);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contato);
            $em->flush();

            $this->addFlash('info', 'Contato adicionado com sucesso');

            return $this->redirectToRoute('contato', ['cliente' => $cliente->getId()]);

        }

        return $this->renderForm('contato/new.html.twig', [
            'form' => $form,
            'cliente' => $cliente
        ]);
    }

    /**
     * @Route("/{contato}/edit", name="contato_edit")
     */
    public function edit(Request $request, Contato $contato): Response
    {

        $form = $this->createForm(ContatoType::class, $contato);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contato);
            $em->flush();

            $this->addFlash('info', 'Contato alterado com sucesso');

            return $this->redirectToRoute('contato', ['cliente' => $contato->getCliente()->getId()]);

        }

        return $this->renderForm('contato/edit.html.twig', [
            'form' => $form,
            'cliente' => $contato->getCliente()
        ]);
    }
}
