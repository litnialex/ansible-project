<?php
$config['additional_message_headers']['X-Remote-Browser'] = $_SERVER['HTTP_USER_AGENT'];
$config['additional_message_headers']['X-Originating-IP'] = '[' . $_SERVER['REMOTE_ADDR'] .']';
$config['additional_message_headers']['X-RoundCube-Server'] = $_SERVER['SERVER_ADDR']; 
?>
