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
	  var $window = $(window);
	  var $overlay = $('#fm-overlay');
	  var $overlayWrapper = $overlay.children('.fm-overlay-wrapper');
	  var $overlayFade = $overlay.children('.fm-overlay-fade');
	  var $overlayImage = $overlay.find('img', '.fm-overlay-content.image');
	  var $closeButton = $overlayWrapper.children('button.fm-overlay-close');
	  var timer = 500; // matches css transition duration
	  var activeClass = 'visible';
	  var cookieName = $overlay.data('cookiename');
	  // Image Overlay Variables
	  var wrapperWidth = $window.innerWidth() * 0.75;
	  var wrapperHeight = $window.innerHeight() * 0.75;
	  var imgRatio = $overlayImage.width() / $overlayImage.height();
	  var wrapperRatio = wrapperWidth / wrapperHeight;
	
	  /**
	   * Hide overlay after fading out
	   */
	  function hideOverlay() {
	    $overlay.removeClass(activeClass);
	    $window.off('resize', resizeOverlayImage);
	    setTimeout(function () {
	      return $overlay.hide();
	    }, timer);
	  }
	
	  /**
	   * Set Overlay cookies.
	   */
	  function setCookie() {
	    var name = cookieName;
	    var date = new Date();
	
	    // set cookie for 2 hours
	    date.setTime(date.getTime() + 2 * 60 * 60 * 1000);
	
	    var expires = '; expires=\' + ' + date.toGMTString();
	    document.cookie = name + ' = ' + true + ' ' + expires + '; path=/';
	  }
	
	  /**
	   * Resize Image Overlay
	   * image should fill overlay wrapper while
	   * maintaining aspect ratio
	   */
	  function resizeOverlayImage() {
	    wrapperWidth = $window.innerWidth() * 0.75;
	    wrapperHeight = $window.innerHeight() * 0.75;
	    imgRatio = $overlayImage.width() / $overlayImage.height();
	    wrapperRatio = wrapperWidth / wrapperHeight;
	
	    if (wrapperRatio >= imgRatio) {
	      $overlayImage.css({
	        width: 'auto',
	        'max-height': Math.ceil(wrapperHeight)
	      });
	      /**
	       * shrink overlay wrapper width if image height is maxed out
	       */
	      if ($overlayImage.width() < $overlayWrapper.width()) {
	        $overlayWrapper.css('width', 'auto');
	      }
	    } else {
	      $overlayWrapper.css('width', '75%');
	      $overlayImage.css({
	        width: '100%',
	        'max-height': 'auto'
	      });
	    }
	  }
	
	  /**
	   * Display the overlay
	   */
	  if ($overlay.length) {
	    setTimeout(function () {
	      /**
	       * Display Overlay
	       * adds class to make overlay active then checks
	       * if overlay is an image type
	       */
	      if ($overlay.show().addClass(activeClass).hasClass('fm-overlay-image')) {
	        /**
	         * handles image resizing based on
	         * screen v.s. image ratio
	         */
	        resizeOverlayImage();
	        $window.resize(resizeOverlayImage);
	        setCookie();
	      }
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
	    $overlayFade.click(function () {
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