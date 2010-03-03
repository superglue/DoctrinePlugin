<?php
return array(
  'doctrine' => array(
    'dsn' => 'sqlite://:memory:',
    'attributes' => array(
      Doctrine_Core::ATTR_MODEL_LOADING => Doctrine_Core::MODEL_LOADING_PEAR,
      Doctrine_Core::ATTR_USE_DQL_CALLBACKS => false,
      Doctrine_Core::ATTR_DEFAULT_TABLE_CHARSET => 'utf-8',
      Doctrine_Core::ATTR_DEFAULT_TABLE_COLLATE => 'utf8_general_ci',
    ),
    'generate_models_options' => array(
      'pearStyle' => true,
      'generateTableClasses' => true,
      'baseClassPrefix' => 'Base',
      'baseClassesDirectory' => 'Base',
    ),
  ),
);