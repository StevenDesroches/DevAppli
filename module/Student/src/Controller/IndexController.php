<?php

namespace Student\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
