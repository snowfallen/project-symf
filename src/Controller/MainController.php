<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'main')]
class MainController extends AbstractController
{


    #[Route('/create', name: 'name')]
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
}
