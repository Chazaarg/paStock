<?php

namespace App\Controller;

use App\Entity\VentaDetalle;
use App\Form\VentaDetalleType;
use App\Entity\Venta;
use App\Form\VentaType;
use App\Repository\VentaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DefaultValidator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/venta")
 */
class VentaController extends AbstractController
{
    private $defaultValidator;
    private $security;
    
    public function __construct(DefaultValidator $defaultValidator, Security $security)
    {
        $this->defaultValidator = $defaultValidator;
        $this->security = $security;
    }
    /**
     * @Route("/", name="venta_index", methods="GET")
     */
    public function index(VentaRepository $ventaRepository): Response
    {
        return $this->render('venta/index.html.twig', ['ventas' => $ventaRepository->findAll()]);
    }

    /**
     * @Route("/new", name="venta_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
        
        $user = $this->security->getUser();
        $ventum = new Venta($user);
        $form = $this->createForm(VentaType::class, $ventum);
        
        $form->submit($data['venta']);
        

        $err = $this->defaultValidator->validar($ventum);
        if ($err) {
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
        $em->persist($ventum);
        $em->flush();

        foreach ($data['ventaDetalle'] as $detalle) {
            $ventaDetalle = new VentaDetalle($user);
            $ventaDetalle->setVenta($ventum);
            $form = $this->createForm(VentaDetalleType::class, $ventaDetalle);
            $form->submit($detalle);
            $err = $this->defaultValidator->validar($ventaDetalle);
            if ($err) {
                return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
            }
    
            if (false === $form->isValid()) {
                dump($form->getErrors());
                die;
                return new JsonResponse(
                    [
                        'status' => 'error',
                    ],
                    JsonResponse::HTTP_BAD_REQUEST
                );
            }
    
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventaDetalle);
            $em->flush();
        }



        return new JsonResponse(
            [
                'venta' => $ventum,
                'ventaDetalle' => $ventaDetalle,
                'messageType' => 'success',
                'message' => "Venta realizada con éxito",
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/{id}", name="venta_show", methods="GET")
     */
    public function show(Venta $ventum): Response
    {
        return $this->render('venta/show.html.twig', ['ventum' => $ventum]);
    }

    /**
     * @Route("/{id}/edit", name="venta_edit", methods="GET|POST")
     */
    public function edit(Request $request, Venta $ventum): Response
    {
        $form = $this->createForm(VentaType::class, $ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('venta_edit', ['id' => $ventum->getId()]);
        }

        return $this->render('venta/edit.html.twig', [
            'ventum' => $ventum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="venta_delete", methods="DELETE")
     */
    public function delete(Request $request, Venta $ventum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ventum->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ventum);
            $em->flush();
        }

        return $this->redirectToRoute('venta_index');
    }
}
