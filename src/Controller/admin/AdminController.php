<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CreationSearch;
use App\Form\CreationSearchType;
use App\Entity\Creation;
use App\Entity\Commentaires;
use App\Form\CreationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CommentaireType;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()/*affiche toutes les creations avec options (delete,edit,creation)*/
    {

    	$repository = $this->getDoctrine()->getRepository(Creation::class);

		$creations = $repository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'creations' => $creations
        ]);
    }

    /**
     * @Route("/admin/compositions", name="admin.compositions")
     */
    public function compositions(Request $request)/*affiche toutes les creations*/
    {
        /*creer formulaire (en cours)*/
    	$search = new CreationSearch();
		$form = $this->createForm(CreationSearchType::class, $search);
		$form->handleRequest($request);

    	$repository = $this->getDoctrine()->getRepository(Creation::class);

		$creations = $repository->findAll();

        return $this->render('admin/compositions.html.twig', [
            'controller_name' => 'BlogController',
            'creations' => $creations,
            'form' => $form->createView()
        ]);
    }

    /**
	* @Route("/admin/import", name="admin.creation.importer")
	*/
	public function importer(Request $request,EntityManagerInterface $manager) /*creer une creation*/
	{
		/*creer formulaire*/
		$creation = new Creation();
		$form = $this->createForm(CreationType::class, $creation);
		$form->handleRequest($request);
		/*verification formulaire */
		if($form->isSubmitted() && $form->isValid()){

			$creation->setCreatedAt(new \DateTime());

			$manager->persist($creation);
            $manager->flush();

			return $this->redirectToRoute('admin');
		}
		/*affichage*/
		return $this->render('admin/edit.html.twig', [
			'form' => $form->createView(),
			'creation' => $creation
		]);
	}


    /**
	* @Route("/admin/{id}", name="admin.creation.edit")
	*/
	public function edit(Creation $creation, Request $request,EntityManagerInterface $manager)/*modifier une creation*/
	{
		/*creer formulaire*/
		$form = $this->createForm(CreationType::class, $creation);
		$form->handleRequest($request);
		/*verification formulaire */
		if($form->isSubmitted() && $form->isValid()){

			$creation->setCreatedAt(new \DateTime());

			$manager->persist($creation);
            $manager->flush();

			return $this->redirectToRoute('admin');
		}
		/*affichage*/
		return $this->render('admin/edit.html.twig', [
			'creation' => $creation,
			'form' => $form->createView()
		]);
	}

	/**
	* @Route("/admin/delete/{id}", name="admin.creation.delete")
	*/
	public function delete(Creation $creation,EntityManagerInterface $manager)/*efface une creation*/
	{
		/*supprime les commentaires*/
		$commentaires = $creation->getCommentaires();

		foreach ($commentaires as $commentaire) {
			$creation->removeCommentaire($commentaire);
		}
		
		/*supprime la creation*/
		$manager->remove($creation);
		$manager->flush();
		return $this->redirectToRoute('admin');
	}

	 /**
	* @Route("/admin/comment/delete/{id}", name="admin.commentaire.delete")
	*/
	public function deleteComment(Commentaires $commentaire,EntityManagerInterface $manager)/*efface un commentaire*/
	{
		$manager->remove($commentaire);
		$manager->flush();
		return $this->redirectToRoute('admin');
	}

	/**
    * @Route("/admin/comment/{id}", name="admin.creation_show")
    */
    public function show(Creation $creation,Request $request,EntityManagerInterface $manager)/*affiche une creation avec commentaire et creer/effacer commentaire*/
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

            return $this->redirectToRoute('admin.creation_show', ['id' => $creation->getId()]);
        }

        /*affichage*/
        return $this->render('admin/comment/show.html.twig', [
            'creation' => $creation,
            'commentForm' => $form->createView()
        ]);
    }
}
