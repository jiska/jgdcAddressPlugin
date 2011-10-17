<?php
require_once __DIR__ . '/../bootstrap/Doctrine.php';

$t = new lime_test();

$t->is(JgdcPrefectureMasterTable::getNameByCode('01'),   '北海道');
$t->is(JgdcPrefectureMasterTable::getNameByCode('13'),   '東京都');
$t->is(JgdcPrefectureMasterTable::getNameByCode('47'),   '沖縄県');
$t->is(JgdcPrefectureMasterTable::getNameByCode('1'),    false);
$t->is(JgdcPrefectureMasterTable::getNameByCode('0x01'), false);
$t->is(JgdcPrefectureMasterTable::getNameByCode(48),     false);

$expect = array(
  '01' => '北海道',
  '13' => '東京都',
  '47' => '沖縄県',
);

$t->is(JgdcPrefectureMasterTable::getPrefectures(), $expect);
