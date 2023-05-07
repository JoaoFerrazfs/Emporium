<?php

return [
    'access' => env("MERCADO_PAGO_DEVELOP", "TEST-3030807514700823-032620-68626e53e3b7e1846a8ec0fc3d3ea953-274055464"),
    'back_urls'=> [
        "success" => "https://www.seu-site/success",
        "failure" => "http://127.0.0.1:8000/pedido",
        "pending" => "http://127.0.0.1:8000/"
    ],
    'status' => [
        'approved' => 'approved',
    ]
];
