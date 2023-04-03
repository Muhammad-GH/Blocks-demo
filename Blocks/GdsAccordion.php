<?php

namespace App\Blocks;

use Genero\Sage\NativeBlock\NativeBlock;

class GdsAccordion extends NativeBlock
{
    public $name = 'gds/accordion';

    public function with()
    {
        return [
            'text' => $this->attributes->text,
        ];
    }
}
