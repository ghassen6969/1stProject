<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/crud/author')]
class CrudAuthorController extends AbstractController
{     //method to insert a new author
    #[Route('/new', name:'app_new_author')]
    public function newAuthor(ManagerRegistry $doctrine):Response
    {   //create instance from the class author
        $author= new Author();
        $author->setName('Ahmed ');
        $author->setEmail('ahmed@gmail.com');
        $author->setAddress('Tunis');
        $author->setNbrBooks(4);
        //persist the object in the doctrine
        $em=$doctrine->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute("app_list_author");
    }
    #[Route('/list', name: 'app_list_author')]
    public function list(AuthorRepository $repository): Response
    {
        $list=$repository->findAuthorsByEmail('e');
        return $this->render('crud_author/list.html.twig', ['list'=>$list]);
    }
    // search an author by name
    #[Route("/search/{name}",name:'app_crud_search')]
    public function searchByName(AuthorRepository $repository,Request $request ):Response
    {   //get the data name from the request
        $name=$request->get('name');
        //var_dump($name);die();
        //use a magic method to make a reearch by Name
        $authors=$repository->findByName($name);
        //var_dump($authors);die();
        return $this->render('crud_author/list.html.twig',
        ['list'=>$authors]);

    }

    //delete an author
    #[Route("/delete/{id}",name:"app_delete_author")]
    public function deleteAuthor(Author $author, ManagerRegistry $doctrine):Response
    {
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("app_list_author");

    }

    // update an author
    #[Route('/update/{id}',name:'app_update_author')]
     public function updateAuthor(Request $request,AuthorRepository $rep, ManagerRegistry $doctrine):Response{
       //get the old object from the data base
        $id=$request->get('id');
        $author= $rep->find($id);
        //update the object
        $author->setEmail('badia@gmail.com');
        //save this update in the DB
        $em=$doctrine->getManager();
        $em->flush();
        return  $this->redirectToRoute("app_list_author");
    }
}