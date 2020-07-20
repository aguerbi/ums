<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\AdherentRepository;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card")
 */
class CardController extends AbstractController {

    /**
     * @Route("/", name="card_index", methods={"GET"})
     */
    public function index(CardRepository $cardRepository): Response {
        return $this->render('card/index.html.twig', [
                    'cards' => $cardRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="card_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, AdherentRepository $adherentRepository): Response {
        $card = new Card();
        $adherent = $adherentRepository->find($id);
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $card->setAdherent($adherent);
            $entityManager->persist($card);
            $entityManager->flush();
            $this->addFlash('success', 'Carte ajouté');
            return $this->redirectToRoute('adherent_show', ['id' => $id]);
        }

        return $this->render('card/new.html.twig', [
                    'card' => $card,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="card_show", methods={"GET"})
     */
    public function show(Card $card): Response {
        return $this->render('card/show.html.twig', [
                    'card' => $card,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="card_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Card $card): Response {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Carte modifié');
            return $this->redirectToRoute('adherent_show', ['id' => $card->getAdherent()->getId()]);
        }

        return $this->render('card/edit.html.twig', [
                    'card' => $card,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="card_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Card $card): Response {
        if ($this->isCsrfTokenValid('delete' . $card->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($card);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Carte supprimé');
        return $this->redirectToRoute('adherent_show', ['id' => $card->getAdherent()->getId()]);
    }

}
