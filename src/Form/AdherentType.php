<?php

namespace App\Form;

use App\Entity\Adherent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdherentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstName', TextType::class, ['label' => 'Prénom', 'attr' => ['placeholder' => 'Prénom']])
                ->add('lastName', TextType::class, ['label' => 'Nom', 'attr' => ['placeholder' => 'Nom']])
                ->add('cin', TextType::class, ['label' => 'CIN', 'attr' => ['placeholder' => 'CIN']])
                ->add('mobile', IntegerType::class, ['label' => 'Portable', 'attr' => ['placeholder' => 'Poratble']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }

}
