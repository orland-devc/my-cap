<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniTicket - University Support System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #e0f2fe, #dbeafe, #ede9fe);
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
        }
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white shadow-md fixed w-full z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                {{-- <svg class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                </svg> --}}
                <img src="{{ asset('images/PSU logo.png') }}" alt="" class="h-10 w-10 mr-2 rounded-full border border-white">
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="#home" class="hover:text-blue-200 transition duration-300">Home</a></li>
                    <li><a href="#services" class="hover:text-blue-200 transition duration-300">Services</a></li>
                    <li><a href="#how-it-works" class="hover:text-blue-200 transition duration-300">How It Works</a></li>
                    <li><a href="#contact" class="hover:text-blue-200 transition duration-300">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="">
        <section id="home" class="gradient-bg min-h-screen flex items-center mx-auto relative">
            <div class="container w-1/2 mx-auto px-4 text-center text-white" style="z-index: 40">
                <h2 class="text-5xl font-bold mb-6 fade-in">Welcome to UniTicket</h2>
                {{-- <p class="text-xl mb-8 fade-in">Your one-stop solution for all university-related inquiries and concerns</p> --}}
                <p class="text-xl mb-8 fade-in">Streamline inquiries and enhance responsiveness with our advanced Inbox Management System featuring Chatbot Integration.</p>

                @if (Route::has('login'))
                    @auth
                        <a href="login" class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition duration-200 inline-block fade-in">Get Started</a>
                    @else
                        <a href="login" class="bg-blue-600 text-white mr-4 px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition duration-200 inline-block fade-in">Login</a>
                        <a href="register" class="bg-white text-gray-800 px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-200 transition duration-200 inline-block fade-in">Sign Up</a>
                    @endauth
                    
                @endif
            </div>
        
            <div class="top-0 fade-in absolute min-h-screen w-full">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <img src="{{ asset('images/students3.png') }}" alt="University students using UniTicket" class="h-screen w-full shadow-lg object-cover">
            </div>
        </section>        

        <section id="services" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12">Our Services</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-blue-50 p-8 rounded-lg shadow-md">
                        <i class="fas fa-ticket-alt text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-2xl font-semibold mb-4">Ticket System</h4>
                        <p class="mb-4">Submit and track tickets for any school-related questions or concerns. Our dedicated team is here to help you.</p>
                        <ul class="list-disc list-inside mb-4">
                            <li>24/7 ticket submission</li>
                            <li>Real-time status updates</li>
                            <li>Priority handling for urgent issues</li>
                        </ul>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-300">Learn More &rarr;</a>
                    </div>
                    <div class="bg-blue-50 p-8 rounded-lg shadow-md">
                        <i class="fas fa-robot text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-2xl font-semibold mb-4">ChatBot Assistant</h4>
                        <p class="mb-4">Get instant answers to frequently asked questions with our AI-powered chatbot. Available 24/7 for your convenience.</p>
                        <ul class="list-disc list-inside mb-4">
                            <li>Instant responses</li>
                            <li>Multi-language support</li>
                            <li>Seamless handover to human support when needed</li>
                        </ul>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-300">Try it Now &rarr;</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12">How It Works</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-white rounded-full p-6 inline-block mb-4 transform hover:scale-110 transition duration-300">
                            <i class="fas fa-user-plus text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">1. Create an Account</h4>
                        <p>Sign up with your university email to access our services.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-full p-6 inline-block mb-4 transform hover:scale-110 transition duration-300">
                            <i class="fas fa-ticket-alt text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">2. Submit a Ticket</h4>
                        <p>Describe your issue or question in detail for our team to assist you.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-full p-6 inline-block mb-4 transform hover:scale-110 transition duration-300">
                            <i class="fas fa-comments text-4xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">3. Get Help</h4>
                        <p>Receive timely responses and solutions from our dedicated support team.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-blue-600 text-white">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-3xl font-bold mb-6 fade-in">Ready to Get Started?</h3>
                <p class="text-xl mb-8 fade-in">Join thousands of students who are already using UniTicket for their university support needs.</p>
                <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300 inline-block fade-in">Sign Up Now</a>
            </div>
        </section>

        <section id="testimonials" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12 fade-in">What Our Users Say</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                        <p class="mb-4">"UniTicket has made getting help so much easier. I love how quick and efficient the system is!"</p>
                        <p class="font-semibold">- Sarah J., Computer Science Student</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                        <p class="mb-4">"The chatbot is incredibly helpful for quick questions. It's like having a personal assistant!"</p>
                        <p class="font-semibold">- Mike T., Business Administration Student</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                        <p class="mb-4">"As a faculty member, I appreciate how organized and streamlined the ticket system is. It's a game-changer!"</p>
                        <p class="font-semibold">- Dr. Emily R., Professor of Psychology</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="text-3xl font-bold text-center mb-12 fade-in">Contact Us</h3>
                <div class="max-w-lg mx-auto">
                    <form class="space-y-4 fade-in">
                        <div>
                            <label for="name" class="block mb-1">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="message" class="block mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-lg font-semibold mb-4">About UniTicket</h5>
                    <p class="text-sm">UniTicket is the leading support system for universities, providing efficient ticket management and AI-powered assistance.</p>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                    <ul class="text-sm">
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">Home</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">Services</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Contact Us</h5>
                    <ul class="text-sm">
                        <li>Email: support@uniticket.com</li>
                        <li>Phone: (123) 456-7890</li>
                        <li>Address: 123 University Ave, College Town, ST 12345</li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Follow Us</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-blue-300 transition duration-300"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-sm">
                <p>&copy; 2024 UniTicket. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Smooth scroll for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Fade-in effect for elements
            const fadeInElements = document.querySelectorAll('.fade-in');
            const fadeInObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            fadeInElements.forEach(element => {
                fadeInObserver.observe(element);
            });

            // Header opacity change on scroll
            const header = document.querySelector('header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('bg-opacity-90');
                } else {
                    header.classList.remove('bg-opacity-90');
                }
            });

            // Animated counter for statistics
            function animateValue(obj, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            const statsSection = document.querySelector('#statistics');
            const statsObserver = new IntersectionObserver((entries, observer) => {
                if (entries[0].isIntersecting) {
                    document.querySelectorAll('.stat-number').forEach(el => {
                        animateValue(el, 0, parseInt(el.innerHTML), 2000);
                    });
                    observer.unobserve(entries[0].target);
                }
            }, { threshold: 0.5 });

            if (statsSection) {
                statsObserver.observe(statsSection);
            }

            // GSAP animations
            gsap.registerPlugin(ScrollTrigger);

            gsap.from("#services .fade-in", {
                opacity: 0,
                y: 50,
                stagger: 0.2,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#services",
                    start: "top 80%",
                }
            });

            gsap.from("#how-it-works .fade-in", {
                opacity: 0,
                y: 50,
                stagger: 0.2,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#how-it-works",
                    start: "top 80%",
                }
            });

            // Chatbot toggle
            const chatbotToggle = document.querySelector('#chatbot-toggle');
            const chatbotWindow = document.querySelector('#chatbot-window');

            if (chatbotToggle && chatbotWindow) {
                chatbotToggle.addEventListener('click', () => {
                    chatbotWindow.classList.toggle('hidden');
                });
            }

            // Form submission handling
            const contactForm = document.querySelector('#contact form');
            if (contactForm) {
                contactForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    // Here you would typically send the form data to your server
                    alert('Thank you for your message! We will get back to you soon.');
                    contactForm.reset();
                });
            }
        });
    </script>
</body>
</html>