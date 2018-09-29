<?php

namespace Application\Controller;

class EmployersControler extends BaseController
{
 
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }
    public function deleteAction()
    {

    }
    
}