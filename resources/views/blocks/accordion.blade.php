<div class="{{ esc_attr($block->classes) }}">
  <gds-accordion>
    <gds-label slot="label" size="xl">{{ $text }}</gds-label>
    <gds-icon slot="icon-collapse" name="angle-up" size="s" regular></gds-icon>
    <gds-icon slot="icon-expand" name="angle-down" size="s" regular></gds-icon>
    <div slot="content" class="content">
      {!! $content !!}
    </div>
  </gds-accordion>
</div>
