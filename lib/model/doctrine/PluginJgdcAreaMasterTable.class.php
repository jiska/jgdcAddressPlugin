<?php

/**
 * PluginJgdcAreaMasterTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginJgdcAreaMasterTable extends Doctrine_Table
{
  /**
   * Add DQL order
   *
   * @param Doctrine_Query
   * @return Doctrine_Query
   */
  public function getOrderedList(Doctrine_Query $q)
  {
    return $q->addOrderBy('display_order asc')->execute();
  }
}
