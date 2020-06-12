<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Repository\CardRepository;
use App\Form\AdherentType;
use App\Repository\AdherentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adherent")
 */
class AdherentController extends AbstractController {

    /**
     * @Route("/", name="adherent_index", methods={"GET"})
     */
    public function index(AdherentRepository $adherentRepository): Response {
        return $this->render('adherent/index.html.twig', [
                    'adherents' => $adherentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="adherent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $adherent = new Adherent();
        $form = $this->createForm(AdherentType::class, $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adherent);
            $entityManager->flush();

            return $this->redirectToRoute('adherent_index');
        }

        return $this->render('adherent/new.html.twig', [
                    'adherent' => $adherent,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adherent_show", methods={"GET"})
     */
    public function show(Adherent $adherent, CardRepository $cardRepository): Response {
        $member = $cardRepository->getCountYear($adherent);
        $electer = $cardRepository->getNowYear($adherent);
        return $this->render('adherent/show.html.twig', [
                    'adherent' => $adherent,
                    'member' => $member,
                    'electer' => $electer
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adherent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Adherent $adherent): Response {
        $form = $this->createForm(AdherentType::class, $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adherent_index');
        }

        return $this->render('adherent/edit.html.twig', [
                    'adherent' => $adherent,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adherent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Adherent $adherent): Response {
        if ($this->isCsrfTokenValid('delete' . $adherent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adherent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adherent_index');
    }

}
