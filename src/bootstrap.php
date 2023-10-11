<?php declare(strict_types = 1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;

require __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration([__DIR__], true);
$config->setNamingStrategy(new UnderscoreNamingStrategy());

// todo move to config
return EntityManager::create([
    'driver' => 'pdo_mysql',
    'host' => 'shipmonk-packing-mysql',
    'user' => 'root',
    'password' => 'secret',
    'dbname' => 'packing',
], $config);
