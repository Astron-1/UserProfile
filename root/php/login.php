<?php include("config.php");?>
<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $email = mysqli_real_escape_string($conn, $_POST["email"]);
     $password = mysqli_real_escape_string($conn, $_POST["password"]);
 
     // Perform any server-side validation or database operations here
     // For example, check if the email and password match a user in the database

     $stmt = $conn->prepare("SELECT pass FROM $tableName WHERE email = ?");
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($hashedPassword);

     // Fetch the result
     if ($stmt->fetch()) {
        if (password_verify($password, $hashedPassword)) {

            $sessionToken = "your_generated_session_token";
            $response = array(
                "message" => "Login successful!",
                "status" => 200,
                "sessionToken" => $sessionToken
            );
        } else {
            $response = array(
                "message" => "Incorrect email or password.",
                "status" => 401 // Unauthorized
            );
        }
    } else {
        // Email not found in the database
        $response = array(
            "message" => "Email not registered.",
            "status" => 401 // Unauthorized
        );
    }

    $stmt->close();

    echo json_encode($response);
} else {
    http_response_code(400); // Bad Request
    $response = array(
        "message" => "Invalid request.",
        "status" => 400
    );
    echo json_encode($response);
}
  $conn->close();
?>
<!-- session storing in the redis database -->
<?php
$redisHost = '127.0.0.1'; 
$redisPort = 6379; 

require ('vendor/autoload.php');
try {
    $redisClient = new Redis();
    $redisClient->connect($redisHost, $redisPort);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (password_verify($password, $hashedPassword)) {
            $sessionToken = bin2hex(random_bytes(16));
            $redisClient->setex($sessionToken, 3600, $email);

            $response = array(
                "message" => "Login successful!",
                "status" => 200,
                "sessionToken" => $sessionToken
            );
        } else {
            // Password not matched
            $response = array(
                "message" => "Incorrect email or password.",
                "status" => 401
            );
        }

        echo json_encode($response);
    } else {
        http_response_code(400);
        $response = array(
            "message" => "Bad request.",
            "status" => 400
        );
        echo json_encode($response);
    }
} catch (RedisException $e) {
    die("Failed to connect to Redis: " . $e->getMessage());
}
?>

