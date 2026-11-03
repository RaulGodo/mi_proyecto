<?php

namespace App\DataFixtures;

use App\Entity\Disertante;
use App\Entity\Evento;
use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Disertantes
        $disertante1 = new Disertante();
        $disertante1
            ->setNombre('Juan')
            ->setApellido('Pérez')
            ->setTelefono('3511111111')
            ->setUrl('https://example.com/juan')
            ->setEmail('juan@example.com')
            ->setTwitter('https://twitter.com/juan')
            ->setLinkedin('https://linkedin.com/in/juan')
            ->setBiografia('Especialista en desarrollo web y Symfony.');

        $disertante2 = new Disertante();
        $disertante2
            ->setNombre('María')
            ->setApellido('Gómez')
            ->setTelefono('3512222222')
            ->setUrl('https://example.com/maria')
            ->setEmail('maria@example.com')
            ->setTwitter('https://twitter.com/maria')
            ->setLinkedin('https://linkedin.com/in/maria')
            ->setBiografia('Especialista en bases de datos y Doctrine ORM.');

        $manager->persist($disertante1);
        $manager->persist($disertante2);

        // Eventos
        $evento1 = new Evento();
        $evento1
            ->setTitulo('Introducción a Symfony 7')
            ->setSlug('introduccion-symfony-7')
            ->setIdioma('Español')
            ->setDescripcion('Introducción al desarrollo web con Symfony 7.')
            ->setFecha(new \DateTime('2026-09-10'))
            ->setHora(new \DateTime('18:00'))
            ->setDuracion(90)
            ->setCapacidad(100)
            ->setDisertante($disertante1);
        $evento2 = new Evento();
        $evento2
            ->setTitulo('Doctrine ORM en Symfony')
            ->setSlug('doctrine-orm-symfony')
            ->setIdioma('Español')
            ->setDescripcion('Relaciones, repositorios y consultas con Doctrine ORM.')
            ->setFecha(new \DateTime('2026-09-12'))
            ->setHora(new \DateTime('19:00'))
            ->setDuracion(120)
            ->setCapacidad(80)
            ->setDisertante($disertante2);
        $evento3 = new Evento();
        $evento3
            ->setTitulo('Twig desde cero')
            ->setSlug('twig-desde-cero')
            ->setIdioma('Español')
            ->setDescripcion('Creación de vistas dinámicas utilizando Twig.')
            ->setFecha(new \DateTime('2026-09-15'))
            ->setHora(new \DateTime('17:30'))
            ->setDuracion(60)
            ->setCapacidad(60)
            ->setDisertante($disertante1);
        $manager->persist($evento1);
        $manager->persist($evento2);
        $manager->persist($evento3);

        // Usuarios
        $usuario1 = new Usuario();
        $usuario1
            ->setNombre('Ana')
            ->setApellido('López')
            ->setDni('30111222')
            ->setDireccion('Av. Siempre Viva 123')
            ->setTelefono('3513333333')
            ->setEmail('ana@example.com')
            ->setPassword('123456');

        $usuario2 = new Usuario();
        $usuario2
            ->setNombre('Carlos')
            ->setApellido('Martínez')
            ->setDni('32444555')
            ->setDireccion('San Martín 456')
            ->setTelefono('3514444444')
            ->setEmail('carlos@example.com')
            ->setPassword('123456');

        $manager->persist($usuario1);
        $manager->persist($usuario2);

        // Inscripciones
        $evento1->addUsuario($usuario1);
        $evento1->addUsuario($usuario2);
        $evento2->addUsuario($usuario1);

        $manager->flush();
    }
}
