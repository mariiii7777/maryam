<?php

namespace App\Controller;

use App\Entity\BasicBundle;
use App\Form\BasicBundleType;
use App\Repository\BasicBundleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/basic/bundle')]
final class BasicBundleController extends AbstractController
{
    #[Route('', name: 'app_basic_bundle_index', methods: ['GET'])]
    public function index(BasicBundleRepository $basicBundleRepository): Response
    {
        return $this->render('basic_bundle/index.html.twig', [
            'basic_bundles' => $basicBundleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_basic_bundle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $basicBundle = new BasicBundle();
        $form = $this->createForm(BasicBundleType::class, $basicBundle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($basicBundle);
            $entityManager->flush();

            return $this->redirectToRoute('app_basic_bundle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('basic_bundle/new.html.twig', [
            'basic_bundle' => $basicBundle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_basic_bundle_show', methods: ['GET'])]
    public function show(BasicBundle $basicBundle): Response
    {
        return $this->render('basic_bundle/show.html.twig', [
            'basic_bundle' => $basicBundle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_basic_bundle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BasicBundle $basicBundle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BasicBundleType::class, $basicBundle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_basic_bundle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('basic_bundle/edit.html.twig', [
            'basic_bundle' => $basicBundle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_basic_bundle_delete', methods: ['POST'])]
    public function delete(Request $request, BasicBundle $basicBundle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $basicBundle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($basicBundle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_basic_bundle_index', [], Response::HTTP_SEE_OTHER);
    }
}
