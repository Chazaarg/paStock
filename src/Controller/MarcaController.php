<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Form\MarcaType;
use App\Repository\MarcaRepository;
use App\Service\DefaultValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/marca")
 */
class MarcaController extends AbstractController
{
    private $defaultValidator;
    public function __construct(DefaultValidator $defaultValidator, Security $security)
    {
        $this->defaultValidator = $defaultValidator;
        $this->security = $security;
    }
    /**
     * @Route("/", name="marca_index", methods="GET")
     */
    public function index(MarcaRepository $marcaRepository): Response
    {
        $marcasRepository = $marcaRepository->findAllAsc();

        $marcas = [];

        foreach ($marcasRepository as $marca) {
            $marcas[] = $marca->jsonSerialize();
        }

        return new JsonResponse(
            $marcas,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="marca_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $user = $this->security->getUser();

        $marca = new Marca($user);
        $form = $this->createForm(MarcaType::class, $marca);

        $form->submit($data);

        $err = $this->defaultValidator->validar($marca);
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
        $em->persist($marca);
        $em->flush();

        return new JsonResponse(
            [
                'marca' => $marca->jsonSerialize(),
                'messageType' => 'success',
                'message' => "Marca '" . strtoupper($marca->getNombre()) . "' creada",
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/{id}/edit", name="marca_edit", methods="PUT")
     */
    public function edit(Request $request, Marca $marca): Response
    {

        //La data es el nombre, que es lo único editable.
        $nombre = $request->getContent();

        $form = $this->createForm(MarcaType::class, $marca);
        $form->submit(['nombre' => $nombre]);

        //Lo valido.
        $err = $this->defaultValidator->validar($marca);
        if ($err) {
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                [
                    'marca' => $marca->jsonSerialize(),
                    'messageType' => 'success',
                    'message' => "Marca '" . strtoupper($marca->getNombre()) . "' editada",
                ],
    
                JsonResponse::HTTP_CREATED
            );
        }
    }

    /**
     * @Route("/{id}", name="marca_delete", methods="DELETE")
     */
    public function delete(Request $request, Marca $marca): Response
    {
        //Si algún producto contiene la MARCA a eliminar, se la quito.
        if ($marca->getProductos()) {
            foreach ($marca->getProductos() as $producto) {
                $producto->setMarca(null);
            }
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($marca);
        $em->flush();
        
        return new JsonResponse(
                null,
                JsonResponse::HTTP_NO_CONTENT
            );
    }
}
