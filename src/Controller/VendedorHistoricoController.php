<?php

namespace App\Controller;

use App\Entity\VendedorHistorico;
use App\Form\VendedorHistoricoType;
use App\Repository\VendedorHistoricoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vendedor/historico")
 */
class VendedorHistoricoController extends AbstractController
{
    /**
     * @Route("/", name="vendedor_historico_index", methods="GET")
     */
    public function index(VendedorHistoricoRepository $vendedorHistoricoRepository): Response
    {
        return $this->render('vendedor_historico/index.html.twig', ['vendedor_historicos' => $vendedorHistoricoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="vendedor_historico_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $vendedorHistorico = new VendedorHistorico();
        $form = $this->createForm(VendedorHistoricoType::class, $vendedorHistorico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vendedorHistorico);
            $em->flush();

            return $this->redirectToRoute('vendedor_historico_index');
        }

        return $this->render('vendedor_historico/new.html.twig', [
            'vendedor_historico' => $vendedorHistorico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vendedor_historico_show", methods="GET")
     */
    public function show(VendedorHistorico $vendedorHistorico): Response
    {
        return $this->render('vendedor_historico/show.html.twig', ['vendedor_historico' => $vendedorHistorico]);
    }

    /**
     * @Route("/{id}/edit", name="vendedor_historico_edit", methods="GET|POST")
     */
    public function edit(Request $request, VendedorHistorico $vendedorHistorico): Response
    {
        $form = $this->createForm(VendedorHistoricoType::class, $vendedorHistorico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vendedor_historico_edit', ['id' => $vendedorHistorico->getId()]);
        }

        return $this->render('vendedor_historico/edit.html.twig', [
            'vendedor_historico' => $vendedorHistorico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vendedor_historico_delete", methods="DELETE")
     */
    public function delete(Request $request, VendedorHistorico $vendedorHistorico): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vendedorHistorico->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vendedorHistorico);
            $em->flush();
        }

        return $this->redirectToRoute('vendedor_historico_index');
    }
}
