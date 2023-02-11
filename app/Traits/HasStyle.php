<?php

namespace App\Traits;

trait HasStyle
{

    public $styles;

    protected function makeStyles(array $styles)
    {
        if (empty($styles)) {
            return;
        }

        $this->styles = [];

        foreach ($styles as $key => $strings) {
            $value = implode('', $strings);
            $this->styles[$key] = $value;
        }
    }

    protected function hexToRgb(string $hex): string
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return "$r,$g,$b";
    }
}
