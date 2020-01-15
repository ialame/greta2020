<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Detail;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProduitFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'foufaf'));
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail("ibrahim.alame@gmail.com")
            ->setAdresse($faker->address)
            ->setLocalite($faker->city)
            ->setNom("Ibrahim ALAME")
            ->setCompte($faker->randomNumber())
            ->setCat($faker->randomAscii.($faker->randomDigit % 10));

        $manager->persist($user);
        $manager->flush();
        $clients[] =$user;
        $N=mt_rand(5, 10);
        for ($i = 1; $i <$N ; $i++) {
            $user = new User();

            $user->setPassword($this->passwordEncoder->encodePassword($user, 'foufaf'));
            $user->setEmail($faker->email)
                ->setAdresse($faker->address)
                ->setLocalite($faker->city)
                ->setNom($faker->name)
                ->setCompte($faker->randomNumber())
                ->setCat($faker->randomAscii.($faker->randomDigit % 10));

            $manager->persist($user);
            $manager->flush();
            $clients[] =$user;
        }
        $N=mt_rand(15, 20);
        for ($i = 1; $i < $N; $i++) {
            $commande = new Commande();
            $commande->setDate($faker->dateTimeBetween('-50 days')) // new \DateTime())
            ->setClient($faker->randomElement($clients));
            $commandes[] = $commande;
            $manager->persist($commande);

            $manager->flush();
        }

        $produits = [];
        $N = mt_rand(5, 10);
        for ($j = 1; $j < $N; $j++) {
            $produit = new Produit();
            $description = '<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>';
            $produit->setNom($faker->word())
                ->setDescription($description)
                ->setImage($faker->imageUrl())
                ->setDate($faker->dateTime())
                ->setQstock(mt_rand(5, 20))
                ->setPrix(mt_rand(1, 10) * 1.5)
                ->setPoids(mt_rand(10, 50) / 10)
                ->setDimensions(mt_rand(2, 10) . "x" . mt_rand(2, 10) . "x" . mt_rand(2, 10));
            $produits[] = $produit;
            $manager->persist($produit);
            $manager->flush();
        }
        $N=mt_rand(40, 80);
                for ($j = 1; $j < $N; $j++) {
                    $detail = new Detail();
                    $detail->setCommande($faker->randomElement($commandes))
                        ->setProduit($faker->randomElement($produits))
                        ->setQuantite($faker->randomDigitNotNull);
                    $manager->persist($detail);
                    $manager->flush();
                }

    }
}
