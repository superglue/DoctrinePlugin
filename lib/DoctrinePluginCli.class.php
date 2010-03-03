<?php
/**
* Wrapper for Doctrine_Cli to make up for the fact that the default text color should not be set
*/
class DoctrinePluginCli extends Doctrine_Cli
{
  public function notify($notification = null, $style = null)
  {
    parent::notify($notification, $style);
  }
}
