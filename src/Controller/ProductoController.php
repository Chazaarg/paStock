<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Variante;
use App\Service\ProductoValidator;
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
    private $productoValidator;
    public function __construct(ProductoValidator $productoValidator){
        $this->productoValidator = $productoValidator;
    }
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

        //Agarro la data de $request y la decodifico.

        $data = json_decode(
            $request->getContent(),
            true
        );

        //Creo un nuevo producto
        $producto = new Producto();
        $producto->setCreatedAt(new \DateTime());

        //Valido el producto.
        $err = $this->productoValidator->validarProducto($data, $producto);
        if($err){
            return $err;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($producto);
        $em->flush();

        return new JsonResponse(
            [
                'messageType' => 'success',
                'message' => "Producto '". strtoupper($producto->getNombre()) ."' importado con éxito. Con ". count($producto->getVariantes()) . " variantes.",
                'producto' => $producto,
            ],
            JsonResponse::HTTP_OK
        );
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
    }

    /**
     * @Route("/{id}/edit", name="producto_edit", methods="GET|POST|PUT")
     */
    public function edit(Request $request, Producto $producto, $id): Response
    {
        $variantesOriginales = new ArrayCollection();

        // Crea un ArrayCollection de las actuales variantes en la DB
        foreach ($producto->getVariantes() as $variante) {
            $variantesOriginales->add($variante);
        }

        //Agarro la data de $request y la decodifico.
        $data = json_decode(
            $request->getContent(),
            true
        );

        //Valido el producto.
        $err = $this->productoValidator->validarProducto($data, $producto);

        if($err){
            return $err;
        }


        $entityManager = $this->getDoctrine()->getManager();

        // Borra la relación entre Producto y sus variante.
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
                'messageType' => 'success',
                'message' => "Producto '". strtoupper($producto->getNombre()) ."' importado con éxito. Con ". count($producto->getVariantes()) . " variantes.",
                'producto' => $producto,
            ],
            JsonResponse::HTTP_OK
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
