<?php

namespace App\Controller;

use App\Entity\Trainer;
use App\Form\MemberSyndicatType;
use App\Form\TrainerTrainingType;
use App\Form\TrainerType;
use App\Repository\CompanyRepository;
use App\Repository\TrainerRepository;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function index() {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/{id}/add-member-syndicat", name="add_member_syndicat")
     */
    public function addMemberSyndicat(Request $request, $id, CompanyRepository $companyRepository): Response {
        $company = $companyRepository->find($id);
        $form = $this->createForm(MemberSyndicatType::class, ['var' => $id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist();
            $entityManager->flush();
        }

        return $this->render('member_syndicat/new.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/add-trainer-training", name="add_trainer_training", methods={"GET","POST"})
     */
    public function addTrainerTraining(TrainingRepository $trainingRepository, Request $request, $id, TrainerRepository $trainerRepository): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $training = $trainingRepository->find($id);
        $form = $this->createForm(TrainerTrainingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trainer = $form->get('trainer')->getData();
            // dd($trainer);
            $training->addTrainer($trainer);
            $entityManager->persist($training);
            $entityManager->flush();

            return $this->redirectToRoute('training_show', ['id' => $id]);
        }

        return $this->render('training/add_trainer.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
