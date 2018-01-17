<?php
require_once("support.php");
require_once("tuna.php");
session_start();
$tuna = new fun_tuna();
$correspond = array(1=>31, 2=>28,3=>31,4=>30,5=>31,6=>30,7=>31,8=>31,9=>30,10=>31,11=>30,12=>31);
$corr_counter = array(1=>1,2=>2,3=>4,4=>7,5=>15,6=>0);
$date = getdate();
$month = $date['mon'];
$day = $date['mday'];

$this_month = $correspond[$month];
$table = "";
if(!isset($_SESSION['idarr'])){
    $_SESSION['idarr'] = array();
}


if(isset($_POST['submit'])){
    if($_POST['input'] != null){
        $in = trim($_POST['input']);
        $in = explode(",",$in);
        foreach($in as $key => $value){
            $arr = array("\"".$value."\"", $month, $day, 1);
            $tuna->insert($arr);
        }
    }
}
else if(isset($_POST['todo'])){
	//print table
    $table .= "<table border = '2'>";
    $table.="<th> Page Number </th> <th> Review Process </th>"; 
    //$table .= "<caption> Never Give Up! </caption>";
    $out = $tuna->getInfo($month,$day);
    $id_arr = array();
    foreach($out as $key=>$value){
        $table.="<tr>";
        $id = $value['id'];
		$count = $value['counter'];
        $row = "<td> $id </td> <td> $count </td>";
        $table.=$row;
        $table.="</tr>";
        $id_arr[$id] = $value['counter'];
    }
    $_SESSION['idarr'] = serialize($id_arr);
    $table.="</table><br>";
}
else if(isset($_POST['finish'])){
    //$key is id; $value is counter
    $id_arr = unserialize($_SESSION['idarr']);

    foreach($id_arr as $key=>$value){
        $t_day = $day;
        $t_month = $month;
        $t_day = $day + $corr_counter[$value];
        $t_month_day = $correspond[$month];
        if($t_day > $t_month_day && $month != 12){
            $t_day = $t_day - $t_month_day;
            $t_month = $month + 1;
        }else if($t_day > $t_month_day && $month == 12){
            $t_day = $t_day - $t_month_day;
            $t_month = 1;
        }
        $tuna->update($key,$t_month,$t_day,$value+1);
        if($value == 7){
            //if it is the last time
            $tuna->delete($key);
        }
    }
}else{
    
}
$body =<<<EOBODY
    <form action="" method="POST">
            <fieldset>
                <legend><em>Fight For Your Dreams</em></legend>
                Input Data(only input new knowledge)  <input type="txt" id="input" name="input" placeholder="1,2,3" > <br><br>
                <input type="reset" /> &nbsp;&nbsp;
                <input type="submit" name="submit" value="Add New Data"/> &nbsp;&nbsp;
                <input type="submit" name="todo" value="To Do List"/> &nbsp;&nbsp;
                <input type ='submit' name='finish' value='Mission Completed!'>
            </fieldset>
    </form>
    <br>
EOBODY;

echo generatePage($body.$table,"StudySmart");
?>