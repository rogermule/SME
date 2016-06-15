<?php


//will hold files that are going to be included or required in every views
require("../../../CONFIGURATION/Config.php");
//require(DB);
require("../database.php");
require("../../../MODEL/User.php");
require("../../../MODEL/User_Type.php");
require("../../../CONTROLLER/User_Controller.php");
require("../../../CONTROLLER/Admin_Controller.php");
require("../../../CONTROLLER/Controller_Secure_Access.php");
require("Admin_Security.php");