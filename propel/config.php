<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=192.168.0.20;dbname=albopretorio',
  'user' => 'albopretorio',
  'password' => 'albo.pass',
  'settings' =>
  array (
    'charset' => 'utf8',
    'queries' =>
    array (
    ),
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
));
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setAdapterClass('albopretorio', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=192.168.0.20;dbname=albopretorio',
  'user' => 'albopretorio',
  'password' => 'albo.pass',
  'settings' =>
  array (
    'charset' => 'utf8',
    'queries' =>
    array (
    ),
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
));
$manager->setName('albopretorio');
$serviceContainer->setConnectionManager('albopretorio', $manager);
$serviceContainer->setAdapterClass('protocolloro', 'pgsql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'pgsql:host=192.168.0.23;port=5433;dbname=protocollo;user=protocolloro;password=protocolloro',
  'user' => 'protocolloro',
  'password' => 'protocolloro',
  'settings' =>
  array (
    'charset' => 'utf8',
    'queries' =>
    array (
    ),
  ),
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
));
$manager->setName('protocolloro');
$serviceContainer->setConnectionManager('protocolloro', $manager);
$serviceContainer->setDefaultDatasource('default');