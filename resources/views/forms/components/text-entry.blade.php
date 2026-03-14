<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }"
    >
        @if ($getCurrency())
            <span>{{ $getCurrency() }}</span>
        @endif

        <span x-text="state"></span>
    </div>
</x-dynamic-component>
