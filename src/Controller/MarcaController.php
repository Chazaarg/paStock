<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Form\MarcaType;
use App\Repository\MarcaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marca")
 */
class MarcaController extends AbstractController
{
    /**
     * @Route("/", name="marca_index", methods="GET")
     */
    public function index(MarcaRepository $marcaRepository): Response
    {
        $marcasRepository = $marcaRepository->findAllAsc();

        $marcas = [];

        foreach ($marcasRepository as $marca) {

            $marcas[] = $marca->jsonSerialize();

        }

        return new JsonResponse(
            $marcas,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="marca_new", methods="GET|POST")
     */
    function new (Request $request): Response {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $marca = new Marca();
        $form = $this->createForm(MarcaType::class, $marca);

        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ]
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($marca);
        $em->flush();

        return new JsonResponse(

            $marca->jsonSerialize()
            ,
            JsonResponse::HTTP_CREATED
        );

    }

    /**
     * @Route("/{id}", name="marca_show", methods="GET")
     */
    public function show(Marca $marca): Response
    {
        return $this->render('marca/show.html.twig', ['marca' => $marca]);
    }

    /**
     * @Route("/{id}/edit", name="marca_edit", methods="GET|POST")
     */
    public function edit(Request $request, Marca $marca): Response
    {
        $form = $this->createForm(MarcaType::class, $marca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marca_edit', ['id' => $marca->getId()]);
        }

        return $this->render('marca/edit.html.twig', [
            'marca' => $marca,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marca_delete", methods="DELETE")
     */
    public function delete(Request $request, Marca $marca): Response
    {
        if ($this->isCsrfTokenValid('delete' . $marca->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($marca);
            $em->flush();
        }

        return $this->redirectToRoute('marca_index');
    }
}
