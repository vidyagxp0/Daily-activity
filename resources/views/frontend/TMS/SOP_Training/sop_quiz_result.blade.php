@extends('frontend.layout.main')

@section('container')

<style>
    .result-container {
        width: 60%;
        max-width: 700px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

   
    @keyframes slideIn {
        0% {
            transform: translateY(-20px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

  
    .result-container h1 {
        font-size: 2.5em;
        color: #007BFF;
        animation: slideIn 1s ease-out;
    }

    .result-container p {
        font-size: 1.2em;
        margin: 15px 0;
    }

    .pass {
        color: green;
    }

    .fail {
        color: red;
    }

    .certificate {
        border: 2px solid #007BFF;
        padding: 20px;
        margin-top: 20px;
        border-radius: 5px;
        background-color: #e7f3fe;
        color: #333;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
        animation: bounceIn 1s ease;
    }

    
    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }

    .certificate h2 {
        font-size: 2.5em;
        background-color: #e7f3fe;
        animation: bounceIn 1.5s ease-out;
    }

    .certificate p {
        font-size: 1.2em;
        margin-top: 10px;
        animation: fadeIn 2s ease-in-out;
    }

    button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.1em;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    button a {
        color: white;
        text-decoration: none;
    }

    .details {
        margin: 10px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>

<div class="result-container">
    <h1>Quiz Result</h1>
    <p>Your Score: <strong>{{ $score }}%</strong></p>
    <p class="{{ $result == 'Pass' ? 'pass' : 'fail' }}">
        {{ $result == 'Pass' ? 'Congratulations! You Passed!' : 'Sorry, You Failed.' }}
    </p>

    <div class="details">
        <p>Total Questions: <strong>{{ $totalQuestions }}</strong></p>
        <p>Correct Answers: <strong>{{ $correctCount }}</strong></p>
        <p>Incorrect Answers: <strong>{{ $totalQuestions - $correctCount }}</strong></p>
    </div>

    @if ($result == 'Pass')
        <!-- Display the pass certificate -->
        <div class="certificate">
            <h2>🎉 Certificate of Achievement 🎉</h2>
            <p>We hereby certify that you have successfully passed the quiz with a score of {{ $score }}%.</p>
            <p>Keep up the good work!</p>
        </div>
    @else
        <!-- Display the fail certificate -->
        <div class="certificate">
            <h2>💥 Certificate of Completion 💥</h2>
            <p>Unfortunately, you did not pass the quiz. Your score was {{ $score }}%. Please review the material and try again!</p>
            <p>Better luck next time!</p>
        </div>
    @endif
    <button type="button"> <a class="text-white" href="{{ route('tms.training') }}"> Go Back to Home </a> </button>
</div>

@endsection
