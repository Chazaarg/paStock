<?php

namespace App\DataFixtures;

use App\Entity\Cliente;
use App\Entity\FormaDePago;
use App\Entity\VarianteTipo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PastockFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Default values for every user.


        $cliente = new Cliente(null);
        $cliente->setNombre("Cliente");
        $cliente->setApellido("Genérico");
        $manager->persist($cliente);
        
        $formaDePago = new FormaDePago(null);
        $formaDePago->setNombre("Efectivo");
        $manager->persist($formaDePago);
        
        $formaDePago = new FormaDePago(null);
        $formaDePago->setNombre("Tarjeta");
        $manager->persist($formaDePago);

        $varianteTipo = new VarianteTipo(null);
        $varianteTipo->setNombre("Color");
        $manager->persist($varianteTipo);

        $varianteTipo = new VarianteTipo(null);
        $varianteTipo->setNombre("Tono");
        $manager->persist($varianteTipo);


        $manager->flush();
    }
}
