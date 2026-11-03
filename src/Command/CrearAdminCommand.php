<?php

namespace App\Command;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:crear-admin',
    description: 'Crea un usuario administrador'
)]
class CrearAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        $email = 'admin@eventos.com';

        // Evitar crear administradores duplicados.
        $existente = $this->entityManager
            ->getRepository(Usuario::class)
            ->findOneBy(['email' => $email]);

        if ($existente) {
            $io->note('El administrador ya existe. Vamos a actualizar su contraseña.');

            $nuevaPassword = $io->askHidden('Ingresá la nueva contraseña');

            if (!$nuevaPassword || strlen($nuevaPassword) < 12) {
                $io->error('La contraseña debe tener al menos 12 caracteres.');
                return Command::FAILURE;
            }

            $hash = $this->passwordHasher->hashPassword(
                $existente,
                $nuevaPassword
            );

            $existente->setPassword($hash);

            $this->entityManager->flush();

            $io->success('Contraseña actualizada correctamente.');

            return Command::SUCCESS;
        }

        // Solicitar la contraseña sin mostrarla en pantalla.
        $password = $io->askHidden('Contraseña del administrador');

        if (!$password || strlen($password) < 12) {
            $io->error('La contraseña debe tener al menos 12 caracteres.');
            return Command::FAILURE;
        }

        $usuario = new Usuario();

        $usuario->setNombre('Administrador');
        $usuario->setApellido('Sistema');
        $usuario->setDni('ADMIN001');
        $usuario->setDireccion('Administración');
        $usuario->setTelefono('No informado');
        $usuario->setEmail($email);
        $usuario->setRoles(['ROLE_ADMIN']);

        // Symfony genera el hash de la contraseña.
        $hash = $this->passwordHasher->hashPassword(
            $usuario,
            $password
        );

        $usuario->setPassword($hash);

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        $io->success('Administrador creado correctamente.');

        return Command::SUCCESS;
    }
}
