<?php
session_start();
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $apiUrl = "http://127.0.0.1:8000/api/logout";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

session_destroy();
header("Refresh:2; url=login.php"); // 👈 Redirect after 2 seconds
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logging Out...</title>

<style>
    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #74ABE2, #5563DE);
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logout-box {
        background: #fff;
        border-radius: 15px;
        padding: 40px 60px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        animation: fadeIn 0.8s ease;
    }

    h1 {
        color: #333;
        margin-bottom: 15px;
        font-size: 26px;
    }

    p {
        color: #666;
        font-size: 16px;
    }

    .loader {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #5563DE;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin: 20px auto;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>

<div class="logout-box">
    <h1>Logging Out...</h1>
    <div class="loader"></div>
    <p>You are being redirected to the login page.</p>
</div>

</body>
</html>
