<?php

namespace App\Controller;

use App\Entity\Events;
use DateTime;
use DateTimeInterface;
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
            'info' => htmlspecialchars_decode($event->getInfo()),
            'date' => ($event->getDate()),
            'time' => ($event->getTime()), 
            'location' => htmlspecialchars_decode($event->getLocation()), 
            'transport' => htmlspecialchars_decode($event->getTransport()), ]; 
        } 
      

return
$this->json($data);
}

#[Route('/event/{id}', name:'getOne')]
function getData(EntityManagerInterface $em, int $id): Response
    {
    $event = $em->getRepository(Events::class)->find($id);

    $data = [
        'id' => $event->getId(),
        'title' => htmlspecialchars_decode($event->getTitle()), 
        'picture' => htmlspecialchars_decode($event->getPicture()), 
        'duration' => htmlspecialchars_decode($event->getDuration()), 
        'info' => htmlspecialchars_decode($event->getInfo()),
        'date' => ($event->getDate()),
        'time' => ($event->getTime()), 
        'location' => htmlspecialchars_decode($event->getLocation()), 
        'transport' => htmlspecialchars_decode($event->getTransport()),
    ];

    return 
    $this->json($data);
}

#[Route('/addEvent', name:'createEvent', methods:['POST'])]
function add(Request $request, ManagerRegistry $doctrine)
    {
    $em = $doctrine->getManager();
    $newEvent = new Events();
    $newEvent->setTitle(htmlspecialchars($request->request->get('title')));
    $newEvent->setInfo(htmlentities($request->request->get('info')));
    $newEvent->setPicture($request->request->get('picture'));
    $newEvent->setDate(date_create());
    $newEvent->setTime(date_create());
    $newEvent->setDuration(number_format(($request->request->get('duration'))));
    $newEvent->setLocation(htmlspecialchars($request->request->get('location')));
    $newEvent->setTransport(htmlspecialchars($request->request->get('transport')));
    $em->persist($newEvent);
    $em->flush();
    return $this->json('Created new project successfully with id ');

}
}
