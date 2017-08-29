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
    public function select($table, $column, $value, $op="="){
        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` ".$op." :".$column."";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array($column => $value));
        $stmt = $stmt->fetchAll();
        
        if (count($stmt)==0){
            return 0;
        }
        foreach($stmt as $row){
            return $row;
        }
    }
    public function selectAll($table, $column, $value){
        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` = :".$column."";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array($column => $value));
        $stmt = $stmt->fetchAll();
        
        return $stmt;
    }
    public function selectParams($table, $param){
        $sql = "SELECT * FROM `".$table."` WHERE ";
        
        $i=0;
        foreach($param as $key => $value){
            if($i++!=0) $sql .= " AND ";
            $sql .= $key ." = :".$key;
        }
        
//        echo $sql;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($param);
        return $stmt->fetchAll();
    }
    
    //update row with corresponding has in table with data
    //data is an array such that [key1 => value1, key2 =>value2, etc]
    public function update($table, $hash, $data){
        $sql = "UPDATE `".$table."` SET ";
        
        $i=0;
        foreach($data as $key => $value){
            if($i++!=0) $sql .= " , ";
            $sql .= $key ." = :".$key;
        }
        $sql .= " WHERE `hash` = :hash";
        $data["hash"] = $hash;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
//        echo $sql;
    }
    
    public function updateParams($table, $param, $data){
        $sql = "UPDATE `".$table."` SET ";
        
        $i=0;
        foreach($data as $key => $value){
            if($i++!=0) $sql .= " , ";
            $sql .= $key ." = :".$key;
        }
        $sql .= " WHERE ";
        $i = 0;
        foreach($param as $key => $value){
            if($i++!=0) $sql .= " AND ";
            $sql .= $key ." = :".$key;
            $data[$key] = $value;
        }
//        echo $sql;
        print_r($data);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }
    
    //update row with corresponding has in table with data
    //data is an array such that [key1 => value1, key2 =>value2, etc]
    public function insert($table, $data){
        $sql = "INSERT INTO `".$table."` (";
        
        $col = "";
        $val = "";
        $i=0;
        foreach($data as $key => $value){
            if($i++!=0){
                $col .=",";
                $val .=",";
            }
            $col .= $key;
            $val .= ":".$key;
        }
        $sql .= $col.") VALUE (".$val.")";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }
    
    public function delete($table, $hash){
        $sql = "DELETE FROM ".$table." WHERE hash=:hash";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["hash"=>$hash]);
    }
    
    public function all($table){
        $sql = "SELECT * FROM ".$table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }
    
}

function removeNumberKey($ary){
    $new = [];
    $i=0;
    foreach($ary as $row){
        foreach($row as $key=>$value){
            if(!is_numeric($key)){
                $new[$i][$key] = $value;
            }
        }
        $i++;
    }
    return $new;
}

$db = new DB($conn);

?>
