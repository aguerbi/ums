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

        $this->var = $options['var'];
        $builder
                ->add('adherent', EntityType::class, [
                    'class' => Adherent::class,
                    'query_builder' => function ($er) {
                        return $er->createQueryBuilder('a')
                                ->join('a.company', 'up')
                                ->where('up.id = :var')
                                ->setParameter("var", $this->var);
                    },
                    'choice_label' => 'fullName',
                ])
                ->add('syndicat', EntityType::class, [
                    'class' => Syndicat::class,
                    'query_builder' => function ($er) {
                        return $er->createQueryBuilder('s')
                                ->join('s.company', 'up')
                                ->where('up.id = :var')
                                ->setParameter("var", $this->var);
                    },
                    'choice_label' => 'name',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
            'var' => 62
        ]);
    }

}
