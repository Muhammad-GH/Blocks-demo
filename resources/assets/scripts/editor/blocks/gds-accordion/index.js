/** @wordpress */
import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import { InnerBlocks } from '@wordpress/block-editor'

/** Accordion components */
import edit from './edit'
import meta from './block.json';

registerBlockType(meta.name, {
  ...meta,
  title: __('Accordion', 'gds'),
  description: __('Display content that can be toggled open or closed', 'gds'),
  parent: null,
  supports: {
    align: true,
    alignWide: true,
    customClassName: true,
    html: false,
    inserter: true,
    multiple: true,
    reusable: false,
  },
  edit,
  save() {
    return <InnerBlocks.Content />;
  },
})
