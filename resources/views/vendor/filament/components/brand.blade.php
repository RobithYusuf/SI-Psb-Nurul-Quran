@if (filled($brand = config('filament.brand')))
    <div
        @class([
            'filament-brand flex items-center text-xl font-bold tracking-tight',
            'dark:text-white' => config('filament.dark_mode'),
        ])>
    <img src="{{ asset('/nurul_quran.png') }}" alt="Logo" class="h-8">
        <span class="ml-2">{{ $brand }}</span>
    </div>
@endif
