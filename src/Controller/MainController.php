<?php

namespace App\Controller;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'main.')]
class MainController extends AbstractController
{


    #[Route('/create', name: 'post')]
    public function Post(ManagerRegistry $doctrine)
    {
        //create a new  post with title
        $post = new Test();
        $post->setTitle('New Title');

        // entity manager
        $em = $doctrine->getManager();
        //upload
        $em->persist($post);
        //push
        $em->flush();

        return new Response();
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
}
