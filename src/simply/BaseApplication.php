<?php

namespace Simply;

use DI\ContainerBuilder;

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

    public abstract function run(): void;

}
