<?php

namespace Employer\Controller;

use Employer\Model\InternshipsTable;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Employer\Form\InternshipsForm;

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
        $form = new InternshipsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if(! $request->isPost())
        {

            $viewData = ['form' => $form];
            return $viewData;
        }

        $internship = new Internship();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $internship->exchangeArray($form->getData());
        $internship->date_posted=date();
        $this->table->saveEmployer($internship);
        return $this->redirect()->toRoute('internships');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('internships', ['action' => 'index']);
        }

        try {
            $internship = $this->table->getInternship($id);
            var_dump($internship);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('internships', ['action' => 'index']);
        }

        $form = new InternshipsForm();
        $form->bind($internship);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($internship->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->editStudent($internship);

       
        return $this->redirect()->toRoute('internships', ['action' => 'index']);
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