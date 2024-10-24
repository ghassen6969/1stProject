<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Library;
use App\Repository\AuthorRepository;
use App\Repository\LibraryRepository;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/crud/library')]
class CrudLibraryController extends AbstractController
{
    #[Route('/list', name: 'app_crud_library')]
    public function list(LibraryRepository $repository): Response
    {

        $list = $repository->findAll();
        return $this->render('crud_library/list.html.twig', ['list' => $list]);
    }

    //insert library
    #[Route('/new', name: 'app_crud_library_new')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {

        if ($request->isMethod('POST')) {

            $name = $request->request->get('name');
            $website = $request->request->get('website');
            $creationDateStr = $request->request->get('creationDate');


            $creationDate = new \DateTime($creationDateStr);


            $library = new Library();
            $library->setName($name);
            $library->setWebsite($website);
            $library->setDateCreation($creationDate);

            // Persist and flush the new Library entity to the database
            $em = $doctrine->getManager();
            $em->persist($library);
            $em->flush();

            // Redirect to another route (e.g., the library list) after the form is processed
            return $this->redirectToRoute('app_crud_library');
        }

        // If the request is not POST, display the form (GET request)
        return $this->render('crud_library/form.html.twig');
    }


    //delete library
    #[Route('/delete/{id}', name: 'app_delete_library')]
    public function deleteLibrary(Library $library, ManagerRegistry $doctrine): Response
    {

        $em = $doctrine->getManager();
        $em->remove($library);
        $em->flush();
        return $this->redirectToRoute('app_crud_library');
    }


    #[Route('/update/{id}', name: 'app_crud_update_library')]
    public function update(ManagerRegistry $doctrine, LibraryRepository $repository, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $id = $request->get('id');
            $library = $repository->find($id);


            $newName = $request->request->get('name');
            $newWebsite = $request->request->get('website');
            $creationDateStr = $request->request->get('creationDate');

            $creationDate = new \DateTime($creationDateStr);

            $library->setName($newName);
            $library->setWebsite($newWebsite);
            $library->setDateCreation($creationDate);

            //presist the object in the doctrine
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_crud_library');
        }


        return $this->render('crud_library/formupdate.html.twig');
    }


}