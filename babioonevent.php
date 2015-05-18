<?php

require_once __DIR__ . '/vendor/autoload.php';

$config['appenv'] = 'joomla';
$config['admin'] = JFactory::getApplication()->isAdmin();
$config['input'] = JFactory::getApplication()->input;


$Application = new BabioonRad\Application\Application($config);

$Application->execute();

var_dump($Application);

