<?php

namespace App\Controller;

use App\Entity\Trainer;
use App\Form\MemberSyndicatType;
use App\Form\ParticipantType;
use App\Form\TrainerTrainingType;
use App\Form\TrainerType;
use App\Repository\AdherentRepository;
use App\Repository\CardRepository;
use App\Repository\CompanyRepository;
use App\Repository\SyndicatRepository;
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
    public function index(CardRepository $cardRepository) {
        $m = $cardRepository->getListMembersSyndicates();

        // dd($m);
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/add-member-syndicat", name="add_member_syndicat")
     */
    public function addMemberSyndicat(Request $request, SyndicatRepository $syndicatRepository): Response {
        $form = $this->createForm(MemberSyndicatType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $syndicat_1 = $form->get('syndicat')->getData();
            $syndicat = $syndicatRepository->find($syndicat_1);
            $member = $form->get('adherent')->getData();
            $syndicat->addMemberSyndicat($member);
            $entityManager->persist();
            $entityManager->flush();
        }
        $this->addFlash('success', 'Membre Syndicat ajouté');
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
            $this->addFlash('success', 'Formateur ajouté');
            return $this->redirectToRoute('training_show', ['id' => $id, '_fragment' => 'nav-tr']);
        }

        return $this->render('training/add_trainer.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/add-participant", name="add_participant", methods={"GET","POST"})
     */
    public function addParticipant(TrainingRepository $trainingRepository, Request $request, $id, AdherentRepository $adherentRepository): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $training = $trainingRepository->find($id);
        $form = $this->createForm(ParticipantType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->get('participant')->getData();
            // dd($trainer);
            $training->addParticipant($participant);
            $entityManager->persist($training);
            $entityManager->flush();
            $this->addFlash('success', 'Participant ajouté');
            return $this->redirectToRoute('training_show', ['id' => $id, '_fragment' => 'nav-fr']);
        }

        return $this->render('training/add_participant.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
