<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request,ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordHasher)
    {

        //form for login
        $form = $this->createFormBuilder()  //forms field
            ->add('username') //add new field into forms
            ->add('password',RepeatedType::class,[ //add new field into forms with some parameters
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label'=>'Password'],
                'second_options' => ['label'=>'Repeat Password'],
            ])
            ->add('register',SubmitType::class,[
                'attr' => [
                    'class' => 'btn-success float-end m-2'
                ]
            ])
            ->getForm(); // we will get form
        $form ->handleRequest($request); // was called for processing forms data

        if($form->isSubmitted()){
            $data = $form->getData(); //get data from form
            $user = new User();
            $user->setUsername($data['username']); // get username from arr data by key-words
            $user->setPassword($passwordHasher->hashPassword($user,$data['password'])); // get password and hash them
            $em = $doctrine->getManager(); // get doctrine manager

            $em->persist($user); // pass object for processing
            $em->flush(); // push all changes to database
            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView() // create elements
        ]);
    }
}
