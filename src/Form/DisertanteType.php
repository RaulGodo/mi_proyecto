<?php

namespace App\Form;

use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DisertanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'constraints' => [
                    new NotBlank(message: 'El nombre es obligatorio.'),
                    new Length(max: 100),
                ],
            ])
            ->add('apellido', TextType::class, [
                'label' => 'Apellido',
                'constraints' => [
                    new NotBlank(message: 'El apellido es obligatorio.'),
                    new Length(max: 100),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'constraints' => [
                    new NotBlank(message: 'El correo electrónico es obligatorio.'),
                    new Email(message: 'El formato del correo no es válido.'),
                    new Length(max: 180),
                ],
            ])
            ->add('especialidad', TextType::class, [
                'label' => 'Especialidad',
                'constraints' => [
                    new NotBlank(message: 'La especialidad es obligatoria.'),
                    new Length(max: 150),
                ],
            ])
            ->add('biografia', TextareaType::class, [
                'label' => 'Biografía',
                'required' => false,
                'attr' => ['rows' => 5],
            ])
            ->add('activo', CheckboxType::class, [
                'label' => 'Activo',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Disertante::class]);
    }
}
