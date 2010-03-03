<?php

class DoctrineTask extends sgTask
{
  public static function configure()
  {
    self::$tasks = array(
      'doctrine' => array(
        'cli' => array('description' => 'prefix for Doctrine CLI'),
      ),
    );
  }
  
  public function executeDoctrineCli($arguments = array(), $options = array())
  {
    try
    {
      DoctrinePluginConfiguration::init();
    }
    catch (Exception $e)
    {
      sgCLI::error($e->getMessage());
      return false;
    }
    
    // spl_autoload_register(array('Doctrine', 'modelsAutoload'));
    spl_autoload_register(array('Doctrine', 'extensionsAutoload'));
    $settings = sgConfiguration::get('settings', 'doctrine');
    $settings['generate_models_options']['suffix'] = '.class.php';
    
    $config = array(
        'data_fixtures_path'      => DoctrinePluginConfiguration::getPath('fixtures'),
        'models_path'             => DoctrinePluginConfiguration::getPath('models'),
        'migrations_path'         => DoctrinePluginConfiguration::getPath('mogrations'),
        'sql_path'                => DoctrinePluginConfiguration::getPath('sql'),
        'yaml_schema_path'        => DoctrinePluginConfiguration::getPath('schema'),
        'generate_models_options' => $settings['generate_models_options'],
    );
    
    $cg = new Console_Getopt();
    $params = $cg->readPHPArgv();
    $params[0] .= ' ' . $params[1];
    unset($params[1]);
    $params = array_merge($params);
    $cli = new DoctrinePluginCli($config);
    $cli->run($params);
  }
}