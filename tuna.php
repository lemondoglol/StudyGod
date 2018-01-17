<?php
class fun_tuna{

    public function insert($arr){
        $host = "localhost";
        $user = "dbuser";
        $password = "1";
        $database = "studyGod";
        $tablename = "info";
        $signal = 5;
        $db_connection = new mysqli($host, $user, $password, $database);
        if($db_connection->connect_error){
            die($db_connection->connect_error);
        }
        $tuna = implode(",", $arr);
        $query = "insert into $tablename values($tuna)";
        $result = $db_connection->query($query);
        if(!$result){
            die("Insertion Error: ".$db_connection->error);
        }else{
            $db_connection->close();
        }
    }
    
    public function update($id,$month,$day,$counter){
        $host = "localhost";
        $user = "dbuser";
        $password = "1";
        $database = "studyGod";
        $tablename = "info";
        $db_connection = new mysqli($host, $user, $password, $database);
        if($db_connection->connect_error){
            die($db_connection->connect_error);
        }
		$temp = "\"".$id."\"";
        $query = "update $tablename set month=$month,day=$day,counter=$counter where id=$temp ";
        $result = $db_connection->query($query);
        if(!$result){
            die("Insertion Error: ".$db_connection->error);
        }else{
            $db_connection->close();
        }
    }
    public function delete($id){
        $host = "localhost";
        $user = "dbuser";
        $password = "1";
        $database = "studyGod";
        $tablename = "info";
        $db_connection = new mysqli($host, $user, $password, $database);
        if($db_connection->connect_error){
            die($db_connection->connect_error);
        }
        $query = "delete from $tablename where id=$id ";
        $result = $db_connection->query($query);
        if(!$result){
            die("Insertion Error: ".$db_connection->error);
        }else{
            $db_connection->close();
        }
    }

public function getInfo($mon,$day){
        $host = "localhost";
        $user = "dbuser";
        $password = "1";
        $database = "studyGod";
        $tablename = "info";
        $signal = 5;
        $db_connection = new mysqli($host, $user, $password, $database);
        if($db_connection->connect_error){
            die($db_connection->connect_error);
        }
        $query = "select * from $tablename where month = $mon and day = $day ORDER BY counter,id ";
        $result = $db_connection->query($query);
        $lemon = array();
        if(!$result){
            die($db_connection->error);
        }else{
            $num_rows = $result->num_rows;
            $index = 0;
            while($index < $num_rows){
                $result->data_seek($num_rows);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $lemon[$index] = $row;
                $index = $index + 1;
            }
            $db_connection->close();
        }
        return $lemon;
}
    
} 
?>