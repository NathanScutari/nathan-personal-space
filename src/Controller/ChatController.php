<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chat', name: 'chat')]
class ChatController extends AbstractController
{
    #[Route('/test', name: '_test')]
    public function index(): Response
    {
        $jwt = $_ENV['JWT'];
        $hubUrl = $_ENV['MERCURE_HUB_URL'];

        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'jwt' => $jwt,
            'hubUrl' => $hubUrl,
        ]);
    }
}
