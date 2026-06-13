<?php

namespace App\Form;

use App\Entity\Candidato;
use App\Entity\Evento;
use App\Entity\User;
use App\Entity\Voto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('evento', EntityType::class, [
                'class' => Evento::class,
                'choice_label' => 'id',
            ])
            ->add('usuario', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('candidato', EntityType::class, [
                'class' => Candidato::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voto::class,
        ]);
    }
}
