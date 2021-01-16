<?php

namespace App\Form;

use App\Entity\Profondeur;
use App\Entity\Tableplongee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProfondeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $builder
            ->add('profondeur', NumberType::class)
            ->add('correspond', EntityType::Class, [
                'class' => Tableplongee::Class,
                'choice_label' => function ($table) {
                    return $table->getNom();
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
            'data_class' => Profondeur::class,
        ]);
    }
}
