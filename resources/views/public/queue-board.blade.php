<x-layouts.app>
    <section id="app2" class="min-h-screen max-h-screen grid grid-cols-4 gap-0 bg-primary-100">
        <div class="col-span-3 grid gap-0 grid-rows-[auto_1fr_10%]">
            <div class="bg-transparent grid grid-cols-[1fr_20%] gap-1 place-items-center place-content-between text-white">
                <div class="w-auto h-32">
                    <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div class="text-right text-black">
                    <p class="font-extrabold" id="clock" style="font-size: 2rem"></p>
                    <p class="font-bold" id="date" style="font-size: 1rem"></p>
                </div>
            </div>
            <div id="videoContainer" class="bg-gray flex items-center justify-center overflow-hidden relative " style="background-color:green;">
                <video id="video1" class="absolute  w-full h-full rounded-t-md p-0 m-0 object-cover" src="{{asset('images/frontend_asset/abr_vid.mp4')}}" autoplay muted loop playsinline></video>
            </div>
            <div class="max-w-full overflow-hidden grid place-items-center text-xs bg-primary text-black">
                @include('public.hmos')
            </div>
        </div>

        <div class="min-h-full min-w-full col-span-1 max-h-full bg-gray-200 rounded-lg grid-rows-[auto_1fr]" >
            
                <div class="bg-white text-center py-2">
                    <p class="font-black text-black text-2xl">Now Serving</p>
                </div>
                <div>
                    @foreach ($dummy->take(5) as $station)
                        <div class="min-h-full text-black odd:bg-primary-400 even:bg-primary-500 grid grid-rows-[auto_1fr] mb-1">
                            <div class="text-center text-2xl font-extrabold py-1">
                                {{$station['station']}} :
                                <span class="text-red-500 text-xl">
                                     {{ $station['now_serving']['number'] }} - {{ $station['now_serving']['name'] }}
                                </span>
                            </div>

                            @php
                                $nextInLine = $station['next_in_line'];
                                $perColumn = 3; // max items per column
                                $columns = array_chunk($nextInLine, $perColumn);
                            @endphp

                            <div class="grid grid-rows-[10%_1fr] h-full border rounded py-2 px-4 ">
                                <!-- Currently serving -->
                                @if(!empty($columns))
                                    <div class="flex gap-2 mt-2 text-gray-600">
                                        @foreach ($columns as $col)
                                            <div class="flex flex-col gap-3 pr-2">
                                                @foreach ($col as $next)
                                                    <div class="rounded text-center text-md font-bold">
                                                        {{ $next['number'] }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="rounded text-center text-md font-bold text-center text-gray-400">
                                        <em>Nothing follows</em>
                                    </div>
                                @endif
                            </div>

                                {{-- <div>
                                    <span class="font-extrabold text-[2.8rem] leading-none ">{{$station['now_serving']['number']}} </span>
                                    <p class="text-md font-semibold uppercase tracking-wide">Now Serving</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-md font-semibold uppercase tracking-wide">Window</p>
                                    <span class="font-extrabold text-[2.8rem] leading-none">{{nowserving.station_code}}</span>
                                </div> --}}
                        </div>
                    @endforeach
                    {{-- <div v-for="(nowserving) in now_serving"
                        :key="nowserving.id" class="min-h-full text-white px-3 py-4 flex items-center justify-between"
                        :style="{ backgroundColor: nowserving.bg_color }"
                    >
                        <div>
                            <p class="text-md font-semibold uppercase tracking-wide">{{nowserving.stations_name}} - {{nowserving.name}}</p>
                            <div class="flex items-baseline gap-3">
                            <span class="font-extrabold text-[2.8rem] leading-none ">{{nowserving.queue_number}} </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-md font-semibold uppercase tracking-wide">Window</p>
                            <span class="font-extrabold text-[2.8rem] leading-none">{{nowserving.station_code}}</span>
                        </div>
                    </div> --}}
                </div>
            </div>

            {{-- <now-serving></now-serving> --}}
            {{-- <div class="min-h-full text-white text-sm bg-white px-2 py-3">
                <div class="min-h-full py-3">
                    <p class="font-black text-black uppercase" style="font-size: 1.2rem">Next in line</p>
                    <p class="font-none text-black text-sm">Please prepare your document before your number is called.</p>
                </div>
            </div> --}}
            {{-- <next-in-line></next-in-line> --}}
        {{-- <queue-call /> --}}
    </section>

    {{-- @routes --}}
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

