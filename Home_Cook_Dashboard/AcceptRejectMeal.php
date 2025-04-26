<?php

include "../Connect.php";

$status   = $_GET['status'];
$order_id = $_GET['order_id'];

$stmt = $con->prepare("UPDATE meals_orders SET status = ? WHERE id = ? ");

$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {

    if ($status == 'Accepted') {

        echo "<script language='JavaScript'>
        alert ('Order Accepted !');
        </script>";

        echo "<script language='JavaScript'>
        document.location='./Meals-Orders.php';
        </script>";

    } else if ($status == 'Rejected') {
        echo "<script language='JavaScript'>
alert ('Order Rejected !');
</script>";

        echo "<script language='JavaScript'>
document.location='./Meals-Orders.php';
</script>";
    }

}
