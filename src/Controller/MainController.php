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
    public function Post(ManagerRegistry $doctrine,Request $request)
    {
        //create a new  post with title
        $post = new Test();

        $form = $this->createForm(PostType::class,$post);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirect($this->generateUrl('page_get'));
        }
        // entity manager
        //$em = $doctrine->getManager();
        //upload

        //push
        //$em->flush();

        return $this->render('create/create.html.twig',[
            'form' => $form->createView()
        ]);
        //return $this->redirect($this->generateUrl('page_get'));
    }

    #[Route('/get', name: 'get')]
    public function Get(TestRepository $testRepository)
    {
        $posts = $testRepository->findAll();
        //dump($posts);
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
        ]);
    }

    #[Route('/show/{id}',name: "show")]
    public function show($id , TestRepository $testRepository)
    {
        $post = $testRepository->find($id);
        return $this->render('show/show.html.twig',[
            'post' => $post,
        ]);
    }

    #[Route('/delete/{id}',name: "delete")]
    public function remove(Test $test,ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();

        $em->remove($test);
        $em->flush();

        $this->addFlash('success','Post was removed');

        return $this->redirect($this->generateUrl('page_get'));
    }
}
