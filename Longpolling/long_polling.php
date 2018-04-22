<?php
/** calling script for long polling tests */

require_once './RequestHandler.php' ;
require_once './RequestHandlerSingleton.php';

//$param1 = $argv[1];
//echo 'given param was: '. $param1 ."\n";
//echo 'returned JSON was: '. getJSON($param1) ."\n";

//mit singleton
$rh = RequestHandlerSingleton::getInstance();
$rh->handleRequest();

//$rh = new RequestHandler();
//$rh->handleRequest();
?>