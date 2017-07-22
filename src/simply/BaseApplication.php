<?php

namespace Simply;

use DI\ContainerBuilder;
use Simply\Exception\Exception;

/**
 * Class BaseApplication
 * @package Simply
 */
abstract class BaseApplication {

    protected $app;

    /**
     * BaseApplication constructor.
     * @param array $kernel
     */
    public function __construct(array $kernel = []) {
        $this->setContainer($kernel);
        $this->setErrorHandler($this->app->get('Config')->debug);
    }

    /**
     * define the dependency injection container
     * @param array $kernel
     */
    private function setContainer(array $kernel = []) : void {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($kernel);
        $container = $builder->build();
        $container->set('App', $container);
        $this->app = $container->get('App');
    }

    private function setErrorHandler(bool $debug): void {
        error_reporting(E_ALL);

        Exception::setTypeOfDebug($debug);
        set_error_handler('\Simply\Error\Error::errorHandler');
        set_exception_handler('\Simply\Exception\Exception::exceptionHandler');
    }

    public abstract function run(): void;

}
