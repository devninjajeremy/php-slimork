<?php
define('BASE_ROOT', dirname(__FILE__));
define('VENDOR_ROOT', BASE_ROOT.'/vendor');
define('CONFIG_ROOT', BASE_ROOT.'/config');
define('RESOURCES_ROOT', BASE_ROOT.'/resources');
define('STORAGE_ROOT', BASE_ROOT.'/storage');
define('APP_ROOT', BASE_ROOT.'/app');

// Import
use Illuminate\Database\Capsule\Manager as Capsule;
use Slimork\Foundation\App;

// Config
$app    = new App();
$config = $app->getContainer()->get('settings');

// Initial
date_default_timezone_set($config['app']['timezone']);

// Database
$capsule = new Capsule;

foreach($config['database'] as $name => $database) {
    $capsule->addConnection($database, $name);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Return
return [
    'paths' => [
        'migrations' => BASE_ROOT.'/database/migrations',
        'seeds'      => BASE_ROOT.'/database/seeds'
    ],
    'migration_base_class' => Simork\Contracts\Migration::class,
    'environments' => [
        'default_migration_table' => $config['database']['default']['prefix'].$config['database']['migration']['table'],
        'default_database' => 'default',
        'default' => [
            'connection'   => $capsule->getConnection()->getPdo(),
            'name'         => $config['database']['default']['database'],
            'table_prefix' => $config['database']['default']['prefix']
        ]
    ],
];
