<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4" x-data="chatbot()">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-center">PSU San Carlos Campus Chatbot</h1>
            </div>
            <div class="mb-4 h-64 overflow-y-auto border border-gray-300 p-2 rounded" id="chat-messages">
                <template x-for="message in messages" :key="message.id">
                    <div :class="{'text-right': message.sender === 'user'}">
                        <span x-text="message.sender" class="font-bold"></span>: <span x-text="message.text"></span>
                    </div>
                </template>
            </div>
            <div class="flex">
                <input type="text" x-model="userInput" @keydown.enter="sendMessage" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Type your message...">
                <button onclick="sendMessage()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">Send</button>
            </div>
        </div>
    </div>

    <script>
        function chatbot() {
            return {
                userInput: '',
                messages: [],
                sendMessage() {
                    if (this.userInput.trim() === '') return;
                    
                    this.messages.push({id: Date.now(), sender: 'user', text: this.userInput});
                    
                    fetch('/chatbot', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({message: this.userInput})
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.messages.push({id: Date.now(), sender: 'bot', text: data.message});
                        this.scrollToBottom();
                    });

                    this.userInput = '';
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        const chatMessages = document.getElementById('chat-messages');
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    });
                }
            }
        }
    </script>
</body>
</html>

