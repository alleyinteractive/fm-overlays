require('../css/global.scss');
const $ = require('jQuery');

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
  const $window = $(window);
  const $overlay = $('#fm-overlay');
  const $overlayWrapper = $overlay.children('.fm-overlay-wrapper');
  const $overlayFade = $overlay.children('.fm-overlay-fade');
  const $overlayImage = $overlay.find('img', '.fm-overlay-content.image');
  const $closeButton = $overlayWrapper.children('button.fm-overlay-close');
  const timer = 500; // matches css transition duration
  const activeClass = 'visible';
  const cookieName = $overlay.data('cookiename');
  // Image Overlay Variables
  let wrapperWidth = $window.innerWidth() * 0.75;
  let wrapperHeight = $window.innerHeight() * 0.75;
  let imgRatio = $overlayImage.width() / $overlayImage.height();
  let wrapperRatio = wrapperWidth / wrapperHeight;

  /**
   * Hide overlay after fading out
   */
  function hideOverlay() {
    $overlay.removeClass(activeClass);
    $window.off('resize', resizeOverlayImage);
    setTimeout(() => $overlay.hide(), timer);
  }

  /**
   * Set Overlay cookies.
   */
  function setCookie() {
    const date = new Date();

    // set cookie for 2 hours
    date.setTime(date.getTime() + (2 * 60 * 60 * 1000));

    const expires = `; expires=' + ${date.toGMTString()}`;
    document.cookie = `${cookieName} = ${true} ${expires}; path=/`;
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
        'max-height': Math.ceil(wrapperHeight),
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
        'max-height': 'auto',
      });
    }
  }

  /**
   * Display the overlay
   */
  if ($overlay.length) {
    setTimeout(() => {
      // Display Overlay
      $overlay.show().addClass(activeClass);
      setCookie();
      // checks if we need to listen for image resizing events
      if ($overlay.hasClass('fm-overlay-image')) {
        /**
         * handles image resizing based on
         * screen v.s. image ratio
         */
        resizeOverlayImage();
        $window.resize(resizeOverlayImage);
      }
    }, timer);

    /**
     * Exit strategies
     * Escape (keyCode 27)
     * Close Button
     * Click Overlay
     *
     */
    $(document).keyup((e) => {
      if (27 === e.keyCode) {
        hideOverlay();
      }
    });

    $closeButton.click(() => hideOverlay());

    // close the overlay when a click occurs outside of the overlay content
    $overlayFade.click(() => hideOverlay());
  }
}

/**
 * Initialize
 */
$(document).ready(() => fmOverlay());
