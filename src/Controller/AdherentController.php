<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Form\AdherentType;
use App\Repository\AdherentRepository;
use App\Repository\CardRepository;
use App\Repository\CompanyRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(AdherentRepository $adherentRepository, PaginatorInterface $paginator, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->query->getAlnum('search')) {
            $query = $entityManager->createQuery(
                            'SELECT a FROM App:Adherent a WHERE  a.firstName LIKE :search OR a.lastName LIKE :search OR a.mobile LIKE :search OR a.cin LIKE :search'
                    )->setParameter('search', '%' . $request->query->getAlnum('search') . '%');
            $resulat = $query->getResult();
        } else {
            $resulat = $adherentRepository->findby([], ['id' => 'DESC']);
        }

        $adherents = $paginator->paginate(
                $resulat, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                20 /* limit per page */
        );
        return $this->render('adherent/index.html.twig', [
                    'adherents' => $adherents
        ]);
    }

    /**
     * @Route("/{id}/new", name="adherent_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, CompanyRepository $companyRepository): Response {
        $adherent = new Adherent();
        $company = $companyRepository->find($id);
        $form = $this->createForm(AdherentType::class, $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $adherent->setCompany($company);
            $entityManager->persist($adherent);
            $entityManager->flush();

            return $this->redirectToRoute('company_show', ['id' => $id]);
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

        $memberSyndicate = $cardRepository->getMemberSyandicate($adherent);
        $electer = $cardRepository->getElecter($adherent);
        $memberSyndicate == 3 ? ($m = 'Oui') : ( $m = 'Non');
        $electer == 1 ? ($e = 'Oui') : ($e = 'Non');
        return $this->render('adherent/show.html.twig', [
                    'adherent' => $adherent, 'm' => $m, 'e' => $e,
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

            return $this->redirectToRoute('company_show', ['id' => $adherent->getCompany()->getId()]);
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

        return $this->redirectToRoute('company_show', ['id' => $adherent->getCompany()->getId()]);
    }

}
