<?php

namespace Student\Controller;

use Zend\View\Model\ViewModel;
use Student\Model\FileTable;
use Student\Form\FileForm;
use Student\Model\StudentsTable;
use Student\Model\File;


class FilesController extends BaseController
{

    private $table;
    private $studentsTable;
    
    public function __construct(FileTable $table, StudentsTable $studentsTable)
    {
        parent::__construct();
        $this->table = $table;
        $this->studentsTable = $studentsTable;
    }

    public function indexAction()
    { 
        $form = new FileForm(); 
        $form->get('submit')->setValue('Add'); 
        $form->get('student_id')->setValue($this->currentUser); 
        $request = $this->getRequest(); 
        if ($request->isPost()) { 
           $file = new File(); 
           $form->setInputFilter($file->getInputFilter()); 
           $post = array_merge_recursive( 
              $request->getPost()->toArray(), 
              $request->getFiles()->toArray() 
           );  
           $form->setData($post);   
           if ($form->isValid()) { 
              $file->exchangeArray($form->getData());  
              $this->table->saveFile($file);  
              
 
              return $this->redirect()->toRoute('student_home', ['action' => 'index']);
 
           } 
        }  
        return array('form' => $form); 
     }
    }
