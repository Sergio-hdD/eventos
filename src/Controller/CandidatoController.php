<?php

namespace App\Controller;

use App\Entity\Candidato;
use App\Form\CandidatoType;
use App\Repository\CandidatoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/candidato')]
final class CandidatoController extends AbstractController
{
    #[Route(name: 'app_candidato_index', methods: ['GET'])]
    public function index(CandidatoRepository $candidatoRepository): Response
    {
        return $this->render('candidato/index.html.twig', [
            'candidatos' => $candidatoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_candidato_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidato = new Candidato();
        $form = $this->createForm(CandidatoType::class, $candidato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidato);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidato/new.html.twig', [
            'candidato' => $candidato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidato_show', methods: ['GET'])]
    public function show(Candidato $candidato): Response
    {
        return $this->render('candidato/show.html.twig', [
            'candidato' => $candidato,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidato_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidato $candidato, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatoType::class, $candidato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidato/edit.html.twig', [
            'candidato' => $candidato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidato_delete', methods: ['POST'])]
    public function delete(Request $request, Candidato $candidato, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidato->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($candidato);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidato_index', [], Response::HTTP_SEE_OTHER);
    }
}
