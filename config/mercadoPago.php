<?php

$orders = $_SERVER['APP_URL'] .  '/pedidos';

return [
    'access' => env("MERCADO_PAGO_DEVELOP", "TEST-3030807514700823-032620-68626e53e3b7e1846a8ec0fc3d3ea953-274055464"),
    'back_urls'=> [
        "success" => $orders,
        "failure" =>  $orders,
        "pending" => $orders
    ],
    'status' => [
        'approved' => 'approved',
    ]
];
