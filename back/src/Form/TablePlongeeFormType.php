<?php

namespace App\Form;

use App\Entity\Tableplongee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TablePlongeeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'required' => True,    
                ],
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
            'data_class' => Tableplongee::class,
        ]);
    }
}
