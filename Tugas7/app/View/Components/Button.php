<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $className;
    public $buttonType;
    public $label;

    public function __construct($className, $buttonType, $label)
    {
        $this->className = $className;
        $this->buttonType = $buttonType;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.button');
    }
}
