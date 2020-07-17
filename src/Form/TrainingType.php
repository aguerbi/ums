<?php

namespace App\Form;

use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, ['label' => 'Titre', 'attr' => ['placeholder' => 'Titre']])
                ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['placeholder' => 'Description']])
                ->add('startDate', DateTimeType::class, array('label' => 'Date de début', 'required' => true, 'widget' => 'single_text', 'html5' => true,
                    'attr' => ['class' => 'datetimepicker5', 'autocomplete' => 'off', 'placeholder' => 'Date de début']
                ))
                ->add('endDate', DateTimeType::class, array('label' => 'Date de fin', 'required' => true, 'widget' => 'single_text', 'html5' => true,
                    'attr' => ['class' => 'datetimepicker5', 'autocomplete' => 'off', 'placeholder' => 'Date de fin']
                ))
                ->add('location', TextType::class, ['label' => 'Lieu', 'attr' => ['placeholder' => 'Lieu']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }

}
