<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_ROLES = [
        'ROLE_USER',
        'ROLE_ADMIN',
        'ROLE_EMPLOYEE',
    ];

    public const  USER_NUMBER = 40;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setFirstname('Gojo');
        $user->setLastname('Satoru');
        $user->setEmail('user@makesense.com');
        $user->setRoles(['ROLE_USER']);
        $user->setIsActivated(true);
        $user->setAvatar('avatarBenevole.jpg');
        copy(
            __DIR__ . '/avatar/avatarBenevole.jpg',
            'public/uploads/avatar/avatarBenevole.jpg'
        );

        $this->addReference('user_0', $user);

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'azertyuiop');
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $employee = new User();
        $employee->setFirstname('Kirua');
        $employee->setLastname('Zoldik');
        $employee->setEmail('employee@makesense.com');
        $employee->setRoles(['ROLE_EMPLOYEE']);
        $employee->setIsActivated(true);
        $employee->setAvatar('avatarEmployee.jpg');
        copy(
            __DIR__ . '/avatar/avatarEmployee.jpg',
            'public/uploads/avatar/avatarEmployee.jpg'
        );

        $this->addReference('employee_0', $employee);

        $hashedPassword = $this->passwordHasher->hashPassword($employee, 'azertyuiop');
        $employee->setPassword($hashedPassword);
        $manager->persist($employee);

        $admin = new User();
        $admin->setFirstname('Gon');
        $admin->setLastname('Freecss');
        $admin->setEmail('admin@makesense.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActivated(true);
        $admin->setAvatar('avatarAdmin.jpg');
        copy(
            __DIR__ . '/avatar/avatarAdmin.jpg',
            'public/uploads/avatar/avatarAdmin.jpg'
        );

        $this->addReference('admin_0', $admin);


        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'azertyuiop');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);


        for ($i = 0; $i < self::USER_NUMBER; $i++) {
            $user = new User();
            $avatar = 'avatar' . ($i + 1) . '.jpg';

            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email());
            $user->setRoles([$faker->randomElement(self::USER_ROLES)]);
            $user->setBiography($faker->text(250));

            $user->setAvatar($avatar);

            $this->addReference('user_' . ($i + 1), $user);


            copy(
                __DIR__ . '/avatar/' . $avatar,
                'public/uploads/avatar/' . $avatar
            );

            $user->setPassword('');

            $user->setIsActivated($faker->boolean);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
