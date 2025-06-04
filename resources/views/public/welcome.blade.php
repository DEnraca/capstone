<x-layouts.custom>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    <style>
        *{
            font-family: "Fira Sans", sans-serif;
            font-weight: 1000;
            font-style:normal;
        }
        html {
            scroll-behavior: smooth;
            /* color: #557ca8 */


        }
        .herosection {
            background-image: url('{{asset('images/frontend_asset/hospitalfront.jpg')}}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            align-items: center;
            justify-content: center;
        }

        .roboto-<uniquifier> {
        font-family: "Roboto", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "wdth" 100;
        }

        .google-map {
            padding-bottom: 30%;
            position: relative;
        }

        .google-map iframe {
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            position: absolute;
        }



    </style>
    <div style="background-color: #FBFEE1;" class="max-w-screen" class="roboto">
        <!-- Hero Section -->
        <section id="hero" class="bg-cover bg-center herosection h-[70vh] xs:h-[45vh] text-info-100 " >
            <!-- Navbar -->
            <header class="relative sticky top-0 left-0 w-full backdrop-blur-md bg-[#557ca8]/30 shadow md:h-[18%]">
                <div class="px-10 py-0 flex items-center justify-between md:grid md:grid-cols-3 text-xl h-full">
                    <div class="col-span-1">
                        <img src="{{asset('images/logo-light-text.png')}}" height="auto" class="max-h-full" >
                    </div>
                    <div class="col-span-2 justify-items-end">
                        <nav class="hidden md:flex space-x-6 pt-2">
                            <a href="#hero" class="hover:text-primary-400 pt-1 pr-3">Home</a>
                            <a href="#services" class="hover:text-primary-400 pt-1 pr-3">About Us</a>
                            <a href="#mission" class="hover:text-primary-400 pt-1 pr-3" >Patient Care</a>
                            <a href="{{route('filament.admin.auth.login')}}" class="bg-primary-400 font-bold  px-5 pt-1 border border-secondary rounded-lg hover:text-primary-600">Login</a>
                        </nav>

                        <button class="md:hidden focus:outline-none" onclick="toggleMenu()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
                    <a href="#hero" class="block py-2 hover:text-primary-400">Home</a>
                    <a href="#services" class="block py-2 hover:text-primary-400">About Us</a>
                    <a href="#mission" class="block py-2 hover:text-primary-400">Patient Care</a>
                    <a href="#footer" class="block py-2 hover:text-primary-400">Login</a>
                </div>
            </header>

            <div class="grid md:grid-cols-5 gap-4 mx-auto h-[82%] pl-4">
                <div class="md:col-span-3">
                </div>

                <div class="md:col-span-2 sm:col-span-5 flex flex-col justify-center bg-[#000000]  bg-opacity-50 p-4 rounded-lg px-auto">
                    <p class="text-md ">Your Path to</p>
                    <h1 class="text-4xl font-bold text-primary-400">BETTER HEALTH</h1>

                    <p class="text-md ">Start here, with</p>
                    <h1 class="text-4xl font-bold text-primary-400">INNOVATIVE DIAGNOSTIC</h1>
                    <p class="text-md ">and Exceptional care</p>

                    <div class="text-sm pt-4">
                        <p class="flex"><x-fas-check-circle class="w-5 h-5 text-primary-500 mr-2"/>HMO Available</p>
                        <p class="text-primary-400"> <span class="pr-7 "></span> Medicard, Cocolife, Philcare</p>
                        <p class="text-primary-400"> <span class="pr-7"></span> Intellicare & Avega</p>
                        <p class="flex"><x-fas-check-circle class="w-5 h-5 text-primary-500 mr-2"/>64 Slice CT Scan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Divider -->
        <div class="m-0 bg-primary-400 text-shadow-lg text-lg text-white font-bold text-center uppercase py-2 [text-shadow:_1px_3px_rgb(0_0_1_/_0.2)]">
          <span >need help? abr hotline 0935-575-1649 (tavera st pakil laguna) clinic 6:00 am to 8:00 pm daily.  </span>
        </div>


        <section id="services" class="my-6">
            <div id="controls-carousel" class="relative overflow-hidden w-full h-auto bg-transparent px-12" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative rounded-lg h-96">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 bg-transparent ease-out-in grid grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-3" data-carousel-item="active">
                        <div class="p-2 rounded max-h-full col-span-1">
                            <img src="{{asset('images/frontend_asset/laboratory.jpg')}}" class="object-contain w-full h-auto max-h-40  rounded-xl">
                            <h3 class="mt-4 text-2xl font-bold text-primary-400 border-b-2 border-[#000000] py-3">CARDIAC</h3>
                            <p class="text-sm mt-2">Refers to anything related to the heart. A cardiac laboratory usually performs tests and procedures to evaluate heart function, such as ECG, stress tests, and cardiac imaging.</p>
                        </div>
                        <div class="p-2 rounded max-h-full col-span-1">
                            <img src="{{asset('images/frontend_asset/laboratory.jpg')}}" class="object-contain w-full h-auto max-h-40  rounded-xl">
                            <h3 class="mt-4 text-2xl font-bold text-primary-400 border-b-2 border-[#000000] py-3">LABORATORY</h3>
                            <p class="text-sm mt-2">A medical laboratory is a facility where tests are carried out on clinical specimens (like blood, urine, or tissue) to gather information about a patient's health for diagnosis, treatment, and prevention of diseases.</p>
                        </div>

                        <div class="p-2 rounded max-h-full col-span-1">
                            <img src="{{asset('images/frontend_asset/laboratory.jpg')}}" class="object-contain w-full h-auto max-h-40 rounded-xl">
                            <h3 class="mt-4 text-2xl font-bold text-primary-400 border-b-2 border-[#000000] py-3">ULTRA-SOUND</h3>
                            <p class="text-sm mt-2">Also known as sonography, it is an imaging method that uses high-frequency sound waves to create images of the inside of the body. It’s commonly used in pregnancy, but also for organs like the liver, kidneys, and heart.</p>
                        </div>
                    </div>
                    <!-- Item 1 -->
                    <div class="hidden duration-700 bg-transparent ease-out-in grid grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-2 p-3" data-carousel-item>
                        <div class="p-2 rounded max-h-full col-span-1">
                            <img src="{{asset('images/frontend_asset/laboratory.jpg')}}" class="object-contain w-full h-auto max-h-40  rounded-xl">
                            <h3 class="mt-4 text-2xl font-bold text-primary-400 border-b-2 border-[#000000] py-3">X-RAY</h3>
                            <p class="text-sm mt-2">Refers to anything related to the heart. A cardiac laboratory usually performs tests and procedures to evaluate heart function, such as ECG, stress tests, and cardiac imaging.</p>
                        </div>

                        <div class="p-2 rounded max-h-full col-span-1">
                            <img src="{{asset('images/frontend_asset/laboratory.jpg')}}" class="object-contain w-full h-auto max-h-40  rounded-xl">
                            <h3 class="mt-4 text-2xl font-bold text-primary-400 border-b-2 border-[#000000] py-3">LABORATORY</h3>
                            <p class="text-sm mt-2">A medical laboratory is a facility where tests are carried out on clinical specimens (like blood, urine, or tissue) to gather information about a patient's health for diagnosis, treatment, and prevention of diseases.</p>
                        </div>
                    </div>
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-0 left-1/2 ">
                    <button type="button" class="w-3 h-3 bg-primary-400 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 bg-primary-400 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                </div>
                <!-- Slider controls -->
                <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-primary-400 dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-primary-400 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </section>


    {{-- https://codepen.io/imedeli/pen/gbpryYO for logo --}}



        <!-- Patient Care Section 1 -->
        <div class="py-10 mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-primary-400 mb-2 uppercase">ABR Diagnostic center opc.</h2>
            <p class="text-md mb-8">Trust the experts in advanced outpatient medical imaging.</p>
        </div>

        <section class="py-8">
          <div class="max-w-5xl mx-auto text-center">
            <div class="grid md:grid-cols-4 gap-8 text-center">
              <div>
                <div class="justify-items-center mb-2">
                    <x-fas-stethoscope class="w-10 h-10"> </x-fas-stethoscope>
                </div>
                <h4 class="font-bold text-lg text-primary-400">Experienced Medical Professionals</h4>
                <p class="text-sm pt-1">A diagnostic center relies on skilled professionals for accurate tests, ensuring early detection and quality care.</p>
              </div>
              <div>
                <div class="justify-items-center mb-2">
                    <x-fas-heartbeat class="w-10 h-10"> </x-fas-heartbeat>
                </div>
                <h4 class="font-bold text-lg text-primary-400">Innovative Medical Technologies</h4>
                <p class="text-sm pt-1">Precise diagnostics are vital for effective treatment, and we use cutting-edge technology to enhance patient outcomes.</p>
              </div>
              <div>
                <div class="justify-items-center mb-2">
                    <x-fas-thumbs-up class="w-10 h-10"> </x-fas-thumbs-up>
                </div>
                <h4 class="font-bold text-lg text-primary-400">Innovative Medical Technologies
                </h4>
                <p class="text-sm pt-1">Equipped with advanced technology and efficient workflows, diagnostic centers deliver fast, reliable results for early detection and timely treatment.</p>
              </div>
              <div>
                <div class="justify-items-center mb-3">
                    <x-fas-file-zipper class="w-10 h-10"> </x-fas-file-zipper>
                </div>
                <h4 class="font-bold text-lg text-primary-400">Fast and Accurate Results</h4>
                <p class="text-sm pt-1">Equipped with advanced technology and efficient workflows, diagnostic centers deliver fast, reliable results for early detection and timely treatment.</p>
              </div>

            </div>
          </div>
        </section>
        <section>
            <div class="m-0 bg-primary-400 text-lg text-white font-bold text-center uppercase py-4  grid grid-cols-4">
                <span class="col-span-3 text-xl [text-shadow:_1px_3px_rgb(0_0_1_/_0.2)]">Do you want to make an appointment ? check our certified doctors! </span>
                <span class="col-span-1">
                    <a href="{{route('filament.admin.auth.login')}}" class="bg-primary-100 font-bold  px-5 py-3 rounded-lg text-primary-400 hover:bg-primary-500 hover:text-primary-400 uppercase">create an appointment</a>
                </span>
            </div>
        </section>

        <!-- HMO Partners -->
        <section class="py-10">
          <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-primary-400 mb-4">Our Health Medical Orgranization (HMO) Partners</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
              <img src="https://picsum.photos/100?random=1" alt="Partner 1" class="mx-auto h-16" />
              <img src="https://picsum.photos/100?random=2" alt="Partner 2" class="mx-auto h-16" />
              <img src="https://picsum.photos/100?random=3" alt="Partner 3" class="mx-auto h-16" />
              <img src="https://picsum.photos/100?random=4" alt="Partner 4" class="mx-auto h-16" />
            </div>
          </div>
        </section>

        <!-- Patient Care Section 2 -->
        <section class="py-12">
          <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-primary-400 mb-2">DISCOVER THE SERVICES WE OFFER FOR YOUR HEALTH.</h2>
            <div class="grid grid-cols-1 text-center sm:grid-cols-2 md:grid-cols-3 gap-6 text-left">
              <div class="p-4">
                <h4 class="font-bold text-primary-400">Accurate Diagnostics</h4>
                <p class="text-sm mt-2">Our advanced diagnostic technologies ensure precise and reliable results, enabling early detection and effective treatment planning.</p>
              </div>
              <div class="p-4">
                <h4 class="font-bold text-primary-400">Experienced Specialists</h4>
                <p class="text-sm mt-2">Our team of highly skilled radiologists and laboratory experts provide accurate assessments and expert consultations to guide your healthcare journey.</p>
              </div>
              <div class="p-4">
                <h4 class="font-bold text-primary-400">Comprehensive Testing Services</h4>
                <p class="text-sm mt-2">We offer a wide range of medical tests, including blood work, imaging, and specialized screenings, ensuring a one-stop solution for your diagnostic needs.</p>
              </div>
              <!-- Repeat cards to fill 3x3 grid -->
              <div class="p-4">
                <h4 class="font-bold text-primary-400">State-of-the-Art Equipment</h4>
                <p class="text-sm mt-2">We invest in the latest medical technology to deliver high-quality diagnostic services with speed and accuracy.</p>
              </div>
              <div class="p-4">
                <h4 class="font-bold text-primary-400">Affordable and Accessible Healthcare</h4>
                <p class="text-sm mt-2">We believe quality diagnostics should be within everyone’s reach. Our services are offered at competitive prices with various payment options available.</p>
              </div>
              <div class="p-4">
                <h4 class="font-bold text-primary-400">Convenient and Fast Results</h4>
                <p class="text-sm mt-2">Our efficient processes ensure quick turnaround times, so you can receive your results faster and proceed with the necessary medical care without delay.</p>
              </div>
            </div>
          </div>
        </section>

         <!-- Divider -->
         <div class="m-0 bg-primary-400 text-md text-white font-bold text-center uppercase py-1 [text-shadow:_1px_3px_rgb(0_0_1_/_0.2)]">
            <span >Do you want to make an appointment? Check our certified doctors!  Need help? ABR HOTLINE NUMBERS  0935-575-1649 Clinic Hours: 6:00am to 6:00pm daily.</span>
        </div>



        <!-- Mission and Vision -->
        <section id="mission" class="py-6">
            <div class="mx-auto text-center grid grid-cols-2 px-10 gap-6">
                <div class="col-span-1 ">
                    <h2 class="text-xl font-bold text-primary-400 mb-3 ">Mission</h2>
                    <p class="text-sm mt-2 mb-8">Our mission is to provide accessible and affordable laboratory test to promote better health and well-being in the community.</p>
                </div>
                <div class="col-span-1">
                    <h2 class="text-xl font-bold text-primary-400 mb-3">Vision</h2>
                    <p class="text-sm mt-2">We envision a healthier community where everyone has easy access to essential diagnostic services, contributing to preventive healthcare and early detection of diseases.</p>
                </div>
            </div> <br>

            <div class="h-48 google-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.7164340754807!2d121.47534797515954!3d14.385811486075482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397f13560091c33%3A0x203b989f7d4bc699!2sABR%20DIAGNOSTIC%20CENTER%20OPC!5e0!3m2!1sen!2sph!4v1749023854904!5m2!1sen!2sph" width="100%" height="100" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>

        <!-- Footer -->
        <footer id="footer" class="text-sm">
            <div class="max-w-6xl mx-auto px-4 py-8 text-primary-400">
                <h4 class="text-4xl mb-2 uppercase text-center" style="font-weight: 900;">ABR Diagnostics center opc.</h4>
                <div class="flex justify-center gap-3">
                    <div class="h-12 w-10">
                        <img src="{{asset('images/frontend_asset/doh.png')}}" alt="Doh Logo" class="h-full w-full object-contain">
                    </div>
                    <div class="h-12 w-10">
                        <img src="{{asset('images/frontend_asset/hmo.png')}}" alt="Doh Logo" class="h-full w-full object-contain">
                    </div>
                    <div class="h-12 w-10">
                        <img src="{{asset('images/frontend_asset/financial.png')}}" alt="Doh Logo" class="h-full w-full object-contain">
                    </div>
                </div>

                <div class="mt-3 pt-2">
                    <h5 class="uppercase text-lg text-center" style="font-weight: 900">stay connected</h5>
                    <div class="flex justify-center gap-4">
                        <a href="">
                            <x-fab-facebook class="h-12 w-10 text-gray-400">

                            </x-fab-facebook>
                        </a>
                        <a href="">
                            <x-fab-instagram class="h-12 w-10 text-gray-400">

                            </x-fab-instagram>
                        </a>

                    </div>

                </div>

            </div>
            <div class="text-center py-2 bg-primary-400 text-white text-md">&copy; 2025 ABR Diagnostics Center. All rights reserved.</div>
        </footer>

    </div>
    <script>
        function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        }
    </script>

</x-layouts.custom>

