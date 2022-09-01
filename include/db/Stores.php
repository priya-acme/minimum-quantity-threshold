<?php

include_once 'db_connection.php';

class Stores extends DB_connect {


    protected $_name = "total_sales";
    protected $_primary = "id";
    public function __construct() {
        parent::__construct();
    }
    
    public function add($data) {
       foreach($data as $column => $value) {
            if ($column != $this->_primary) {
                $columns[] = $column;
                if (is_string($value)) {
                    $value = "'".$value."'";
                }
                $values[] = $value;
            }
        }
        return $this->insert($this->_name, $columns, $values);
    }
    
    public function updateProductData($product_id, $data) {
        return $this->update($this->_name, $data,$product_id);
    }

    
    public function getProductData($product_id) {
        return $this->select($this->_name, '*',$product_id);
    }

    public function getAllData(){
        return $this->selectAll($this->_name);
    }


}

?>
