<?php
session_start();

include "../Connect.php";

$sellers = [];

$category_id     = $_GET['category_id'];
$sub_category_id = $_GET['sub_category_id'];
$price           = $_GET['price'];
$filter          = $_GET['filter'];

$sql = "SELECT * from users WHERE active = 1 AND user_type_id = 2";

if ($filter === 'popularity') {

    $sql = "SELECT * from users WHERE active = 1 AND user_type_id = 2 ORDER BY total_rate DESC";
}

$sql1 = mysqli_query($con, $sql);

while ($row1 = mysqli_fetch_array($sql1)) {

    $sellers[] = [
        'id'          => $row1['id'],
        'name'        => $row1['name'],
        'total_rate'  => $row1['total_rate'],
        'description' => $row1['description'],
        'image'       => $row1['image'],
    ];
}

echo json_encode($sellers);
