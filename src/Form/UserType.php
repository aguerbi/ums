<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', TextType::class, array('label' => 'Nom d\'utilisateur', 'attr' => array('placeholder' => 'Nom d\'utilisateur')))
                ->add('fullname', TextType::class, array('label' => 'Nom & Prénom', 'attr' => array('placeholder' => 'Nom & Prénom')))
                ->add('email', TextType::class, array('label' => 'E-mail', 'attr' => array('placeholder' => 'E-mail')))
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'min' => 8,
                            'max' => 128,
                                ]),
                    ],
                    'first_options' => [
                        'label' => 'Nouveau mot de passe',
                        'attr' => array('placeholder' => 'Nouveau mot de passe')
                    ],
                    'second_options' => [
                        'label' => 'Confirmer le mot de passe',
                        'attr' => array('placeholder' => 'Confirmer le mot de passe')
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
