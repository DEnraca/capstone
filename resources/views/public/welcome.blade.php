<x-layouts.custom>

    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <style>
            @keyframes slide {
                0% {
                    transform: translateX(0%);
                }

                100% {
                    transform: translateX(-100%);
                }
            }

            .animate-slide {
                display: flex;
                animation: slide 20s linear infinite;
            }

            .animate-slide:hover {
                animation-play-state: paused;
            }
        </style>
        <div class="font-sans text-gray-800 bg-white">
            <!-- Hero Section -->
            <section class="relative min-h-[400px] md:min-h-[450px] lg:min-h-[660px] bg-white">
                <div>
                    <!-- Background Image -->
                    <img src="{{ asset('images/frontend_asset/hospitalfront.jpg') }}" alt="ABR Diagnostics Center"
                        class="absolute inset-0 w-full h-full object-cover object-center" />

                    <!-- Centered Overlay -->
                    <div class="absolute inset-0">
                        <div
                            class="w-full h-full flex justify-center md:justify-end items-center
                                    bg-slate-900/80 sm:[background:linear-gradient(to_right,rgba(15,23,42,0.35)_15%,transparent_45%,rgba(15,23,42,0.9)_100%)]">
                            <!-- Headings -->
                            <div
                                class="text-white max-w-full sm:max-w-xl md:max-w-3xl flex flex-col justify-center space-y-2">
                                <div class="sm:space-y-2 px-4 sm:px-6 py-2 sm:py-4 text-center md:text-start">
                                    <h5 class="text-sm sm:text-sm md:text-lg font-semibold">
                                        Your path to
                                    </h5>
                                    <h1 class="text-3xl sm:text-2xl md:text-3xl font-bold uppercase text-amber-400">
                                        BETTER HEALTH
                                    </h1>
                                    <h5 class="text-xs sm:text-sm md:text-lg font-semibold">
                                        Start here, with
                                    </h5>
                                    <h1 class="text-lg sm:text-2xl md:text-3xl font-bold uppercase text-amber-400">
                                        INNOVATIVE DIAGNOSTIC
                                    </h1>
                                    <h5 class="text-xs sm:text-sm md:text-lg font-semibold">
                                        and Exceptional care
                                    </h5>
                                </div>
                                <!-- Check Items -->
                                <div class="flex flex-col gap-2 px-4 sm:px-6 text-center md:text-start">
                                    <!-- Item 1 -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="hidden sm:block w-3 sm:w-6 h-3 sm:h-6 text-amber-400" fill="none"
                                            stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                        <p class="font-semibold text-sm sm:text-base">
                                            HMO Available
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col gap-1 px-4 sm:px-7 text-amber-400 font-semibold text-xs sm:text-sm md:text-base">
                                        <p>Medicard, Cocolife, Philcare</p>
                                        <p>Intellicare & Avega</p>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="hidden sm:block sm:w-6 h-5 sm:h-6 text-amber-400" fill="none"
                                            stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                        <p class="font-semibold text-sm sm:text-base">
                                            64 Slice CT Scan
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Navbar -->
                <header
                    class="fixed top-0 w-full flex items-center justify-between px-6 py-2 text-white z-50 bg-white/10 backdrop-blur-md border-b border-white/20">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 sm:h-12 w-auto" />

                    </div>

                    <!-- Desktop Menu -->
                    <nav class="hidden md:flex space-x-8 text-sm flex items-center">
                        <a href="#hero" class="hover:text-amber-400 transition">Home</a>
                        <a href="#about-us" class="hover:text-amber-400 transition">About Us</a>
                        <a href="#patient-care" class="hover:text-amber-400 transition">Patient Care</a>
                    </nav>

                    <!-- Desktop Buttons -->
                    <div class="hidden md:flex space-x-2">
                        <a href="{{ route('livewire-appointment') }}" target="_blank"
                            class="text-sm text-amber-400 border border-slate-300 py-1 px-4 rounded hover:bg-amber-400 hover:text-white transition">
                            Create an appointment
                        </a>
                        <a href="{{ route('filament.admin.auth.login') }}"
                            class="text-sm bg-amber-400 px-4 py-1 rounded text-white hover:bg-amber-500 transition">
                            Log in
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="menu-btn" class="md:hidden focus:outline-none p-2 rounded hover:bg-white/20">
                        <!-- Open Icon -->
                        <svg id="icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close Icon -->
                        <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </header>

                <!-- Mobile Menu -->
                <nav id="mobile-menu"
                    class="fixed text-primary-300 top-[62px] left-0 w-full bg-white/30 backdrop-blur-xl border-b border-white/20 text-white hidden flex-col px-6 py-8 z-40 md:hidden shadow-lg space-y-4 text-center text-sm uppercase">
                    <a href="#hero"
                        class="block py-2 font-medium tracking-wide hover:text-amber-300 transition">Home</a>
                    <a href="#about-us"
                        class="block py-2 font-medium tracking-wide hover:text-amber-300 transition">About Us</a>
                    <a href="#patient-care"
                        class="block py-2 font-medium tracking-wide hover:text-amber-300 transition">Patient Care</a>
                    <div class="flex flex-col pt-4 border-t border-white/20 space-y-2">
                        <a href="{{ route('livewire-appointment') }}" target="_blank"
                            class="w-full bg-amber-600 py-2.5 rounded-lg text-white font-semibold shadow-md">
                            Create Appointment
                        </a>
                        <a href="{{ route('filament.admin.auth.login') }}"
                            class="w-full bg-amber-400 py-2.5 rounded-lg text-white font-semibold shadow-md">
                            Log In
                        </a>
                    </div>
                </nav>
            </section>

            <!-- Divider -->
            <div
                class="bg-amber-400 uppercase text-[10px] sm:text-xs md:text-sm text-center px-2 py-1 text-white leading-snug whitespace-normal">
                <p>
                    Need help?
                    <span class="font-semibold">ABR Hotline: 0935-575-1649</span>
                    (Tavera St. Pakil, Laguna) | Clinic Hours: 6:00pm daily.
                </p>
            </div>
            <h3 class="text-center capitalize my-6 text-2xl sm:text-3xl font-bold">
                Our diagnostic services
            </h3>

            <!-- main -->

            <main class="space-y-6 my-2">
                <!-- carousel card content -->
                <div id="about-us" class="relative w-full overflow-hidden">
                    <!-- LEFT side shadow (white fade to right) -->
                    <div class="pointer-events-none absolute inset-y-0 left-0 w-24 sm:w-36 z-20"
                        style="background: linear-gradient(to right, rgba(255,255,255,0.9), rgba(255,255,255,0.6), transparent);">
                    </div>

                    <!-- RIGHT side shadow (white fade to left) -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 w-24 sm:w-36 z-20"
                        style="background: linear-gradient(to left, rgba(255,255,255,0.9), rgba(255,255,255,0.6), transparent);">
                    </div>

                    <!-- Slides Container -->
                    <div id="slides-container" class="flex w-full animate-slide z-10">
                        <!-- Slides will be injected here -->
                    </div>
                </div>

                <!-- Patient Care Section 1 -->
                <div class="py-10 mx-auto px-4 text-center">
                    <h2 class="text-4xl font-bold text-primary-400 mb-2 uppercase">
                        ABR Diagnostic center opc.
                    </h2>
                    <p class="text-md mb-8 text-gray-800">
                        Trust the experts in advanced outpatient medical imaging.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                    <!-- Card 1 -->
                    <div class="flex flex-col items-center p-8 space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-stethoscope mb-3">
                            <path d="M11 2v2" />
                            <path d="M5 2v2" />
                            <path d="M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1" />
                            <path d="M8 15a6 6 0 0 0 12 0v-3" />
                            <circle cx="20" cy="10" r="2" />
                        </svg>

                        <h5 class="font-semibold text-amber-400 text-sm text-center">
                            Experienced Medical Professionals
                        </h5>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed text-justify">
                            A diagnostic center relies on skilled professionals for accurate
                            tests, ensuring early detection and quality care.
                        </p>
                    </div>
                    <!-- Card 2 -->
                    <div class="flex flex-col items-center p-6 space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-heart-pulse-icon lucide-heart-pulse">
                            <path
                                d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                            <path d="M3.22 13H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27" />
                        </svg>

                        <h5 class="font-semibold text-amber-400 text-sm text-center">
                            Innovative Medical Technologies
                        </h5>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed text-justify">
                            Precise diagnostics are vital for effective treatment, and we use
                            cutting-edge technology to enhance patient outcomes.
                        </p>
                    </div>
                    <!-- card 3 -->
                    <div class="flex flex-col items-center p-6 space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-thumbs-up-icon lucide-thumbs-up">
                            <path d="M7 10v12" />
                            <path
                                d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z" />
                        </svg>

                        <h5 class="font-semibold text-amber-400 text-sm text-center">
                            Innovative Medical Technologies
                        </h5>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed text-justify">
                            Equipped with advanced technology and efficient workflows,
                            diagnostic centers deliver fast, reliable results for early
                            detection and timely treatment.
                        </p>
                    </div>
                    <!-- card 4 -->
                    <div class="flex flex-col items-center p-6 space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-archive-icon lucide-file-archive">
                            <path d="M10 12v-1" />
                            <path d="M10 18v-2" />
                            <path d="M10 7V6" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M15.5 22H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v16a2 2 0 0 0 .274 1.01" />
                            <circle cx="10" cy="20" r="2" />
                        </svg>

                        <h5 class="font-semibold text-amber-400 text-sm text-center">
                            Fast and Accurate Results
                        </h5>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed text-justify">
                            Equipped with advanced technology and efficient workflows,
                            diagnostic centers deliver fast, reliable results for early
                            detection and timely treatment.
                        </p>
                    </div>
                </div>
                <!--  Check our certified doctors! -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-3 py-3 px-6 bg-amber-400">
                    <p class="text-xs sm:text-sm text-center md:text-left uppercase font-bold text-white">
                        Do you want to make an appointment? Check our certified doctors!
                    </p>
                    <a href="{{ route('livewire-appointment') }}" target="_blank"
                        class="bg-amber-50 text-amber-400 py-2 px-6 text-xs sm:text-sm font-bold rounded-md shadow hover:bg-white transition">
                        Create an appointment
                    </a>
                </div>
                <!-- HMO Partners -->
                <div class="overflow-hidden relative w-full">
                    <!-- LEFT shadow -->
                    <div class="pointer-events-none absolute inset-y-0 left-0 w-32 sm:w-48 z-20"
                        style="background: linear-gradient(to right, rgba(255,255,255,0.95), rgba(255,255,255,0.7), rgba(255,255,255,0.3), transparent);">
                    </div>

                    <!-- RIGHT shadow -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 w-32 sm:w-48 z-20"
                        style="background: linear-gradient(to left, rgba(255,255,255,0.95), rgba(255,255,255,0.7), rgba(255,255,255,0.3), transparent);">
                    </div>

                    <!-- Carousel container -->
                    <div id="carousel" class="flex gap-4 animate-slide"></div>
                </div>


                <!-- Patient Care Section 2 -->
                <div class="px-4 py-12 max-w-7xl mx-auto">
                    <h1 class="text-2xl md:text-3xl font-bold text-center mb-10 text-gray-800">
                        DISCOVER THE SERVICES WE OFFER FOR YOUR HEALTH.
                    </h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="p-6 bg-white rounded-xl shadow transition">
                            <h5 class="text-lg font-semibold text-amber-400 mb-2">
                                Accurate Diagnostics
                            </h5>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Our advanced diagnostic technologies ensure precise and reliable
                                results, enabling early detection and effective treatment
                                planning.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="p-6 bg-white rounded-xl shadow transition">
                            <h5 class="text-lg font-semibold text-amber-400 mb-2">
                                Experienced Specialists
                            </h5>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Our team of highly skilled radiologists and laboratory experts
                                provide accurate assessments and expert consultations to guide
                                your healthcare journey.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="p-6 bg-white rounded-xl shadow transition">
                            <h5 class="text-lg font-semibold text-amber-400 mb-2">
                                Comprehensive Testing Services
                            </h5>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                We offer a wide range of medical tests, including blood work,
                                imaging, and specialized screenings, ensuring a one-stop solution
                                for your diagnostic needs.
                            </p>
                        </div>

                        <!-- Card 4 -->
                        <div class="p-6 bg-white rounded-xl shadow transition">
                            <h5 class="text-lg font-semibold text-amber-400 mb-2">
                                Affordable and Accessible Healthcare
                            </h5>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                We believe quality diagnostics should be within everyone’s reach.
                                Our services are offered at competitive prices with various
                                payment options available.
                            </p>
                        </div>

                        <!-- Card 5 -->
                        <div class="p-6 bg-white rounded-xl shadow transition">
                            <h5 class="text-lg font-semibold text-amber-400 mb-2">
                                Convenient and Fast Results
                            </h5>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Our efficient processes ensure quick turnaround times, so you can
                                receive your results faster and proceed with the necessary medical
                                care without delay.
                            </p>
                        </div>

                        <!-- Card 6 -->
                        <div class="p-6 bg-white rounded-xl shadow transition">
                            <h5 class="text-lg font-semibold text-amber-400 mb-2">
                                Patient Support
                            </h5>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Personalized assistance and guidance through every step of your
                                healthcare journey.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="py-3 px-6 bg-amber-400">
                    <h3
                        class="uppercase text-center text-white font-semibold text-xs sm:text-base md:text-lg leading-relaxed">
                        Do you want to make an appointment? Check our certified doctors! Need
                        help? <span class="font-bold">ABR HOTLINE: 0935-575-1649</span>
                        <br />
                        Clinic Hours: 6:00am – 8:00pm daily
                    </h3>
                </div>
                <!-- mission and vision -->
                <div class="px-4 py-12 max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-amber-400 mb-3">Mission</h3>
                            <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                Our mission is to provide accessible and affordable laboratory
                                tests to promote better health and well-being in the community.
                            </p>
                        </div>

                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-amber-400 mb-3">Vision</h3>
                            <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                We envision a healthier community where everyone has easy access
                                to essential diagnostic services, contributing to preventive
                                healthcare and early detection of diseases.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- iframe map -->
                <div class="w-full mx-auto">
                    <div class="relative w-full h-64 md:h-96 overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d30917.731401472854!2d121.477923!3d14.385812!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397f13560091c33%3A0x203b989f7d4bc699!2sABR%20DIAGNOSTIC%20CENTER%20OPC!5e0!3m2!1sen!2sph!4v1759372362769!5m2!1sen!2sph"
                            width="100%" height="100%" style="border: 0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="flex flex-col justify-center items-center my-6 space-y-4 px-4">
                    <!-- Title -->
                    <h1 class="text-center text-2xl sm:text-3xl md:text-4xl uppercase font-extrabold text-amber-400">
                        ABR Diagnostics Center OPC.
                    </h1>

                    <!-- Logos -->
                    <div class="flex justify-center items-center gap-3 sm:gap-6 flex-wrap">
                        <div class="w-12 sm:w-16 md:w-20 aspect-square flex items-center justify-center">
                            <!-- logo 1 -->
                            <img src="{{ asset('images/frontend_asset/doh.png') }}" alt="Logo 1"
                                class="w-full h-full object-contain" />
                        </div>
                        <div class="w-12 sm:w-16 md:w-20 aspect-square flex items-center justify-center">
                            <!-- logo 2 -->
                            <img src="{{ asset('images/frontend_asset/hmo.png') }}" alt="Logo 2"
                                class="w-full h-full object-contain" />
                        </div>
                        <div class="w-12 sm:w-16 md:w-20 aspect-square flex items-center justify-center">
                            <!-- logo 3 -->
                            <img src="{{ asset('images/frontend_asset/financial.png') }}" alt="Logo 3"
                                class="w-full h-full object-contain" />
                        </div>
                    </div>

                    <!-- Social Media -->
                    <h3 class="text-lg sm:text-xl md:text-2xl uppercase text-center font-extrabold text-amber-400">
                        Stay Connected
                    </h3>

                    <div class="flex justify-center items-center gap-6">
                        <!-- Facebook -->
                        <a target="_blank" href="https://www.facebook.com/abrlaboratory2010/" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 sm:w-10 sm:h-10 text-slate-600 hover:text-amber-400 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 sm:w-10 sm:h-10 text-slate-600 hover:text-amber-400 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </main>

            <!-- {{-- https://codepen.io/imedeli/pen/gbpryYO for logo --}} -->

            <!-- HMO Partners -->
            <!-- <section class="py-10">@include('public.hmos')</section> -->

            <!-- Footer -->
            <footer class="mt-6 py-4 bg-amber-400">
                <p class="text-center text-xs sm:text-sm md:text-base text-white px-2 leading-relaxed">
                    © 2025 ABR Diagnostics Center. All rights reserved.
                </p>
            </footer>

        </div>
        <script>
            const menuBtn = document.getElementById("menu-btn");
            const iconOpen = document.getElementById("icon-open");
            const iconClose = document.getElementById("icon-close");
            const header = document.querySelector("header");
            const h3 = document.getElementById("header-title");
            const mobileMenu = document.getElementById("mobile-menu");

            const container = document.getElementById("slides-container");

            const advertiser = document.getElementById("carousel");

            // carousel image array from card content
            const slides = [{
                    src: "{{ asset('images/frontend_asset/cardiac.jpg') }}",
                    title: "Modern Laboratory",
                    description: "Refers to anything related to the heart. A cardiac laboratory usually performs tests and procedures to evaluate heart function, such as ECG, stress tests, and cardiac imaging.",
                },
                {
                    src: "{{ asset('images/frontend_asset/ultrasound.jpg') }}",
                    title: "Expert Medical Team",
                    description: "Also known as sonography, it is an imaging method that uses high-frequency sound waves to create images of the inside of the body. It’s commonly used in pregnancy, but also for organs like the liver, kidneys, and heart.",
                },
                {
                    src: "{{ asset('images/frontend_asset/xray.jpg') }}",
                    title: "Patient Care First",
                    description: "A quick, painless imaging technique that uses radiation to view inside the body mainly bones and chest. It helps detect fractures, infections, and abnormalities like pneumonia.",
                },
                {
                    src: "{{ asset('images/frontend_asset/laboratory.jpg') }}",
                    title: "Patient Care First",
                    description: "A medical laboratory is a facility where tests are carried out on clinical specimens (like blood, urine, or tissue) to gather information about a patient's health for diagnosis, treatment, and prevention of diseases.",
                },
                {
                    src: "{{ asset('images/frontend_asset/cardiac.jpg') }}",
                    title: "Modern Laboratory",
                    description: "Refers to anything related to the heart. A cardiac laboratory usually performs tests and procedures to evaluate heart function, such as ECG, stress tests, and cardiac imaging.",
                },
                {
                    src: "{{ asset('images/frontend_asset/ultrasound.jpg') }}",
                    title: "Expert Medical Team",
                    description: "Also known as sonography, it is an imaging method that uses high-frequency sound waves to create images of the inside of the body. It’s commonly used in pregnancy, but also for organs like the liver, kidneys, and heart.",
                },
                {
                    src: "{{ asset('images/frontend_asset/xray.jpg') }}",
                    title: "Patient Care First",
                    description: "A quick, painless imaging technique that uses radiation to view inside the body mainly bones and chest. It helps detect fractures, infections, and abnormalities like pneumonia.",
                },
                {
                    src: "{{ asset('images/frontend_asset/laboratory.jpg') }}",
                    title: "Patient Care First",
                    description: "A medical laboratory is a facility where tests are carried out on clinical specimens (like blood, urine, or tissue) to gather information about a patient's health for diagnosis, treatment, and prevention of diseases.",
                },
            ];

            // HMO partnership logo
            const logos = [{
                    src: "{{ asset('images/frontend_asset/hmo1.png') }}",
                    alt: "hmo1",
                    bg: ""
                },
                {
                    src: "{{ asset('images/frontend_asset/hmo2.png') }}",
                    alt: "hmo2",
                    bg: ""
                },
                {
                    src: "{{ asset('images/frontend_asset/hmo3.png') }}",
                    alt: "hmo3",
                    bg: ""
                },
                {
                    src: "{{ asset('images/frontend_asset/hmo5.png') }}",
                    alt: "hmo5",
                    bg: ""
                },
            ];


            // hamburger toggle button - header
            menuBtn.addEventListener("click", () => {
                mobileMenu.classList.toggle("hidden");
                iconOpen.classList.toggle("hidden");
                iconClose.classList.toggle("hidden");
            });
            // displaying card content
            [...slides, ...slides].forEach((slide, index) => {
                container.innerHTML += `
					<div class="w-1/2 sm:w-1/2 md:w-1/4 lg:w-1/5 flex-shrink-0 p-2 sm:p-3">
						<div class="bg-white space-y-2 sm:space-y-4">
							<div class="aspect-[16/9] overflow-hidden">
								<img src="${slide.src}" alt="Slide ${index + 1}"
									class="w-full h-full object-cover" />
							</div>
							${
								slide.title && slide.description
									? `
                                                                                                                                                                                                                                                                                                							<div class="p-1 sm:p-2">
                                                                                                                                                                                                                                                                                                								<h4 class="text-amber-400 text-[10px] sm:text-sm uppercase font-semibold">
                                                                                                                                                                                                                                                                                                									${slide.title}
                                                                                                                                                                                                                                                                                                								</h4>
                                                                                                                                                                                                                                                                                                								<hr class="my-1 sm:my-2"/>
                                                                                                                                                                                                                                                                                                								<p class="text-[9px] sm:text-xs text-justify">
                                                                                                                                                                                                                                                                                                									${slide.description}
                                                                                                                                                                                                                                                                                                								</p>
                                                                                                                                                                                                                                                                                                							</div>`
									: ""
							}
						</div>
					</div>
				`;
            });

            window.addEventListener("scroll", () => {
                if (window.scrollY > 50) {
                    header.classList.add("bg-white", "text-black", "shadow-md");
                    header.classList.remove("bg-white/10", "text-white");
                    h3.style.textShadow = "none";
                    mobileMenu.style.color = "black";
                } else {
                    header.classList.remove("bg-white", "text-black", "shadow-md");
                    header.classList.add("bg-white/10", "text-white");
                    h3.style.textShadow = "2px 2px 4px rgba(0,0,0,0.8)";
                    mobileMenu.style.color = "white";
                }
            });

            const repeat = 10;
            for (let i = 0; i < repeat; i++) {
                logos.forEach((slide) => {
                    advertiser.innerHTML += `
				<div class="${slide.bg} w-28 sm:w-36 flex-shrink-0 p-2 flex items-center justify-center">
				<img src="${slide.src}" alt="${slide.alt}" class="w-auto h-8 sm:h-12 object-contain"/>
				</div>
				`;
                });
            }
            // display HMO partnership logo
            let scrollPos = 0;
            const speed = 4;

            function scrollLogos() {
                scrollPos += speed;
                if (scrollPos >= advertiser.scrollWidth / 2) scrollPos = 0;
                advertiser.style.transform = `translateX(-${scrollPos}px)`;
                requestAnimationFrame(scrollLogos);
            }

            scrollLogos();
        </script>

</x-layouts.custom>
