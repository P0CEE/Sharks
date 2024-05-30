<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Point;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AppFixtures extends Fixture
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setName($faker->name);
            $user->setDescription($faker->paragraph);
            $user->setProfileImageUrl($faker->imageUrl(640, 480, 'people'));
            $user->setFollowersCount($faker->numberBetween(0, 10000));
            $user->setFollowingCount($faker->numberBetween(0, 10000));
            $user->setIsContentCreator($faker->boolean);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTime());
            $users[] = $user;
            $manager->persist($user);
        }

        // Mélange aléatoire des utilisateurs pour créer un classement aléatoire
        shuffle($users);

        // Attribuez à chaque utilisateur un nombre fixe de points et un classement unique
        foreach ($users as $index => $user) {
            $points = new Point();
            $points->setUser($user);
            $points->setPoints($faker->numberBetween(0, 1000));
            $points->setUserRank($index + 1); // Classement commence à 1
            $manager->persist($points);
        }

        $manager->flush();

        $point = new Point(); 
        $this->updateUserPoints($point);
    }

    private function updateUserPoints(Point $point): void
    {
        // Dispatch a custom event to trigger user points update
        $this->eventDispatcher->dispatch($point, 'user.points.updated');
    }
}
