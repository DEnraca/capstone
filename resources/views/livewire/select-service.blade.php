<div>
    <div class="grid grid-cols-[1fr_25%] gap-2">
        <div class="grid md:grid-cols-3 lg:grid-cols-5 gap-3 min-w-full" style="width: 80%">
            @for ($i=0; $i<=6; $i++)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    {{-- <div class="relative">
                        <img class="rounded-t-lg absolute" src="{{asset('images/frontend_asset/cardiac.jpg')}}" alt="" />
                    </div> --}}
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-primary-700 ">Noteworthy technology acquisitions 2021</h5>
                        <p class="mb-3 font-normal ">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
                        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endfor
        </div>
        <div>
            <ul class="max-w-md divide-y divide-gray-200">
                <li class="pb-3 sm:pb-4">
                    <div class="flex items-center space-x-4 py-2 rtl:space-x-reverse">
                        <div class="shrink-0 p-1 m-0 flex justify-center">
                            <img class="w-18 h-14 rounded-lg" src="{{asset('images/frontend_asset/cardiac.jpg')}}"alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-black truncate">
                                Neil Sims
                            </p>
                            <p class="text-sm text-primary-500 truncate">
                                email@flowbite.com
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900">
                            $320
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
