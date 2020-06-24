<?php

namespace App\DataFixtures;

use App\Entity\Adherent;
use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {
        $faker = Factory::create('fr_FR');
        // Ajouter utilisateur
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);
        // Ajouter société
        for ($i = 0; $i < 30; $i++) {
            $company = new Company();
            $company->setName($faker->company);
            $company->setEmail($faker->companyEmail);
            $company->setPhone($faker->e164PhoneNumber);
            $company->setFax($faker->e164PhoneNumber);
            $company->setAddress($faker->address);
            $company->setDirector($faker->name);
            $company->setMobile($faker->e164PhoneNumber);
            // Ajouter Adhérent
            for ($j = 0; $j < 50; $j++) {
                $adherent = new Adherent();
                $adherent->setFirstName($faker->firstName);
                $adherent->setLastName($faker->lastName);
                $adherent->setCin($faker->numerify('0#######'));
                $adherent->setMobile($faker->numerify('########'));
                $adherent->setCompany($company);
                $manager->persist($adherent);
            }

            $manager->persist($company);
        }
        $manager->flush();
    }

}
