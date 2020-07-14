<?php

namespace App\Controller;

use App\Entity\Syndicat;
use App\Form\SyndicatType;
use App\Repository\CompanyRepository;
use App\Repository\SyndicatRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/syndicat")
 */
class SyndicatController extends AbstractController {

    /**
     * @Route("/", name="syndicat_index", methods={"GET"})
     */
    public function index(SyndicatRepository $syndicatRepository, PaginatorInterface $paginator, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->query->getAlnum('search')) {
            $query = $entityManager->createQuery(
                            'SELECT s FROM App:Syndicat s WHERE  s.name LIKE :search'
                    )->setParameter('search', '%' . $request->query->getAlnum('search') . '%');
            $resulat = $query->getResult();
        } else {
            $resulat = $syndicatRepository->findby([], ['id' => 'DESC']);
        }

        $syndicats = $paginator->paginate(
                $resulat, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                20 /* limit per page */
        );


        return $this->render('syndicat/index.html.twig', [
                    'syndicats' => $syndicats,
        ]);
    }

    /**
     * @Route("/{id}/new", name="syndicat_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, CompanyRepository $companyRepository): Response {
        $syndicat = new Syndicat();
        $company = $companyRepository->find($id);
        $form = $this->createForm(SyndicatType::class, $syndicat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $syndicat->setCompany($company);
            $entityManager->persist($syndicat);
            $entityManager->flush();

            return $this->redirectToRoute('company_show', ['id' => $id]);
        }

        return $this->render('syndicat/new.html.twig', [
                    'syndicat' => $syndicat,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="syndicat_show", methods={"GET"})
     */
    public function show(Syndicat $syndicat): Response {
        return $this->render('syndicat/show.html.twig', [
                    'syndicat' => $syndicat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="syndicat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Syndicat $syndicat): Response {
        $form = $this->createForm(SyndicatType::class, $syndicat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_show', ['id' => $syndicat->getCompany()->getId()]);
        }

        return $this->render('syndicat/edit.html.twig', [
                    'syndicat' => $syndicat,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="syndicat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Syndicat $syndicat): Response {
        if ($this->isCsrfTokenValid('delete' . $syndicat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($syndicat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_show', ['id' => $syndicat->getCompany()->getId()]);
    }

}
