<?php

namespace Application\Controller;

use Application\Model\InternshipsTable;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;

class InternshipsController extends BaseController 
{
    private $table;

    public function __construct(InternshipsTable $table)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
        return new ViewModel(['internships' => $this->table->fetchAllWithEmployer(),]);
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