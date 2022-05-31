<?php
include_once("sql-connection.php");

global $conn;

if ($_GET["action"] == "add") {
    $sql = "INSERT INTO contains (cart_id, product_id, quantity)
    VALUES (". $_COOKIE["cart"] .", ". $_GET["p"] . ", " . $_GET["q"] . ")";
} else if ($_GET["action"] == "delete") {
    $sql = "DELETE FROM products
    WHERE id = " . $_GET["p"];
}

if ($conn->query($sql) === TRUE) {
    header("location:index.php");
} else {
    echo $_GET["p"];
    echo "error:" . $conn->error;
}