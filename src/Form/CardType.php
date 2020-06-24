<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('numberCard', TextType::class, ['label' => 'Numéro CID', 'attr' => ['placeholder' => 'Numéro CID']])
                ->add('year', ChoiceType::class, [
                    'choices' => [
                        date('Y') => date('Y'),
                        date('Y') - 1 => date('Y') - 1,
                        date('Y') - 2 => date('Y') - 2,
                    ], 'label' => 'Année'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }

}
