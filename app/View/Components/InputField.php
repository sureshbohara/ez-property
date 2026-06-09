<?php


namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class InputField extends Component
{
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public ?string $placeholder = null,
        public string $cols = 'col-md-12',
        public int $rows = 6,
        public bool $required = false,
        public array|Collection $options = [],
        public string $extraClass = '',
        public string $extraId = '',
        public $value = null,
        public bool $inline = false,
        public bool $preview = false,
        public ?string $error = null,
        public ?string $accept = null,
        public bool $disabled = false,
        public bool $readonly = false,
        public ?string $min = null,
        public ?string $max = null,
        public ?string $step = null,
        public ?string $prompt = null,
        public bool $editor = false
    ) {

        $this->options = $options instanceof Collection ? $options->toArray() : $options;

        $this->extraId = $extraId ?: $name;

        $this->value = old($name, $value);
    }

    public function render()
    {
        return view('components.input-field');
    }
}