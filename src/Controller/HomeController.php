<?php

namespace App\Controller;

use App\Form\MemberSyndicatType;
use App\Repository\CompanyRepository;
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

}
