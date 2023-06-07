<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Events;
use App\Entity\Followed;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowedController extends AbstractController
{
    #[Route('/follow', name:'follow', methods:['POST'])]
function follow(Request $request, ManagerRegistry $doctrine): Response
    {
    $em = $doctrine->getManager();
    $data = json_decode($request->getContent(), true);

    $event = $em->getRepository(Events::class)->find($data['event']);
    $user = $em->getRepository(Login::class)->find($data['user']);

    if (!$event || !$user) {
        return $this->json('Event or user not found.', Response::HTTP_NOT_FOUND);
    }

    $exists = $em->getRepository(Followed::class)->findOneBy([
        'eventId' => $data['event'],
        'userId' => $data['user'],
    ]);

    if ($exists) {
        return $this->json('You have already signed for this event.');
    }

    $newRelation = new Followed();
    $newRelation->setEventId($event);
    $newRelation->setUserId($user);

    $em->persist($newRelation);
    $em->flush();

    return $this->json('You have reserved a place for this event.');
    }

    #[Route('/unfollow', name: 'unfollow', methods: ['POST'])]
    public function unfollow(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);

        $relation = $em->getRepository(Followed::class)->findOneBy([
            'eventId' => $data['event'],
            'userId' => $data['user'],
        ]);

        if ($relation) {
            $em->remove($relation);
            $em->flush();

            return $this->json('You have canceled your place for this event.');
        }

        return $this->json('You are not participating in this event.');
    }

    #[Route('/myevents/{userId}', name: 'myevents', methods: ['GET'])]
    public function myevents(int $userId, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $user = $em->getRepository(Login::class)->find($userId);

        if (!$user) {
            return $this->json('User not found.', Response::HTTP_NOT_FOUND);
        }

        $followedEvents = $em->getRepository(Followed::class)->findBy(['userId' => $user]);
        $events = array_map(fn (Followed $followed) => $followed->getEventId()->getId(), $followedEvents);
        $myevents = $em->getRepository(Events::class)->findBy(['id' => $events]);

        foreach ($myevents as $event)

        { $res[] = [ 'id' => $event->getId(), 
            'title' => htmlspecialchars_decode($event->getTitle()), 
            'picture' => htmlspecialchars_decode($event->getPicture()), 
            'duration' => htmlspecialchars_decode($event->getDuration()), 
            'info' => htmlspecialchars_decode($event->getInfo()),
            'date' => htmlspecialchars_decode($event->getDate()),
            'time' => htmlspecialchars_decode($event->getTime()),
            'location' => htmlspecialchars_decode($event->getLocation()), 
            'transport' => htmlspecialchars_decode($event->getTransport()), ]; 
        } 

        return $this->json($res);
    }
}
