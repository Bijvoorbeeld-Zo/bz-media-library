<?php

namespace JornBoerema\BzMediaLibrary\Livewire;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use JornBoerema\BzMediaLibrary\Models\MediaLibraryItem;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Upload extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('images')
                    ->image()
                    ->hiddenLabel()
                    ->required()
                    ->multiple()
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, Get $get): int {
                        $media_library_item = MediaLibraryItem::create(['name' => $file->getClientOriginalName()]);
                        $media_library_item
                            ->addMediaFromDisk($file->getRealPath(), config('media-library.disk_name'))
                            ->toMediaCollection();

                        return $media_library_item->id;
                    })
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $state = $this->form->getState();

        $this->dispatch('refresh_media');
    }

    public function render(): View
    {
        return view('bz-media-library::livewire.upload');
    }
}
