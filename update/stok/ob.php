<?php
ob_start( ) ;
echo 'Test Output' . '<br / >' ;
$buff = ob_get_contents( ) ;
echo $buff ;
?>