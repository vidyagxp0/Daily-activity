<style>
        /* Overall page styling */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #f8b195, #427CE6);
        }

        .otp-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .otp-box {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .otp-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .otp-input-wrapper {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .otp-input-wrapper input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: 2px solid #000;
            border-radius: 8px;
            background-color: #f9f9f9;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .otp-input-wrapper input:focus {
            border-color: #427CE6;
            box-shadow: 0 0 5px rgba(33, 147, 176, 0.5);
        }

        .form-group {
            text-align: center;
        }

        button {
            padding: 12px 30px;
            background-color: #427CE6;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #176d81;
        }

        .error-message {
            color: #d9534f;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
        }
    </style>
    <!-- 
<style>
    .otp-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .otp-input-wrapper {
            display: flex;
            gap: 10px;
        }

        .otp-input-wrapper input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            outline: none;
        }

        .otp-input-wrapper input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Submit button styling */
        .form-group {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    .error-message {
        color: red;
        text-align: center;
        margin-bottom: 15px;
        font-size: 16px;
    }
    .success-message {
        color: green;
        text-align: center;
        margin-bottom: 15px;
        font-size: 16px;
    }
</style> -->

<div class="otp-container">
        <div class="otp-box">
            <h2>Verify Your OTP</h2>

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Success message -->
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <!-- OTP Form -->
            <form method="POST" action="{{ route('otp-verification-submit') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $id }}">
                <div class="otp-input-wrapper">
                    <input type="text" name="otp[]" maxlength="1" required pattern="[0-9]" oninput="moveNext(this, 'otp2')">
                    <input type="text" id="otp2" name="otp[]" maxlength="1" required pattern="[0-9]" oninput="moveNext(this, 'otp3')">
                    <input type="text" id="otp3" name="otp[]" maxlength="1" required pattern="[0-9]" oninput="moveNext(this, 'otp4')">
                    <input type="text" id="otp4" name="otp[]" maxlength="1" required pattern="[0-9]" oninput="moveNext(this, '')">
                </div>
                <div class="form-group">
                    <button type="submit">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to move the cursor to the next input field automatically
        function moveNext(current, nextFieldID) {
            if (current.value.length >= 1 && nextFieldID !== "") {
                document.getElementById(nextFieldID).focus();
            }
        }
    </script>



