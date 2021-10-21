<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Followup;
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
}
