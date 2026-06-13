<?php

namespace App\Form;

use App\Entity\Evento;
use App\Entity\Participante;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rol')
            ->add('createdAt')
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('activo')
            ->add('evento', EntityType::class, [
                'class' => Evento::class,
                'choice_label' => 'id',
            ])
            ->add('usuario', EntityType::class, [
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
            'data_class' => Participante::class,
        ]);
    }
}
