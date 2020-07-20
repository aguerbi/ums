<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController {

    /**
     * @Route("/", methods={"GET", "POST"}, name="show_profile")
     */
    public function showProfile() {
        $user = $this->getUser();

        return $this->render('Account/show_profile.html.twig', [
                    'user' => $user,
        ]);
    }

    /**
     * @Route("/edit-profile", methods={"GET", "POST"}, name="edit_profile")
     */
    public function editProfile(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $editForm = $this->createForm('App\Form\ProfileType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Mise à jour de compte effectué avec succès');
            return $this->redirectToRoute('show_profile');
        }

        return $this->render('Account/edit_profile.html.twig', array(
                    'user' => $user,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/change-password", methods={"GET", "POST"}, name="change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Mot de passe changé');
            return $this->redirectToRoute('show_profile');
        }
        return $this->render('Account/change_password.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
