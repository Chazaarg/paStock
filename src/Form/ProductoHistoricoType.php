<?php

namespace App\Form;

use App\Entity\ProductoHistorico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoHistoricoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producto')
            ->add('nombre')
            ->add('marca')
            ->add('precio')
            ->add('codigoDeBarras')
            ->add('categoria')
            ->add('subcategoria')
            ->add('variante')
            ->add('varianteTipo')
            ->add('varianteId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductoHistorico::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
