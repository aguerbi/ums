<?php

namespace App\DataFixtures;

use App\Entity\Adherent;
use App\Entity\Company;
use App\Entity\Event;
use App\Entity\Syndicat;
use App\Entity\Trainer;
use App\Entity\Training;
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
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setFullName('Abdekarim Aguerbi');
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'password'));
        $admin->setEmail('admin@admin.com');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);
        $user = new User();
        $user->setUsername('user');
        $user->setFullName('Salem Cherih');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        $user->setEmail('user@user.com');
        $user->setEnabled(true);
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
            // Ajouter Event
            for ($k = 0; $k < 10; $k++) {
                $event = new Event();
                $event->setTitle($faker->text($maxNbChars = 100));
                $event->setUpdatedAt($faker->dateTime($max = 'now'));
                $event->setDocument($faker->bankAccountNumber);
                $event->setCompany($company);
                $manager->persist($event);
            }
            // Ajouter Syndicat
            $syndicat = new Syndicat();
            $syndicat->setName($faker->city);
            $syndicat->setCompany($company);
            $manager->persist($syndicat);

            $manager->persist($company);
        }
        // Ajouter Formation
        for ($l = 0; $l < 50; $l++) {
            $training = new Training();
            $training->setTitle($faker->text($maxNbChars = 100));
            $training->setDescription($faker->text($maxNbChars = 500));
            $training->setStartDate($faker->dateTime($max = 'now'));
            $training->setEndDate($faker->dateTime($max = 'now'));
            $training->setLocation($faker->city);
            $manager->persist($training);
        }
        // Ajouter Formateur
        for ($l = 0; $l < 100; $l++) {
            $trainer = new Trainer();
            $trainer->setFirstName($faker->firstName);
            $trainer->setLastName($faker->lastName);
            $trainer->setMobile($faker->numerify('########'));
            $trainer->setSpecialty($faker->word);
            $manager->persist($trainer);
        }
        $manager->flush();
    }

}
