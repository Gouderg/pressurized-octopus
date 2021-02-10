<?php

namespace App\Form;

use App\Entity\Temps;
use App\Entity\Profondeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TempsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('temps', NumberType::class)
            ->add('palier15', NumberType::class,['attr' => ['value' => 0,],])
            ->add('palier12', NumberType::class,['attr' => ['value' => 0,],])
            ->add('palier9', NumberType::class,['attr' => ['value' => 0,],])
            ->add('palier6', NumberType::class,['attr' => ['value' => 0,],])
            ->add('palier3', NumberType::class,['attr' => ['value' => 0,],])
            ->add('esta', EntityType::Class, [
                'class' => Profondeur::Class,
                'choice_label' => function ($profondeur) {
                    return $profondeur->getProfondeur();
                },
                'multiple' => false,
                'expanded' => false
            ])
            ->add('btnCreate', SubmitType::class, [
                'label' => 'Create',
                'attr' => [
                    'class' => 'btn-create',
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Temps::class,
        ]);
    }
}
