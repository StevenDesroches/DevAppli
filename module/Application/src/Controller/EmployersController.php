<?php

namespace Application\Controller;

use Application\Model\Employer;
use Application\Model\EmployerTable;
use Application\Form\EmployerForm;
use Zend\View\Model\ViewModel;

class EmployersController extends BaseController
{

    private $table;

    public function __construct(EmployerTable $table)
    {
         $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel(['employers' => $this->table->fetchAll()]);
    }

    public function addAction()
    {
        $form = new EmployerForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if(! $request->isPost())
        {
            //$form = new EmployerForm();
            //$form->get('submit')->setAttribute('value', 'Add');
            $viewData = ['form' => $form];
            return $viewData;
        }

        $employer = new Employer();
        //$form->setInputFilter($employer->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $employer->exchangeArray($form->getData());
        $this->table->saveEmployer($employer);
        return $this->redirect()->toRoute('employers');
    }

    public function editAction()
    {
// a delete ou non?
    }
    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employers');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteEmployer($id);
            }

            return $this->redirect()->toRoute('employers');
        }

        return [
            'id'    => $id,
            'employer' => $this->table->getEmployer($id),
        ];
    }
    }
    
