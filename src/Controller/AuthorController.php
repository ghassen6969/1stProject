<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/author')]
class AuthorController extends AbstractController
{   #[Route('/show',name:'app_author_show')]
    public function showAuthor():Response{
        $authorName='Victor Hugo';
        $authorEmail='vh@gmail.com';
        return $this->render('author/showAuthor.html.twig',
        array(
            'authorName'=>$authorName,
            'authorEmail'=>$authorEmail
        ));
    }
    #[Route('/list',name:'app_list_authors')]
    public function listAuthors(): Response {
        $authors=[
            ["authorName"=>"Victor Hugo","picture"=>"images/vh.jpeg","nbrBooks"=>44],
            ["authorName"=>"william S","picture"=>"images/ws.jpeg","nbrBooks"=>55],
            ["authorName"=>"taha hsin","picture"=>"images/th.jpeg","nbrBooks"=>4]
        ];
        return $this->render('author/listAuthors.html.twig',[
            'list1'=>$authors
        ]);

    }
}
