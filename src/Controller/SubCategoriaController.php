<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\SubCategoria;
use App\Form\SubCategoriaType;
use App\Repository\SubCategoriaRepository;
use App\Service\DefaultValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/subcategoria")
 */
class SubCategoriaController extends AbstractController
{
    private $defaultValidator;
    public function __construct(DefaultValidator $defaultValidator, Security $security)
    {
        $this->defaultValidator = $defaultValidator;
        $this->security = $security;
    }

    /**
     * @Route("/", name="sub_categoria_index", methods="GET")
     */
    public function index(SubCategoriaRepository $subCategoriaRepository): Response
    {
        $subCategoriasRepository = $subCategoriaRepository->findAllAsc();

        $subCategorias = [];

        foreach ($subCategoriasRepository as $subCategoria) {
            $subCategorias[] = $subCategoria->jsonSerialize();
        }

        return new JsonResponse(
            $subCategorias,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/new", name="sub_categoria_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $user = $this->security->getUser();

        $subCategorium = new SubCategoria($user);
        $form = $this->createForm(SubCategoriaType::class, $subCategorium);

        $form->submit($data);

        $err = $this->defaultValidator->validar($subCategorium);
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
        $em->persist($subCategorium);
        $em->flush();

        return new JsonResponse(

            [
                'subcategoria' => $subCategorium->jsonSerialize(),
                'messageType' => 'success',
                'message' => "Subcategoria '" . strtoupper($subCategorium->getNombre()) . "' creada",
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/{id}", name="sub_categoria_show", methods="GET")
     */
    public function show(SubCategoria $subCategorium): Response
    {
        $categoria = $this->getDoctrine()
            ->getRepository(Categoria::class)
            ->findOneBy(
                ['id' => $subCategorium->getCategoria()->getId()]
            );

        return $this->render('sub_categoria/show.html.twig', [
            'sub_categorium' => $subCategorium,
            'categoria' => $categoria,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sub_categoria_edit", methods="PUT")
     */
    public function edit(Request $request, SubCategoria $subCategorium): Response
    {
        $categoria = $this->getDoctrine()
        ->getRepository(Categoria::class)
        ->findOneBy(
            ['id' => $subCategorium->getCategoria()->getId()]
        );
        
        //La data es el nombre, que es lo único editable.
        $nombre = $request->getContent();

        $form = $this->createForm(SubCategoriaType::class, $subCategorium);
        $form->submit(['nombre' => $nombre, 'categoria' => $categoria->getId()]);

        //Lo valido.
        $err = $this->defaultValidator->validar($subCategorium);
        if ($err) {
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                [
                    'subcategoria' => $subCategorium->jsonSerialize(),
                    'messageType' => 'success',
                    'message' => "Categoria '" . strtoupper($subCategorium->getNombre()) . "' editada",
                ],

                JsonResponse::HTTP_CREATED
            );
        }
    }

    /**
     * @Route("/{id}", name="sub_categoria_delete", methods="DELETE")
     */
    public function delete(Request $request, SubCategoria $subCategorium): Response
    {

        //Si algún producto contiene la subcategoría a eliminar, se la quito.
        if ($subCategorium->getProductos()) {
            foreach ($subCategorium->getProductos() as $producto) {
                $producto->setSubCategoria(null);
            }
        }

        //Finalmente remuevo la subcategoría.
        $em = $this->getDoctrine()->getManager();
        $em->remove($subCategorium);
        $em->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
