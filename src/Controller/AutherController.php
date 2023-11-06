<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AutherRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Auther;  // Add this "use" statement
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;



class AutherController extends AbstractController
{
    #[Route('/auther', name: 'app_auther')]
    public function index(): Response
    {
        return $this->render('auther/index.html.twig', [
            'controller_name' => 'AutherController',
        ]);
    }
    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        $authers = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('auther/list.html.twig', [
            'auther' => $auther,
        ]);
    }
    #[Route('/detailAuteur/{i}', name: 'detailA')]
    public function detailA($i): Response
    {
        return $this->render('auther/show.html.twig', [
            'id' => $i,
        ]);
    }
    #[Route('/Affiche', name: 'Affiche')]
    public function Affiche(AutherRepository $repo): Response
    {
        $authers = $repo->findAll();
        return $this->render('auther/affiche.html.twig', [
            'authers' => $authers,
        ]);
    }
    #[Route('/supprimerA/{i}', name: 'suppA')]
    public function supprimerA($i,AutherRepository $repo, ManagerRegistry $doctrine ): Response
    {
        //recuperer l'auteur a supprimer
        $auteurs = $repo->find($i);
        //recuperer l'entity manager : le chef d'orchestre de l'ORM
        $em=$doctrine->getManager();
        //Action suppression 
        $em->remove($auteurs);
        
        //commit
        $em->flush();
        return $this->redirectToRoute('Affiche');    }
        #[Route('/ajoutA', name: 'ajoutA')]
    public function ajoutA(ManagerRegistry $doctrine,Request $req): Response
    {
        //instancier un nouvel auteur
        $auther = new Auther();
        //creer l'objet form
        $form =$this->createForm(AuthorType::class, $auther);
        //recuperer les donnes saisies dans le formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em ->persist($auther);
            $em ->flush();
            return $this->redirectToRoute('Affiche');
        }
        return $this->renderForm('auther/add.html.twig', [
            'f' => $form,
        ]);
    }
    #[Route('/update/{id}', name: 'update')]
public function updateAuthor(ManagerRegistry $doctrine, Request $req, $id): Response
{
    $em = $doctrine->getManager();
    $auther = $em->getRepository(Author::class)->find($id);
    
    $form = $this->createForm(AuthorType::class, $auther);

    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();

        $em->flush();

        return $this->redirectToRoute('affiche');
    }

    return $this->renderForm('auther/edit.html.twig', [
        'f1' => $form,
    ]);
}

}
