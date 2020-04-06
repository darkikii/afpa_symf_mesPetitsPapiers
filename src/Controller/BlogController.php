<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CreationSearch;
use App\Form\CreationSearchType;
use App\Entity\Creation;
use App\Entity\Commentaires;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;


class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()/*affiche 4 dernieres creations*/
    {
    	$repository = $this->getDoctrine()->getRepository(Creation::class);

		$creations = $repository->findFourLast();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'creations' => $creations
        ]);
    }

    /**
     * @Route("/compositions", name="compositions")
     */
    public function compositions(Request $request)/*affiche toutes les creations*/
    {
        /*creer formulaire (en cours)*/
    	$search = new CreationSearch();
		$form = $this->createForm(CreationSearchType::class, $search);
		$form->handleRequest($request);

    	$repository = $this->getDoctrine()->getRepository(Creation::class);

		$creations = $repository->findAll();

        return $this->render('blog/compositions.html.twig', [
            'controller_name' => 'BlogController',
            'creations' => $creations,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/blog/{id}", name="creation_show")
    * @return Response
    */
    public function show(Creation $creation,Request $request,EntityManagerInterface $manager)/*affiche une creation avec commentaire et creer commentaire*/
    {   
        /*creer formulaire*/
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        /*verification formulaire */
        if($form->isSubmitted() && $form->isvalid())
        {    
            $commentaire->setCreatedAt(new \DateTime())
                        ->setCreation($creation);
            $manager->persist($commentaire);
            $manager->flush();

            return $this->redirectToRoute('creation_show', ['id' => $creation->getId()]);
        }

        /*affichage*/
        return $this->render('blog/show.html.twig', [
            'creation' => $creation,
            'commentForm' => $form->createView()
        ]);
    }
}
