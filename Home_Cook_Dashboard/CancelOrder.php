<?php

include "../Connect.php";

$status      = 'Cancled';
$order_id = $_GET['order_id'];

$stmt = $con->prepare("UPDATE orders SET status = ? WHERE id = ? ");

$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {

    echo "<script language='JavaScript'>
alert ('Order Has Been Canceled !');
</script>";

    echo "<script language='JavaScript'>
document.location='./Orders.php';
</script>";

}
