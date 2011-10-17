<?php
require_once __DIR__ . '/../bootstrap/Doctrine.php';

$t = new lime_test();

$t->is('北海道', JgdcPrefectureMasterTable::getNameByCode('01'));
$t->is('東京都', JgdcPrefectureMasterTable::getNameByCode('13'));
$t->is('沖縄県', JgdcPrefectureMasterTable::getNameByCode('47'));
$t->is(false, JgdcPrefectureMasterTable::getNameByCode('1'));
$t->is(false, JgdcPrefectureMasterTable::getNameByCode('0x01'));
$t->is(false, JgdcPrefectureMasterTable::getNameByCode(48));


$expect = array(
  '01' => '北海道',
  '13' => '東京都',
  '47' => '沖縄県',
);

$t->is($expect, JgdcPrefectureMasterTable::getPrefectures());
