<?php

namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class StudentTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getStudent($id)
    {
        $id = (int) $id;
        $rowset= $this->tableGateway->select(['admission_number' => $id]);
        $row = $rowset->current();
        if (!row){
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }
        return $row;
        }

        public function editStudent($student)
        {
            // $data = [
            //     'artist' => $album->artist,
            //     'title'  => $album->title,
            // ];
    
            // $id = (int) $album->id;
            $this->tableGateway->update($data, ['id' => $id]);
        }

        public function deleteStudent($id)
        {
            $this->tableGateway->delete(['id' => (int) $id]);
        }
    }
