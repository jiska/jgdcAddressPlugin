<?php
require_once __DIR__ . '/../bootstrap/Doctrine.php';

$t = new lime_test();
$o = JgdcAddressMasterTable::getInstance()->findOneByNewMaCode('11110123456');

$t->is($o->getNewMaCode(),      '11110123456');
$t->is($o->getPrefectureCode(), '11');
$t->is($o->getCityCode(),       '11110');
$t->is($o->getAreaCode(),       '123456');
$t->is($o->getCityName(),       'テストデータ市');

