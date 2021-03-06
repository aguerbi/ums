<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\TrainingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/training")
 */
class TrainingController extends AbstractController {

    /**
     * @Route("/", name="training_index", methods={"GET"})
     */
    public function index(TrainingRepository $trainingRepository, PaginatorInterface $paginator, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->query->getAlnum('search')) {
            $query = $entityManager->createQuery(
                            'SELECT t FROM App:Training t WHERE  t.title LIKE :search OR t.location LIKE :search'
                    )->setParameter('search', '%' . $request->query->getAlnum('search') . '%');
            $resulat = $query->getResult();
        } else {
            $resulat = $trainingRepository->findby([], ['id' => 'DESC']);
        }

        $trainings = $paginator->paginate(
                $resulat, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                20 /* limit per page */
        );
        return $this->render('training/index.html.twig', [
                    'trainings' => $trainings
        ]);
    }

    /**
     * @Route("/new", name="training_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $training = new Training();
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($training);
            $entityManager->flush();
            $this->addFlash('success', 'Formation ajouté');
            return $this->redirectToRoute('training_index');
        }

        return $this->render('training/new.html.twig', [
                    'training' => $training,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="training_show", methods={"GET"})
     */
    public function show(Training $training): Response {
        return $this->render('training/show.html.twig', [
                    'training' => $training,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="training_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Training $training): Response {
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Formation modifié');
            return $this->redirectToRoute('training_index');
        }

        return $this->render('training/edit.html.twig', [
                    'training' => $training,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="training_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Training $training): Response {
        if ($this->isCsrfTokenValid('delete' . $training->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($training);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Formation supprimé');
        return $this->redirectToRoute('training_index');
    }

}
