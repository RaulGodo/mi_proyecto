<?php

namespace App\Form;

use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class DisertanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('nombre', null, [
    'label' => 'Nombre',
    'attr' => [
        'placeholder' => 'Ingresá el nombre del disertante',
    ],
])
->add('apellido', null, [
    'label' => 'Apellido',
    'attr' => [
        'placeholder' => 'Ingresá el apellido del disertante',
    ],
])           
->add('telefono', null, [
    'label' => 'Teléfono',
    'required' => false,
    'attr' => [
        'placeholder' => 'Ingresá un teléfono de contacto',
    ],
])

->add('url', null, [
    'label' => 'Página web',
    'required' => false,
    'attr' => [
        'placeholder' => 'https://ejemplo.com',
    ],
])
->add('email', EmailType::class, [
    'label' => 'Correo electrónico',
    'attr' => [
        'placeholder' => 'ejemplo@correo.com',
    ],
])           

->add('twitter', null, [
    'label' => 'Twitter / X',
    'required' => false,
    'attr' => [
        'placeholder' => '@usuario',
    ],
])            

->add('linkedin', null, [
    'label' => 'LinkedIn',
    'required' => false,
    'attr' => [
        'placeholder' => 'https://linkedin.com/in/usuario',
    ],
])
->add('biografia', TextareaType::class, [
    'label' => 'Biografía',
    'required' => false,
    'attr' => [
        'placeholder' => 'Escribí una breve descripción del disertante',
        'rows' => 5,
    ],
])->add('especialidad', null, [
    'label' => 'Especialidad',
    'attr' => [
        'placeholder' => 'Ejemplo: Desarrollo web',
        'maxlength' => 150,
    ],
])            
->add('activo', CheckboxType::class, [
    'label' => 'Disertante activo',
    'required' => false,
])        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disertante::class,
        ]);
    }
}
