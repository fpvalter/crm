<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notification")
 */
class NotificationController extends BaseController
{
    /**
     * @Route("/get-notification", name="notification_get", methods="POST")
     */
    public function getNotification(): Response
    {

        $notificationRepo = $this->getDoctrine()->getRepository(Notification::class);
        $notifications = $notificationRepo->findByDisplayed(false);

        return $this->render('notification/_notifications.html.twig', [
            'notifications' => $notifications,
        ]);
    }
}
