<?php

include "../Connect.php";

$status  = $_GET['status'];
$user_id = $_GET['user_id'];
$type    = $_GET['type'];

$stmt = $con->prepare("UPDATE users SET status = ? WHERE id = ? ");

$stmt->bind_param("si", $status, $user_id);

if ($stmt->execute()) {

    if ($status == 'Accepted') {

        if ($type == 'farmer') {

            echo "<script language='JavaScript'>
            alert ('Farmer Has Been Accepted Successfully !');
            </script>";
        } else {

            echo "<script language='JavaScript'>
            alert ('Home Cook Has Been Accepted Successfully !');
            </script>";
        }

    } else {

        if ($type == 'farmer') {

            echo "<script language='JavaScript'>
            alert ('Farmer Has Been Rejected Successfully !');
            </script>";
        } else {

            echo "<script language='JavaScript'>
            alert ('Home Cook Has Been Rejected Successfully !');
            </script>";
        }

    }

    if ($type == 'farmer') {
        echo "<script language='JavaScript'>
        document.location='./Farmers.php';
        </script>";
    } else {

        echo "<script language='JavaScript'>
        document.location='./Home-Cooks.php';
        </script>";
    }

}
