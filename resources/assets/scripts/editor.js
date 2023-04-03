import '@wordpress/edit-post';
import domReady from '@wordpress/dom-ready';
import {
  registerBlockStyle,
  registerBlockCollection,
  unregisterBlockType,
} from '@wordpress/blocks';

import './editor/blocks/gds-accordion/index'

registerBlockCollection('gds', { title: 'Genero Design System' } );

domReady(() => {
  registerBlockStyle('core/social-links', {
    name: 'monochrome',
    label: 'Monochrome',
  });

  registerBlockStyle('core/list', {
    name: 'checklist',
    label: 'Checklist',
  });

  registerBlockStyle('core/button', {
    name: 'block',
    label: 'Block',
  });

  registerBlockStyle('core/buttons', {
    name: 'grid',
    label: 'Grid',
  });

  registerBlockStyle('core/gallery', {
    name: 'logo-grid',
    label: 'Logo Grid',
  });

  registerBlockStyle('core/columns', {
    name: 'link-cards',
    label: 'Link Cards',
  });

  registerBlockStyle('core/media-text', {
    name: 'header',
    label: 'Header',
  });
});

document.addEventListener('DOMContentLoaded', () => {
  [
    'advgb/accordion',
    'advgb/accordion-item',
    'advgb/accordions',
    'advgb/button',
    'advgb/icon',
    'advgb/image',
    'advgb/list',
    // 'advgb/table',
    'advgb/adv-tabs',
    'advgb/tab',
    'advgb/video',
    'advgb/columns',
    'advgb/column',
    'advgb/contact-form',
    'advgb/container',
    'advgb/count-up',
    'advgb/images-slider',
    'advgb/infobox',
    'advgb/login-form',
    'advgb/map',
    'advgb/newsletter',
    'advgb/recent-posts',
    'advgb/search-bar',
    'advgb/social-links',
    'advgb/summary',
    'advgb/tabs',
    'advgb/testimonial',
    'advgb/woo-products',
    'taxopress/related-posts',
    // 'gravityforms/form',
    'polylang/language-switcher',
    'polylang/language-switcher-inner-block',
    // 'acf/person-list',
    // 'acf/article-list',
    // 'acf/featured-article',
    // 'acf/product-list',
    // 'gds/accordion',
    // 'core/paragraph',
    // 'core/image',
    // 'core/heading',
    // 'core/gallery',
    // 'core/list',
    // 'core/quote',
    'core/shortcode',
    'core/archives',
    // 'core/audio',
    // 'core/button',
    // 'core/buttons',
    'core/calendar',
    'core/categories',
    'core/code',
    // 'core/columns',
    // 'core/column',
    'core/cover',
    // 'core/embed',
    // 'core/file',
    // 'core/group',
    // 'core/freeform',
    // 'core/html',
    // 'core/media-text',
    'core/latest-comments',
    'core/latest-posts',
    // 'core/missing',
    'core/more',
    'core/nextpage',
    'core/page-list',
    'core/preformatted',
    'core/pullquote',
    'core/rss',
    'core/search',
    // 'core/separator',
    // 'core/block',
    'core/social-links',
    'core/social-link',
    // 'core/spacer',
    // 'core/table',
    'core/tag-cloud',
    'core/text-columns',
    'core/verse',
    // 'core/video',
    'core/site-logo',
    'core/site-tagline',
    'core/site-title',
    'core/query',
    'core/post-template',
    'core/query-title',
    'core/query-pagination',
    'core/query-pagination-next',
    'core/query-pagination-numbers',
    'core/query-pagination-previous',
    'core/post-title',
    'core/post-content',
    'core/post-date',
    'core/post-excerpt',
    'core/post-featured-image',
    'core/post-terms',
    'core/loginout',
  ].forEach(block => unregisterBlockType(block));
});
