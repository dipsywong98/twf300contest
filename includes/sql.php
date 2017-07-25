<?php

require("sql_init.php");


class DB{
    public function __construct($conn){
        if(empty($conn)) throw new Exception("no connection to sql server", 1);
        $this->conn = $conn;
        $this->table = "contestant";
    }
    
    public function numberOf($table, $column, $value){
        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` = '".$value."'";
        $result = $this->conn->query($sql);
        try{
            return $result->num_rows;
        }
        catch(Exception $e){
            return 0;
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
    
    public function select($table, $index = -1, $param=""){
        $rows = "";
        
        if($param){
            $sql = "SELECT * FROM `".$table."`";
            $result = $this->conn->query($sql);
        }
        else{
            $sql = "SELECT * FROM `".$table."` WHERE ".$param;
            $result = $this->conn->query($sql);
        }
        
        if($index == -1)
            return $result;
        else{
            $i = 0;
            while($row = $result->fetch_assoc()) {
                if($i++==$index) return $row;
            }
        }
        
//        $rows = array();
//        
//        $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$table."'";
//        $column_rows = $this->conn->query($sql);
//        $columns = array();
//        while($row = $column_rows->fetch_assoc()) {
//            array_push($columns,$row["COLUMN_NAME"]);
//        }
//
//        for($i=0;$i<count($columns);$i++){
//            echo $columns[$i].",";
//        }
    }
}

$db = new DB($conn);

$db->select("usr");

/**
* return number of row with column as this value in the table
*/
function numberOf($conn, $table, $column, $value){
    $sql = "SELECT * FROM `".$table."` WHERE `".$column."` = '".$value."'";
    return $conn->query($sql)->num_rows;
}
?>