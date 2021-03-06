<?php

namespace Employer\Controller;

use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Storage\Session;

class BaseController extends AbstractController
{
    protected $eventIdentifier = __CLASS__;
    protected $allowedActions;
    protected $currentUser;

    public function __construct()
    {
        $this->allowedActions = ['login'];
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

        $this->layout()->setTemplate('layout/employer');

        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);
        
        if (! method_exists($this, $method)) {
            $method = 'notFoundAction';
        }

        if(!in_array($action, $this->allowedActions)) {
            $auth = new AuthenticationService();
            $auth->setStorage(new Session('Employer'));

            $uuid = $routeMatch->getParam('uuid', 'none');
            if($action == 'edit' && $uuid != 'none') {
                $this->currentUser = "Employer";
            }
            else if(!$auth->hasIdentity())
            {
                $this->redirect()->toRoute("employer_users", ['action' => 'login']);
            }
            else
            {
                $this->currentUser = $auth->getIdentity();
            }
        }  

        $actionResponse = $this->$method();

        $e->setResult($actionResponse);
        $this->layout()->setVariable('currentUser', $this->currentUser);

        return $actionResponse;
    }
}