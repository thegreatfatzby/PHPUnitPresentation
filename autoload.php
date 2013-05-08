<?php 

spl_autoload_register(function($className) {
	require_once(str_replace(array('\\', '_'), '/', ltrim($className, '\\')) . '.php');
});