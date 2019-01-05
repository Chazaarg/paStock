<?php

namespace App\Controller;

use App\Entity\ProductoHistorico;
use App\Form\ProductoHistoricoType;
use App\Repository\ProductoHistoricoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producto/historico")
 */
class ProductoHistoricoController extends AbstractController
{
    /**
     * @Route("/", name="producto_historico_index", methods="GET")
     */
    public function index(ProductoHistoricoRepository $productoHistoricoRepository): Response
    {
        return $this->render('producto_historico/index.html.twig', ['producto_historicos' => $productoHistoricoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="producto_historico_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $productoHistorico = new ProductoHistorico();
        $form = $this->createForm(ProductoHistoricoType::class, $productoHistorico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productoHistorico);
            $em->flush();

            return $this->redirectToRoute('producto_historico_index');
        }

        return $this->render('producto_historico/new.html.twig', [
            'producto_historico' => $productoHistorico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producto_historico_show", methods="GET")
     */
    public function show(ProductoHistorico $productoHistorico): Response
    {
        return $this->render('producto_historico/show.html.twig', ['producto_historico' => $productoHistorico]);
    }

    /**
     * @Route("/{id}/edit", name="producto_historico_edit", methods="GET|POST")
     */
    public function edit(Request $request, ProductoHistorico $productoHistorico): Response
    {
        $form = $this->createForm(ProductoHistoricoType::class, $productoHistorico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producto_historico_edit', ['id' => $productoHistorico->getId()]);
        }

        return $this->render('producto_historico/edit.html.twig', [
            'producto_historico' => $productoHistorico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producto_historico_delete", methods="DELETE")
     */
    public function delete(Request $request, ProductoHistorico $productoHistorico): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productoHistorico->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productoHistorico);
            $em->flush();
        }

        return $this->redirectToRoute('producto_historico_index');
    }
}
