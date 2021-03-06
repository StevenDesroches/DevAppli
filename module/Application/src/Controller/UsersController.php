<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Application\Adapter\CredentialAdapter;
use \Zend\Db\Adapter\Adapter as Database;
use Zend\Authentication\Storage\Session;

class UsersController extends BaseController
{  
    private $db;
    public function __construct(Database $db)
    {
        parent::__construct();
        $this->db = $db;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        if(!$this->getRequest()->isPost())
        {
            return new ViewModel();
        }
        else
        {
            $authAdapter = new CredentialAdapter($this->db, 'users', 'email', 'password');
            $authAdapter->setIdentity($this->params()->fromPost('email'));
            $authAdapter->setCredential(md5($this->params()->fromPost('password')));
            $authAdapter->setUserType(0);

            $auth = new AuthenticationService();
            $auth->setStorage(new Session('Application'));

            $result = $auth->authenticate($authAdapter);           
             $this->redirect()->toRoute("home", ['action' => 'index']);
        }
        
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService(); 
        $auth->setStorage(new Session('Application'));
        if($auth->hasIdentity()) 
        { 
            $auth->clearIdentity();
            return $this->redirect()->toRoute('users', ['action' => 'login']);
        } 
    }
}
