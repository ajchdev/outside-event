import { createElement } from "@wordpress/element";

/**
 * External dependencies
 */
import { isEmpty } from 'lodash';
/**
 * WordPress dependencies
 */

import { useSelect } from '@wordpress/data';
import { PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
/**
 * Internal dependencies
 */

import GradientPicker from './control';
export default function GradientPanel(props) {
  var gradients = useSelect(function (select) {
    return select('core/block-editor').getSettings().gradients;
  }, []);

  if (isEmpty(gradients)) {
    return null;
  }

  return createElement(PanelBody, {
    title: __('Gradient')
  }, createElement(GradientPicker, props));
}
//# sourceMappingURL=panel.js.map