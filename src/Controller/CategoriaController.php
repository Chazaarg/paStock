<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use App\Service\DefaultValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/categoria")
 */
class CategoriaController extends AbstractController
{
    private $defaultValidator;
    private $security;
    
    public function __construct(DefaultValidator $defaultValidator, Security $security)
    {
        $this->defaultValidator = $defaultValidator;
        $this->security = $security;
    }

    /**
     * @Route("/", name="categoria_index", methods="GET")
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        $categoriasRepository = $categoriaRepository->findAllAsc();

        $categorias = [];

        foreach ($categoriasRepository as $categoria) {
            $categorias[] = $categoria->jsonSerialize();
        }

        return new JsonResponse(
            $categorias,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="categoria_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
        
        $user = $this->security->getUser();

        $categorium = new Categoria($user);
        $form = $this->createForm(CategoriaType::class, $categorium);

        $form->submit($data);

        $err = $this->defaultValidator->validar($categorium);
        if ($err) {
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ]
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($categorium);
        $em->flush();

        return new JsonResponse(
            [
                'categoria' => $categorium->jsonSerialize(),
                'messageType' => 'success',
                'message' => "Categoria '" . strtoupper($categorium->getNombre()) . "' creada",
            ],

            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/{id}/edit", name="categoria_edit", methods="PUT")
     */
    public function edit(Request $request, Categoria $categorium): Response
    {
        //La data es el nombre, que es lo único editable.
        $nombre = $request->getContent();
        

        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->submit(['nombre' => $nombre]);


        //Lo valido.
        $err = $this->defaultValidator->validar($categorium);
        if ($err) {
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                [
                    'categoria' => $categorium->jsonSerialize(),
                    'messageType' => 'success',
                    'message' => "Categoria '" . strtoupper($categorium->getNombre()) . "' editada",
                ],
    
                JsonResponse::HTTP_CREATED
            );
        }
    }

    /**
     * @Route("/{id}", name="categoria_delete", methods="DELETE")
     */
    public function delete(Request $request, Categoria $categorium): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Elimino las subcategorias de la categoría a remover.
        foreach ($categorium->getSubcategoria() as $subcategoria) {

            //Si algún producto contiene la subcategoría a eliminar, se la quito.
            if ($subcategoria->getProductos()) {
                foreach ($subcategoria->getProductos() as $producto) {
                    $producto->setSubCategoria(null);
                }
            }

            $em->remove($subcategoria);
            $em->flush();
        }

        //Si algún producto contiene la categoría a eliminar, se la quito.
        if ($categorium->getProductos()) {
            foreach ($categorium->getProductos() as $producto) {
                $producto->setCategoria(null);
            }
        }

        //Finalmente remuevo la categoría.
        $em->remove($categorium);
        $em->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
