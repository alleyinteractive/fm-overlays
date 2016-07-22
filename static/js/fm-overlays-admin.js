/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/wp-content/plugins/fm-overlays/static/";
/******/ 	// webpack-livereload-plugin
/******/ 	(function() {
/******/ 	  if (typeof window === "undefined") { return };
/******/ 	  var id = "webpack-livereload-plugin-script";
/******/ 	  if (document.getElementById(id)) { return; }
/******/ 	  var el = document.createElement("script");
/******/ 	  el.id = id;
/******/ 	  el.async = true;
/******/ 	  el.src = "http://localhost:35729/livereload.js";
/******/ 	  document.head.appendChild(el);
/******/ 	}());
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!****************************!*\
  !*** ./client/js/admin.js ***!
  \****************************/
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(/*! ../css/admin.scss */ 1);
	var $ = __webpack_require__(/*! jQuery */ 5);
	
	/**
	 * fm-overlays-admin.js
	 *
	 * @created 1/8/16 2:44 PM
	 * @author Alley Interactive
	 * @package fm-overlays
	 * @description JS manipulations to the fm-overlays admin area.
	 *
	 */
	
	/**
	 * Pass select field data to the labels
	 * to make the UI a little easier and slicker
	 */
	function conditionFieldLabelLoader() {
	  var _this = this;
	
	  // When a select field is updated, also update the label
	  $('body').on('change', 'select[conditional="labels"]', function () {
	    var $selectField = $(_this);
	    var selectVal = $selectField.val();
	    var separator = ' - ';
	    var $labelSelector = $selectField.closest('.fm-fm_overlays_conditionals').find('.fm-label-fm_overlays_conditionals');
	    var labelText = $labelSelector.text();
	
	    if (!selectVal) {
	      selectVal = '';
	      separator = '';
	    }
	
	    // update the label string
	    labelText = labelText.split(' ', 1) + separator + selectVal;
	
	    // replace the label
	    $labelSelector.text(labelText);
	  });
	
	  // trigger a change for the select fields
	  // so the labels load according to their values
	  $('select[conditional="labels"]').trigger('change');
	}
	
	/**
	 * DOM ready
	 */
	$(document).ready(function () {
	  return conditionFieldLabelLoader();
	});

/***/ },
/* 1 */
/*!*******************************!*\
  !*** ./client/css/admin.scss ***!
  \*******************************/
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ function(module, exports) {

	module.exports = jQuery;

/***/ }
/******/ ]);
//# sourceMappingURL=fm-overlays-admin.js.map