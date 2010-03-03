<?php

class DoctrinePluginConfiguration
{
  static protected 
    $doctrineLoaded = false,
    $paths = array(
      'extensions' => '/lib/doctrine/extensions',
      'fixtures' => '/data/doctrine/fixtures',
      'migrations' => '/data/doctrine/migrations',
      'sql' => '/data/doctrine/sql',
      'schema' => '/config/doctrine/schema',
      'models' => '/models/doctrine',
    );
  
  public function preExecute()
  {
    print 'Plugin preExecute()';
  }
  
  public function postExecute()
  {
    print 'Plugin postExecute()';
  }
  
  public static function preConfig()
  {
    require_once(dirname(__FILE__) . '/../lib/vendor/doctrine/lib/Doctrine/Doctrine.php');
    spl_autoload_register(array('Doctrine', 'autoload'));
  }
    
  public static function init()
  {
    self::registerDoctrine();
    sgAutoloader::loadPaths(array(self::getPath('models')), '.class.php');
  }
  
  public static function registerDoctrine()
  {
    if (self::$doctrineLoaded)
    {
      return;
    }
    
    $settings = sgConfiguration::get('settings', 'doctrine');
    Doctrine_Core::setExtensionsPath(self::getPath('extensions'));
    Doctrine_Core::setModelsDirectory(self::getPath('models'));
    $manager = Doctrine_Manager::getInstance();
    $manager->openConnection($settings['dsn'], 'doctrine');
    if (isset($settings['attributes']))
    {
      foreach ($settings['attributes'] as $attribute => $value)
      {
        $manager->setAttribute($attribute, $value);
      }
    }
    self::$doctrineLoaded = true;
  }
  
  public static function install()
  {
    sgToolkit::mkdir(self::getPath('fixtures'));
    sgToolkit::mkdir(self::getPath('migrations'));
    sgToolkit::mkdir(self::getPath('sql'));
    sgToolkit::mkdir(self::getPath('schema'));
    sgToolkit::mkdir(self::getPath('models'));
    sgToolkit::mkdir(self::getPath('extensions'));
  }
  
  public static function uninstall()
  {
    $root = sgContext::getInstance()->getRootDir();
    sgToolkit::rmdir($root . '/config/doctrine');
    sgToolkit::rmdir($root . '/lib/doctrine');
    sgToolkit::rmdir($root . '/models/doctrine');
    sgToolkit::rmdir($root . '/data/doctrine');
  }
  
  public static function getPath($pathName)
  {
    if (isset(self::$paths[$pathName]))
    {
      return sgContext::getInstance()->getRootDir() . self::$paths[$pathName];
    }
    
    return false;
  }
}