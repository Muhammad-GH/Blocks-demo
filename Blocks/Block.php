<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block as BaseBlock;

abstract class Block extends BaseBlock
{
    public function render($block, $content = '', $preview = false, $post_id = 0)
    {
        $this->style = $this->getBlockStyle();

        return parent::render(...func_get_args());
    }

    public function getBlockStyle(): string
    {
        preg_match('/is-style-([^\s]+)/', $this->classes ?? '', $matches);

        return $matches[1] ?? 'default';
    }

    public function fields()
    {
        return [];
    }
}
