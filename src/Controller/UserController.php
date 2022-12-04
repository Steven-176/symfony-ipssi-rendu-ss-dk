<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\PasswordChangeType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public function __construct(protected UserPasswordHasherInterface $userPasswordHasher)
    {      
    }

    #[Route('/profile/{id}', name: 'app_user_show')]
    public function getProfile(Request $request, User $user, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if ($user->getId() == $this->getUser()->getId()) {
            $profile = $user;
            $userArticles = $user->getArticles()->toArray();
            $userProducts = $user->getProducts()->toArray();

            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            $passwordForm = $this->createForm(PasswordChangeType::class, $user);
            $passwordForm->handleRequest($request);
    
            // Verification formulaire modification des informations
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
    
                $userRepository->save($user, true);
                // $entityManager->persist($user);
                // $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées.'
                );
                
                return $this->redirectToRoute('app_home');
            }

            // Verification formulaire modification du Mot de Passe
            if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
                // encode the plain password

                // dd($user, $this->userPasswordHasher->hashPassword($user,$passwordForm->get('plainPassword')->getData()), $passwordForm->get('plainPassword')->getData(), $user->getPassword());
                // if ($passwordForm->get('plainPassword')->getData() == $user->getPassword()) {
                //     $user->setPassword(
                //         $this->userPasswordHasher->hashPassword(
                //             $user,
                //             $passwordForm->get('password')->getData()
                //         )
                //     );
                // }

                $user->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $user,
                        $passwordForm->get('password')->getData()
                    )
                );

                $user = $passwordForm->getData();
    
                $userRepository->save($user, true);

                $this->addFlash(
                    'success',
                    'Le mot de passe de votre compte a bien été modifié.'
                );
                
                return $this->redirectToRoute('app_home');
            }

                    
        return $this->render('user/index.html.twig', [
            'user' => $profile,
            'articles' => $userArticles,
            'products' => $userProducts,
            'form' => $form->createView(),
            'passwordForm' => $passwordForm->createView()
        ]);

        } else {
            return $this->redirectToRoute('app_home');
        }
    }
}
