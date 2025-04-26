<?php

include "../Connect.php";

$keyword_id = $_GET['keyword_id'];
$meal_id    = $_GET['meal_id'];

$stmt = $con->prepare("DELETE FROM meal_keywords WHERE id = ?");

$stmt->bind_param("i", $keyword_id);

if ($stmt->execute()) {

    echo "<script language='JavaScript'>
        alert ('Keyword Has Been Deleted Successfully !');
        </script>";

    echo "<script language='JavaScript'>
        document.location='./Keywords.php?meal_id={$meal_id}';
        </script>";

}
