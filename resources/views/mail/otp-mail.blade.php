<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email OTP Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            padding: 30px;
            text-align: center;
        }

        .card .logo img {
            width: 50px;
            margin-bottom: 20px;
        }

        .card h3 {
            color: #333333;
        }

        .card p {
            font-size: 14px;
            color: #555555;
            margin: 10px 0;
        }

        .card .otp {
            background-color: #1E90FF;
            color: #ffffff;
            font-size: 22px;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin: 20px 0;
        }

        .card .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 15px;
        }

        .card-footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Logo Section -->
        <div class="logo">
            <img src="https://vidyagxp.com/vidyaGxp_logo.png" alt="Company Logo">
        </div>

        <!-- Greeting Message -->
        <h3>Hi,</h3>
        <p>To proceed further with your login process please enter the OTP below.</p>

        <!-- Personalized User Greeting -->
        <div class="greeting">
            Dear <strong> {{ $data->name }} </strong>,
        </div>

        <!-- OTP Code Display -->
        <div class="otp">
            Code: {{ $otp  }}
        </div>
    </div>
</body>
</html>
