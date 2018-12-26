<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\DefaultValidator;

/**
 * @Route("/api/cliente")
 */
class ClienteController extends AbstractController
{
    private $defaultValidator;
    public function __construct(DefaultValidator $defaultValidator, Security $security)
    {
        $this->defaultValidator = $defaultValidator;
        $this->security = $security;
    }
    /**
     * @Route("/", name="cliente_index", methods="GET")
     */
    public function index(ClienteRepository $clienteRepository): Response
    {
        $user = $this->security->getUser()->getId();
        $clienteRepository = $clienteRepository->findByUser($user);

        $clientes = [];

        foreach ($clienteRepository as $cliente) {
            $clientes[] = $cliente->jsonSerialize();
        }

        return new JsonResponse(
            $clientes,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="cliente_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $user = $this->security->getUser();
        $cliente = new Cliente($user);
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->submit($data);

        $err = $this->defaultValidator->validar($cliente);
        if ($err) {
            $err["errors"][0]["for"] = "cliente";
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

        return new JsonResponse(
            [
                'cliente' => $cliente->jsonSerialize(),
                'messageType' => 'success',
                'message' => "Cliente/a '" . strtoupper($cliente->getNombre()) . "' añadido/a",
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/{id}", name="cliente_show", methods="GET")
     */
    public function show(Cliente $cliente): Response
    {
        return $this->render('cliente/show.html.twig', ['cliente' => $cliente]);
    }

    /**
     * @Route("/{id}/edit", name="cliente_edit", methods="GET|POST")
     */
    public function edit(Request $request, Cliente $cliente): Response
    {
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_edit', ['id' => $cliente->getId()]);
        }

        return $this->render('cliente/edit.html.twig', [
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cliente_delete", methods="DELETE")
     */
    public function delete(Request $request, Cliente $cliente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cliente);
            $em->flush();
        }

        return $this->redirectToRoute('cliente_index');
    }
}
