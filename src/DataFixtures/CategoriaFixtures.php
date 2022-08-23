<?php

namespace App\DataFixtures;

use App\Entity\Categoria;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoria = new Categoria();
        $categoria->setNome("Alimentacao");
        $manager->persist($categoria);
        $manager->flush();
    
        $categoria2 = new Categoria();
        $categoria2->setNome("Saude");
        $manager->persist($categoria2);
        $manager->flush();
    
        $categoria3 = new Categoria();
        $categoria3->setNome("Outras");
        $manager->persist($categoria3);
        $manager->flush();

        $categoria4 = new Categoria();
        $categoria4->setNome("Moradia");
        $manager->persist($categoria4);
        $manager->flush();

        $categoria5 = new Categoria();
        $categoria5->setNome("Transporte");
        $manager->persist($categoria5);
        $manager->flush();
    
        $categoria6 = new Categoria();
        $categoria6->setNome("Educacao");
        $manager->persist($categoria6);
        $manager->flush();
    
        $categoria7 = new Categoria();
        $categoria7->setNome("Lazer");
        $manager->persist($categoria7);
        $manager->flush();

        $categoria8 = new Categoria();
        $categoria8->setNome("Imprevistos");
        $manager->persist($categoria8);
        $manager->flush();
    }
}
