<?php

namespace App\Controller;




use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/create/project', name: 'app_create_project', priority: 2)]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {

        $project = new Project;
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){


            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute("app_home");
        }


        return $this->render('project/create.html.twig', [
            "project"=>$project,
            "form"=>$form->createView(),
            "btnValue"=>"Ajouter"
        ]);
    }

    #[Route('/project/delete/{id}', name: 'app_delete_project', priority: 3)]
    public function delete(EntityManagerInterface $manager, Project $project):Response
    {
        $manager->remove($project);
        $manager->flush();
        return $this->redirectToRoute("app_home");
    }

    #[Route('project/edit/{id}', name: 'app_edit_project', priority: 4)]
    public function edit(Request $request, EntityManagerInterface $manager, Project $project):Response
    {

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute("app_home");
        }

        return $this->render('project/create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Editer"
        ]);

    }



}



