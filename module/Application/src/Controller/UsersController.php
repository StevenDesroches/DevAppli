<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

class UsersController extends BaseController
{
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
        $authAdapter = new AuthAdapter($db, 'users', 'email', 'password');
        $authAdapter->setIdentity($this->params()->fromPost('email'));
        $authAdapter->setCredential($this->params()->fromPost('password'));
        $result = $authAdapter->authenticate();
        return new ViewModel();
    }
}
