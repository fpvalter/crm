<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Followup;
use App\Enum\FollowupTipo;
use App\Repository\FollowupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/followup")
 */
class FollowupController extends AbstractController
{

    private FollowupRepository $repository;

    public function __construct(FollowupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="followup")
     */
    public function index(): Response
    {
        return $this->render('followup/index.html.twig');
    }

    /**
     * @Route("/new", name="followup_new", methods="POST")
     */
    public function new(Request $request): Response
    {

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('add_followup', $token)) {

            $descricao = $request->request->get('descricao_followup');
            $cliente_id = $request->request->get('cliente_id');
            $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($cliente_id);

            $followup = new Followup();
            $followup->setTipo(FollowupTipo::INFO);
            $followup->setCliente($cliente);
            $followup->setUser($this->getUser());
            $followup->setDescricao($descricao);

            $em = $this->getDoctrine()->getManager();
            $em->persist($followup);
            $em->flush();

            return $this->redirectToRoute("cliente_detail", ['cliente' => $cliente_id]);
        }

        throw new AccessDeniedException();
    }

    /**
     * @Route("/timeline-cliente", name="followup_get_by_cliente", methods="POST")
     */
    public function getFollowupsByCliente(Request $request): Response
    {

        $cliente_id = $request->request->get('cliente_id');
        $page = $request->request->get('page');

        $followups = $this->repository->findFollowupsTimelineByCliente($cliente_id, $page);

        return $this->render('followup/_timeline.html.twig', [
            'followups' => $followups
        ]);
    }
}