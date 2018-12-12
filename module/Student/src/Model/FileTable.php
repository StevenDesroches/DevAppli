<?php
namespace Student\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Student\Model\File;

class FileTable {

    protected $tableGateway; 

   public function __construct(TableGatewayInterface $tableGateway) { 

      $this->tableGateway = $tableGateway; 
   }  

   public function fetchAll() { 
      $resultSet = $this->tableGateway->select(); 
      return $resultSet; 
   }  
   public function saveFile(File $file) { 
    $data = array ( 
       'file'  => substr($file->file, strrpos($file->file, 'data'), strlen($file->file)), 
       'student_id' => $file->student_id 
    );  
    

       $this->tableGateway->insert($data);      
    
 } 
}
