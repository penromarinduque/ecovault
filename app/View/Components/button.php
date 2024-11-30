<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class button extends Component
{
    public $id;
    public $label;
    public $type;
    public $onclick;
    public $style;

    public function __construct($id, $label, $type = 'button', $style = 'default', $onclick = null)
    {
        $this->id = $id;
        $this->label = $label;
        $this->type = $type;
        $this->style = $style;
        $this->onclick = $onclick;
    }

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
