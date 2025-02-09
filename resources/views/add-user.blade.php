@section('title', 'Admin Dashboard')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inbox Management System') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-white flex justify-between items-center px-6 py-4 bg-gray-100 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">User Accounts</h2>
                    <a onclick="addUserTab()" class="cursor-pointer select-none pr-4 pl-8 py-2 bg-gray-800 hover:bg-gray-700 rounded-md text-xs uppercase text-white font-semibold">
                        <ion-icon class="text-lg absolute" style="margin-left: -25px" name="add-circle"></ion-icon>
                        Add User
                    </a>
                </div>
                <div class="px-6 py-4">
                    @foreach (['Administrator', 'Office', 'Student'] as $role)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                                {{ ucfirst($role) }} 
                                @if ($role == 'Office')
                                    Head
                                @endif
                                Accounts
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-md leading-normal">
                                            <th class="py-3 px-6 text-left">ID</th>
                                            <th class="py-3 px-6 text-left">Name</th>
                                            <th class="py-3 px-6 text-left">Email</th>
                                            <th class="py-3 px-6 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-md font-light">
                                        @foreach ($users->where('role', $role) as $user)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer" onclick="window.location.href='{{ route('users.edit', $user->id) }}'">
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->id }}</td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                                    <div class="flex items-center gap-4">
                                                        @if ($user->profile_picture)
                                                            <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}"  width="30" class="rounded-full border border-gray-400">
                                                        @else
                                                            <img class="h-8 w-8 border border-gray-400 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $user->name }}">
                                                        @endif
                                                        {{ $user->name }} 
                                                        @if ($user->name == Auth::user()->name)
                                                            (You)
                                                        @endif
                                                    </div> 
                                                                                                      
                                                </td>
                                                <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                                                <td class="py-3 px-6 text-center">
                                                    <div class="flex justify-center items-center">
                                                        <a href="#" onclick="viewUserData('{{ json_encode($user) }}')" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="#" onclick="editUserData({{ json_encode($user) }})" class="text-green-600 hover:text-green-900 mr-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </a>
                                                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="addUserTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
            <div id="formUser"  class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
                <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 border">
                    <h2 class="text-2xl font-semibold mb-6">Add New Account</h2>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                    
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                <option value="">Select Role</option>
                                <option value="Administrator">Admin</option>
                                <option value="Office">Staff</option>
                                <option value="Student">Student</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="flex items-center justify-between">
                            <x-primary-button type="submit">
                                Create Account
                            </x-primary-button>
                            <a href="#" onclick="hideAddUserTab()" class="text-gray-800 hover:text-indigo-600 font-semibold">Cancel</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

</x-app-layout>



<script>
    function addUserTab() {
        const addUserTab = document.getElementById('addUserTab');
        const formUser = document.getElementById('formUser');
        addUserTab.style.display = 'flex';
        addUserTab.classList.add('animated-pulse');
    }
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' || event.keyCode === 27) {
            hideAddUserTab();
        }
    });

    function hideAddUserTab() {
        const addUserTab = document.getElementById('addUserTab');
        const formUser = document.getElementById('formUser');
        addUserTab.classList.add('animated-vanish');
        formUser.classList.add('animated-close');

        setTimeout(() => {
            addUserTab.style.display = 'none';
            addUserTab.classList.remove('animated-pulse');
            formUser.classList.remove('animated-close');
            addUserTab.classList.remove('animated-vanish');
        }, 300);
    }    



</script>

<style>
    /* Tailwind CSS utility classes */

    .custom-shadow {
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.2);
    }

    /* Additional CSS styles */
    .animated-hover {
        transition: transform 0.2s ease-in-out;
    }

    .animated-hover:hover {
        transform: scale(1.05);
    }

    .animated-pulse {
        animation: pulse 0.3s ease-in-out;
    }

    .animated-close {
        animation: close 0.3s ease-in-out;
    }

    .animated-vanish {
        animation: vanish 0.3s ease-in-out;
    }

    .animated-pulsesss {
        animation: pulsesss 0.2s ease-in-out;
    }

    .animated-closesss {
        animation: closesss 0.2s ease-in-out;
    }

    .animated-vanishsss {
        animation: vanishsss 0.2s ease-in-out;
    }

    @keyframes showUp {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% {
            opacity: 0;
            scale: 0.7;
        }
        50% {
            scale: 1.1;
        }
        100% {
            opacity: 1;
            scale: 1;
        }
    }

    @keyframes close {
        0% {
            scale: 1;
            opacity: 1;
        }
        50% {
            scale: 1.1;
            opacity: 1;
        }
        100% {
            scale: 0.7;
            opacity: 0;
        }
    }

    @keyframes vanish {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    @keyframes pulsesss {
        0% {
            opacity: 0;
            scale: 0.95;
        }
        100% {
            opacity: 1;
            scale: 1;
        }
    }

    @keyframes closesss {
        0% {
            scale: 1;
            opacity: 1;
        }
        100% {
            scale: 0.9;
            opacity: 0;
        }
    }

    @keyframes vanishsss {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

</style>

