<?php

  use DI\ContainerBuilder;
  use Slim\App;

  require_once __DIR__ . '/../vendor/autoload.php';

  /**
   * @var ContainerBuilder $containerBuilder - The application container builder
   */
  $containerBuilder = new ContainerBuilder();

  // Add DI container definitions
  $containerBuilder->addDefinitions(__DIR__ . '/container.php');

  // Create DI container instance
  $container = $containerBuilder->build();

  // Create Slim App instance
  $app = $container->get(App::class);

  if (!$container->get('settings')['debug']) {
    /**
     * To generate the route cache data, you need to set the file to one that does not exist in a writable directory.
     * After the file is generated on first run, only read permissions for the file are required.
     *
     * You may need to generate this file in a development environment and comitting it to your project before deploying
     * if you don't have write permissions for the directory where the cache file resides on the server it is being deployed to
     */
    $routeCollector = $app->getRouteCollector();
    $routeCollector->setCacheFile(__DIR__ . '/Cache/RoauteCaching.php');
  }


  // Register routes
  (require __DIR__ . '/routes.php')($app);

  // Register middleware
  (require __DIR__ . '/middleware.php')($app);

  // Start PHP session
  session_start();

  return $app;