<?php

class LoadJgdcAddressMasterTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('filename', null, sfCommandOption::PARAMETER_OPTIONAL, 'file name', date('Ym')),
      // add your own options here
    ));

    $this->namespace        = 'jgdc';
    $this->name             = 'load-master';
    $this->briefDescription = '国土地理協会から購入できる住所マスターを読み込んでJgdcAddressMasterにインサートします';
    $this->detailedDescription = <<<EOF
The [jgdc:load-master|INFO] task load file to jgdc_address_master.
put file on data/csv/jgdc_address_master

You can set filename to select load files:

  [./symfony jgdc:load-master --env=test --filename=200109|INFO]

EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $filepath = sfConfig::get('sf_data_dir') . '/csv/' . $options['filename'] . 'jgdc.csv';
    $this->logSection('jgdc', sprintf('Loading "%s" environment "%s"', $options['env'], $filepath));

    if (false === is_readable($filepath) || false === file_exists($filepath)) {
      throw new sfException(sprintf('jgdc_address_file "%s" does not exist (or can not readable).', $filepath));
    }

    $this->log('process start.');

    $reader = new sfCsvReader($filepath);
    $reader->open();
    $i = 1;
    while ($data = $reader->read()) {
      if (51 !== count($data)) {
        throw new sfException(sprintf('jgdc_master_file field count does not match 51. check file "%s" line %d.', $filepath, $i));
      }

      $jgdc_address = JgdcAddressMasterTable::getInstance()->findOneByNewMaCode($this->trim_mbspace($data[1]));
      if (false === $jgdc_address) {
        $jgdc_address = new JgdcAddressMaster;
      }
      $jgdc_address->setMaCode($this->trim_mbspace($data[0]));
      $jgdc_address->setNewMaCode($this->trim_mbspace($data[1]));
      $jgdc_address->setZipCode($this->trim_mbspace($data[2]));
      $jgdc_address->setBarcode($this->trim_mbspace($data[3]));
      $jgdc_address->setBarcodeLength($this->trim_mbspace($data[4]));
      $jgdc_address->setZipCodeAdditionalInfo1($this->trim_mbspace($data[5]));
      $jgdc_address->setZipCodeAdditionalInfo2($this->trim_mbspace($data[6]));
      $jgdc_address->setRelationFlag($this->trim_mbspace($data[7]));
      $jgdc_address->setRelationMaCode($this->trim_mbspace($data[8]));
      $jgdc_address->setNoPrefectureNameCode($this->trim_mbspace($data[9]));
      $jgdc_address->setPrefectureNameKana($this->trim_mbspace($data[10]));
      $jgdc_address->setCityNameKana($this->trim_mbspace($data[11]));
      $jgdc_address->setAreaNameKana($this->trim_mbspace($data[12]));
      $jgdc_address->setAddressKana($this->trim_mbspace($data[13]));
      $jgdc_address->setPrefectureNameKanaLength($this->trim_mbspace($data[14]));
      $jgdc_address->setCityNameKanaLength($this->trim_mbspace($data[15]));
      $jgdc_address->setAreaNameKanaLength($this->trim_mbspace($data[16]));
      $jgdc_address->setAddressKanaLength($this->trim_mbspace($data[17]));
      $jgdc_address->setTotalKanaLength($this->trim_mbspace($data[18]));
      $jgdc_address->setPrefectureName($this->trim_mbspace($data[19]));
      $jgdc_address->setCityName($this->trim_mbspace($data[20]));
      $jgdc_address->setAreaName($this->trim_mbspace($data[21]));
      $jgdc_address->setAddress($this->trim_mbspace($data[22]));
      $jgdc_address->setPrefectureNameLength($this->trim_mbspace($data[23]));
      $jgdc_address->setCityNameLength($this->trim_mbspace($data[24]));
      $jgdc_address->setAreaNameLength($this->trim_mbspace($data[25]));
      $jgdc_address->setAddressLength($this->trim_mbspace($data[26]));
      $jgdc_address->setTotalLength($this->trim_mbspace($data[27]));
      $jgdc_address->setJistype_prefectureName($this->trim_mbspace($data[28]));
      $jgdc_address->setJistypeCityName1($this->trim_mbspace($data[29]));
      $jgdc_address->setJistypeCityName2($this->trim_mbspace($data[30]));
      $jgdc_address->setJistypeAreaName1($this->trim_mbspace($data[31]));
      $jgdc_address->setJistypeAreaName2($this->trim_mbspace($data[32]));
      $jgdc_address->setJistypeAddress1($this->trim_mbspace($data[33]));
      $jgdc_address->setJistypeAddress2($this->trim_mbspace($data[34]));
      $jgdc_address->setAddressFlag1($this->trim_mbspace($data[35]));
      $jgdc_address->setAddressFlag2($this->trim_mbspace($data[36]));
      $jgdc_address->setNicknameType($this->trim_mbspace($data[37]));
      $jgdc_address->setNicknameFlag($this->trim_mbspace($data[38]));
      $jgdc_address->setOpenYearMonth($this->trim_mbspace($data[39]));
      $jgdc_address->setCloseYearMonth($this->trim_mbspace($data[40]));
      $jgdc_address->setNewMaCodeYearMonth($this->trim_mbspace($data[41]));
      $jgdc_address->setRenamedYearMonth($this->trim_mbspace($data[42]));
      $jgdc_address->setRenumberdZipCodeYearMonth($this->trim_mbspace($data[43]));
      $jgdc_address->setChangedBarcodeYearMonth($this->trim_mbspace($data[44]));
      $jgdc_address->setChangedRelationYearMonth($this->trim_mbspace($data[45]));
      $jgdc_address->setChangedNicknameFlagYearMonth($this->trim_mbspace($data[46]));
      $jgdc_address->setChangedAddressYearMonth($this->trim_mbspace($data[47]));
      $jgdc_address->setOldZipCode($this->trim_mbspace($data[48]));
      $jgdc_address->setUnnecessaryField($this->trim_mbspace($data[49]));
      $jgdc_address->setEditCode($this->trim_mbspace($data[50]));

      $jgdc_address->save();
      unset($jgdc_address);

      if (0 === $i % 100) $this->log(sprintf('%s records preceed.', $i));
      $i ++;
    }
    $reader->close();

    $this->logSection('jgdc', 'all process finish.');
 }

  public function trim_mbspace($string)
  {
    $string = trim($string);
    $string = trim($string, '　');
    return $string;
  }
}
