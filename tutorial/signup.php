<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json'); // Ensure the response is JSON

    http_response_code(200); // Send OK for preflight request
    exit();
}

include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$response = [];

if (isset($data['username']) && isset($data['email']) && isset($data['password'])) {
    $username  = $data['username'];
    $mail = $data['email'];
    $password = $data['password'];

    $query = "INSERT INTO users (username, mail, password) VALUES(?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $mail, $password);

    if (mysqli_stmt_execute($stmt)) {
        http_response_code(200); 
        $response = ['success' => true, 'message' => 'New record created successfully'];
    } else {
        http_response_code(500); 
        $response = ['success' => false, 'message' => 'Database error: ' . mysqli_error($con)];
    }

    mysqli_stmt_close($stmt);
} else {
    http_response_code(400); 
    $response = ['success' => false, 'message' => 'Error: Missing required fields'];
}

mysqli_close($con);

echo json_encode($response);
