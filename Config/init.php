<?php

define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "api");

require 'Interfaces/iCRUD.php';

require 'Controllers/APIController.php';
require 'Controllers/ContactController.php';
require 'Controllers/PhoneController.php';

require 'Models/DatabaseModel.php';
require 'Models/ContactModel.php';
require 'Models/PhoneModel.php';