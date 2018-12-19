<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Este campo es requerido.')))
            ))
            ->add(
                'email',
                null,
                array(
                    'constraints' => array(
                        new Assert\NotBlank(
                            array(
                                'message' => 'Este campo es requerido.'
                            )
                        ),
                        new Assert\Email(
                            array(
                                'message' => 'El email {{ value }} no es válido.'
                            )

                        )
                    )
                )
                        
                        
            )
                   
                
            
            ->add('message', null, array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Este campo es requerido.')))
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }
}
