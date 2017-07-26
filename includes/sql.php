<?php

require("sql_init.php");


class DB{
    public function __construct($conn){
        if(empty($conn)) throw new Exception("no connection to sql server", 1);
        $this->conn = $conn;
        $this->table = "contestant";
    }
    
    //return amout of rows in table with column value as value
    public function numberOf($table, $column, $value){
        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` = :".$column."";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array( $column => $value));
        $result = $stmt->fetchAll();
        return count($result);
    }
    
    //return the hash of first row in table with column value as value
    public function select($table, $column, $value){
        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` = :".$column."";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array($column => $value));
        $stmt = $stmt->fetchAll();
        
        if (count($stmt)==0){
            echo("nothing");
            return 0;
        }
        foreach($stmt as $row){
            return $row;
        }
    }
    
    public function insert($table, $columns, $values){
        if(count($columns)!=count($values)) return false;
        $col = "(";
        $val = "('";
        for ($i=0;$i<count($columns);$i++){
            if($i!=0){
                $col .=",";
                $val .="','";
            }
            $col .= $columns[$i];
            $val .= $values[$i];
        }
        $col .= ")";
        $val .= "')";
        
        $sql = "INSERT INTO `".$table."` ".$col." VALUES".$val;
        
        echo "<br>".$sql."<br>";
        
        return $this->conn->query($sql);
    }
    
    //update row with corresponding has in table with data
    //data is an array such that [key1 => value1, key2 =>value2, etc]
    public function update($table, $hash, $data){
        $sql = "UPDATE `".$table."` SET ";
        
        $i=0;
        foreach($data as $key => $value){
            if($i!=0) $sql .= " , "
            $sql .= $key ." = :".$key;
        }
        $sql .= " WHERE `hash = :hash";
        
        echo $sql;
    }
    
}

$db = new DB($conn);

?>
