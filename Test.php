<?php

declare(strict_types=1);

use App\Entity\Users;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(".env");

# $usersData = new Users()->setGuid("131231245");

$params = [
    'host'      => $_ENV['DB_HOST'],
    'user'      => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASS'],
    'dbname'    => $_ENV['DB_DATABASE'],
    'driver'    => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];

$entityManager = new EntityManager(
    DriverManager::getConnection($params),
    ORMSetup::createAttributeMetadataConfiguration([
        __DIR__ . '/src/Entity',
    ])
);