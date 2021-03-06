<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Entity\Syndicat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberSyndicatType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder
                ->add('adherent', EntityType::class, [
                    'class' => Adherent::class,
                    'choice_label' => 'fullName',
                ])
                ->add('syndicat', EntityType::class, [
                    'class' => Syndicat::class,
                    'choice_label' => 'name',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
        ]);
    }

}
