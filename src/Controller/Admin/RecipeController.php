<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/recipe', name: 'admin_recipe_')]
class RecipeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(RecipeRepository $repository): Response
    {
    
        $recipe = $repository->findAll();
        return $this->render('admin/recipe/index.html.twig', [
            "recipe_form" => $recipe
        ]);

    }
    #[Route('/create', name: 'create',methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        $slugger =new AsciiSlugger();
        $recipe->setSlug($slugger->slug($recipe->getName()));
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'La recette a été crée avec succès!');
            return $this->redirectToRoute('admin_recipe_index');
        }

        return $this->render('admin/recipe/create.html.twig', [
            'recipe_form' => $form
        ]);
    }

    #[Route('/update/{id}', name: 'update',methods: ['GET', 'POST'])]
    public function update(Request $request, EntityManagerInterface $em, Recipe $recipe): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La recette à été modifié avce succès');

            return $this->redirectToRoute('admin_recipe_index');
        }

        return $this->render('admin/recipe/update.html.twig', ['recipe_form' => $form]);
    }


}
