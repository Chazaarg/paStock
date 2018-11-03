<?php

namespace App\Form;

use App\Entity\Marca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarcaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('origen', null, array(
                'required' => false,
            ))
            ->add('pagina', null, array(
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Marca::class,
            'csrf_protection' => false,
        ]);
    }
}
