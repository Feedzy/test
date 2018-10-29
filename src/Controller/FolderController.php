<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity;
use App\Entity\Folder;
use App\Form\FolderType;

class FolderController extends AbstractController
{
 
	protected $entityManager;
	protected $translator;
	protected $repository;

	// Set up all necessary variable
	protected function initialise()
	{
		$this->entityManager = $this->getDoctrine()->getManager();
		$this->repository = $this->entityManager->getRepository('App:Folder');
		$this->translator = $this->get('translator');
	}

	public function add(Request $request)
	{
		// Set up required variables
		$this->initialise();

		// New object
		$folder = new Folder();

		// Build the form
		$form = $this->get('form.factory')->create(FolderType::class, $folder);

		if ($request->isMethod('POST'))
		{
			$form->handleRequest($request);
			// Check form data is valid
			if ($form->isValid())
			{
				// Save data to database
				$this->entityManager->persist($folder);
				$this->entityManager->flush();

				// Inform user
				$request->getSession()->getFlashBag()->add('notice', $flashBag);

				// Redirect to view page
				return $this->redirectToRoute('cookiejar_folder_view', array(
					'id'	=>	$folder->getId(),
				));
			}
		}
		// If we are here it means that either
		//	- request is GET (user has just landed on the page and has not filled the form)
		//	- request is POST (form has invalid data)
		return $this->render('folder/add.html.twig',array('form'=>$form->createView()));
	}

	public function edit(Request $request, Folder $folder)
	{
		// Set up required variables
		$this->initialise();

		// Build the form
		$form = $this->get('form.factory')->create(FolderType::class, $folder);

		if ($request->isMethod('POST'))
		{
			$form->handleRequest($request);
			// Check form data is valid
			if ($form->isValid())
			{
				// Save data to database
				$this->entityManager->persist($folder);
				$this->entityManager->flush();

				// Inform user
	
				// Redirect to view page
				return $this->redirectToRoute('cookiejar_folder_view', array(
					'id'	=>	$folder->getId(),
				));
			}
		}
		// If we are here it means that either
		//	- request is GET (user has just landed on the page and has not filled the form)
		//	- request is POST (form has invalid data)
		return $this->render(
			'Folder/edit.html.twig',
			array (
				'form'		=>	$form->createView(),
				'folder'	=>	$folder
			)
		);
	}

	public function view(Request $request, Folder $folder)
	{
		// Set up required variables
		$this->initialise();

		return $this->render(
			'Folder/view.html.twig',
			array (
				'folder'	=>	$folder,
			)
		);
	}

}