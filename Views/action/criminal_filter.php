<?php

require(get_include_path()."\Projects\aiub project\Controllers\CriminalController.php");

if(isset($_GET["key"]) && isset($_GET["value"]))
{
    $key = $_GET["key"];
    $value = $_GET["value"];
    $criminal_control = new CriminalController();
    $json_criminals = $criminal_control->getCriminalsBy($key , $value);
    echo $json_criminals;

}



 ?>
