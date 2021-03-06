<?php
session_start();

require_once("./include/php/sql.php");
/* Index Page - Website Manager */

$includePage = "";
$includeTemplate = true;
switch(@$_GET['act']){
  case "register":
  case "login":
    $includePage = $_GET['act'];
    $includeTemplate = false;
  break;

  case "mailbox":
  case "following":
  case "users":
  case "addproject":
  case "addfiles":
  case "profile":
  case "project":
  case "chat":
    $includePage = $_GET['act'];
    break;

  case "logout":
    session_destroy();
    header("Location: ./");
  break;

  default:
      if(!@isset($_SESSION['UserID'])){
          //Redirect
          header("Location: ./?act=login");
          return;
      }
    $includePage = "default";
  break;
    }


function active($menuItem){
  if($menuItem == @$_GET['act'] || ($menuItem == "default" && !isset($_GET['act']))){
    echo "class=\"active\"";
  }
}

try{
include "./include/php/".$includePage.".php";
}
catch(Exception $e)
{
    echo "<pre>The following error occured: <br />".$e->getMessage()."</pre>";
}

if($includeTemplate){
  //Meaning user it attempting to get into the Website
  //Verify user is logged in    
  if(!@isset($_SESSION['UserID'])){
    //Redirect
    header("Location: ./?act=login");
    return;
  }
  include "./include/php/template.php";
}






 ?>