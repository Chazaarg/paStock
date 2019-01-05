<?php

namespace App\Controller;

use App\Entity\ClienteHistorico;
use App\Form\ClienteHistoricoType;
use App\Repository\ClienteHistoricoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliente/historico")
 */
class ClienteHistoricoController extends AbstractController
{
    /**
     * @Route("/", name="cliente_historico_index", methods="GET")
     */
    public function index(ClienteHistoricoRepository $clienteHistoricoRepository): Response
    {
        return $this->render('cliente_historico/index.html.twig', ['cliente_historicos' => $clienteHistoricoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="cliente_historico_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $clienteHistorico = new ClienteHistorico();
        $form = $this->createForm(ClienteHistoricoType::class, $clienteHistorico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($clienteHistorico);
            $em->flush();

            return $this->redirectToRoute('cliente_historico_index');
        }

        return $this->render('cliente_historico/new.html.twig', [
            'cliente_historico' => $clienteHistorico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cliente_historico_show", methods="GET")
     */
    public function show(ClienteHistorico $clienteHistorico): Response
    {
        return $this->render('cliente_historico/show.html.twig', ['cliente_historico' => $clienteHistorico]);
    }

    /**
     * @Route("/{id}/edit", name="cliente_historico_edit", methods="GET|POST")
     */
    public function edit(Request $request, ClienteHistorico $clienteHistorico): Response
    {
        $form = $this->createForm(ClienteHistoricoType::class, $clienteHistorico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_historico_edit', ['id' => $clienteHistorico->getId()]);
        }

        return $this->render('cliente_historico/edit.html.twig', [
            'cliente_historico' => $clienteHistorico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cliente_historico_delete", methods="DELETE")
     */
    public function delete(Request $request, ClienteHistorico $clienteHistorico): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clienteHistorico->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clienteHistorico);
            $em->flush();
        }

        return $this->redirectToRoute('cliente_historico_index');
    }
}
