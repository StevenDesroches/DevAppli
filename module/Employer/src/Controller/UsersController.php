<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Employer\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Employer\Adapter\CredentialAdapter;

class UsersController extends BaseController
{
    public function __construct($db)
    {
        parent::__construct($db);
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

            $result = $auth->authenticate($authAdapter); 
            $this->redirect()->toRoute("home", ['action' => 'index']);
        }
        
    }
}
