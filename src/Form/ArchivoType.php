<?php

namespace App\Form;

use App\Entity\Archivo;
use App\Entity\Evento;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreOriginal')
            ->add('nombreFisico')
            ->add('ruta')
            ->add('mimeType')
            ->add('extension')
            ->add('tamano')
            ->add('tipo')
            ->add('ancho')
            ->add('alto')
            ->add('duracion')
            ->add('activo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Archivo::class,
        ]);
    }
}
