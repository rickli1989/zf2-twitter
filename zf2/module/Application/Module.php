<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Twitter;
use Application\Model\TwitterTable;
use Application\Model\User;
use Application\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        date_default_timezone_set("UTC");
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Application\Model\TwitterTable' =>  function($sm) {
                     $tableGateway = $sm->get('TwitterTableGateway');
                     $table = new TwitterTable($tableGateway);
                     return $table;
                 },
                 'TwitterTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Twitter());
                     return new TableGateway('twitter', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Application\Model\UserTable' =>  function($sm) {
                     $tableGateway = $sm->get('UserTableGateway');
                     $table = new UserTable($tableGateway);
                     return $table;
                 },
                 'UserTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new User());
                     return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
}
