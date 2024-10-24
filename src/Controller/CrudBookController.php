<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/crud/book')]
class CrudBookController extends AbstractController
{
    #[Route('/new', name: 'app_new_book')]
    public function newBook(ManagerRegistry $doctrine, Request $request): Response
    {
      //1.create instance of Book
        $book= new Book();
        //2. create interface
        $form=$this->createForm(BookType::class,$book);
        //4. get data from Form /interface
        $form=$form->handleRequest($request);
        //5. check if the form is valid and submitted
        if($form->isSubmitted()&& $form->isValid()){
            //6.getManager
            //7.save into the DB : flush
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return  $this->redirectToRoute('app_book_list');
        }

        // 3. send interface to the user
        return  $this->render('crud_book/form.html.twig',
            ['form'=>$form->createView()]);


    }
    #[Route('/list', name: 'app_book_list')]
    public function listBook(BookRepository $repository):Response
    {
        $books=$repository->findAll();
        return  $this->render('crud_book/index.html.twig',
            ['books'=>$books]);
    }


}