<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $inputType;
    public $inputName;
    public $inputClass;
    public $placeholder;
    public $label;

    public function __construct($inputType, $inputName, $inputClass, $placeholder, $label)
    {
        $this->inputType = $inputType;
        $this->inputName = $inputName;
        $this->inputClass = $inputClass;
        $this->placeholder = $placeholder;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.input');
    }
}
