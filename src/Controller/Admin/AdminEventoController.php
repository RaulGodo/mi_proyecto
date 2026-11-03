<?php

namespace App\Controller\Admin;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/evento')]

class AdminEventoController extends AbstractAdminBaseController
{
    #[Route('/listar', name: 'admin_evento_listar')]

    public function listar(
        EventoRepository $eventoRepository
    ): Response {

        $eventos = $eventoRepository->findEventosAlfabeticamente();

        return $this->render('admin/evento/listar.html.twig', [
            'eventos' => $eventos,
        ]);
    }
    #[Route(
        '/inscriptos/{id}',
        name: 'admin_evento_inscriptos',
        requirements: ['id' => '\d+']
    )]
    public function inscriptos(
        int $id,
        EventoRepository $eventoRepository
    ): Response {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'Evento no encontrado'
            );
        }

        return $this->render(
            'admin/evento/inscriptos.html.twig',
            [
                'evento' => $evento,
            ]
        );
    }
    #[Route(
        '/borrar/{id}',
        name: 'admin_evento_borrar',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]

    public function borrar(
        int $id,
        Request $request,
        EventoRepository $eventoRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado.'
            );
        }

        // Verificar el token CSRF
        $token = $request->getPayload()->getString('_token');

        if (!$this->isCsrfTokenValid(
            'delete' . $evento->getId(),
            $token
        )) {
            throw $this->createAccessDeniedException(
                'Token CSRF inválido.'
            );
        }

        $titulo = $evento->getTitulo();

        $entityManager->remove($evento);
        $entityManager->flush();

        $this->addSuccessMessage(
            sprintf(
                "El evento '%s' se ha borrado correctamente.",
                $titulo
            )
        );

        return $this->redirectToAdmin();
    }
    #[Route(
        '/nuevo',
        name: 'admin_evento_nuevo',
        methods: ['GET', 'POST']
    )]
    public function nuevo(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $evento = new Evento();

        $form = $this->createForm(
            EventoType::class,
            $evento
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($evento);
            $entityManager->flush();

            $this->addSuccessMessage(
                'Evento creado correctamente.'
            );

            return $this->redirectToAdmin();
        }

        return $this->render(
            'admin/evento/nuevo.html.twig',
            [
                'form' => $form,
            ]
        );
    }
    #[Route(
        '/ver/{id}',
        name: 'admin_evento_ver',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function ver(
        int $id,
        EventoRepository $eventoRepository
    ): Response {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado.'
            );
        }

        return $this->render(
            'admin/evento/ver.html.twig',
            [
                'evento' => $evento,
            ]
        );
    }
    #[Route(
        '/editar/{id}',
        name: 'admin_evento_editar',
        requirements: ['id' => '\d+'],
        methods: ['GET', 'POST']
    )]
    public function editar(
        int $id,
        Request $request,
        EventoRepository $eventoRepository,
        EntityManagerInterface $entityManager
    ): Response {

        // Buscar el evento existente
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado.'
            );
        }

        // Crear el formulario con los datos del evento
        $form = $this->createForm(
            EventoType::class,
            $evento
        );

        // Procesar la petición
        $form->handleRequest($request);

        // Guardar los cambios si el formulario es válido
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addSuccessMessage(
                'Evento actualizado correctamente.'
            );

            return $this->redirectToAdmin();
        }

        // Mostrar el formulario
        return $this->render(
            'admin/evento/editar.html.twig',
            [
                'form' => $form,
                'evento' => $evento,
            ]
        );
    }
}
