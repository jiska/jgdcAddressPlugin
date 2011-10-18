<?php

class UpdatePrefectureMasterTask extends sfBaseTask
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
    $this->name             = 'update-prefecture';
    $this->briefDescription = 'JgdcAddressMasterを読み込んでPrefectureMasterにインサート or アップデートします';
    $this->detailedDescription = <<<EOF
The [jgdc:update-prefecture|INFO] task load file to jgdc_address_master.

EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $this->logSection('jgdc', 'process start.');

    $i = 1;
    foreach (JgdcAddressMasterTable::getAllCities() as $address) {
      $prefecture_code = $address->getPrefectureCode();
      $prefecture = JgdcPrefectureMasterTable::getInstance()->findOneByCode($prefecture_code);
      if (false === $prefecture) {
        $prefecture = new JgdcPrefectureMaster;
      }

      $prefecture->setCode($prefecture_code);
      $prefecture->setName($address->getPrefectureName());

      $prefecture->save();
      unset($prefecture);

      if (0 === $i % 100) $this->log(sprintf('%s records preceed.', $i));
      $i ++;
    }

    $this->logSection('jgdc', sprintf('all process finish. total %d records.', $i));
  }
}
