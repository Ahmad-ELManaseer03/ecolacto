<?php

session_start();

include "../Connect.php";

$H_ID = $_SESSION['H_Log'];

$product_id = $_GET['product_id'];
$qty        = $_GET['qty'];

$response = [];

$stmt = $con->prepare("INSERT INTO carts (consumer_id, product_id, qty) VALUES (?, ?, ?)");

$stmt->bind_param("iii", $H_ID, $product_id, $qty);

if ($stmt->execute()) {

    $sql211 = mysqli_query($con, "SELECT COUNT(id) AS cart_count FROM carts WHERE consumer_id = '$H_ID'");
    $row211 = mysqli_fetch_array($sql211);

    $cart_count = $row211['cart_count'];

    $response['error']      = false;
    $response['cart_count'] = $cart_count;

} else {
    $response['error']      = true;
    $response['cart_count'] = 0;
}

echo json_encode($response);
