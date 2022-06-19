<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@user.com')->setFullName('Fatma Jouini')->setRoles(['ROLE_STUDENT']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        $company = new User();
        $company->setEmail('company@company.com')->setFullName('Walid Elouni')->setRoles(['ROLE_COMPANY']);
        $company->setPassword($this->passwordHasher->hashPassword($company, 'password'));
        $manager->persist($company);


        $cities = ['Ariana', 'Béja', 'Ben Arous', 'Bizerte', 'Gabès', 'Gafsa', 'Jendouba', 'Kairouan', 'Kasserine', 'Kebili', 'Kef', 'Mahdia', 'Manouba', 'Medenine', 'Monastir', 'Nabeul', 'Sfax', 'Sidi Bouzid', 'Siliana', 'Sousse', 'Tataouine', 'Tozeur', 'Tunis', 'Zaghouan'];
        foreach ($cities as $city) {
            $city = (new City())->setName($city);
            $manager->persist($city);
        }

        $manager->flush();
    }
}
