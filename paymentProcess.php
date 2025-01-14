<?php

session_start();
include "connection.php";
require 'vendor/autoload.php';

$order_id = $_SESSION["oid"];

$order_rs = Database::search("SELECT * FROM `order` WHERE `order_id`='".$order_id."' ");
$order_num = $order_rs->num_rows;
$order_data = $order_rs->fetch_assoc();
$ammount = $order_data["total_cost"]*100;
$invoiceID = "BZ#00".$order_id;

$stripe = new \Stripe\StripeClient('sk_test_51PNxLGE5DfO8rsyjtuIIZZdtwqWh3AbQ8LN7HaPTHcivrwArWxvSTcdNliQkiOn96axf9Ou134NAo6HFGrW7mHJL001ldBWcPo');

$checkout_session = $stripe->checkout->sessions->create([
  'line_items' => [[
    'price_data' => [
      'currency' => 'LKR',
      'product_data' => [
        'name' => $invoiceID,
      ],
      'unit_amount' => $ammount,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => 'https://bookzone.yobivar.com/orderSuccess.php?status=2&id='.$order_id,
  'cancel_url' => 'https://bookzone.yobivar.com/orderCancel.php?status=5&id='.$order_id,
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
?>