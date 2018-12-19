<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\DefaultValidator;

class ContactController extends AbstractController
{
    private $defaultValidator;
    
    public function __construct(DefaultValidator $defaultValidator)
    {
        $this->defaultValidator = $defaultValidator;
    }

    /**
     * @Route("/api/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer, ValidatorInterface $validator)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
    
        $form = $this->createForm(ContactType::class);

        $form->submit($data);

        $err = $this->defaultValidator->validar($form);
        if ($err) {
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $contactData = $form->getData();

            $message = (new \Swift_Message('De ' . $contactData['name'] .' desde paStock.'))
            ->setFrom($contactData['email'])
            ->setTo('chazarreta.patricio@gmail.com')
            ->setBody(
                "Enviado por " . $contactData['name'] . ". Mail: " .$contactData['email'] . "

                ---------------------------------------------------------------

                ". $contactData['message']. "
                
                
                ---------------------------------------------------------------
                ",
                'text/plain'
            )
    ;

            if ($mailer->send($message)) {
                return new JsonResponse(
                    [
                    'message' => 'Email enviado con éxito',
                    'messageType' => 'success',
                    'errors' => null

                ],
                    JsonResponse::HTTP_OK
                );
            } else {
                return new JsonResponse(
                    [
                    'message' => 'Ha habido un error',
                    'messageType' => 'error',
                    'errors' => null

                ],
                    JsonResponse::HTTP_BAD_REQUEST
                );
            }
        }
        return new JsonResponse(
            [
            'message' => 'Ha habido un error',
            'messageType' => 'error',
            'errors' => null

        ],
            JsonResponse::HTTP_BAD_REQUEST
        );
    }
}
