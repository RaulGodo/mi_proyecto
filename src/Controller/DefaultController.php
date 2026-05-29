<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    #[Route(
        '/sitio/{pagina}',
        name: 'app_estatica',
        defaults: ['pagina' => 'patrocinadores'],
        requirements: [
            'pagina' => 'patrocinadores|privacidad|condiciones|licencia'
        ]
    )]
    public function estatica(string $pagina): Response
    {
        return $this->render('estatica/' . $pagina . '.html.twig');
    }

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_portada')]
    public function portada(): Response
    {
        $em = $this->entityManager;

        $eventos = $em->getRepository(Evento::class)->findAll();

        shuffle($eventos);
        // dump ($eventos); exit; // Verificar la estructura de los datos y asegurarse de que sean objetos Evento

        $eventos = array_slice($eventos, 0, 8);

        return $this->render('default/portada.html.twig', [
            'eventosCol1' => array_slice($eventos, 0, 4),
            'eventosCol2' => array_slice($eventos, 4, 4),
        ]);
    }
}
