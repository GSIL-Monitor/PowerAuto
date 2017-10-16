<?php
namespace PowerAuto;
$m=isset($_GET['m'])?strtolower($_GET['m']):'Index';

$a=isset($_GET['a'])?strtolower($_GET['a']):'index';

require './action/' . $m . 'Action.php';

