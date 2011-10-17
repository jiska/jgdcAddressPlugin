<?php
include __DIR__ . '/unit.php';

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

new sfDatabaseManager($configuration);

Doctrine_Core::loadData(__DIR__ . '/../fixtures');
