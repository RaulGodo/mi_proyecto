<?php

namespace App\Controller;

use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\EventoDisponibilidadService;
use App\Service\EventoResumenService;

class EventoController extends AbstractBaseController
{
    #[Route('/eventos', name: 'app_eventos')]
    public function eventos(EventoRepository $repository): Response
    {
        $eventos = $repository->findEventosAlfabeticamente();

        return $this->render('evento/eventos.html.twig', [
            'eventos' => $eventos,
        ]);
    }
    #[Route('/evento/{slug}', name: 'app_evento_detalle')]
    public function evento(
        Request $request,
        EventoRepository $repository
    ): Response {
        $slug = $request->attributes->get('slug');

        $evento = $repository->findOneBy([
            'slug' => $slug,
        ]);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado'
            );
        }

        $this->addInfoMessage(
            sprintf(
                "Has leído sobre el evento '%s' a las %s.",
                $evento->getTitulo(),
                date('H:i:s')
            )

        );

        return $this->render('evento/evento.html.twig', [
            'evento' => $evento,
        ]);
    }
    #[Route(
        '/evento/{id}/disponibilidad',
        name: 'evento_disponibilidad',
        requirements: ['id' => '\d+']
    )]
    #[Route(
        '/evento/{id}/disponibilidad',
        name: 'evento_disponibilidad',
        requirements: ['id' => '\d+']
    )]
    public function disponibilidad(
        int $id,
        EventoRepository $repository,
        EventoResumenService $resumenService
    ): Response {
        $evento = $repository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado.'
            );
        }

        $resumen = $resumenService->obtenerResumen($evento);

        return $this->render('evento/disponibilidad.html.twig', [
            'evento' => $evento,
            'mensaje' => $resumen['mensaje'],
            'resumen' => $resumen,
        ]);
    }
}
