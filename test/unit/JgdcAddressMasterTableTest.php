<?php
require_once __DIR__ . '/../bootstrap/Doctrine.php';

$t = new lime_test();

foreach (JgdcAddressMasterTable::getAllPrefectures() as $o) {
  $prefecture_code = $o->getPrefectureCode();
  $t->is($o->getNewMaCode(), $prefecture_code . '000000000');
}

foreach (JgdcAddressMasterTable::getAllCities() as $o) {
  $city_code = $o->getCityCode();
  $t->is($o->getNewMaCode(), $city_code . '000000');
}

