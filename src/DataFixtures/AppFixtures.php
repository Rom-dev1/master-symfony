<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Fakecar;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Fakecar($faker));

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName($faker->vehicle());
            $product->setDescription($faker->text());
            $product->setPrice($faker->numberBetween(100, 2000) * 100);
            $product->setImage('https://picsum.photos/id/'.$faker->numberBetween(0, 1000).'/200/300');
            $manager->persist($product);
        }

        for ($i = 0; $i < 100; $i++) {
            $post = new Post();
            $post->setName($faker->sentence());
            $post->setContent($faker->text());
            $publishedAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', '30 days'));
            $post->setPublishedAt($publishedAt);
            $post->setActive($faker->boolean());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
