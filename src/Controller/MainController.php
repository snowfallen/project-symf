<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'main')]
class MainController extends AbstractController
{


    #[Route('/create', name: 'name')]
    public function Post(Request $request)
    {
        dump($request);
        $post = new Test();
        $post->setTitle('Title');

        return new Response();
    }
}
