<?php

namespace App\View\Components\fileUpload;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class fileUpload extends Component
{
    /**
     * Create a new component instance.
     */
    public string $type;
    public string $municipality;

    public string $record;
    public function __construct(string $type, string $municipality, string $record)
    {
        $this->type = $type;
        $this->municipality = $municipality;
        $this->record = $record;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.file-upload.file-upload');
    }
}
