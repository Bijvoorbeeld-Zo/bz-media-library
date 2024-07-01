@php
    use Carbon\Carbon;

    function formatBytes($bytes, $precision = 2): string {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    $media = \JornBoerema\BzMediaLibrary\Models\MediaLibraryItem::all()->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'size' => formatBytes($item->getFirstMedia()->size),
            'url' => $item->getFirstMedia()->getTemporaryUrl(Carbon::now()->addMinutes(5)),
        ];
    })->toArray();
@endphp

<x-filament-panels::page>
    @livewire(\JornBoerema\BzMediaLibrary\Livewire\Upload::class)

    <div class="grid grid-cols-12 gap-10 items-start justify-start"
         x-data="{ selected: null, media: {{ json_encode($media) }} }">
        <div class="col-span-9 grid grid-cols-4 gap-5">
            @foreach(\JornBoerema\BzMediaLibrary\Models\MediaLibraryItem::all() as $item)
                <label for="media-{{ $item->id }}" class="relative cursor-pointer">
                    <input type="radio" id="media-{{ $item->id }}" value="{{ $item->id }}" x-model="selected"
                           class="hidden peer"/>
                    <img src="{{ $item->getFirstMedia()->getTemporaryUrl(Carbon::now()->addMinutes(5)) }}" alt=""
                         class="w-full bg-primary-300 aspect-square rounded-md object-cover object-center ring-primary-600 peer-checked:ring-2 ring-offset-4"/>
                    <p class="mt-3 text-sm truncate" title="{{ $item->name }}">{{ $item->name }}</p>
                    <p class="text-xs text-gray-500">{{ formatBytes($item->getFirstMedia()->size) }}</p>
                </label>
            @endforeach
        </div>

        <div x-show="selected" class="col-span-3">
            <img :src="media.find(item => String(item.id) === String(selected)).url" alt=""
                 class="w-full aspect-square object-cover object-center rounded-md mb-2"/>

            <p x-text="media.find(item => String(item.id) === String(selected)).name" class="text-sm"></p>
            <p x-text="media.find(item => String(item.id) === String(selected)).size" class="text-gray-500 text-sm"></p>

            <a :href="media.find(item => String(item.id) === String(selected)).url" target="_blank">
                <x-filament::button color="gray" class="w-full mt-4">Bekijken</x-filament::button>
            </a>
{{--            <x-filament::button color="danger" class="w-full mt-2">Verwijder</x-filament::button>--}}
        </div>
    </div>
</x-filament-panels::page>
