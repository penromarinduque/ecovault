<?php

namespace App\View\Components\breadcrumb;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class breadcrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public $category;
    public $municipality;
    public $record;
    public $archivedType;
    public function __construct($type = null, $category = null, $municipality = null, $record = null, $archivedType = null)
    {
        $this->type = $type;
        $this->category = $category;
        $this->municipality = $municipality;
        $this->record = $record;
        $this->archivedType = $archivedType;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb.breadcrumb');
    }
}
