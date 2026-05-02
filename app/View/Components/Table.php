<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Component attributes array for the table wrapper.
     *
     * @var array
     */
    public $attributes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // no special data; the slot handles content
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.table');
    }
}
