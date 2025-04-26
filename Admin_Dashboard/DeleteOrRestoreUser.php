<?php

include "../Connect.php";

$isActive = $_GET['isActive'];
$user_id  = $_GET['user_id'];
$type     = $_GET['type'];

$stmt = $con->prepare("UPDATE users SET active = ? WHERE id = ? ");

$stmt->bind_param("ii", $isActive, $user_id);

if ($stmt->execute()) {

    if ($isActive == 0) {

        if ($type == 'farmer') {

            echo "<script language='JavaScript'>
            alert ('Farmer Has Been Deleted Successfully !');
            </script>";
        } else {
            echo "<script language='JavaScript'>
            alert ('Home Cook Has Been Deleted Successfully !');
            </script>";
        }

    } else {

        if ($type == 'farmer') {

            echo "<script language='JavaScript'>
            alert ('Farmer Has Been Restored Successfully !');
            </script>";
        } else {
            echo "<script language='JavaScript'>
            alert ('Home Cook Has Been Restored Successfully !');
            </script>";
        }

    }

    if ($type == 'farmer') {
        echo "<script language='JavaScript'>
        document.location='./Farmers.php';
        </script>";
    } else {

        echo "<script language='JavaScript'>
        document.location='./Advertisements.php';
        </script>";
    }

}
