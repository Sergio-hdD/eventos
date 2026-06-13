<?php

namespace App\Form;

use App\Entity\Candidato;
use App\Entity\Evento;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('foto')
            ->add('descripcion')
            ->add('activo')
            ->add('orden')
            ->add('cantidadVotos')
            ->add('evento', EntityType::class, [
                'class' => Evento::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidato::class,
        ]);
    }
}
