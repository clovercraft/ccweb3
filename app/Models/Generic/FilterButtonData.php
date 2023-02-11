<?php

namespace App\Models\Generic;

class FilterButtonData
{

    public string $id;
    public string $label;
    public array $options;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function optionsFromObjects(mixed $objects, string $valueProperty, ?string $displayProperty = null): self
    {
        $options = [];
        foreach ($objects as $obj) {
            // skip object if the value property isn't set
            if (!isset($obj->$valueProperty)) {
                continue;
            }

            $value = $obj->$valueProperty;
            $display = '';

            if ($displayProperty !== null) {
                $display = $this->$displayProperty ?? $this->displayFromSlug($value);
            } else {
                $display = $this->displayFromSlug($value);
            }

            // we need both a value and a display string
            if (empty($value) || empty($display)) {
                continue;
            }

            $options[$value] = $display;
        }
        $this->options = $options;

        return $this;
    }

    private function displayFromSlug(string $slug): string
    {
        // split hyphenated words
        $display = str_replace(["-", "_", "."], " ", $slug);
        $display = ucfirst($display);
        return $display;
    }
}
