<?php

namespace App\Controller;

use App\Entity\Events;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(EntityManagerInterface $em): Response
    {
        $events = $em->getRepository(Events::class)->findAll(); $data = [];

  foreach ($events as $event)

        { $data[] = [ 'id' => $event->getId(), 
            'title' => htmlspecialchars_decode($event->getTitle()), 
            'picture' => htmlspecialchars_decode($event->getPicture()), 
            'duration' => htmlspecialchars_decode($event->getDuration()), 
            'info' => htmlspecialchars_decode($event->getInfo()), 'date' => ($event->getDate()),
            'time' => ($event->getTime()), 
            'location' => htmlspecialchars_decode($event->getLocation()), 
            'transport' => htmlspecialchars_decode($event->getTransport()), ]; 
        } 
      

return
$this->json($data);
}
}
