<?php
define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat/');
define('CHAT_SERVER_ID', '4f9b8bf6-2349-44b0-9854-8bab2c105da9'); # Ihre Collection ID

spl_autoload_register(function($class) {
include str_replace('\\', '/', $class) . '.php';
});
?>
