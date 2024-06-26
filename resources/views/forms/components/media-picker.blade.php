@php
    $mediaItems = \JornBoerema\BzMediaLibrary\Models\MediaLibraryItem::all()->map(function($item) {
        return [
            'id' => $item->id,
            'url' => $item->getFirstMedia()->getUrl(),
        ];
    })->toArray();

    $items = $getState() ?? [];
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}'), selected: [], media: {{ json_encode($mediaItems) }} }"
        class="grid"
    >
        <div class="flex items-center gap-x-4">
            <x-filament::modal
                :close-button="false"
                id="media-library"
                width="5xl"
            >
                <x-slot name="heading">
                    Media library
                </x-slot>

                <x-slot name="trigger" class="flex items-center justify-start gap-2">
                    <x-filament::button>
                        @if($getMultiple())
                            Choose images
                        @else
                            Choose image
                        @endif
                    </x-filament::button>
                </x-slot>

                <div class="grid grid-cols-5 gap-5">
                    @foreach(\JornBoerema\BzMediaLibrary\Models\MediaLibraryItem::all() as $item)
                        <label for="media-{{ $item->id }}" class="relative cursor-pointer">
                            <input type="checkbox" id="media-{{ $item->id }}" value="{{ $item->id }}" x-model="selected"
                                   class="hidden peer"/>
                            <img src="{{ $item->getFirstMedia()->getUrl() }}" alt=""
                                 class="w-full h-full bg-primary-300 aspect-square rounded-md object-cover object-center ring-primary-600 peer-checked:ring-2 ring-offset-4"></img>
                        </label>
                    @endforeach
                </div>

                <x-slot name="footer">
                    <x-filament::button color="gray" @click="$dispatch('close-modal', { id: 'media-library' });">
                        Cancel
                    </x-filament::button>
                    <x-filament::button @click="state = selected; $dispatch('close-modal', { id: 'media-library' });">
                        Update and close
                    </x-filament::button>
                </x-slot>
            </x-filament::modal>
            <button type="button" x-show="state && state.length > 0" @click="state = []; selected = [];"
                    class="text-base text-gray-500">Reset
            </button>
            <p x-show="!state || state.length === 0" class="text-base text-gray-500">No images selected</p>
            <p x-show="state && state.length > 1" x-text="(state ?? []).length + ' images selected'" class="text-base text-gray-500"></p>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4">
            <template x-for="item in media.filter(i => (state ?? []).includes(String(i.id)))">
                <img :src="item.url" alt="" class="w-full h-full aspect-square rounded-md object-cover object-center"/>
            </template>
        </div>
    </div>
</x-dynamic-component>
