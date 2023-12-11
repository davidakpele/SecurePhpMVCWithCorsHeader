<?php 

require "../app/config/configuration.php";
// Accessing the Database file
require "../app/config/database.php";
//Accessing the controller file 
require "../app/config/controller.php";
// Accessing the Application file
require "../app/config/app.php";
require_once "../app/sessions/session.php";
require_once "../app/bootstrap/sanctum.php";
require_once "../app/bootstrap/jwtUtil.php";
require "../app/helpers/http/validate.php";
require "../app/helpers/errors/errorHandler.php";
require '../app/vendor/autoload.php';
