<?php
session_start();
if (empty($_SESSION["userID"]))
{
  header("Location: index.php");
  die();
} else {
  session_destroy();
  header("Location: ../index.php");
  die();
}

?>