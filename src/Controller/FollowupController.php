<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Followup;
use App\Entity\Negocio;
use App\Entity\User;
use App\Enum\FollowupTipo;
use App\Repository\FollowupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/followup")
 */
class FollowupController extends BaseController
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
            $negocio_id = $request->request->get('negocio_id');

            $em = $this->getDoctrine()->getManager();

            if($cliente_id) {
                $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($cliente_id);
                self::add($em, $this->getUser(), $cliente, $descricao, FollowupTipo::INFO);
                return $this->redirectToRoute("cliente_detail", ['cliente' => $cliente_id]);
            } elseif($negocio_id) {
                $negocio = $this->getDoctrine()->getRepository(Negocio::class)->find($negocio_id);
                self::add($em, $this->getUser(), $negocio, $descricao, FollowupTipo::INFO);
                return $this->redirectToRoute("negocio_detail", ['negocio' => $negocio_id]);
            }

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

    public static function add(EntityManagerInterface $em, User $user, $entity, string $descricao, string $tipo)
    {

        $followup = new Followup();
        $followup->setUser($user);
        $followup->setDescricao($descricao);
        $followup->setTipo($tipo);

        if($entity instanceof Cliente) {
            $followup->setCliente($entity);
        } elseif ($entity instanceof Negocio) {
            $followup->setCliente($entity->getCliente());
            $followup->setNegocio($entity);
        } else {
            throw new Exception("É necessário informar um entidade");
        }

        $em->persist($followup);
        $em->flush();

    }
}
