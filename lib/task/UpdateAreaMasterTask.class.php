<?php

class UpdateAreaMasterTask extends sfBaseTask
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
      // add your own options here
    ));

    $this->namespace        = 'jgdc';
    $this->name             = 'update-area';
    $this->briefDescription = 'JgdcAddressMasterを読み込んでAreaMasterにインサート or アップデートします';
    $this->detailedDescription = <<<EOF
The [jgdc:update-area|INFO] task load file to jgdc_address_master.

EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $this->logSection('jgdc', 'process start.');

    $i = 1;
    foreach (JgdcAddressMasterTable::getAllArea () as $address) {
      $area = JgdcAreaMasterTable::getInstance()->findOneByCode($address->getNewMaCode());
      if (false === $area) {
        $area = new JgdcAreaMaster;
      }

      $area->setCode($address->getNewMaCode());
      $area->setJgdcPrefectureMasterCode($address->getPrefectureCode());
      $area->setJgdcCityMasterCode($address->getCityCode());
      $area->setZipCode($address->getZipCode());
      $area->setName($address->getAreaName());
      $area->setAddress($address->getAddress());

      $area->save();
      unset($area);

      if (0 === $i % 100) $this->log(sprintf('%s records preceed.', $i));
      $i ++;
    }

    $this->logSection('jgdc', sprintf('all process finish. total %d records.', $i));
  }
}
