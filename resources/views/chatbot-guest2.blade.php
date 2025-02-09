<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSU ChatBot</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="icon" href="{{ asset('images/botbot.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Poppins, 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #3b82f6, #ffffff);

        }
        .chat-container {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .chat-header {
            background: linear-gradient(90deg, #dae9fe 0%, #bfdcfe 100%);
            padding: 20px;
            color: #5c74b0;
            text-align: center;
        }
        .chat-body {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
        }
        .message-container {
            display: flex;
            margin-bottom: 20px;
        }
        .user-container {
            justify-content: flex-end;
        }
        .bot-container {
            justify-content: flex-start;
        }
        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }
        .user-message {
            background-color: #667eea;
            color: white;
            border-bottom-right-radius: 4px;
        }
        .bot-message {
            background-color: #f0f0f0;
            color: #333;
            border-bottom-left-radius: 4px;
            margin-left: 10px;
        }
        .bot-message:hover {
            background-color: #e2e2e2;
        }
        .chatImage {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .input-area {
            display: flex;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        #user-input {
            flex-grow: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        #user-input:focus {
            box-shadow: 0 2px 15px rgba(103,126,234,0.25);
            outline-color: #3b82f6;
        }
        .send-button {
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .send-button:hover {
            background-color: #4a66e5;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .chat-body::-webkit-scrollbar {
            width: 6px;
        }
        .chat-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .chat-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        .chat-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .typing-indicator {
            display: inline-block;
            width: 40px;
        }
        .typing-indicator span {
            height: 8px;
            width: 8px;
            float: left;
            margin: 0 1px;
            background-color: #9E9EA1;
            display: block;
            border-radius: 50%;
            opacity: 0.4;
        }
        .typing-indicator span:nth-of-type(1) {
            animation: 1s blink infinite 0.3333s;
        }
        .typing-indicator span:nth-of-type(2) {
            animation: 1s blink infinite 0.6666s;
        }
        .typing-indicator span:nth-of-type(3) {
            animation: 1s blink infinite 0.9999s;
        }
        @keyframes blink {
            50% {
                opacity: 1;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="chat-container w-full max-w-2xl">
        <div class="chat-header">
            <img src="{{ asset('images/bot.png') }}" id="botImage" class="mx-auto h-24 w-auto mb-4" alt="Bot Image">
            <h1 class="text-2xl font-bold">{{ $botName->message }} ChatBot</h1>
            <p class="text-sm mt-2">Powered by Pangasinan State University</p>
        </div>
        <div id="chat-messages" class="chat-body">
            <!-- Messages will be inserted here -->
        </div>
        <div class="input-area">
            <input type="text" id="user-input" placeholder="Type your message..." autofocus>
            <button class="send-button">
                <ion-icon name="send"></ion-icon>
            </button>
        </div>
    </div>

    <script>
        var botProfilePicture = "{{ asset('images/botbot.png') }}";
    </script>
    <script>
        let previousQueries = new Set();

        function processQuery(query) {
            const lowerCaseQuery = query.toLowerCase();

            const responses = [
                @foreach ($dataBanks as $dataBank)
                    { 
                        pattern: new RegExp("{{ $dataBank->chatPattern }}", "i"), // 'i' for case-insensitive
                        response: "{{ $dataBank->chatResponse }}"
                    },
                @endforeach
            ];

            // Check if the query has been asked before
            if (previousQueries.has(lowerCaseQuery)) {
                return "{{$botRepeated->message}}";
            }

            for (const { pattern, response } of responses) {
                if (pattern.test(lowerCaseQuery)) {
                    // Store the query for future reference
                    previousQueries.add(lowerCaseQuery);
                    return response;
                }
            }
            
            return '{{$botFallback->message}}';
        }
    </script>
    <script src="{{ asset('js main/queryProcessor.js') }}"></script>
    <script>
        // Add an initial bot message
        addMessage('{{$botGreeting->message}}', false);
</script>
    </script>
</body>
</html>