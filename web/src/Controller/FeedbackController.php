<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Events;
use App\Entity\Feedback;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name:'feedback', methods:['POST'])]
function feedback(Request $request, ManagerRegistry $doctrine): Response
    {
    $em = $doctrine->getManager();
    $data = json_decode($request->getContent(), true);

    $event = $em->getRepository(Events::class)->find($data['event']);
    $user = $em->getRepository(Login::class)->find($data['user']);
    $feedback = $data['feedback'];

    if (!$event || !$user) {
        return $this->json('Event or user not found.', Response::HTTP_NOT_FOUND);
    }

    $newRelation = new Feedback();
    $newRelation->setEventId($event);
    $newRelation->setUserId($user);
    $newRelation->setFeedback($feedback);

    $em->persist($newRelation);
    $em->flush();

    return $this->json('Your feedback has been submitted.');
    }
    #[Route('/checkfeedback', name:'checkfeedback', methods:['POST'])]
    function checkfeedback(Request $request, ManagerRegistry $doctrine): Response
        {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);
    
        $event = $em->getRepository(Events::class)->find($data['event']);
        $user = $em->getRepository(Login::class)->find($data['user']);
    
        $followedRepository = $em->getRepository(Feedback::class);
        $exists = $followedRepository->findOneBy([
            'eventId' => $event->getId(),
            'userId' => $user->getId(),
        ]);
    
        if ($exists) {
            return $this->json('You have already submitted feedback about this event.');
        }

        return $this->json('');
    }
}
