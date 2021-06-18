"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = UnitControl;
exports.useCustomUnits = useCustomUnits;

var _element = require("@wordpress/element");

var _extends2 = _interopRequireDefault(require("@babel/runtime/helpers/extends"));

var _objectWithoutProperties2 = _interopRequireDefault(require("@babel/runtime/helpers/objectWithoutProperties"));

var _components = require("@wordpress/components");

var _data = require("@wordpress/data");

/**
 * WordPress dependencies
 */
function UnitControl(_ref) {
  var unitsProp = _ref.units,
      props = (0, _objectWithoutProperties2.default)(_ref, ["units"]);
  var units = useCustomUnits(unitsProp);
  return (0, _element.createElement)(_components.__experimentalUnitControl, (0, _extends2.default)({
    units: units
  }, props));
}
/**
 * Filters available units based on values defined by settings.
 *
 * @param {Array} settings Collection of preferred units.
 * @param {Array} units Collection of available units.
 *
 * @return {Array} Filtered units based on settings.
 */


function filterUnitsWithSettings() {
  var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  var units = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
  return units.filter(function (unit) {
    return settings.includes(unit.value);
  });
}
/**
 * Custom hook to retrieve and consolidate units setting from add_theme_support().
 *
 * @param {Array} unitsProp Collection of available units.
 *
 * @return {Array} Filtered units based on settings.
 */


function useCustomUnits(unitsProp) {
  var settings = (0, _data.useSelect)(function (select) {
    return select('core/block-editor').getSettings().enableCustomUnits;
  }, []);
  var isDisabled = !settings; // Adjust units based on add_theme_support( 'custom-units' );

  var units;
  /**
   * Handle extra arguments for add_theme_support
   *
   * Example: add_theme_support( 'custom-units', 'rem' );
   * Or: add_theme_support( 'custom-units', 'px, 'rem', 'em' );
   *
   * Note: If there are unit argument (e.g. 'em'), these units are enabled
   * within the control.
   */

  if (Array.isArray(settings)) {
    units = filterUnitsWithSettings(settings, unitsProp);
  } else {
    units = isDisabled ? false : unitsProp;
  }

  return units;
}
//# sourceMappingURL=index.js.map