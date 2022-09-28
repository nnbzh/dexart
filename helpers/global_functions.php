<?php

function dd()
{
    foreach (func_get_args() as $x) {
        print_r($x);
    }
    die;
}

function response(mixed $data = [], int $status = 200)
{
    header_remove();
    header("Content-Type: application/json");
    http_response_code($status);

    $response = is_array($data) ? $data : ['data' => $data];
    echo json_encode($response);

    exit;
}