<?php

namespace App\Controller;

use App\Entity\VentaDetalle;
use App\Entity\Producto;
use App\Entity\Variante;
use App\Form\VentaDetalleType;
use App\Entity\Venta;
use App\Form\VentaType;
use App\Repository\VentaRepository;
use App\Repository\VentaDetalleRepository;
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
     * @Route("/", name="venta_index", methods="GET|POST")
     */
    public function index(VentaRepository $ventaRepository, VentaDetalleRepository $ventaDetalleRepository, Request $request): Response
    {
        $user = $this->security->getUser()->getId();
        $data = json_decode(
            $request->getContent(),
            true
        );
        $sortNumber = $data["sortNumber"];
        $sortDesde = $data["sortDesde"];
        $sortHasta = $data["sortHasta"];
        $date = date('Y-m-d H:i:s');
        $ventas;
        switch ($sortNumber) {
            case '0':
            $ventas = $ventaRepository->findByUser($user);
                break;
            case '1':
            $lastDay = (new \DateTime())->modify('-24 hours');
            $ventas = $ventaRepository->findByDate($user, $lastDay);
                break;
            case '2':
            $lastWeek = (new \DateTime())->modify('-1 week');
            $ventas = $ventaRepository->findByDate($user, $lastWeek);
                break;
            case '3':
            $lastMonth = (new \DateTime())->modify('-1 month');
            $ventas = $ventaRepository->findByDate($user, $lastMonth);
                break;
            case '4':
            $sortDesde = \DateTime::createFromFormat("d/m/Y H:i:s", $sortDesde . "24:60:99");
            $sortDesde = $sortDesde->format("Y-m-d H:i:s");
            $sortHasta = \DateTime::createFromFormat("d/m/Y H:i:s", $sortHasta . "24:60:99");
            $sortHasta = $sortHasta->format("Y-m-d H:i:s");

            
            $ventas = $ventaRepository->findByCustom($user, $sortDesde, $sortHasta);
                break;
            
            default:
            $ventas = $ventaRepository->findByUser($user);
                break;
        }
        
        

        $ventaVentaDetalle = [];

        foreach ($ventas as $venta) {
            $ventaDetalleRepository = $this->getDoctrine()->getRepository(VentaDetalle::class)->findBy(
                ['venta' => $venta->getId()]
            );

            $ventaDetalles = [];

            foreach ($ventaDetalleRepository as $ventaDetalle) {
                $ventaDetalles[] = $ventaDetalle->jsonSerialize();
            }

            if ($ventaDetalles != null) {
                $ventaDetalles = array("ventaDetalle" => $ventaDetalles);
            }

            $ventaVentaDetalle[] = array_merge($venta->jsonSerialize(), $ventaDetalles);
        }

        return new JsonResponse(
            $ventaVentaDetalle,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="venta_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {

        //Almaceno en $data la venta y ventaDetalle (ventaDetalle es el producto y la cantidad).
        $data = json_decode(
            $request->getContent(),
            true
        );
       

        //Primero registro la venta
        $user = $this->security->getUser();
        $ventum = new Venta($user);
        $ventum->setCreatedAt(new \DateTime());
        $form = $this->createForm(VentaType::class, $ventum);
        
        $form->submit($data['venta']);
        
        //Si tiene errores, los almaceno en una variable.
        $errVenta = $this->defaultValidator->validar($ventum);
       


        //Inicializo la variable de detalles
        $ventaDetalles = [];

        //Inicializo la variable de error.

        $errProducto = [];


        $i= 0;
        $err = false;


        //Valido cada detalle.
        foreach ($data['ventaDetalle'] as $detalle) {
            $ventaDetalles[$i] = new VentaDetalle($user);
            $ventaDetalles[$i]->setVenta($ventum);
            $form = $this->createForm(VentaDetalleType::class, $ventaDetalles[$i]);
            $form->submit($detalle);
           
            //Si tiene errores, almaceno solamente esos en la variable $errProducto. Si no, dejo un array vacío que es igual a una fila de producto en el FrontEnd.
            $errProducto = [];

            $errores[] = $this->defaultValidator->validar($ventaDetalles[$i]);
            if ($errores[$i]) {
                foreach ($errores as $error) {
                    $errProducto[] = $error["errors"];
                }
                $err = true;
            }
            if ($detalle["codigoDeBarras"] && $ventaDetalles[$i]->getProducto()->getCodigoDeBarras()) {
                if ($detalle["codigoDeBarras"] !== $ventaDetalles[$i]->getProducto()->getCodigoDeBarras()) {
                    $errProducto[$i][] = ["value" => "codigoDeBarras", "message" => "El código de barras no coincide con el producto", "status" => "error"];
                    $err = true;
                }
            }
            $i++;
        }

        if ($errVenta || $err) {
            return new JsonResponse(
                [
                    'messageType' => 'error',
                    'message' => 'Ha habido un error.',
                    'errors' => ['ventaError' => $errVenta["errors"], 'productoError' => $errProducto],
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }



        
        //No hay errores, persisto venta a la base de datos y también el detalle.
        foreach ($data['ventaDetalle'] as $detalle) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventum);
            $em->flush();


            foreach ($ventaDetalles as $ventaDetalle) {
                $em->persist($ventaDetalle);
                $em->flush();
            }

            //Edito el producto con su nueva cantidad.

            //Si se trata de una variante...
            if ($detalle['variante']) {
                $variante = $this->getDoctrine()
                ->getRepository(Variante::class)
                ->find($detalle["variante"]);

                $cantInicial = $variante->getCantidad();
                $cantNueva = $cantInicial - $detalle["cantidad"];
                $variante->setCantidad($cantNueva);

                //Lo persisto en la base de datos.
                $em->persist($variante);
                $em->flush();
            } else {
                //Si se trata de un producto individual...
                
                $producto = $this->getDoctrine()
                ->getRepository(Producto::class)
                ->find($detalle["producto"]);
                $cantInicial = $producto->getCantidad();
                $cantNueva = $cantInicial - $detalle["cantidad"];
                $producto->setCantidad($cantNueva);

                //Lo persisto en la base de datos.
                $em->persist($producto);
                $em->flush();
            }
        }
        return new JsonResponse(
            [
                'venta' => $ventum,
                'ventaDetalle' => $ventaDetalles,
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
