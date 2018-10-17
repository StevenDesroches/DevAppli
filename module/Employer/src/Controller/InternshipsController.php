<?php

namespace Application\Controller;

use Application\Model\InternshipsTable;
use Application\Model\EmployersTable;
use Application\Form\InternshipsForm;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;

class InternshipsController extends BaseController 
{
    private $table;
    private $employers;

    public function __construct(InternshipsTable $table, EmployersTable $employers)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
        return new ViewModel(['internships' => $this->table->fetchAllWithEmployer(),]);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $employer = $employers->getFromUid($this->params()->fromRoute('uid', 0));
        if ($request->isPost()) {

        } else {
            $form = new InternshipForm();
            $employer = 
            $form->get('submit')->setAttribute('value', 'Add');
            $viewData = ['form' => $form, 'employer' => $employer];
            return $viewData;
        }
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