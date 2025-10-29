<x-layouts.app>
    <section class="grid grid-cols-5 grid-rows-[auto_1fr_auto_auto_auto] bg-amber-100 h-screen text-center p-2">
        <div class="col-span-5 bg-amber-100 flex items-center justify-between px-6 py-2 h-[80px]">
            <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo" class="w-[600px] h-auto object-contain">
            <div>
                <p class="text-4xl font-bold" id="clock"></p>
                <p class="text-sx" id="date"></p>
            </div>
        </div>
        <div class="col-span-4 row-span-3 row-start-2 relative rounded-2xl overflow-hidden">
            <video id="video1" class="w-full h-full object-cover"
                src="{{ asset('images/frontend_asset/abr_vid.mp4') }}" autoplay muted loop playsinline></video>

            <div class="absolute bottom-0 left-0 bg-amber-100 w-64 h-16 rounded-tr-xl rounded-t-l-2xl">
                <p class="p-5 text-2xl font-bold text-slate-600">Now Serving</p>
            </div>
        </div>

        <div class="row-span-3 col-start-5 row-start-2 grid place-items-center">
            @include('public.hmos_board')
        </div>

        <div id="app2"class="col-span-5 row-start-5 mt-5 flex justify-start gap-2 overflow-y-auto ">
            <div class="p-1 rounded-lg m-1">
                <now-serving></now-serving>
            </div>
            <queue-call></queue-call>
        </div>
    </section>

    @routes
    <script>
        function updateDateTime() {
            const now = new Date();
            // Format Time (12-hour with meridiem)
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, "0");
            const seconds = String(now.getSeconds()).padStart(2, "0");
            const meridiem = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12; // convert to 12-hour format
            const formattedHours = String(hours).padStart(2, "0");
            const timeString = `${formattedHours}:${minutes}:${seconds} ${meridiem}`;
            // Format Date (12 August 2025)
            const options = {
                day: "numeric",
                month: "long",
                year: "numeric"
            };
            const dateString = now.toLocaleDateString("us-EN", options);
            // Update DOM
            document.getElementById("clock").textContent = timeString;
            document.getElementById("date").textContent = dateString;
        }
        // Update every second
        setInterval(updateDateTime, 1000);
        updateDateTime();


        ["click"].forEach(evt =>
            document.addEventListener(evt, () => {
                const videos = document.querySelectorAll('#videoContainer video');
                const playButton = document.getElementById('playButton');
                let currentVideo = 0;
                // Check if videos exist
                if (videos.length === 0) return;
                // Hide all videos initially except the first one
                videos.forEach((video, index) => {
                    video.style.display = index === 0 ? 'block' : 'none';
                });

                function playNextVideo() {
                    videos[currentVideo].style.display = 'none';
                    videos[currentVideo].pause();
                    currentVideo = (currentVideo + 1) % videos.length;
                    videos[currentVideo].style.display = 'block';
                    videos[currentVideo].play();
                }
                videos.forEach(video => {
                    video.addEventListener('ended', playNextVideo);
                });
                // Hide play button and play the first video on load
                if (playButton) {
                    playButton.style.display = 'none';
                }
                videos[0].play();
            })
        );
    </script>

</x-layouts.app>
