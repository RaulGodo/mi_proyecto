<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractBaseController
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

    #[Route('/', name: 'app_portada')]
    public function portada(EntityManagerInterface $entityManager): Response
    {
        $eventos = $entityManager
            ->getRepository(Evento::class)
            ->findAll();

        shuffle($eventos);

        $eventos = array_slice($eventos, 0, 8);

        return $this->render('default/portada.html.twig', [
            'eventosCol1' => array_slice($eventos, 0, 4),
            'eventosCol2' => array_slice($eventos, 4, 4),
        ]);
    }
}
