<?php

namespace Application\Controller;

use Application\Model\InternshipsTable;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Application\Form\InternshipForm;

class InternshipsController extends BaseController 
{
    private $table;

    public function __construct(InternshipsTable $table)
    {
        parent::__construct();
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
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('internships');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteInternship($id);
            }

            return $this->redirect()->toRoute('internships');
        }

        return [
            'id'    => $id,
            'internship' => $this->table->getInternship($id),
        ];
    }
}