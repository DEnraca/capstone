<x-layouts.app>
    <section class="min-h-screen max-h-screen grid grid-rows-[auto_1fr_auto] gap-0 bg-primary-100">
        <div class="bg-transparent grid grid-cols-[1fr_20%] gap-1 place-items-center place-content-between text-white">
            <div class="w-auto h-24">
                <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div class="text-right text-black">
                <p class="font-extrabold" id="clock" style="font-size: 2rem"></p>
                <p class="font-bold" id="date" style="font-size: 1rem"></p>
            </div>
        </div>
        <div class="grid grid-cols-[1fr_20%] gap-1">
            <div id="videoContainer" class="bg-gray rounded-md flex items-center justify-center overflow-hidden relative " style="background-color:green;">
                <video id="video1" class="absolute  w-full h-full rounded-t-md p-0 m-0 object-cover" src="{{asset('images/frontend_asset/abr_vid.mp4')}}" autoplay muted loop playsinline></video>
            </div>
            <div class="flex items-center justify-center bg-transparent rounded-md">
                @include('public.hmos_board')
            </div>
        </div>

        <div id="app2" class="min-h-full p-1" >
            <div class="text-center py-1 bg-gray-200 rounded-lg">
                <p class="font-black text-black text-xl">Now Serving</p>
            </div>
            <div class="overflow-y-auto p-1 bg-gray-200 rounded-lg m-1">
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
            const options = { day: "numeric", month: "long", year: "numeric" };
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

