<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Entity\Ingredient;
use App\Entity\RecetteIngredient;
use App\Repository\RecetteRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RecetteIngredientRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/recette")
 */
class RecetteController extends AbstractController
{
    

    /**
     * @Route("/liste", name="recette_index", methods={"GET"})
     */
    public function index( RecetteRepository $recetteRepository, RecetteIngredientRepository $recetteIngredientRepository,IngredientRepository $IngredientRepository /*, int $id*/): Response
    {
       // $ingredient = $IngredientRepository->find($id);
       
        return $this->render('recette/index.html.twig', [
            'recettes' => $recetteRepository->findAll(),
            //'recette_ingredient' => $recetteIngredientRepository->find($id),
        ]);
        
    }

    /**
     * @Route("/new", name="recette_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagesDirectory = "img/uploads/";
            $entityManager = $this->getDoctrine()->getManager();
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFilename);
                $finalFilename = $safeFileName . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($imagesDirectory, $finalFilename);
                // petite astuce pour éviter d'avoir à modifier les vues
                $fichierCheminComplet = "$imagesDirectory$finalFilename";
                $recette->setImage($fichierCheminComplet);

            }
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="recette_show", methods={"GET"})
     */
    public function show(Recette $recette, RecetteIngredientRepository $recetteIngredientRepository): Response
    {
        $ingredients = $recetteIngredientRepository->findBy([
            'recette' => $recette,
        ]);
        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recette $recette,RecetteIngredientRepository $recetteIngredientRepository): Response
    {
        $ingredients = $recetteIngredientRepository->findBy([
            'recette' => $recette,
        ]);
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
            'ingredients' => $ingredients
        ]);
    }

    /**
     * @Route("/{id}", name="recette_delete", methods={"POST"})
     */
    public function delete(Request $request, Recette $recette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recette_index', [], Response::HTTP_SEE_OTHER);
    }
}
