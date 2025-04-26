<?php

session_start();

include "../Connect.php";

$B_ID = $_SESSION['H_Log'];

$response = [
    'orders' => [],
];

$sql33 = mysqli_query($con, "SELECT * from orders WHERE consumer_id = '$B_ID' ORDER BY id DESC");

while ($row33 = mysqli_fetch_array($sql33)) {

    $order_id    = $row33['id'];
    $total_price = $row33['total_price'];
    $status      = $row33['status'];

    $items = [];

    $sql444 = mysqli_query($con, "SELECT * from order_items WHERE order_id = '$order_id'");

    while ($row44 = mysqli_fetch_array($sql444)) {

        $product_id = $row44['product_id'];
        $farmer_id  = $row44['seller_id'];
        $qty        = $row44['quantity'];

        $sql555 = mysqli_query($con, "SELECT * from products WHERE id = '$product_id'");
        $row555 = mysqli_fetch_array($sql555);

        $product_name  = $row555['name'];
        $product_price = $row555['price'];
        $product_image = $row555['image'];

        $sql666 = mysqli_query($con, "SELECT * from users WHERE id = '$farmer_id'");
        $row666 = mysqli_fetch_array($sql666);

        $farmer_name = $row666['name'];

        $items[] = [
            'item_id'     => $product_id,
            'item_name'   => $product_name,
            'item_price'  => $product_price,
            'item_image'  => $product_image,
            'qty'         => $qty,
            'farmer_id'   => $farmer_id,
            'farmer_name' => $farmer_name,
        ];
    }

    $response['orders'][] = [
        'order_id'    => $order_id,
        'total_price' => $total_price,
        'status'      => $status,
        'items'       => $items,
    ];

}

echo json_encode($response);
