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
/*!*****************************!*\
  !*** ./client/js/global.js ***!
  \*****************************/
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(/*! ../css/global.scss */ 6);
	var $ = __webpack_require__(/*! jQuery */ 5);
	
	/**
	* fm-overlays-global.js
	*
	* @created 1/15/16 5:33 PM
	* @author Alley Interactive
	* @package fm-overlays
	* @description Front-end JS for fm-overlays.
	*
	*/
	
	/**
	 * Very simple overlay event handler.
	 *
	 * @returns {fmOverlay}
	 */
	function fmOverlay() {
	  var $overlay = $('#fm-overlay');
	  var $overlayWrapper = $overlay.children('.fm-overlay-wrapper');
	  var timer = 500; // matches css transition duration
	  var activeClass = 'visible';
	  var $closeButton = $overlayWrapper.children('button.fm-overlay-close');
	
	  /**
	   * Hide overlay after fading out
	   */
	  function hideOverlay() {
	    $overlay.removeClass(activeClass);
	
	    setTimeout(function () {
	      return $overlay.hide();
	    }, timer);
	  }
	
	  var wrapper = $(window);
	  var image = new Image();
	  var overlayImage = $overlay.find('.entry-thumbnail');
	
	  image.src = overlayImage.children().first().attr('srcset');
	
	  var wrapperWidth = wrapper.width() * 0.25;
	  var wrapperHeight = wrapper.height() * 0.25;
	  var imgWidth = image.naturalWidth;
	  var imgHeight = image.naturalHeight;
	
	  var imgRatio = imgWidth / imgHeight;
	  var wrapperRatio = wrapperWidth / wrapperHeight;
	
	  console.log(imgRatio, wrapperRatio);
	
	  if (wrapperRatio > imgRatio) {
	    overlayImage.css({
	      height: '100%',
	      width: 'auto'
	    }).data('orientation', 'height');
	  } else {
	    overlayImage.css({
	      height: 'auto',
	      width: '100%'
	    }).data('orientation', 'width');
	  }
	
	  if ($overlay.length) {
	    /**
	     * Display the overlay
	     */
	    setTimeout(function () {
	      return $overlay.show().addClass(activeClass);
	    }, timer);
	
	    /**
	     * Exit strategies
	     * Escape (keyCode 27)
	     * Close Button
	     * Click Overlay
	     *
	     */
	    $(document).keyup(function (e) {
	      if (27 === e.keyCode) {
	        hideOverlay();
	      }
	    });
	
	    $closeButton.click(function () {
	      return hideOverlay();
	    });
	
	    // close the overlay when a click occurs outside of the overlay content
	    $overlayWrapper.click(function () {
	      return hideOverlay();
	    });
	  }
	}
	
	/**
	 * Initialize
	 */
	$(document).ready(function () {
	  return fmOverlay();
	});

/***/ },
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ function(module, exports) {

	module.exports = jQuery;

/***/ },
/* 6 */
/*!********************************!*\
  !*** ./client/css/global.scss ***!
  \********************************/
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ }
/******/ ]);
//# sourceMappingURL=fm-overlays-global.js.map