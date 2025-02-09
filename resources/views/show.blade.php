@section('title', 'Ticket ID ' . $ticket->id)

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center justify-between">
            <div class="flex">
                <a href="http://127.0.0.1:8000/tickets" class="hover:bg-blue-100 flex items-center justify-center h-10 w-10 rounded-full" style="transform:translateX(-30%)">
                    <h2 class="font-semibold text-xl text-gray-800">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </h2>
                </a>
                <div class="flex items-center gap-4">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Ticket ID {{ $ticket->id }}
                        {{-- <ion-icon name="ticket" class=""></ion-icon> --}}
                    </h2>
                    @if ( $ticket->level == 'normal' )
                        <p class="capitalize px-4 py-2 rounded-full bg-green-200 text-green-500 font-semibold text-sm">
                    @elseif ( $ticket->level == 'important' )
                        <p class="capitalize px-4 py-2 rounded-full bg-yellow-200 text-yellow-500 font-semibold text-sm">
                    @else 
                        <p class="uppercase px-4 py-2 rounded-full bg-red-200 text-red-600 font-semibold text-sm">
                    @endif
                        {{ $ticket->level }}
                    </p>
                    {{-- <span class="ml-5 mt-2 text-sm text-gray-400">{{ $ticket->created_at->format('M d, Y g:i A') }}</span> --}}
                </div>
            </div>
            <div class="ml-5">
                @include('_updates')
            </div>
        </div>
        
    </x-slot>
    

    <div class="max-w-screen flex p-3 custom-bg h-[90vh]">
        <div class="bg-white border border-2 shadow-lg rounded-lg mr-2 w-1/4 min-w-72 border">
            <div class="flex items-center text-2xl m-auto py-4 px-6">
                <h2 class="text-xl font-semibold text-gray-800 text-center">
                    {{ $ticket->category }}
                    <ion-icon name="ticket" class="mr-2 text-gray-400" style="margin-top: -5px;"></ion-icon>
                </h2>
            </div>
            <hr class="border">
            <style>
                .ticket-content {
                    scrollbar-width: thin; /* "auto" hides scrollbar in Firefox */
                    scrollbar-color: #4a5568 #edf2f7; /* thumb color and track color */
                }

                .ticket-content::-webkit-scrollbar {
                    width: 12px; /* width of the scrollbar */
                }

                /* Customize the scrollbar thumb */
                .ticket-content::-webkit-scrollbar-thumb {
                    background-color: #667896; /* color of the thumb */
                    border-radius: 6px; /* rounded corners */
                }

                /* Change scrollbar thumb on hover */
                .ticket-content::-webkit-scrollbar-thumb:hover {
                    background-color: #2d3748; /* darker color on hover */
                }

                /* Customize the scrollbar track (optional) */
                .ticket-content::-webkit-scrollbar-track {
                    background-color: #edf2f7; /* color of the track */
                }
            </style>

            <div class="py-4 px-6 overflow-y-auto ticket-content h-[78vh]">
                <div class="mb-4">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset($ticket->user->profile_picture) }}" alt="" class="h-10 w-10 rounded-full">
                        <div class="">
                            <p class="text-gray-400">{{ $ticket->user->name }}</p>
                            <p class="text-gray-400 text-xs">{{ $ticket->created_at->format('M d, Y g:i A') }}</p>
                        </div>    
                    </div>                
                    @if ($ticket->assigned_to)
                        {{-- <span class="text-gray-400">Assigned to</span> --}}
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($ticket->ticket->profile_picture) }}" alt="" class="h-10 w-10 rounded-full">
                            <p class="text-gray-400">{{ $ticket->ticket->name }} (assigned)</p>
                        </div>
                    @endif
                </div>
                
                <hr style="border: 1px dashed #ccc;">

                <div class="mb-6">
                    <div class="flex items-center my-3">
                        {{-- <ion-icon name="document-text-outline" class="text-3xl text-blue-500 mr-4"></ion-icon> --}}
                        <h4 class="text-lg font-semibold text-gray-800">{{ $ticket->subject }}</h4>
                    </div>
                    @php
                        $plainContent = $ticket->content; // Get the raw content
                        $singleLineContent = preg_replace('/\r\n|\r|\n/', ' ', $plainContent); // Remove newlines and replace with a space
                        $contentLength = Str::length($plainContent); // Get the plain content length
                        $partialContent = Str::limit($singleLineContent, 70, ' . . .'); // Limit the single-line content to 70 characters
                    @endphp
                    
                    <div class="mb-4">
                        <!-- Display the partial content with nl2br applied -->
                        <p class="text-gray-600" id="partialContent">{{$partialContent}}</p>
                        
                        <!-- Display the full content, hidden by default -->
                        <p class="text-gray-600 hidden" id="fullContent">{!! nl2br(e($plainContent)) !!}</p>
                        
                        @if ($contentLength > 70 || strpos($plainContent, "\n") !== false)
                            <a href="#" id="readMore" class="text-blue-500 flex items-center mt-0 font-semibold">
                                Read more &nbsp;
                                <ion-icon name="arrow-forward"></ion-icon>
                            </a>
                        @endif
                    
                        <a href="#" id="readLess" class="text-blue-500 flex items-center mt-0 font-semibold hidden">
                            Read less &nbsp;
                            <ion-icon name="arrow-back"></ion-icon>
                        </a>
                    </div>
                

                    <style>
                        .side-header {
                            display: none;
                        }
                        .reveal {
                            animation: slideDown 0.3s ease-in-out;
                        }
                        @keyframes slideDown {
                            0% {
                                max-height: 0;
                                opacity: 0;
                            }
                            100% {
                                max-height: 500px; /* Set to a larger value than the expected full content height */
                                opacity: 1;
                            }
                        }

                        .hideUp {
                            animation: slideUp 0.3s ease-in-out;
                        }
                        @keyframes slideUp {
                            0% {
                                max-height: 500px;
                                opacity: 0;
                            }
                            100% {
                                max-height: 0; /* Set to a larger value than the expected full content height */
                                opacity: 1;
                            }
                        }
                    </style>

                    <script>
                        document.getElementById('readMore').addEventListener('click', function(event) {
                            event.preventDefault();
                            document.getElementById('partialContent').classList.add('hidden');
                            document.getElementById('fullContent').classList.remove('hidden');
                            document.getElementById('fullContent').classList.remove('hideUp');
                            setTimeout(function() {
                                document.getElementById('fullContent').classList.add('reveal');
                            }, 10); // Delay the addition of the 'reveal' class
                            document.getElementById('readMore').classList.add('hidden');
                            document.getElementById('readLess').classList.remove('hidden');
                        });

                        document.getElementById('readLess').addEventListener('click', function(event) {
                            event.preventDefault();
                            document.getElementById('partialContent').classList.remove('hidden');
                            document.getElementById('fullContent').classList.add('hidden');
                            document.getElementById('fullContent').classList.remove('reveal');
                            setTimeout(function() {
                                document.getElementById('fullContent').classList.add('hideUp');
                            }, 10); // Delay the addition of the 'reveal' class
                            document.getElementById('readMore').classList.remove('hidden');
                            document.getElementById('readLess').classList.add('hidden');
                        });
                    </script>



                    

                    @if ($ticket->attachments->isNotEmpty())
                        <div class="mb-6">
                            @foreach ($ticket->attachments as $attachment)
                            @php
                                $maxLength = 20;
                                $partialFileName = Str::limit($attachment->file_name, $maxLength, '');
                                $extension = pathinfo($attachment->file_name, PATHINFO_EXTENSION);
                            
                                // Check if the file name was truncated
                                if (strlen($attachment->file_name) > $maxLength) {
                                    $partialFileName .= ' . . .' . $extension;
                                }
                            @endphp
                        
                                <a href="#" class="flex justify-between text-blue-500 rounded-md my-4 flex items-center p-3 bg-blue-100 border-2 border-blue-300 hover:bg-blue-200" onclick="viewImage('{{ asset($attachment->file_location) }}', '{{ $attachment->file_name }}', {{ $loop->index }})">
                                    <div class="flex items-center  gap-4">
                                        @if (Str::contains($attachment->file_name, '.pdf'))
                                            <img src='{{ asset("images/PDF_icon2.png") }}' alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                        @else
                                            <img src="{{ asset($attachment->file_location) }}" alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                        @endif
                                        {{ $partialFileName }}
                                    </div>
                                        
                                    <div>
                                        @if ($attachment->getSize() > 999999)
                                            <span class="text-xs text-gray-500">{{ number_format($attachment->getSize() / (1024 * 1024), 2) }} MB</span>
                                        @else
                                            <span class="text-xs text-gray-500">{{ number_format($attachment->getSize() / 1024, 0) }} KB</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                                
                            </ul>
                        </div>
                    @endif                    
                </div>

                

            </div>
        </div>

        <div class="w-3/4" style="">
            <div class="overflow-y-auto autoScroll flex flex-col h-[88vh]">
                <div>
                    @include('_replies')
                </div>

                <div id="replySection" class="hidden flex flex-start bg-white mb-4 p-6 rounded-xl border shadow-md text-gray-700 break-words">
                    <img src="{{ asset(Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="h-12 rounded-full mr-4 border border-gray-400">
                    <div class="w-full">
                        <div class="flex items-center gap-2 px-2 py-0 mt-3 mb-6 w-fit rounded-lg bg-blue-100 text-black">
                            <p class="font-bold">Reply to:</p>
                            {{ $ticket->user->name }}
                        </div>
                        <form action="{{ route('office.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" style="m-0 p-0">
                            @csrf
                            <div class="">
                                <div id="editor" contenteditable="true" class="outline-none min-h-40 appearance-none p-3 rounded-lg text-gray-700 leading-tight border border-blue-200" autofocus placeholder="Enter your reply"></div>
                                <input type="hidden" name="content" id="hiddenContent">
                
                                <div id="attachmentPreviews" class="flex flex-wrap gap-2 mt-2">
                                    <!-- Attachment previews will be inserted here -->
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-2">
                                <input type="file" id="attachmentInput" name="attachments[]" class="hidden" multiple>
                                <label for="attachmentInput" class="cursor-pointer">
                                    <ion-icon name="attach-outline" class="text-3xl text-gray-600 p-1 hover:bg-blue-200 rounded-full"></ion-icon>
                                </label>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">Submit Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        

    </div>

    <!-- View Image -->
    <div id="imageTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-90 flex items-center justify-center py-8" style="display: none; backdrop-filter: blur(5px);">
        <div id="fileName" class="text-white text-2xl flex-col items-center absolute top-10 mx-auto"></div>
        <div class="absolute text-3xl grid grid-cols-2 gap-6" style="top: 20px; right:20px">
            <a href="#" onclick="downloadImage()" class="flex items-center justify-center font-bold text-gray-300 hover:text-white hover:bg-gray-600 p-3 rounded-full w-14 h-14 transition-all duration-200">
                <i class="fa-solid fa-download text-gray-300 hover:text-white"></i>
            </a>
            <a href="#" onclick="hideimageTab()" class="flex items-center justify-center font-bold text-gray-300 hover:text-white hover:bg-gray-600 p-3 rounded-full w-14 h-14 transition-all duration-200">
                <i class="fa-regular fa-circle-xmark text-gray-300 hover:text-white"></i>
            </a>
        </div>
        @if ($ticket->attachments->count() > 1)
        <div>
            <a href="#" onclick="prevImage()" class="text-6xl text-gray-400 hover:text-white font-bold absolute" style="top: 45%; left: 20px">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            <a href="#" onclick="nextImage()" class="text-6xl text-gray-400 hover:text-white font-bold absolute" style="top: 45%; right: 20px">
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
        @endif
        <img id="imagePreview" src="" alt="" class="h-[80vh] hidden">
        <div id="otherFile" class="hidden text-white text-2xl flex-col items-center gap-8"></div>

        
    </div>

    <!-- Assign Modal -->
    <div id="assignTab" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display: none;">
        <div id="form"  class="bg-white rounded-lg shadow-lg" style="width: 400px; max-width: 90vw;">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Ticket ID {{ $ticket->id }}</h3>
                    <a href="#" onclick="hideAssignTab()" class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <ion-icon name="close-outline" class="text-2xl"></ion-icon>
                    </a>
                </div>
                <p class="mb-4 font-bold">{{ $ticket->subject }}</p>
                <form action="{{ route('tickets.assign', $ticket) }}" method="POST" class="bg-white border shadow-md rounded-lg p-6">
                    @csrf
                    <div class="mb-6">
                        <label for="assigned_to" class="block text-gray-700 font-semibold mb-2">Assign To</label>
                        <select name="assigned_to" id="assignee" class="block w-full px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                            <option value="" class="text-gray-500">Select a user</option>
                            @foreach ($officers as $user)
                                <option value="{{ $user->id }}" class="text-gray-900">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button onclick="hideAssignTabs()" type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <ion-icon name="person-add-outline" class="mr-2"></ion-icon>
                            Assign Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        let currentIndex = 0;
        const attachments = @json($ticket->attachments->pluck('file_location'));
        const fileNames = @json($ticket->attachments->pluck('file_name'));

        function viewImage(imageUrl, fileName, index, fileExtension) {
            const img = document.getElementById('imagePreview');
            const otherFile = document.getElementById('otherFile');
            const titleName = document.getElementById('fileName');
            if (fileName.endsWith('.jpg') || fileName.endsWith('.jpeg') || fileName.endsWith('.png')) {
                otherFile.classList.add('hidden');
                img.classList.remove('hidden');
                titleName.innerHTML = `<p>${fileName}</p>`;
                img.src = imageUrl;
                img.dataset.fileName = fileName;
                const imageTab = document.getElementById('imageTab');
                imageTab.style.display = "flex";
            }
            else {
                titleName.innerHTML = `<p>${fileName}</p>`;
                img.classList.add('hidden');
                otherFile.classList.remove('hidden');
                otherFile.classList.add('flex');
                const imageTab = document.getElementById('imageTab');
                imageTab.style.display = "flex";
                otherFile.innerHTML = `<p>Can't view this file. Please download it.</p><a href="${imageUrl}" class="px-4 py-2 bg-white rounded-xl text-gray-600 hover:text-blue-600" download>Download ${fileName} <i class="fa-solid fa-download ml-4"></i></a>`;
            }
            
            currentIndex = index;
        }
        function hideimageTab() {
            const img = document.getElementById('imageTab');
            img.style.display = "none";
        }

        function showReplySection() {
            const replySection = document.getElementById('replySection');

            if (replySection.classList.contains('hidden')) {
                replySection.classList.remove('hidden');
                scrollToBottom();
            } else {
                replySection.classList.add('hidden');
            }
        }

        function scrollToBottom() {
            var repliesContainer = $(".autoScroll");
            repliesContainer.scrollTop(repliesContainer[0].scrollHeight);
        }

        function showAssignTab() {
            const assignTab = document.getElementById('assignTab');
            const form = document.getElementById('form');
            assignTab.style.display = 'flex';
            assignTab.classList.add('animated-show');
            form.classList.add('animated-pulse');

            document.addEventListener('click', function(event) {
                if (!assignTab.contains(event.target) && !event.target.closest('.options')) {
                    hideAssignTab();
                }
            });
        }

        function hideAssignTab() {
            const assignTab = document.getElementById('assignTab');
            const form = document.getElementById('form');
            assignTab.classList.add('animated-vanish');
            form.classList.add('animated-close');

            setTimeout(() => {
                assignTab.style.display = 'none';
                assignTab.classList.remove('animated-pulse');
                form.classList.remove('animated-close');
                assignTab.classList.remove('animated-vanish');
            }, 300);
        }    

        function hideAssignTabs() {
            const assignTab = document.getElementById('assignTab');
            const form = document.getElementById('form');
            assignTab.classList.add('animated-vanish');
            form.classList.add('animated-close');

            setTimeout(() => {
                assignTab.style.display = 'none';
                assignTab.classList.remove('animated-pulse');
                form.classList.remove('animated-close');
                assignTab.classList.remove('animated-vanish');
            }, 300);
        }    

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                hideAssignTab();
                hideimageTab();
            }
        });

        function downloadImage() {
            const imageUrl = document.getElementById('imagePreview').src;
            const fileName = document.getElementById('imagePreview').dataset.fileName;
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function prevImage() {
            currentIndex = (currentIndex === 0) ? attachments.length - 1 : currentIndex - 1;
            const imageUrl = "{{ asset('/') }}" + attachments[currentIndex];
            const fileName = fileNames[currentIndex];
            document.getElementById('imagePreview').src = imageUrl;
            document.getElementById('imagePreview').dataset.fileName = fileName;
        }

        function nextImage() {
            currentIndex = (currentIndex === attachments.length - 1) ? 0 : currentIndex + 1;
            const imageUrl = "{{ asset('/') }}" + attachments[currentIndex];
            const fileName = fileNames[currentIndex];
            document.getElementById('imagePreview').src = imageUrl;
            document.getElementById('imagePreview').dataset.fileName = fileName;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowLeft') {
                prevImage();
            } else if (event.key === 'ArrowRight') {
                nextImage();
            }
        });

    </script>
