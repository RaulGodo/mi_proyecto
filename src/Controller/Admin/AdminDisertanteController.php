<?php

namespace App\Controller\Admin;

use App\Entity\Disertante;
use App\Form\DisertanteType;
use App\Repository\DisertanteRepository;
use App\Service\DisertanteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/disertantes')]
class AdminDisertanteController extends AbstractAdminBaseController
{
    #[Route('', name: 'admin_disertante_listar', methods: ['GET'])]
    public function listar(DisertanteRepository $repository): Response
    {
        return $this->render('admin/disertante/listar.html.twig', [
            'disertantes' => $repository->findDisertantesAlfabeticamente(),
        ]);
    }

    #[Route('/nuevo', name: 'admin_disertante_nuevo', methods: ['GET', 'POST'])]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        $disertante = new Disertante();
        $form = $this->createForm(DisertanteType::class, $disertante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($disertante);
            $em->flush();

            $this->addSuccessMessage('Disertante creado correctamente.');
            return $this->redirectToRoute('admin_disertante_listar');
        }

        return $this->render('admin/disertante/nuevo.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_disertante_ver', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function ver(
        Disertante $disertante,
        DisertanteService $disertanteService
    ): Response {
        return $this->render('admin/disertante/ver.html.twig', [
            'disertante' => $disertante,
            'nombreCompleto' => $disertanteService->obtenerNombreCompleto($disertante),
        ]);
    }

    #[Route('/{id}/editar', name: 'admin_disertante_editar', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function editar(Request $request, Disertante $disertante, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(DisertanteType::class, $disertante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addSuccessMessage('Disertante modificado correctamente.');
            return $this->redirectToRoute('admin_disertante_listar');
        }

        return $this->render('admin/disertante/editar.html.twig', [
            'form' => $form,
            'disertante' => $disertante,
        ]);
    }

    #[Route('/{id}/borrar', name: 'admin_disertante_borrar', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function borrar(Request $request, Disertante $disertante, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('borrar' . $disertante->getId(), $request->request->get('_token'))) {
            $nombre = $disertante->getNombreCompleto();
            $em->remove($disertante);
            $em->flush();

            $this->addSuccessMessage(sprintf("El disertante '%s' se ha borrado correctamente.", $nombre));
        } else {
            $this->addErrorMessage('Token de seguridad inválido.');
        }

        return $this->redirectToRoute('admin_disertante_listar');
    }
}
