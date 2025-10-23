

<x-filament::section collapsible>
    <x-slot name="heading">
        Services Availed
    </x-slot>
    <table class="table-auto w-full" border="1">
        <thead>
            <tr>
                <th style="width: 70%">Services</th>
                <th style="width: 70%">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr class="text-center">
                    <td>{{$service['name']}}</td>
                    <td>₱{{$service['price']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Content --}}
</x-filament::section>

