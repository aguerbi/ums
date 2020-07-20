<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController {

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginator): Response {

        $em = $this->getDoctrine()->getManager();
        if ($request->query->getAlnum('search')) {
            $query = $em->createQuery(
                            'SELECT u FROM App:User u WHERE  u.username LIKE :search OR u.fullName LIKE :search'
                    )->setParameter('search', '%' . $request->query->getAlnum('search') . '%');
            $result = $query->getResult();
        } else {
            $result = $userRepository->findBy(array(), array('id' => 'DESC'));
        }
        $users = $paginator->paginate(
                $result, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                30 // Nombre de résultats par page
        );
        return $this->render('user/index.html.twig', [
                    'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur ajouté');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response {
        return $this->render('user/show.html.twig', [
                    'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Utilisateur modifié');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete")
     */
    public function delete(User $user): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'Utilisateur supprimé');
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/enable", name="user_enable")
     */
    public function enbaled(User $user): Response {

        $entityManager = $this->getDoctrine()->getManager();
        $user->setEnabled(true);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'Utilisateur activé');
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/disable", name="user_disable")
     */
    public function disabled(User $user): Response {

        $entityManager = $this->getDoctrine()->getManager();
        $user->setEnabled(false);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'Utilisateur désactivé');
        return $this->redirectToRoute('user_index');
    }

}
