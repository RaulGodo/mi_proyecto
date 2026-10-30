<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonaController extends AbstractController
{
    #[Route('/persona', name: 'app_persona')]
    public function index(): Response
    {
        return $this->render('persona/index.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/nuevo', name: 'app_nuevo')]
    public function new()
    {
        var_dump("hola mundo");exit;
        return "hola mundo";
    }


}



