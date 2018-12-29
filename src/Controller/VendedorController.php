<?php

namespace App\Controller;

use App\Entity\Vendedor;
use App\Form\VendedorType;
use App\Repository\VendedorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\DefaultValidator;

/**
 * @Route("/api/vendedor")
 */
class VendedorController extends AbstractController
{
    private $defaultValidator;
    public function __construct(DefaultValidator $defaultValidator, Security $security)
    {
        $this->defaultValidator = $defaultValidator;
        $this->security = $security;
    }
    /**
     * @Route("/", name="vendedor_index", methods="GET")
     */
    public function index(VendedorRepository $vendedorRepository): Response
    {
        $user = $this->security->getUser()->getId();
        $vendedorRepository = $vendedorRepository->findByUser($user);

        $vendedores = [];

        foreach ($vendedorRepository as $vendedor) {
            $vendedores[] = $vendedor->jsonSerialize();
        }

        return new JsonResponse(
            $vendedores,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="vendedor_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $user = $this->security->getUser();
        $vendedor = new Vendedor($user);
        $form = $this->createForm(VendedorType::class, $vendedor);
        $form->submit($data);

        $err = $this->defaultValidator->validar($vendedor);
        if ($err) {
            $err["errors"][0]["for"] = "vendedor";
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
        $em->persist($vendedor);
        $em->flush();
        return new JsonResponse(
            [
                'vendedor' => $vendedor->jsonSerialize(),
                'messageType' => 'success',
                'message' => "Vendedor/a '" . strtoupper($vendedor->getNombre()) . "' añadido/a",
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/{id}", name="vendedor_show", methods="GET")
     */
    public function show(Vendedor $vendedor): Response
    {
        return $this->render('vendedor/show.html.twig', ['vendedor' => $vendedor]);
    }

    /**
     * @Route("/{id}/edit", name="vendedor_edit", methods="GET|POST")
     */
    public function edit(Request $request, Vendedor $vendedor): Response
    {
        $form = $this->createForm(VendedorType::class, $vendedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vendedor_edit', ['id' => $vendedor->getId()]);
        }

        return $this->render('vendedor/edit.html.twig', [
            'vendedor' => $vendedor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vendedor_delete", methods="DELETE")
     */
    public function delete(Request $request, Vendedor $vendedor): Response
    {
        $user = $this->security->getUser()->getId();
        
        if ($cliente->getUser()->getId() !== $user) {
            return new JsonResponse("404", JsonResponse::HTTP_NOT_FOUND);
        }

        if ($this->isCsrfTokenValid('delete'.$vendedor->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vendedor);
            $em->flush();
        }

        return $this->redirectToRoute('vendedor_index');
    }
}
