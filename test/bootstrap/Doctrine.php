<?php
include __DIR__ . '/unit.php';

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

new sfDatabaseManager($configuration);

Doctrine_Core::loadData(sfConfig::get('sf_test_dir') . '/fixtures');
