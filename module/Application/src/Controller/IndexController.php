<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function indexAction()
    {
        return new ViewModel(['students' => $this->table->fetchAll(),
        ]);
    }
}
