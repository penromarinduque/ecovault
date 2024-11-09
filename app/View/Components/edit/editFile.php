<?php

namespace App\View\Components\edit;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class editFile extends Component
{
    public string $type;
    public string $municipality;

    /**
     * Create a new component instance.
     */
    public function __construct(string $type, string $municipality)
    {
        $this->type = $type;
        $this->municipality = $municipality;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit.edit-file');
    }
}
