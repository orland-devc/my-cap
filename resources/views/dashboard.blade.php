@section('title', 'Main Menu')

<x-users-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Main Menu') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Quick Actions</h3>
                        <div class="text-center text-blue-500 m-0" style="font-size: 150px">
                            <ion-icon name="ticket" class="absolute text-purple-800 m-0" style="transform:translate(0%, 15%)"></ion-icon>
                            <ion-icon name="ticket" class="m-0"></ion-icon>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" onclick="showPostTab()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                                Submit Ticket
                            </a>
                            <a href="my-tickets" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                                View Tickets
                            </a>
                            <!-- Add more quick actions as needed -->
                        </div>
                    </div>
                </div>

                <!-- Chatbot -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Ask the Chatbot</h3>
                        <div class="flex justify-center items-center mb-10">
                            <img src="{{ asset('images/bot.png') }}" alt="Chatbot" style="height: 170px">
                        </div>
                        <a href="chatbot" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Start Chat
                        </a>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Notifications</h3>
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <a href="#" class="block hover:bg-gray-100 transition-colors duration-200 rounded-lg px-4 py-2">
                                    New Announcement: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </a>
                            </li>
                            <li class="py-3">
                                <a href="#" class="block hover:bg-gray-100 transition-colors duration-200 rounded-lg px-4 py-2">
                                    Ticket Update: Ticket #123 has been resolved.
                                </a>
                            </li>
                            <!-- Add more notifications as needed -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-users-layout>
