<?php 
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

 class TwitterTable
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

     public function getTwitter($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveTwitter(Twitter $twitter)
     {
         $data = array(
             'text' => $twitter->text,
             'created_at'  => $twitter->created_at,
             'user_id' => $twitter->user_id
         );

         $id = (int) $twitter->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getTwitter($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteTwitter($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>