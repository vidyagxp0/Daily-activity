@extends('frontend.layout.main')

@section('container')

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        line-height: 1.6;
    }

    header {
        display: none;
    }

    .instruction-note {
        background-color: #e7f3fe;
        border-left: 6px solid #2196F3;
        padding: 15px;
        margin-bottom: 20px;
    }

    .instruction-note h2 {
        color: #2196F3;
    }

    .quiz-container {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #007BFF;
    }

    /* Question Styles */
    .question {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .question-type {
        font-weight: bold;
        font-size: 14px;
        color: #555;
    }

    .question-text {
        margin: 10px 0;
        font-size: 1.2em;
    }

    .hidden {
        display: none;
    }

    /* Button Styles */
    button {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 5px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.1em;
    }

    button:hover {
        background-color: #0056b3;
    }

    .attempts-over {
        text-align: center;
        margin-top: 20px;
        color: #e74c3c;
    }
</style>

<div class="quiz-container">

    @if ($inductiontrainingid->attempt_count == -1)
        <h1>Your attempts are over</h1>
    @else
        <div class="instruction-note">
            <h2>Instructions</h2>
            <ol>
                <li>Don't refresh, reload, or go back, as it will decrement your attempts.</li>
            </ol>
        </div>



        <h1>Equipment/Lifecycle Management Training Quiz</h1>
        <form action="{{ route('check_answer_equipment') }}" method="POST" id="quizForm"> <!-- Change to your actual form action -->
            @csrf <!-- Include CSRF token for security -->
            {{-- @php dd($inductiontrainingid); @endphp --}}
            {{-- {{ dd($inductiontrainingid->id, $inductiontrainingid->name_employee); }} --}}
            <input type="hidden"  name="training_id" value="{{ $inductiontrainingid->id }}">
            <input type="hidden"  name="equipmentInfo_id" value="{{ $inductiontrainingid->equipmentInfo_id }}">
            <input type="hidden"  name="emp_id" value="{{ $inductiontrainingid->trainees }}">
            <input type="hidden"  name="employee_name" value="{{ Helpers::getInitiatorName($inductiontrainingid->trainees) }}">
            <input type="hidden"  name="training_type" value="Induction Training">
            <input type="hidden"  name="attempt_count" value="{{ $inductiontrainingid->attempt_count }}">
            <input type="hidden"  name="question_count" value="{{ $questions->count() }}">
            <input type="hidden"  name="department" value="{{ $inductiontrainingid->department }}">


            @foreach ($questions as $index => $question)
            <div class="question {{ $index === 0 ? '' : 'hidden' }}" data-question-index="{{ $index }}">
                <p class="question-text"><strong>Question {{ $index + 1 }}:</strong> {{ $question->question }}
                    (<span class="question-type">{{ $question->type }}</span>)</p>

                    @php
                        // Unserialize the options and answers
                        $options = unserialize($question->options);
                    @endphp

                    @if ($options && is_array($options) && count($options) > 0) <!-- Check if options are valid -->
                        @if ($question->type === 'Single Selection Questions')
                            @foreach ($options as $option)
                                @if ($option) <!-- Check if option is not null -->
                                    <div>
                                        <input type="radio" id="option_{{ $index }}_{{ $loop->index }}" 
                                               name="question_{{ $question->id }}" value="{{ $option }}">
                                        <label for="option_{{ $index }}_{{ $loop->index }}">{{ $option }}</label>
                                    </div>
                                @endif
                            @endforeach
                        @elseif ($question->type === 'Multi Selection Questions')
                            @foreach ($options as $option)
                                @if ($option) <!-- Check if option is not null -->
                                    <div>
                                        <input type="checkbox" id="option_{{ $index }}_{{ $loop->index }}" 
                                        name="question_{{ $question->id }}[]" value="{{ $option }}">
                                 <label for="option_{{ $index }}_{{ $loop->index }}">{{ $option }}</label>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @else
                        <p>No options available for this question.</p> <!-- Message if no options are available -->
                    @endif
                </div>
            @endforeach

            <div class="navigation-buttons">
                <button type="button" id="prevButton" class="hidden">Back</button>
                <button type="button" id="nextButton">Next</button>
                <button type="submit" id="submitButton" class="hidden">Submit</button>
            </div>
         </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const questions = document.querySelectorAll('.question');
        const nextButton = document.getElementById('nextButton');
        const prevButton = document.getElementById('prevButton');
        const submitButton = document.getElementById('submitButton');
        let currentQuestionIndex = 0;

        function updateButtons() {
            prevButton.classList.toggle('hidden', currentQuestionIndex === 0);
            nextButton.classList.toggle('hidden', currentQuestionIndex === questions.length - 1);
            submitButton.classList.toggle('hidden', currentQuestionIndex !== questions.length - 1);
        }

        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.classList.toggle('hidden', i !== index);
            });
            updateButtons();
        }

        nextButton.addEventListener('click', () => {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            }
        });

        prevButton.addEventListener('click', () => {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
            }
        });

        showQuestion(currentQuestionIndex);
    });
</script>
@endsection
