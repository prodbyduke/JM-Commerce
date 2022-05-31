<?php
include_once("sql-connection.php");

unauthorize($_COOKIE["user"]);
header("location:index.php");