<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Home;
use App\Entity\User;
use App\Form\HomeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $homes = $entityManager
            ->getRepository(Home::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'homes' => $homes,
        ]);
    }

    #[Route('/new', name: 'app_home_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $home = new Home();
        $user = $entityManager
            ->getRepository(User::class)
            ->find(1);

        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        $home->setIdUser($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $home->getUploadFile();
            $entityManager->persist($home);
            $entityManager->flush();

            return $this->redirectToRoute('app_home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/new.html.twig', [
            'home' => $home,
            'form' => $form,
        ]);
    }

    #[Route('/{idHome}', name: 'app_home_show', methods: ['GET'])]
    public function show(Home $home): Response
    {
        return $this->render('home/show.html.twig', [
            'home' => $home,
        ]);
    }

    #[Route('/{idHome}/edit', name: 'app_home_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Home $home, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/edit.html.twig', [
            'home' => $home,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $h = $entityManager->getRepository(Home::class)->find($id);
        $em->remove($h);
        $em->flush();
        return $this->redirectToRoute('app_home_index');
    }

}
