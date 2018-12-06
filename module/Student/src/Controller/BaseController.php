<?php

namespace Student\Controller;

use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class BaseController extends AbstractController
{
    protected $eventIdentifier = __CLASS__;
    protected $allowedActions;
    protected $currentUser;

    public function __construct()
    {
        $this->allowedActions = ['login', 'edit'];
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

        if(!in_array($action, $this->allowedActions))
        {
            $auth = new AuthenticationService();
            $auth->setStorage(new Session('Student'));
            if(!$auth->hasIdentity())
            {
                $this->redirect()->toRoute("student_users", ['action' => 'login']);
            }
            else
            {
                $this->currentUser = $auth->getIdentity();
            }
        }   

        $actionResponse = $this->$method();
        $this->layout()->setVariable('currentUser', $this->currentUser);

        $e->setResult($actionResponse);

        return $actionResponse;
    }
}