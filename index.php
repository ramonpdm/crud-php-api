<?php

/**
 * PHP CRUD REST API - 2023
 * 
 * @author Ramón Perdomo <inoelperdomo@gmail.com> */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Este archivo define las credenciales
// de la base de datos e incluye todos 
// los archivos de la aplicación.
require 'Config/init.php';

$API = new APIController();
echo $API->init();
