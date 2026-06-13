<?php

namespace App\Form;

use App\Entity\Evento;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('slug')
            ->add('descripcion')
            ->add('fechaInicio', null, [
                'widget' => 'single_text',
            ])
            ->add('fechaFin', null, [
                'widget' => 'single_text',
            ])
            ->add('tokenQr')
            ->add('estado')
            ->add('createdAt')
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('activo')
            ->add('organizador', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('createdBy', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('updatedBy', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
