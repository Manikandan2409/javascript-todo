<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    http_response_code(200); // Send OK for preflight request
    exit();
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json'); // Ensure the response is JSON

$data = json_decode(file_get_contents('php://input'), true);

$response = [];

if (isset($data['email']) && isset($data['password'])) {
    $mail = $data['email'];
    $password = $data['password'];

    $query = "SELECT * FROM users WHERE mail=? AND password=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $mail, $password);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            http_response_code(200); 
            $response = [
                'success' => true,
                'message' => 'User found',
                'user' => [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['mail']
                ]
            ];
        } else {
            http_response_code(401); 
            $response = ['success' => false, 'message' => 'Invalid email or password'];
        }
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
