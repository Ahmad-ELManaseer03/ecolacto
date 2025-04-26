<?php

include "../Connect.php";
$isActive   = $_GET['isActive'];
$product_id = $_GET['product_id'];

$stmt = $con->prepare("UPDATE products SET active = ? WHERE id = ? ");

$stmt->bind_param("ii", $isActive, $product_id);

if ($stmt->execute()) {

    if ($isActive == 0) {

        echo "<script language='JavaScript'>
        alert ('Product Has Been Deleted Successfully !');
        </script>";

        echo "<script language='JavaScript'>
        document.location='./Products.php';
        </script>";

    } else {
        echo "<script language='JavaScript'>
alert ('Product Has Been Restored Successfully !');
</script>";

        echo "<script language='JavaScript'>
document.location='./Products.php';
</script>";
    }

}
