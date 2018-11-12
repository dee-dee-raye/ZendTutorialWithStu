<?php
namespace Student;

// Add these import statements;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\StudentTable::class => function($container) {
                    $tableGateway = $container->get(Model\StudentTableGateway::class);
                    return new Model\StudentTable($tableGateway);
                },
                Model\StudentTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Student());
                    return new TableGateway('student', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\StudentController::class => function($container) {
                    return new Controller\StudentController(
                        $container->get(Model\StudentTable::class)
                    );
                },
            ],
        ];
    }
}