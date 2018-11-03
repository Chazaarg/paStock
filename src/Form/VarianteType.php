<?php

namespace App\Form;

use App\Entity\Variante;
use App\Entity\VarianteTipo;
use App\Repository\VarianteTipoRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VarianteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('cantidad')
            ->add('precio')
            ->add('codigo_de_barras')
            ->add('variante_tipo', EntityType::class, array(
                'class' => VarianteTipo::class,
                'query_builder' => function (VarianteTipoRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => 'id',
                'required' => true,
                'property_path' => 'varianteTipo',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Variante::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
