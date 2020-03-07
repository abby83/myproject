<?php

namespace App\Controller;

use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Respose;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Form\BookpublishType;

class BookspublishController extends AbstractController
{
    private $books;
    
    public function __construct(){
        //Create Instance for Books Entity
        $this->books = new Books();
    }

    /**
     * @Route("/bookspublish", name="bookspublish")
     */
    public function index(Request $request, ValidatorInterface $validator)
    {
		$form = $this->createForm(BookpublishType::class, $this->books, [
            'method' => 'POST'
        ]);

        //Form submit handler
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $books_data = $form->getData();

            $errors = $validator->validate($books_data);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }
    
            // Saving data into DB
            $booksEntity = $this->getDoctrine()->getManager();
            $booksEntity->persist($books_data);
            $booksEntity->flush();
    
            return $this->redirectToRoute('listing');
        }


        return $this->render('bookspublish/index.html.twig', [
            'controller_name' => 'BookspublishController',
			'form_data' => $form->createView()
        ]);
    }

     /**
     * @Route("/listing", name="listing")
     */
    public function booklisting(Request $request)
    {
        $books = $this->getDoctrine()
                        ->getRepository(Books::class)
                        ->findAll();

        return $this->render('bookspublish/listing.html.twig', [
            'controller_name' => 'Books Listing',
            'books' => $books
        ]);
    }

    /**
     * @Route("/deletebook/{id}", name="deletebook")
     */
    public function delete($id)
    {
        $booksEntity = $this->getDoctrine()->getManager();
        $books = $booksEntity->getRepository(Books::class)->find($id);

        if (!$books) {
            throw $this->createNotFoundException(
                'There are no such Books available with the following id: ' . $id
            );
        }

        $booksEntity->remove($books);
        $booksEntity->flush();

        return $this->redirectToRoute('listing');
    }

      /**
     * @Route("/editbook/{id}", name="editbook")
     */
    public function edit(Request $request, $id)
    {
        $booksEntity = $this->getDoctrine()->getManager();
        $books = $booksEntity->getRepository(Books::class)->find($id);

        if (!$books) {
            throw $this->createNotFoundException(
                'There are no such Books available with the following id: ' . $id
            );
        }

        $form = $this->createForm(BookpublishType::class, $books, [
            'method' => 'POST'
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $books_data = $form->getData();
            $booksEntity->flush();
            return $this->redirectToRoute('listing');
        }

        return $this->render('bookspublish/edit.html.twig', [
            'controller_name' => 'BookspublishController',
			'form_data' => $form->createView()
        ]);
    }


}
