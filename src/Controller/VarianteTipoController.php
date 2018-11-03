<?php

namespace App\Controller;

use App\Entity\VarianteTipo;
use App\Form\VarianteTipo1Type;
use App\Repository\VarianteTipoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/variante-tipo")
 */
class VarianteTipoController extends AbstractController
{
    /**
     * @Route("/", name="variante_tipo_index", methods="GET")
     */
    public function index(VarianteTipoRepository $varianteTipoRepository): Response
    {
        $varianteTiposRepository = $varianteTipoRepository->findAllAsc();

        $variantes = [];

        foreach ($varianteTiposRepository as $variante){

            $variantes[] = $variante->jsonSerialize();

        }

        return new JsonResponse(
            $variantes,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="variante_tipo_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $varianteTipo = new VarianteTipo();
        $form = $this->createForm(VarianteTipo1Type::class, $varianteTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($varianteTipo);
            $em->flush();

            return $this->redirectToRoute('variante_tipo_index');
        }

        return $this->render('variante_tipo/new.html.twig', [
            'variante_tipo' => $varianteTipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="variante_tipo_show", methods="GET")
     */
    public function show(VarianteTipo $varianteTipo): Response
    {
        return $this->render('variante_tipo/show.html.twig', ['variante_tipo' => $varianteTipo]);
    }

    /**
     * @Route("/{id}/edit", name="variante_tipo_edit", methods="GET|POST")
     */
    public function edit(Request $request, VarianteTipo $varianteTipo): Response
    {
        $form = $this->createForm(VarianteTipo1Type::class, $varianteTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('variante_tipo_edit', ['id' => $varianteTipo->getId()]);
        }

        return $this->render('variante_tipo/edit.html.twig', [
            'variante_tipo' => $varianteTipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="variante_tipo_delete", methods="DELETE")
     */
    public function delete(Request $request, VarianteTipo $varianteTipo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$varianteTipo->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($varianteTipo);
            $em->flush();
        }

        return $this->redirectToRoute('variante_tipo_index');
    }
}
