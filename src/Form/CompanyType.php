<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, ['label' => 'Nom de société', 'attr' => ['placeholder' => 'Nom de société']])
                ->add('phone', IntegerType::class, ['label' => 'Téléphone', 'attr' => ['placeholder' => 'Téléphone']])
                ->add('fax', IntegerType::class, ['label' => 'Fax', 'required' => false, 'attr' => ['placeholder' => 'Fax']])
                ->add('email', EmailType::class, ['label' => 'Adresse de messagerie', 'required' => false, 'attr' => ['placeholder' => 'Adresse de messagerie']])
                ->add('address', TextareaType::class, ['label' => 'Adresse', 'required' => false, 'attr' => ['placeholder' => 'Adresse']])
                ->add('director', TextType::class, ['label' => 'Directeur', 'required' => false, 'attr' => ['placeholder' => 'Directeur']])
                ->add('mobile', IntegerType::class, ['label' => 'Portable', 'required' => false, 'attr' => ['placeholder' => 'Portable']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }

}
