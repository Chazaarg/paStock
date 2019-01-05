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
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/producto")
 */
class ProductoController extends AbstractController
{
    private $productoValidator;
    private $security;
    public function __construct(ProductoValidator $productoValidator, Security $security)
    {
        $this->security = $security;
        $this->productoValidator = $productoValidator;
    }
    /**
     * @Route("/", name="producto_index", methods="GET|POST")
     */
    public function index(Request $request, ProductoRepository $productoRepository, VarianteRepository $variantesRepository): Response
    {
        $user = $this->security->getUser()->getId();
        $data = json_decode(
            $request->getContent(),
            true
        );
       
        $sortNumber = $data["sortProducto"];
        $sortMarca = $data["sortMarca"];
        $sortCategoria = "";
        $sortSubcategoria = "";
        
        //Checkeo si $data["sortCategoria"] tiene una categoria o una subcategoria (esto es porque vienen del mismo select y la ID se puede superponer, entonces agregué "sub").

        if (strpos($data["sortCategoria"], 'sub') === false) {
            $sortCategoria = $data["sortCategoria"];
        } else {
            $subcategoria = str_replace("sub", "", $data["sortCategoria"]);
            $sortSubcategoria = $subcategoria;
        }


        $productos;

        switch ($sortNumber) {
            case '0':
                // Más nuevo a más viejo
                $productos = $productoRepository->findDESC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case '1':
                // Más nuevo a más viejo
                $productos = $productoRepository->findDESC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case '2':
                // Más viejo a más nuevo
                $productos = $productoRepository->findASC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case '3':
                // Precio mayor a menor
                $productos = $productoRepository->findPriceDESC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case '4':
                // Precio menor a mayor
                $productos = $productoRepository->findPriceASC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case '5':
                // Cantidad menor a mayor
                $productos = $productoRepository->findCantDESC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case '6':
                // Cantidad menor a mayor
                $productos = $productoRepository->findCantASC($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            case null:
                // Cantidad menor a mayor
                $productos = $productoRepository->findByUser($user, $sortMarca, $sortCategoria, $sortSubcategoria);
                break;
            
            default:
            $productos = $productoRepository->findByUser($user);
                break;
        }
        
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
    public function new(Request $request, ProductoRepository $productoRepository): Response
    {

        //Agarro la data de $request y la decodifico.

        $data = json_decode(
            $request->getContent(),
            true
        );
        
        $user = $this->security->getUser();

        //Creo un nuevo producto
        $producto = new Producto($user);
        $producto->setCreatedAt(new \DateTime());

        
        //Valido el producto.
        $err = $this->productoValidator->validarProducto($data, $producto);
        if ($err) {
            return $err;
        }


        //Seteo un precio/cantidad promedio al producto para poder sortear la tabla PRODUCTOS a partir de esta propiedad.
        
        if (sizeOf($producto->getVariantes()) === 0) {
            $producto->setPrecioPromedio($producto->getPrecio());
            $producto->setCantidadPromedio($producto->getCantidad());
        } else {
            $precioPromedio = 0;
            $cantidadPromedio = 0;

            foreach ($producto->getVariantes() as $variante) {
                $precioPromedio += $variante->getPrecio();
                $cantidadPromedio += $variante->getCantidad();
            }

            $precioPromedio = $precioPromedio / sizeOf($producto->getVariantes());
            $cantidadPromedio = $cantidadPromedio / sizeOf($producto->getVariantes());
            $producto->setPrecioPromedio($precioPromedio);
            $producto->setCantidadPromedio($cantidadPromedio);
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
        $user = $this->security->getUser()->getId();
        if ($producto->getUser()->getId() !== $user) {
            return new JsonResponse("404", JsonResponse::HTTP_NOT_FOUND);
        }

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
        $user = $this->security->getUser()->getId();
        if ($producto->getUser()->getId() !== $user) {
            return new JsonResponse("404", JsonResponse::HTTP_NOT_FOUND);
        }
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

        if ($err) {
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

        //Seteo un precio/cantidad promedio al producto para poder sortear la tabla PRODUCTOS a partir de esta propiedad.
        
        if (sizeOf($producto->getVariantes()) === 0) {
            $producto->setPrecioPromedio($producto->getPrecio());
            $producto->setCantidadPromedio($producto->getCantidad());
        } else {
            $precioPromedio = 0;
            $cantidadPromedio = 0;

            foreach ($producto->getVariantes() as $variante) {
                $precioPromedio += $variante->getPrecio();
                $cantidadPromedio += $variante->getCantidad();
            }

            $precioPromedio = $precioPromedio / sizeOf($producto->getVariantes());
            $cantidadPromedio = $cantidadPromedio / sizeOf($producto->getVariantes());
            $producto->setPrecioPromedio($precioPromedio);
            $producto->setCantidadPromedio($cantidadPromedio);
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
        $user = $this->security->getUser()->getId();
        if ($producto->getUser()->getId() !== $user) {
            return new JsonResponse("404", JsonResponse::HTTP_NOT_FOUND);
        }

        

        $entityManager = $this->getDoctrine()->getManager();

        if (sizeOf($producto->getVentaDetalles()) !== 0) {
            foreach ($producto->getVentaDetalles() as $venta) {
                $venta->setProducto(null);
                $venta->setVariante(null);
            }
        }
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
