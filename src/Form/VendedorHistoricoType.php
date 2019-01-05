<?php

namespace App\Form;

use App\Entity\VendedorHistorico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendedorHistoricoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vendedor')
            ->add('nombre')
            ->add('apellido')
            ->add('apodo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VendedorHistorico::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
