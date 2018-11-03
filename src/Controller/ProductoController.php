<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Variante;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use App\Repository\VarianteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producto")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto_index", methods="GET")
     */
    public function index(ProductoRepository $productoRepository, VarianteRepository $variantesRepository): Response
    {
        $productos = $productoRepository->findAll();

        $productoVariante = [];

        foreach ($productos as $producto) {

            $variantesRepository = $this->getDoctrine()->getRepository(Variante::class)->findBy(
                ['producto' => $producto->getId()]
            );

            $variantes = [];

            foreach ($variantesRepository as $variante) {

                $variantes[] = $variante->jsonSerialize();

            }

            if ($variantes != null) {

                $variantes = array("variantes" => $variantes);

            }

            $productoVariante[] = array_merge($producto->jsonSerialize(), $variantes);

        }

        return new JsonResponse(
            $productoVariante,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="producto_new", methods="GET|POST")
     */
    function new (Request $request, ProductoRepository $productoRepository): Response {
        //REACT API

        $data = json_decode(
            $request->getContent(),
            true
        );

/*

//$variante = new Variante();
//$variante->setNombre('Hola');
//$variante->setProducto($producto);
//$producto->getVariantes()->add($variante);
 */

        $producto = new Producto();

        $producto->setCreatedAt(new \DateTime());
        $producto->setUpdatedAt(new \DateTime());
        $form = $this->createForm(ProductoType::class, $producto);

        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ]
            );
        }

        if (sizeOf($form->getData()->getVariantes()) !== 0) {
            foreach ($form->getData()->getVariantes() as $variante_) {
                $variante_->setProducto($producto);
            };
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($producto);
        $em->flush();

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );

/*
$producto = new Producto();

$producto ->setCreatedAt(new \DateTime());
$producto ->setUpdatedAt(new \DateTime());
$form = $this->createForm(ProductoType::class, $producto, array(
'action' => $this->generateUrl('producto_new'),
'method' => 'POST',
));
$form->handleRequest($request);

if (!$request->isXmlHttpRequest())
{
if ($form->isSubmitted() && $form->isValid()) {
$em = $this->getDoctrine()->getManager();
$em->persist($producto);
$em->flush();
return $this->redirectToRoute('producto_index');
}
}

return $this->render('producto/new.html.twig', [
'producto' => $producto,
'form' => $form->createView(),
]);
 */
    }

    /**
     * @Route("/{id}", name="producto_show", methods="GET")
     */
    public function show(Producto $producto, ProductoRepository $productoRepository, $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Producto::class)->find($id);

        $variantesRepository = $this->getDoctrine()->getRepository(Variante::class)->findBy(
            ['producto' => $producto->getId()]
        );

        $variantes = [];
        foreach ($variantesRepository as $variante) {

            $variantes[] = $variante->jsonSerialize();

        }
        if ($variantes != null) {
            $variantes = array("variantes" => $variantes);

        }

        $array = array_merge($repository->jsonSerialize(), $variantes);

        return new JsonResponse(
            $array,
            JsonResponse::HTTP_OK
        );

        /*$repository = $this->getDoctrine()->getRepository(Variante::class);
    $variantes = $repository->findBy(
    ['producto' => $producto->getId()]

    );

    $repository = $this->getDoctrine()->getRepository(Categoria::class);
    $categoria = $repository->find($producto->getCategoria()->getId());

    $array= array(
    "nombre" => $producto->getNombre(),
    "categoria" => $categoria->getNombre(),
    "variantes" => $variantes
    );
    dump(json_decode($variantes));
    die;

    return new JsonResponse(json_encode((json_encode($array))));*/
    }

    /**
     * @Route("/{id}/edit", name="producto_edit", methods="GET|POST|PUT")
     */
    public function edit(Request $request, Producto $producto, $id): Response
    {
        $variantesOriginales = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($producto->getVariantes() as $variante) {
            $variantesOriginales->add($variante);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );

        $producto->setUpdatedAt(new \DateTime());
        $form = $this->createForm(ProductoType::class, $producto);

        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ]
            );
        }

        //Agrega a cada variante su respectivo producto
        if (sizeOf($form->getData()->getVariantes()) !== 0) {
            foreach ($form->getData()->getVariantes() as $variante_) {
                $variante_->setProducto($producto);
            };

        }

        $entityManager = $this->getDoctrine()->getManager();

        // remove the relationship between the tag and the Task
        foreach ($variantesOriginales as $variante) {
            if (false === $producto->getVariantes()->contains($variante)) {
                // remove the Task from the Tag
                //$variante->getProducto()->removeElement($producto);

                // if it was a many-to-one relationship, remove the relationship like this
                $variante->setProducto(null);

                $entityManager->persist($variante);

                // if you wanted to delete the Tag entirely, you can also do that
                $entityManager->remove($variante);
            }
        }

        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );

    }

    /**
     * @Route("/{id}/delete", name="producto_delete", methods="DELETE")
     */
    public function delete(Request $request, Producto $producto, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        if (sizeOf($producto->getVariantes()) !== 0) {
            foreach ($producto->getVariantes() as $variante) {
                $entityManager->remove($variante);
            };
        }

        $existingProducto = $producto;

        $entityManager->remove($existingProducto);
        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
