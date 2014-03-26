<?php 
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

 class UserTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
     	// echo "<pre>";
     	// print_r( $this->tableGateway);
     	// die();
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getUser($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function getUserByName($name)
     {

         $rowset = $this->tableGateway->select(array('name' => $name));
         $row = $rowset->current();
         return $row;
     }

     public function saveUser(User $user)
     {
         $data = array(
             'name' => $user->name
         );

         $id = (int) $user->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
             return $this->tableGateway->adapter->getDriver()->getConnection()->getLastGeneratedValue();
         } else {
             if ($this->getUser($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteUser($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>