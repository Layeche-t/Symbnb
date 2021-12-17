<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('FR-fr');

        $users = [];
        $genres = ['male', 'female'];

        // for entity user 
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();


            $genre = $faker->randomElement($genres);

            $pircture = 'https://randomuser.me/api/portraits/';
            $pirctureId = $faker->numberBetween(1, 99) . '.jpg';

            $pircture .= ($genre == 'male' ? 'men/' : 'women/') . $pirctureId;


            $user->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastname($genre))
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setHash('password')
                ->setPircture($pircture);

            $manager->persist($user);
            $users[] = $user;
        }

        // for entity Ad
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = "https://picsum.photos/1200/350?random=" . mt_rand(1, 5000);;
            $introduction = $faker->paragraph(2);
            $contents = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContents($contents)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 6))
                ->setAuthor($user);

            // for entity image
            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();
                $image->setUrl($coverImage)
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
