<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('titulo', null, [
                'label' => 'Título del evento',
                'attr' => [
                    'placeholder' => 'Ingrese el título del evento',
                ],
            ])
            ->add('idioma', null, [
                'label' => 'Idioma',
                'attr' => [
                    'placeholder' => 'Ej: Español',
                ],
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción',
                'attr' => [
                    'placeholder' => 'Ingrese una descripción',
                ],
            ])
            ->add('fecha', null, [
                'label' => 'Fecha',
            ])
            ->add('hora', null, [
                'label' => 'Hora',
            ])
            ->add('duracion', null, [
                'label' => 'Duración en minutos',
            ])
            ->add('capacidad', null, [
                'label' => 'Capacidad máxima',
            ])
            ->add('disertante', null, [
                'label' => 'Disertante',
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
