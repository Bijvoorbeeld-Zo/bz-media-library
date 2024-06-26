<div>
    <form wire:submit.prevent="create" class="grid gap-4">
        {{ $this->form }}

        <x-filament::button type="submit">Upload</x-filament::button>
    </form>

    <x-filament-actions::modals />
</div>
