<!-- resources/views/components/mic-and-speak.blade.php -->
@props(['disabled' => false])
<style>
    .mini-modal {
        display: none;
        position: absolute;
        z-index: 1;
        padding: 10px;
        background-color: #fefefe;
        border: 1px solid #888;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 200px;
        /* Adjust width as needed */
    }

    .mini-modal-content {
        background-color: #fefefe;
        padding: 10px;
        border-radius: 4px;
    }

    .mini-modal-content h2 {
        font-size: 16px;
        margin-top: 0;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }
</style>
<style>
    .group-input {
        margin-bottom: 20px;
    }

    .mic-btn,
    .speak-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        box-shadow: none;
        opacity: 1;
        transition: opacity 0.3s;
    }

    .mic-btn i,
    .speak-btn i {
        color: black;
    }

    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active,
    .speak-btn:focus,
    .speak-btn:hover,
    .speak-btn:active {
        box-shadow: none;
    }

    .relative-container {
        position: relative;
    }

    .relative-container input {
        width: 100%;
        padding-right: 40px;
    }

    /* .relative-container:hover .mic-btn {
        opacity: 1;
    }

    .relative-container:hover .speak-btn {
        opacity: 1;
    } */
</style>

<style>
    #start-record-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
    }

    #start-record-btn i {
        color: black;
        /* Set the color of the icon */
        box-shadow: none;
        /* Remove shadow */
    }

    #start-record-btn:focus,
    #start-record-btn:hover,
    #start-record-btn:active {
        box-shadow: none;
        /* Remove shadow on hover/focus/active */
    }
</style>
<style>
    .mic-btn {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        position: absolute;
        right: 10px;
        /* Position the button at the right corner */
        top: 50%;
        /* Center the button vertically */
        transform: translateY(-50%);
        /* Adjust for the button's height */
        box-shadow: none;
        /* Remove shadow */
    }

    .mic-btn {
        right: 50px;
        /* Adjust position to avoid overlap with speaker button */
    }

    .speak-btn {
        right: 16px;
    }

    .mic-btn i {
        color: black;
        /* Set the color of the icon */
        // box-shadow: none; /* Remove shadow */
    }

    .mic-btn:focus,
    .mic-btn:hover,
    .mic-btn:active {
        box-shadow: none;
        /* Remove shadow on hover/focus/active */
        // display: none;
    }

    .relative-container {
        position: relative;
    }

    .relative-container textarea {
        width: 100%;
        padding-right: 40px;
        /* Ensure the text does not overlap the button */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">





<button class="mic-btn" type="button" style="display: none;" {{ $disabled ? 'disabled' : '' }}>
    <i class="fas fa-microphone"></i>
</button>
<button class="speak-btn" type="button" {{ $disabled ? 'disabled' : '' }}>
    <i class="fas fa-volume-up"></i>
</button>
<div class="mini-modal">
    <div class="mini-modal-content">
        <span class="close">&times;</span>
        <h2>Select Language</h2>
        <select id="language-select">
            <option value="en-us">English</option>
            <option value="hi-in">Hindi</option>
            <option value="te-in">Telugu</option>
            <option value="fr-fr">French</option>
            <option value="es-es">Spanish</option>
            <option value="zh-cn">Chinese (Mandarin)</option>
            <option value="ja-jp">Japanese</option>
            <option value="de-de">German</option>
            <option value="ru-ru">Russian</option>
            <option value="ko-kr">Korean</option>
            <option value="it-it">Italian</option>
            <option value="pt-br">Portuguese (Brazil)</option>
            <option value="ar-sa">Arabic</option>
            <option value="bn-in">Bengali</option>
            <option value="pa-in">Punjabi</option>
            <option value="mr-in">Marathi</option>
            <option value="gu-in">Gujarati</option>
            <option value="ur-pk">Urdu</option>
            <option value="ta-in">Tamil</option>
            <option value="kn-in">Kannada</option>
            <option value="ml-in">Malayalam</option>
            <option value="or-in">Odia</option>
            <option value="as-in">Assamese</option>
            <!-- Add more languages as needed -->
        </select>
        <button id="select-language-btn">Select</button>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        function startRecognition(targetElement) {
            recognition.start();
            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                targetElement.value += transcript;
            };
            recognition.onerror = function(event) {
                console.error(event.error);
            };
        }

        document.addEventListener('click', function(event) {
            if (event.target.closest('.mic-btn')) {
                const button = event.target.closest('.mic-btn');
                const inputField = button.previousElementSibling;
                if (inputField && inputField.classList.contains('mic-input')) {
                    startRecognition(inputField);
                }
            }
        });

        document.querySelectorAll('.mic-input').forEach(input => {
            input.addEventListener('focus', function() {
                const micBtn = this.nextElementSibling;
                if (micBtn && micBtn.classList.contains('mic-btn')) {
                    micBtn.style.display = 'inline-block';
                }
            });

            input.addEventListener('blur', function() {
                const micBtn = this.nextElementSibling;
                if (micBtn && micBtn.classList.contains('mic-btn')) {
                    setTimeout(() => {
                        micBtn.style.display = 'none';
                    }, 200); // Delay to prevent button from hiding immediately when clicked
                }
            });
        });
    });
