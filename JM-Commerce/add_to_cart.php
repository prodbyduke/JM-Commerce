<?php
include_once("sql-connection.php");

global $conn;

if ($_GET["action"] == "add") {
    $sql = "INSERT INTO contains (cart_id, product_id, quantity)
    VALUES (". $_COOKIE["cart"] .", ". $_GET["p"] . ", " . $_GET["q"] . ")";
} else if ($_GET["action"] == "remove") {
    $sql = "DELETE FROM contains
    WHERE cart_id = " . $_COOKIE["cart"] ." AND product_id = ". $_GET["p"];
}

if ($conn->query($sql) === TRUE) {
    header("location:products.php?g=Cart");
} else {
    echo $_GET["p"];
    echo "error:" . $conn->error;
}