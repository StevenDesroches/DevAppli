<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;

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
        return new ViewModel();
    }

    public function loginPostAction()
    {
        $authAdapter = new AuthAdapter($this->db, 'users', 'email', 'password');
        $authAdapter->setIdentity($this->params()->fromPost('email'));
        $authAdapter->setCredential(md5($this->params()->fromPost('password')));
        
        $auth = new AuthenticationService();

        $result = $auth->authenticate($authAdapter); 
        $this->redirect()->toRoute("home", ['action' => 'index']);
    }
}
