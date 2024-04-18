<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Reponsereclamation;
use App\Entity\User;
use App\Form\ReclamationType;
use App\Form\ReponsereclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{

    #[Route('/editrep/{idReponse}/{idr}', name: 'editrep', methods: ['GET', 'POST'])]
    public function editrep(Request $request, Reponsereclamation $reponsereclamation,$idr, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponsereclamationType::class, $reponsereclamation);
        $form->handleRequest($request);
        $reclamation= $entityManager
            ->getRepository(Reclamation::class)
            ->find($idr);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_showRecbyId', ['id'=>$idr], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponsereclamation/edit.html.twig', [
            'reponsereclamation' => $reponsereclamation,
            'form' => $form,
            'r' => $reclamation,

        ]);
    }

    #[Route('/showReclamation/{id}', name: 'app_reclamation_showRecbyId', methods: ['GET', 'POST'])]
    public function showReclamation(Request $request,EntityManagerInterface $entityManager,$id): Response
    {

        $reponsereclamation = new Reponsereclamation();
        $form = $this->createForm(ReponsereclamationType::class, $reponsereclamation);
        $form->handleRequest($request);
        $reps= $entityManager
            ->getRepository(Reponsereclamation::class)
            ->findOneBy(array('idReclamation'=>$id));
        $reponsereclamation->setDate(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation= $entityManager
                ->getRepository(Reclamation::class)
                ->find($id);
            $reponsereclamation->setIdReclamation($reclamation);
            $reclamation->setEtat("traitée");
            $entityManager->persist($reclamation);
            $entityManager->persist($reponsereclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_showRecbyId', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->find($id);

        return $this->render('reclamation/showreclamtion.html.twig', [
            'r' => $reclamations,
            'form' => $form->createView(),
            'reps' =>$reps
        ]);
    }


    #[Route('/reclamtionAdmin', name: 'app_reclamation_admin', methods: ['GET'])]
    public function indexAdmin(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/indexAdmin.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }


    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setIdUser($entityManager
                ->getRepository(User::class)
                ->find(1));
            $reclamation->setDateenv(new \DateTime());
            $reclamation->getUploadFile();
            $reclamation->setEtat("en attente");
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }




    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findBy(array("idUser"=>1));

        return $this->render(   'reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }



    #[Route('/{idReclamation}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idReclamation}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    #[Route('/deleterec/{id}', name: 'deleteReclamation')]
    public function delete(EntityManagerInterface $entityManager,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $h = $entityManager->getRepository(Reclamation::class)->find($id);
        $em->remove($h);
        $em->flush();
        return $this->redirectToRoute('app_reclamation_index');
    }

}
