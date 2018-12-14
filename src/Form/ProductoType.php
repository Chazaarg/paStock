<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\SubCategoria;
use App\Repository\SubCategoriaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('nombre')
            ->add('precio')
            ->add('descripcion')
            ->add('codigo_de_barras', null, array(
                'required' => false,
                'property_path' => 'codigoDeBarras',
            ))
            ->add('precio_compra', null, array(
                'required' => false,
                'property_path' => 'precioCompra',
            ))
            ->add('precio_real', null, array(
                'required' => false,
                'property_path' => 'precioReal',
            ))
            ->add('cantidad')
            ->add('marca', null, array(
                'required' => false,
            ))
            ->add('categoria', null, array(
                'required' => false,
            ))
            ->add('sub_categoria', EntityType::class, array(
                'class' => SubCategoria::class,
                'query_builder' => function (SubCategoriaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => 'id',
                'required' => false,
                'property_path' => 'SubCategoria',

            ))
            ->add('variantes', CollectionType::class, array(
                'entry_type' => VarianteType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
        /*
        $builder->get('categoria')->addEventListener(
        FormEvents::POST_SUBMIT,
        function(FormEvent $event){
        $form = $event->getForm();

        $form->getParent()->add('SubCategoria', EntityType::Class, array(
        'class' => SubCategoria::class,
        'placeholder' => 'Seleccione subcategoria',
        'choices' => $form->getData()->getSubCategoria()

        ));
        }
        );

        $builder->addEventListener(
        FormEvents::POST_SET_DATA,
        function(FormEvent $event){
        $form = $event->getForm();
        $data = $event->getData();
        $subCategoria = $data->getSubcategoria();

        if($subCategoria){
        $form->get('categoria')->setData($subCategoria->getCategoria());

        $form->add('SubCategoria', EntityType::Class, array(
        'class' => SubCategoria::class,
        'placeholder' => 'Seleccione subcategoria',
        'choices' => $subCategoria->getCategoria()->getSubcategoria(),
        'required' => false,

        ));

        }
        else{
        $form->add('SubCategoria', EntityType::Class, array(
        'class' => SubCategoria::class,
        'placeholder' => 'Seleccione subcategoria',
        'choices' => [],
        'required' => false,

        ));

        }

        }
        );
         */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
