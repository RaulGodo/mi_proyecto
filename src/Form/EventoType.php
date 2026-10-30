<?php

namespace App\Form;

use App\Entity\Disertante;
use App\Entity\Evento;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EventoType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título del evento',
                'attr' => ['placeholder' => 'Ingrese el título del evento'],
                'constraints' => [
                    new NotBlank(message: 'El título es obligatorio.'),
                    new Length(max: 255),
                ],
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'placeholder' => 'Ingrese una descripción',
                    'rows' => 4,
                ],
                'constraints' => [
                    new NotBlank(message: 'La descripción es obligatoria.'),
                    new Length(max: 255),
                ],
            ])
            ->add('fecha', DateType::class, [
                'label' => 'Fecha del evento',
                'widget' => 'single_text',
                'constraints' => [new NotBlank(message: 'La fecha es obligatoria.')],
            ])
            ->add('hora', TimeType::class, [
                'label' => 'Hora de inicio',
                'widget' => 'single_text',
                'constraints' => [new NotBlank(message: 'La hora es obligatoria.')],
            ])
            ->add('duracion', IntegerType::class, [
                'label' => 'Duración (en minutos)',
                'attr' => ['placeholder' => 'Ej: 90'],
                'constraints' => [
                    new NotBlank(message: 'La duración es obligatoria.'),
                    new Positive(message: 'La duración debe ser mayor a cero.'),
                ],
            ])
            ->add('idioma', ChoiceType::class, [
                'label' => 'Idioma',
                'choices' => [
                    'Español' => 'es',
                    'Inglés' => 'en',
                    'Portugués' => 'pt',
                ],
            ])
            ->add('estado', ChoiceType::class, [
                'label' => 'Estado',
                'choices' => [
                    'Activo' => 'Activo',
                    'Cancelado' => 'Cancelado',
                    'Finalizado' => 'Finalizado',
                ],
            ])
            ->add('disertante', EntityType::class, [
                'class' => Disertante::class,
                'choice_label' => 'nombreCompleto',
                'label' => 'Disertantes',
                'multiple' => true,
                'required' => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