</script>


<script>
$(document).ready(function () {
    let selectedLanguage = 'en-US'; // Default language
    let isSpeaking = false; // Flag to track if speech is currently ongoing
    let currentUtterance = null; // Track the current utterance to stop it properly

    // Common Hindi words to detect transliterated Hindi text
    const hindiWords = [
    'bhai', 'kaise', 'sab', 'thik', 'haan', 'acha', 'mujhe', 'tum', 'kya', 'kaha', 'kaam', 'mil', 'hai', 'tu', 'tera', 
    'meri', 'mera', 'bahut', 'pyar', 'dosti', 'kaisa', 'shadi', 'ghar', 'paisa', 'samajh', 'samay', 'kise', 'dost', 
    'baap', 'maa', 'bhaiya', 'behen', 'ladki', 'ladka', 'mujhse', 'tera', 'tumse', 'mujhe', 'bhul', 'bhool', 'yaad', 
    'milna', 'batana', 'batao', 'zaroori', 'bahar', 'andar', 'ghar', 'jana', 'kya', 'kese', 'kab', 'kaun', 'kyu', 
    'yeh', 'woh', 'yaha', 'waha', 'kidar', 'kaise', 'kaam', 'kam', 'bahana', 'chal', 'ruk', 'baat', 'soch', 'socha', 
    'dekha', 'dekhna', 'chalo', 'nahi', 'haan', 'acha', 'theek', 'haanji', 'arey', 'wah', 'arrey', 'kuch', 'jaisa', 
    'waise', 'se', 'karo', 'karte', 'karna', 'karte', 'rahe', 'aana', 'jane', 'jaldi', 'deri', 'badiya', 'laga', 'dil', 
    'baapre', 'khoobsurat', 'bada', 'chota', 'naya', 'purana', 'sabse', 'accha', 'bekar', 'sahi', 'galat', 'bura', 
    'moti', 'patla', 'lamba', 'chota', 'tez', 'dheere'
];

    // Function to detect if the text is transliterated Hindi or not
    function detectLanguage(text) {
        const words = text.split(' ');
        let hindiCount = 0;
        words.forEach(word => {
            if (hindiWords.includes(word.toLowerCase())) {
                hindiCount++;
            }
        });
        return hindiCount > 2 ? 'hi' : 'en'; // If more than 2 words match, consider as Hindi
    }

    // When the user clicks the speak button, open the mini modal
    $(document).on('click', '.speak-btn', function () {
        let inputField = $(this).siblings('textarea, input');
        let inputText = inputField.val();
        let modal = $(this).siblings('.mini-modal');
        if (inputText) {
            $(modal).data('inputField', inputField);
            modal.css({
                display: 'block',
                top: $(this).position().top - modal.outerHeight() - 10,
                left: $(this).position().left + $(this).outerWidth() - modal.outerWidth()
            });
        }
    });

    // Close the mini modal when 'X' is clicked
    $(document).on('click', '.close', function () {
        $(this).closest('.mini-modal').css('display', 'none');
    });

    // Handle language selection and text-to-speech conversion
    $(document).on('click', '#select-language-btn', function (event) {
        event.preventDefault();
        let modal = $(this).closest('.mini-modal');
        selectedLanguage = modal.find('#language-select').val(); // Get selected language
        let inputField = modal.data('inputField');
        let textToSpeak = inputField.val(); // Take text from input field

        if (textToSpeak) {
            // Detect if the text is English or transliterated Hindi
            const detectedLanguage = detectLanguage(textToSpeak);

            // Cancel any ongoing speech before starting a new one
            if (window.speechSynthesis.speaking || window.speechSynthesis.paused) {
                window.speechSynthesis.cancel(); // Ensure that no speech is ongoing
                isSpeaking = false; // Reset speaking flag
                currentUtterance = null; // Reset current utterance
            }

            // Translate and then speak the translated text
            translateText(textToSpeak, detectedLanguage, selectedLanguage.split('-')[0])
                .then(translatedText => {
                    if (!isSpeaking && translatedText) {
                        isSpeaking = true; // Set flag to indicate speaking has started

                        // Create and configure a new utterance
                        currentUtterance = new SpeechSynthesisUtterance(translatedText);
                        currentUtterance.lang = selectedLanguage;

                        // Reset the flag and clear the current utterance when speech ends
                        currentUtterance.onend = function () {
                            isSpeaking = false;
                            currentUtterance = null;
                            window.speechSynthesis.cancel(); // Ensure no lingering speech
                        };

                        // Handle speech errors gracefully
                        currentUtterance.onerror = function () {
                            isSpeaking = false;
                            currentUtterance = null;
                        };

                        // Start speaking the text
                        window.speechSynthesis.speak(currentUtterance);
                    }
                })
                .catch(error => {
                    console.error('Translation failed: ', error);
                    alert('Error in translation or speech synthesis.');
                });
        }

        modal.css('display', 'none');
    });

    // Speech-to-Text functionality
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.lang = 'en-US';

    function startRecognition(targetElement) {
        recognition.start();
        recognition.onresult = function (event) {
            const transcript = event.results[0][0].transcript;
            targetElement.value += transcript;
        };
        recognition.onerror = function (event) {
            console.error(event.error);
        };
    }

    $(document).on('click', '.mic-btn', function () {
        const inputField = $(this).siblings('textarea, input');
        startRecognition(inputField[0]);
    });

    $('.relative-container').hover(
        function () {
            $(this).find('.mic-btn').show();
        },
        function () {
            $(this).find('.mic-btn').hide();
        }
    );

    // Function to translate text using RapidAPI with dynamic 'from' parameter
    async function translateText(text, fromLanguage, toLanguage) {
        const url = `https://free-google-translator.p.rapidapi.com/external-api/free-google-translator?from=${fromLanguage}&to=${toLanguage}&query=${encodeURIComponent(text)}`;

        const options = {
            method: 'POST',
            headers: {
                'x-rapidapi-key': '1e6d004c41msh632fcdce8857b28p197054jsn63ba6760d863',
                'x-rapidapi-host': 'free-google-translator.p.rapidapi.com',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                translate: 'rapidapi'
            })
        };

        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('API Response:', result);
            return result && result.translation ? result.translation : 'Translation not found';
        } catch (error) {
            console.error('Error occurred:', error);
            throw error;
        }
    }
});
</script>






