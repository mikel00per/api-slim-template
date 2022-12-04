<?php
/**
 * This class has been auto-generated by PHP-DI.
 */
class CompiledContainer extends DI\CompiledContainer{
    const METHOD_MAPPING = array (
  'Microservices\\Http\\MicroserviceSlimInterface' => 'get1',
  'Psr\\Http\\Message\\ResponseFactoryInterface' => 'get2',
  'Psr\\Http\\Message\\ServerRequestFactoryInterface' => 'get3',
  'Psr\\Http\\Message\\StreamFactoryInterface' => 'get4',
  'Psr\\Http\\Message\\UploadedFileFactoryInterface' => 'get5',
  'Psr\\Http\\Message\\UriFactoryInterface' => 'get6',
  'Psr\\Log\\LoggerInterface' => 'get7',
  'Slim\\Middleware\\ErrorMiddleware' => 'get8',
  'settings' => 'get9',
  'subEntry1' => 'get10',
  'subEntry2' => 'get11',
  'subEntry3' => 'get12',
  'subEntry4' => 'get13',
  'subEntry5' => 'get14',
  'subEntry6' => 'get15',
  'subEntry7' => 'get16',
  'ContainerSettings\\SettingsInterface' => 'get17',
);

    protected function get1()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        $settings = $container->get(\ContainerSettings\SettingsInterface::class);

        $microservice = new \Microservices\Http\MicroserviceSlim($container);

        // Register routes
        (require $settings->get('router.definition'))($microservice);

        // Register middleware
        (require $settings->get('middlewares.definition'))($microservice);

        return $microservice;
    }, 'Microservices\\Http\\MicroserviceSlimInterface');
    }

    protected function get2()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        return $container->get(\Nyholm\Psr7\Factory\Psr17Factory::class);
    }, 'Psr\\Http\\Message\\ResponseFactoryInterface');
    }

    protected function get3()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        return $container->get(\Nyholm\Psr7\Factory\Psr17Factory::class);
    }, 'Psr\\Http\\Message\\ServerRequestFactoryInterface');
    }

    protected function get4()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        return $container->get(\Nyholm\Psr7\Factory\Psr17Factory::class);
    }, 'Psr\\Http\\Message\\StreamFactoryInterface');
    }

    protected function get5()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        return $container->get(\Nyholm\Psr7\Factory\Psr17Factory::class);
    }, 'Psr\\Http\\Message\\UploadedFileFactoryInterface');
    }

    protected function get6()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        return $container->get(\Nyholm\Psr7\Factory\Psr17Factory::class);
    }, 'Psr\\Http\\Message\\UriFactoryInterface');
    }

    protected function get7()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        $settings = $container->get(\ContainerSettings\SettingsInterface::class);

        $name = $settings->get('logger.name');
        $path = $settings->get('logger.path');
        $fileName = $settings->get('logger.filename');
        $level = $settings->get('logger.level');

        return (new \Microservices\Loggers\LoggerFactory($path, $level))
            ->addProcessor(new \Monolog\Processor\UidProcessor())
            ->addFileHandler($fileName, $level)
            //->addConsoleHandler($level)
            ->createLogger($name);
    }, 'Psr\\Log\\LoggerInterface');
    }

    protected function get8()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container) {
        $settings = $container->get(\ContainerSettings\SettingsInterface::class);
        $microservice = $container->get(\Microservices\Http\MicroserviceSlimInterface::class);
        $logger = $container->get(\Psr\Log\LoggerInterface::class);

        $errorMiddleware = new \Slim\Middleware\ErrorMiddleware(
            $microservice->getCallableResolver(),
            $microservice->getResponseFactory(),
            $settings->get('error_middleware.display_details'),
            $settings->get('error_middleware.log_errors'),
            $settings->get('error_middleware.log_details'),
            $logger
        );

        $httpErrorHandler = $container->get(\Microservices\Http\Handlers\HttpErrorHandler::class);

        $errorMiddleware->setDefaultErrorHandler($httpErrorHandler);

        return $errorMiddleware;
    }, 'Slim\\Middleware\\ErrorMiddleware');
    }

    protected function get10()
    {
        return [
            'name' => 'slim-template',
            'path' => '/code/tmp/logs',
            'filename' => 'microservice.log',
            'level' => 100,
            'file_permission' => 509,
        ];
    }

    protected function get11()
    {
        return [
            'display_details' => true,
            'log_errors' => true,
            'log_details' => true,
        ];
    }

    protected function get13()
    {
        return [
            'enabled' => true,
            'path' => '/code/tmp/cache/',
        ];
    }

    protected function get12()
    {
        return [
            'definitions' => '/code/config/container.php',
            'cache' => $this->get13(),
        ];
    }

    protected function get14()
    {
        return [
            'definition' => '/code/config/middlewares.php',
        ];
    }

    protected function get16()
    {
        return [
            'enabled' => true,
            'path' => '/code/tmp/cache/routes.php',
        ];
    }

    protected function get15()
    {
        return [
            'definition' => '/code/config/routes.php',
            'cache' => $this->get16(),
        ];
    }

    protected function get9()
    {
        return [
            'root' => '/code',
            'config' => '/code/config/',
            'tmp' => '/code/tmp/',
            'cache' => '/code/tmp/cache/',
            'src' => '/code/src/',
            'tests' => '/code/tests/',
            'environment' => 'development',
            'microservice_name' => 'Microservice',
            'microservice_version' => '0.1',
            'logger' => $this->get10(),
            'error_middleware' => $this->get11(),
            'container' => $this->get12(),
            'middlewares' => $this->get14(),
            'router' => $this->get15(),
        ];
    }

    protected function get17()
    {
        return $this->resolveFactory(static function (\Psr\Container\ContainerInterface $container): \ContainerSettings\Settings {
            return new \ContainerSettings\Settings($container->get('settings'));
        }, 'ContainerSettings\\SettingsInterface');
    }

}
