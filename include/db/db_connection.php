<?php

error_reporting(E_ALL);

class DB_connect {
     
     protected $connection;

     public function __construct() {
         $host = "host=ec2-34-235-198-25.compute-1.amazonaws.com";
         $dbname= "dbname=dda0hvp2hqanng";
         $port = "port=5432";
         $credentials = "user=gkdlabhmkypcbv password=05e0942493fcbfaf8e0479f03c3bc896cbbf9a4813f270d6a75e900fdedd6638"; 
         $this->connection = pg_connect("$host $port $dbname $credentials");
         
     }
     public function select($table, $columns, $product_id) {
            
        $query = "SELECT $columns FROM $table where product_id = '$product_id'";
        $result = pg_query($this->connection, $query);
        return pg_fetch_all($result);
    }

    public function insert($table, $columns, $values) {
        if (is_array($columns)) {
            $columns = implode(", ", $columns);
        }
        if (is_array($values)) {
            $values = implode(", ", $values);
        }
        
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $result = pg_query($this->connection , $query); 
    }

    public function update($table, $data, $product_id) {
        $query_data = array();
        foreach($data as $column => $value) {
            $query_data[] = "$column = " . (is_string($value) ? "'".$value."'" : $value);
        }
        $query = "UPDATE $table SET ".  implode(", ", $query_data) . " WHERE product_id='$product_id'";
        $result = pg_query($this->connection, $query);
    }
 
     public function selectAll($table) {
            
        $query = "SELECT * FROM $table";
        $result = pg_query($this->connection, $query);
        return pg_fetch_all($result);
    }

}