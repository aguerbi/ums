<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Defines the custom form field type used to change user's password.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
class ProfileType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('username', TextType::class, array('label' => 'Nom d\'utilisateur', 'attr' => array('placeholder' => 'Nom d\'utilisateur')))
                ->add('fullname', TextType::class, array('label' => 'Nom & Prénom', 'attr' => array('placeholder' => 'Nom & Prénom')))
                ->add('email', TextType::class, array('label' => 'E-mail', 'attr' => array('placeholder' => 'E-mail')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'app_user';
    }

}
