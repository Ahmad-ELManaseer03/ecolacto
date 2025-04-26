<?php

include "../Connect.php";

$status_id = $_GET['status_id'];
$order_id  = $_GET['order_id'];

$stmt = $con->prepare("UPDATE orders SET status = ? WHERE id = ? ");

$stmt->bind_param("si", $status_id, $order_id);

if ($stmt->execute()) {

    if ($status_id == 'Accepted') {

        echo "<script language='JavaScript'>
        alert ('Order Accepted !');
        </script>";

        echo "<script language='JavaScript'>
        document.location='./Orders.php';
        </script>";

    } else if ($status_id == 'Rejected') {
        echo "<script language='JavaScript'>
alert ('Order Rejected !');
</script>";

        echo "<script language='JavaScript'>
document.location='./Orders.php';
</script>";
    }

}
