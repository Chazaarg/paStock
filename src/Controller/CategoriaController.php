<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/categoria")
 */
class CategoriaController extends AbstractController
{
    /**
     * @Route("/", name="categoria_index", methods="GET")
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        $categoriasRepository = $categoriaRepository->findAllAsc();

        $categorias = [];

        foreach ($categoriasRepository as $categoria){

            $categorias[] = $categoria->jsonSerialize();

        }

        return new JsonResponse(
            $categorias,
            JsonResponse::HTTP_OK
        );
        
    }

    /**
     * @Route("/new", name="categoria_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
    
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);

        $form->submit($data);
       
        

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ]
            );
        }

        $em = $this->getDoctrine()->getManager();
            $em->persist($categorium);
            $em->flush();

        return new JsonResponse(
                
                    $categorium->jsonSerialize(),
                
                JsonResponse::HTTP_CREATED
            );
    }

    /**
     * @Route("/{id}", name="categoria_show", methods="GET")
     */
    public function show(Categoria $categorium): Response
    {
        return $this->render('categoria/show.html.twig', ['categorium' => $categorium]);
    }

    /**
     * @Route("/{id}/edit", name="categoria_edit", methods="GET|POST")
     */
    public function edit(Request $request, Categoria $categorium): Response
    {
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_edit', ['id' => $categorium->getId()]);
        }

        return $this->render('categoria/edit.html.twig', [
            'categorium' => $categorium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoria_delete", methods="DELETE")
     */
    public function delete(Request $request, Categoria $categorium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorium);
            $em->flush();
        }

        return $this->redirectToRoute('categoria_index');
    }
}
