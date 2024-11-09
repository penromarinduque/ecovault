<?php

namespace App\View\Components\fileShare;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class fileShare extends Component
{
    /**
     * Create a new component instance.
     */
    public bool $includePermit;
    public function __construct(bool $includePermit)
    {
        $this->includePermit = $includePermit;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.file-share.file-share');
    }
}
