<?php

namespace App\Controller;

use App\Form\PostType;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'page_')]
class MainController extends AbstractController
{


    #[Route('/', name: "root")]
    public function redirecting(){
        return $this->redirectToRoute('page_home');
    }
    #[Route('/home', name: "home")]
    public function home()
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    #[Route('/create', name: 'post')]
    public function Post(ManagerRegistry $doctrine,Request $request) //get ManagerRegistry for future getting doctrine
    {
        //create a new  post with title
        $post = new Test(); // Test is the entity class

        $form = $this->createForm(PostType::class,$post); // PostType that is my form with input field

        $form->handleRequest($request); // was called for processing forms data
        if ($form->isSubmitted()){  //check is forms was submitted
            $em = $doctrine->getManager(); // get manager for works with doctrine
            $em->persist($post); // pass object for processing
            $em->flush(); // pass data(all changes) to entity(database)
            return $this->redirect($this->generateUrl('page_get'));
        }

        return $this->render('create/create.html.twig',[
            'form' => $form->createView()  // create element
        ]);
        //return $this->redirect($this->generateUrl('page_get'));
    }

    #[Route('/get', name: 'get')]
    public function Get(TestRepository $testRepository)//get repository
    {
        $posts = $testRepository->findAll(); // find and get all elements in repo
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
        ]);
    }

    #[Route('/show/{id}',name: "show")]
    public function show($id , TestRepository $testRepository) // we must get id into the function variable
    {
        $post = $testRepository->find($id);// find and get all elements in repo by id
        return $this->render('show/show.html.twig',[
            'post' => $post,
        ]);
    }

    #[Route('/delete/{id}',name: "delete")]
    public function remove(Test $test,ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager(); // get manager for works with doctrine

        $em->remove($test); // remove elements
        $em->flush(); // push all changes to database

        $this->addFlash('success','Post was removed'); // Flash massage

        return $this->redirect($this->generateUrl('page_get'));
    }
}
