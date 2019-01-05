<?php

namespace App\Form;

use App\Entity\ClienteHistorico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteHistoricoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente')
            ->add('nombre')
            ->add('apellido')
            ->add('email')
            ->add('telefono')
            ->add('dni')
            ->add('direccion')
            ->add('localidad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClienteHistorico::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
