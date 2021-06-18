"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault");

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

var _element = require("@wordpress/element");

var _toConsumableArray2 = _interopRequireDefault(require("@babel/runtime/helpers/toConsumableArray"));

var _slicedToArray2 = _interopRequireDefault(require("@babel/runtime/helpers/slicedToArray"));

var _lodash = require("lodash");

var _i18n = require("@wordpress/i18n");

var _compose = require("@wordpress/compose");

var _panel = _interopRequireDefault(require("./panel"));

var _searchItems = require("./search-items");

var _noResults = _interopRequireDefault(require("./no-results"));

var _usePatternsState5 = _interopRequireDefault(require("./hooks/use-patterns-state"));

var _blockPatternsList = _interopRequireDefault(require("../block-patterns-list"));

/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */

/**
 * Internal dependencies
 */
function BlockPatternsSearchResults(_ref) {
  var filterValue = _ref.filterValue,
      onInsert = _ref.onInsert;

  var _usePatternsState = (0, _usePatternsState5.default)(onInsert),
      _usePatternsState2 = (0, _slicedToArray2.default)(_usePatternsState, 3),
      patterns = _usePatternsState2[0],
      onClick = _usePatternsState2[2];

  var currentShownPatterns = (0, _compose.useAsyncList)(patterns);
  var filteredPatterns = (0, _element.useMemo)(function () {
    return (0, _searchItems.searchItems)(patterns, filterValue);
  }, [filterValue, patterns]);

  if (filterValue) {
    return !!filteredPatterns.length ? (0, _element.createElement)(_panel.default, {
      title: (0, _i18n.__)('Search Results')
    }, (0, _element.createElement)(_blockPatternsList.default, {
      shownPatterns: currentShownPatterns,
      blockPatterns: filteredPatterns,
      onClickPattern: onClick
    })) : (0, _element.createElement)(_noResults.default, null);
  }
}

function BlockPatternsPerCategories(_ref2) {
  var onInsert = _ref2.onInsert;

  var _usePatternsState3 = (0, _usePatternsState5.default)(onInsert),
      _usePatternsState4 = (0, _slicedToArray2.default)(_usePatternsState3, 3),
      patterns = _usePatternsState4[0],
      categories = _usePatternsState4[1],
      onClick = _usePatternsState4[2];

  var getPatternIndex = (0, _element.useCallback)(function (pattern) {
    if (!pattern.categories || !pattern.categories.length) {
      return Infinity;
    }

    var indexedCategories = (0, _lodash.fromPairs)(categories.map(function (_ref3, index) {
      var name = _ref3.name;
      return [name, index];
    }));
    return Math.min.apply(Math, (0, _toConsumableArray2.default)(pattern.categories.map(function (category) {
      return indexedCategories[category] !== undefined ? indexedCategories[category] : Infinity;
    })));
  }, [categories]); // Ordering the patterns per category is important for the async rendering.

  var orderedPatterns = (0, _element.useMemo)(function () {
    return patterns.sort(function (a, b) {
      return getPatternIndex(a) - getPatternIndex(b);
    });
  }, [patterns, getPatternIndex]);
  var currentShownPatterns = (0, _compose.useAsyncList)(orderedPatterns); // Uncategorized Patterns

  var uncategorizedPatterns = (0, _element.useMemo)(function () {
    return patterns.filter(function (pattern) {
      return getPatternIndex(pattern) === Infinity;
    });
  }, [patterns, getPatternIndex]);
  return (0, _element.createElement)(_element.Fragment, null, categories.map(function (patternCategory) {
    var categoryPatterns = patterns.filter(function (pattern) {
      return pattern.categories && pattern.categories.includes(patternCategory.name);
    });
    return !!categoryPatterns.length && (0, _element.createElement)(_panel.default, {
      key: patternCategory.name,
      title: patternCategory.label
    }, (0, _element.createElement)(_blockPatternsList.default, {
      shownPatterns: currentShownPatterns,
      blockPatterns: categoryPatterns,
      onClickPattern: onClick
    }));
  }), !!uncategorizedPatterns.length && (0, _element.createElement)(_panel.default, {
    title: (0, _i18n._x)('Uncategorized')
  }, (0, _element.createElement)(_blockPatternsList.default, {
    shownPatterns: currentShownPatterns,
    blockPatterns: uncategorizedPatterns,
    onClickPattern: onClick
  })));
}

function BlockPatternsTabs(_ref4) {
  var onInsert = _ref4.onInsert,
      filterValue = _ref4.filterValue;
  return filterValue ? (0, _element.createElement)(BlockPatternsSearchResults, {
    onInsert: onInsert,
    filterValue: filterValue
  }) : (0, _element.createElement)(BlockPatternsPerCategories, {
    onInsert: onInsert
  });
}

var _default = BlockPatternsTabs;
exports.default = _default;
//# sourceMappingURL=block-patterns-tab.js.map