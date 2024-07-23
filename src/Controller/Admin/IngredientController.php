<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('admin/ingredient', name: 'admin_ingredient_')]
class IngredientController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(IngredientRepository $repository): Response
    {
        $ingredient = $repository->findAll();
        return $this->render('admin/ingredient/index.html.twig', [
            "ingredient" => $ingredient
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(): Response
    {
        return $this->render('admin/ingredient/show.html.twig');
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ingredient);
            $em->flush();
            $this->addFlash('success', 'Un nouvel ingrédient à été ajouté !');
            return $this->redirectToRoute('admin_ingredient_list');
        }



        return $this->render('admin/ingredient/new.html.twig', [
            'ingredient_form' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, Ingredient $ingredient): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Un nouvel ingredient a été ajouté');

            return $this->redirectToRoute('admin_ingredient_list');
        }

        return $this->render('admin/ingredient/edit.html.twig', ['ingredient_form' => $form]);
    }

    #[Route('/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->render('admin/ingredient/delete.html.twig');
    }
}
