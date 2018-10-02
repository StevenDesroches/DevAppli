<?php

namespace Student\Controller;

use Zend\View\Model\ViewModel;

class InternshipController extends BaseController
{
    protected $internshipTable;

    public function getInternshipTable()
    {
        if (!$this->internshipTable) {
            $sm = $this->getServiceLocator();
            $this->internshipTable = $sm->get('Student\Model\InternshipsTable');
        }
        return $this->internshipTable;
    }

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'internships' => $this->getInternshipTable()->fetchAll(),
        ));
    }

    public function detailsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('internship', array(
                'action' => 'details'
            ));
        }
        $internship = $this->getInternshipTable()->getInternship($id);

        return new ViewModel(array(
            'internship' => $internship,
        ));
    }
}
