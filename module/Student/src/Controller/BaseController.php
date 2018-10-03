<?php

namespace Student\Controller;

use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;

class BaseController extends AbstractController
{
    protected $eventIdentifier = __CLASS__;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function notFoundAction()
    {
        $event      = $this->getEvent();
        $routeMatch = $event->getRouteMatch();
        $routeMatch->setParam('action', 'not-found');

        $helper = $this->plugin('createHttpNotFoundModel');
        return $helper($event->getResponse());
    }

    public function onDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if (! $routeMatch) {
            /**
             * @todo Determine requirements for when route match is missing.
             *       Potentially allow pulling directly from request metadata?
             */
            throw new Exception\DomainException('Missing route matches; unsure how to retrieve action');
        }

        $this->layout()->setTemplate('layout/student');
        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);
        
        if (! method_exists($this, $method)) {
            $method = 'notFoundAction';
        }

        if($action != 'login')
        {
            $auth = new AuthenticationService();
            if(!$auth->hasIdentity())
            {
                $this->redirect()->toRoute("student_users", ['action' => 'login']);
            }
        }   

        $actionResponse = $this->$method();

        $e->setResult($actionResponse);

        return $actionResponse;
    }
}