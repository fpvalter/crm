<?php

namespace App\Controller;

use App\Entity\Negocio;
use App\Entity\Notification;
use App\Entity\User;
use App\Repository\NotificationRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notification")
 */
class NotificationController extends BaseController
{

    private NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __advancedFilter()
    {

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepo->findBy([], ["email" => "ASC"]);

        return $this->render('notification/_advanced_filter.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/", name="notification")
     */
    public function index(): Response
    {
        return $this->render('notification/index.html.twig');
    }

    /**
     * @Route("/notification_list", name="notification_list", methods="POST")
     */
    public function list(Request $request): JsonResponse
    {

        $draw = intval($request->request->get('draw'));
        $start = $request->request->get('start');
        $length = $request->request->get('length');
        $search = $request->request->get('search');
        $order = $request->request->get('order');
        //$columns = $request->request->get('columns');
        $advanced_filter['filtro_user'] = $request->request->get('filtro_user');        
        
        $action_filter = null;
        
        $results = $this->repository->listDataTable($start, $length, $order, $search, $action_filter, $advanced_filter);

        foreach ($results["results"] as &$r) {

            
            if($r['displayed']) {
                $r['displayed'] = "<i class='fa fa-check text-success'></i>";
                $r['action_column'] = '<div class="btn-group">
                                            <a class="btn btn-light btn-sm" href="' . $this->generateUrl('notification_set_displayed', ['notification' => $r['id'], 'displayed' => 'N']) . '"><i class="fa fa-fw fa-check"></i></a>
                                        </div>';
            } else {
                $r['displayed'] = "";
                $r['action_column'] = '<div class="btn-group">
                                            <a class="btn btn-success btn-sm" href="' . $this->generateUrl('notification_set_displayed', ['notification' => $r['id'], 'displayed' => 'S']) . '"><i class="fa fa-fw fa-check"></i></a>
                                        </div>';
            }

        }

        $total_objects_count = $this->repository->countNotifications();
        $filtered_objects_count = $results["countResult"];

        return $this->json([
            "draw" => $draw,
            "recordsTotal" => $total_objects_count,
            "recordsFiltered" => $filtered_objects_count,
            "data" => $results["results"]
        ]);
    }

    /**
     * @Route("/get-notification", name="notification_get", methods="POST")
     */
    public function getNotification(): Response
    {

        $notifications = $this->repository->findByUserAndDisplayed($this->getUser()->getId(), false);

        return $this->render('notification/_notifications.html.twig', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * @Route("/new", name="notification_new", methods="POST")
     */
    public function new(Request $request): Response
    {

        $token = $request->request->get('token_notification');
        if ($this->isCsrfTokenValid('add_notification', $token)) {

            $descricao = $request->request->get('descricao_notification');
            $data = $request->request->get('data_notification');
            $hora = $request->request->get('hora_notification');
            $dateTime = "{$data} {$hora}";

            $cliente_id = $request->request->get('cliente_id');
            $negocio_id = $request->request->get('negocio_id');

            try {
                $negocio = $this->getDoctrine()->getRepository(Negocio::class)->find($negocio_id);

                $notification = new Notification();
                $notification->setNegocio($negocio);
                $notification->setUser($this->getUser());
                $notification->setUserTarget($this->getUser());
                $notification->setDescricao($descricao);
                $notification->setScheduledAt( \DateTime::createFromFormat("d/m/Y H:i", $dateTime));
                $notification->setDisplayed(false);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($notification);
                $em->flush();

                $this->addFlash("success", "Notificação adicionada com sucesso");
            } catch(Exception $ex) {
                $this->addFlash("danger", "Não foi possível adicionar a notificação. Tente novamente");
            }

            return $this->redirectToRoute("negocio_detail", ['negocio' => $negocio_id]);

        }

        throw new AccessDeniedException();
    }

    /**
     * @Route("/{notification}/{displayed}/set-displayed", name="notification_set_displayed", methods="GET")
     */
    public function setDisplayed(Request $request, Notification $notification, string $displayed): Response
    {

        $notification->setDisplayed($displayed == 'S');
        $em = $this->getDoctrine()->getManager();
        $em->persist($notification);
        $em->flush();

        return $this->redirectToRoute("notification");
    }
}
