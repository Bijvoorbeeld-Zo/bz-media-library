<?php

namespace JornBoerema\BzMediaLibrary\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class MediaPicker extends Field
{
    protected string $view = 'bz-media-library::forms.components.media-picker';

    protected bool|Closure $multiple = false;
    protected mixed $defaultState = [];

    public function multiple(bool|Closure $multiple = true): static
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function getMultiple(): bool
    {
        return $this->evaluate($this->multiple);
    }
}
