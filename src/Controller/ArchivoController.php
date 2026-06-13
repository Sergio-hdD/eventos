<?php

namespace App\Controller;

use App\Entity\Archivo;
use App\Form\ArchivoType;
use App\Repository\ArchivoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/archivo')]
final class ArchivoController extends AbstractController
{
    #[Route(name: 'app_archivo_index', methods: ['GET'])]
    public function index(ArchivoRepository $archivoRepository): Response
    {
        return $this->render('archivo/index.html.twig', [
            'archivos' => $archivoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_archivo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $archivo = new Archivo();
        $form = $this->createForm(ArchivoType::class, $archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($archivo);
            $entityManager->flush();

            return $this->redirectToRoute('app_archivo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('archivo/new.html.twig', [
            'archivo' => $archivo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_archivo_show', methods: ['GET'])]
    public function show(Archivo $archivo): Response
    {
        return $this->render('archivo/show.html.twig', [
            'archivo' => $archivo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_archivo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Archivo $archivo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArchivoType::class, $archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_archivo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('archivo/edit.html.twig', [
            'archivo' => $archivo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_archivo_delete', methods: ['POST'])]
    public function delete(Request $request, Archivo $archivo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$archivo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($archivo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_archivo_index', [], Response::HTTP_SEE_OTHER);
    }
}