</x-app-layout>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        function fetchReplies() {
            $.get("{{ route('office.tickets.replies', $ticket->id) }}", function(data){
                $(".replies-container").html(data);
                scrollToBottom();
            });
        }

        function fetchUpdates() {
            $.get("{{ route('office.tickets.updates', $ticket->id) }}", function(data){
                $(".top-options").html(data);
            });
        }
        
        fetchUpdates();
        setInterval(fetchUpdates, 3000);
        fetchReplies();
        setInterval(fetchReplies, 3000);
        
        let attachments = new DataTransfer();

        function updateFileInput() {
            $('#attachmentInput').val('');
            $('#attachmentInput')[0].files = attachments.files;
        }

        function updateAttachmentPreviews() {
            $('#attachmentPreviews').empty();
            Array.from(attachments.files).forEach((file, index) => {
                let preview;
                let truncatedFileName = file.name.length > 8 ? file.name.substring(0, 8) + '...' : file.name;
                if (file.type.startsWith('image/')) {
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="${URL.createObjectURL(file)}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else if (file.type === 'application/pdf') { // if PDF
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/uploads/pdf_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else if (file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') { // if DOCX
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/uploads/docx_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else if (file.type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') { // if PPTX
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/uploads/ppt_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">&times;</button>
                    `);
                } else { // For other file types
                    preview = $('<div class="relative">').html(`
                        <div class="border border-gray-700 p-2 rounded flex flex-col items-center">
                            <img src="{{ asset('images/uploads/file_icon.png') }}" class="max-w-[100px] max-h-[100px] rounded">
                            <span class="text-sm">${truncatedFileName}</span>
                        </div>
                        <button type="button" class="remove-attachment absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center" data-index="${index}">×</button>
                    `);
                }

                $('#attachmentPreviews').append(preview);
            });
        }

        function addFiles(files) {
            Array.from(files).forEach((file) => {
                attachments.items.add(file);
            });
            updateAttachmentPreviews();
            updateFileInput();
        }

        $('#attachmentInput').change(function(e) {
            addFiles(e.target.files);
        });

        $(document).on('click', '.remove-attachment', function() {
            const indexToRemove = parseInt($(this).data('index'));
            
            const newAttachments = new DataTransfer();
            Array.from(attachments.files)
                .filter((_, index) => index !== indexToRemove)
                .forEach(file => newAttachments.items.add(file));
            
            attachments = newAttachments;
            updateAttachmentPreviews();
            updateFileInput();
        });

        // Add paste event listener to the editor
        $('#editor').on('paste', function(e) {
            const clipboardData = e.originalEvent.clipboardData;
            if (!clipboardData || !clipboardData.items) return;

            const items = clipboardData.items;
            const files = [];

            for (let i = 0; i < items.length; i++) {
                if (items[i].kind === 'file') {
                    const file = items[i].getAsFile();
                    if (file) files.push(file);
                }
            }

            if (files.length > 0) {
                e.preventDefault();
                addFiles(files);
            }
        });

        $("form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            var htmlContent = $('#editor').html();

            var plainText = htmlContent
                .replace(/<div><br><\/div>/g, '\n') 
                .replace(/<div>/g, '\n') 
                .replace(/<\/div>/g, '') 
                .replace(/<br>/g, '\n') 
                .replace(/&nbsp;/g, ' ')
                .trim();

            formData.set('content', plainText);

            formData.delete('attachments[]');
            for (let file of attachments.files) {
                formData.append('attachments[]', file);
            }

            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    fetchReplies();
                    $('#editor').html(''); 
                    attachments = new DataTransfer();
                    updateAttachmentPreviews();
                    updateFileInput();
                    scrollToBottom();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        function scrollToBottom() {
            var repliesContainer = $(".autoScroll");
            repliesContainer.scrollTop(repliesContainer[0].scrollHeight);
        }

        $('#editor').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (e.originalEvent.dataTransfer.files.length) {
                $('#attachmentInput')[0].files = e.originalEvent.dataTransfer.files;
                $('#attachmentInput').trigger('change');
            }
        });

        $('#editor').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });
</script>

