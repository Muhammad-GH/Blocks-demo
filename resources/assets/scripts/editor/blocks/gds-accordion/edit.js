/** @wordpress */
import { __ } from '@wordpress/i18n'
import { useRef } from '@wordpress/element';
import {
  InnerBlocks,
} from '@wordpress/block-editor'

const DOMAIN = 'gds'
const CLASS_NAME = `wp-block-${DOMAIN}-accordion`

function BlockEdit({
  attributes,
  setAttributes,
}) {
  const { text } = attributes
  const ref = useRef();

  /* eslint-disable react/no-unknown-property */
  return (
    <gds-accordion ref={ref} class={`${CLASS_NAME}`} expanded>
      <gds-label slot="label" size="xl">
        <input
          type="text"
          className={`${CLASS_NAME}__text`}
          placeholder={__('Enter text', DOMAIN)}
          value={text || ''}
          onClick={() => {
            // Force expanded since stopPropagation doesnt work.
            ref.current.expanded = true;
          }}
          onChange={({target: {value: text}}) => {
            setAttributes({text})
          }}
        />
      </gds-label>
      <gds-icon slot="icon-collapse" name="angle-up" size="s" regular></gds-icon>
      <gds-icon slot="icon-expand" name="angle-down" size="s" regular></gds-icon>
      <div slot="content" class="content">
        <InnerBlocks />
      </div>
    </gds-accordion>
  )
  /* eslint-enable react/no-unknown-property */
}
BlockEdit.displayName = 'AccordionBlockEdit'

export default BlockEdit
