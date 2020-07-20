<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\CompanyRepository;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController {

    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, PaginatorInterface $paginator, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->query->getAlnum('search')) {
            $query = $entityManager->createQuery(
                            'SELECT e FROM App:Event e WHERE  e.title LIKE :search'
                    )->setParameter('search', '%' . $request->query->getAlnum('search') . '%');
            $resulat = $query->getResult();
        } else {
            $resulat = $eventRepository->findby([], ['id' => 'DESC']);
        }

        $events = $paginator->paginate(
                $resulat, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                20 /* limit per page */
        );

        return $this->render('event/index.html.twig', [
                    'events' => $events,
        ]);
    }

    /**
     * @Route("/{id}/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, CompanyRepository $companyRepository): Response {
        $event = new Event();
        $company = $companyRepository->find($id);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $event->setCompany($company);
            $entityManager->persist($event);
            $entityManager->flush();
            $this->addFlash('success', 'Evènement ajouté');
            return $this->redirectToRoute('company_show', ['id' => $id, '_fragment' => 'nav-ev']);
        }

        return $this->render('event/new.html.twig', [
                    'event' => $event,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response {
        return $this->render('event/show.html.twig', [
                    'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Evènement modifié');
            return $this->redirectToRoute('company_show', ['id' => $event->getCompany()->getId(), '_fragment' => 'nav-ev']);
        }

        return $this->render('event/edit.html.twig', [
                    'event' => $event,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{company}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event, $company): Response {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Evènement supprimé');
        return $this->redirectToRoute('company_show', ['id' => $company, '_fragment' => 'nav-ev']);
    }

}
