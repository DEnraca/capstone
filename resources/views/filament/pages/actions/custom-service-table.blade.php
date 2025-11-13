<x-filament::card class="col-span-1">
    @php
        $image = $record->getMedia('service_cover')?->first()?->getFullUrl() ?? asset('images/logo-light-text.png');
    @endphp
    <div>
        <img class="w-full h-32 mb-3 rounded-lg" src="{{$image}}" alt="Service Image">
    </div>
    <div class="flex flex-col">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-md font-semibold text-primary-600">{{$record->name}}</h3>
            <span class="text-sm font-medium text-gray-500">₱ {{number_format($record->price,2)}}</span>
        </div>
        <article class="text-sm text-gray-500 whitespace-normal break-words">
            {!! nl2br($record->description) !!}
        </article>
    </div>
</x-filament::card>