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
  const $overlayImage = $overlay.find('img', '.fm-image');
  const timer = 500; // matches css transition duration
  const activeClass = 'visible';
  const $closeButton = $overlayWrapper.children('button.fm-overlay-close');

  /**
   * Hide overlay after fading out
   */
  function hideOverlay() {
    $overlay.removeClass(activeClass);

    setTimeout(() => $overlay.hide(), timer);
  }

  /**
   * Resizing image to fill overlay wrapper
   * while maintaining aspect ratio
   */
  function resizeOverlayImage() {
    const wrapperWidth = $window.innerWidth() * 0.75;
    const wrapperHeight = $window.innerHeight() * 0.75;
    const imgRatio = $overlayImage.width() / $overlayImage.height();
    const wrapperRatio = wrapperWidth / wrapperHeight;

    if (wrapperRatio >= imgRatio) {
      $overlayImage.css({
        width: 'auto',
        'max-height': wrapperHeight,
      });
      // shrink overlay wrapper width if image height is maxed out
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

  if ($overlay.length) {
    /**
     * Display the overlay
     */
    setTimeout(() => $overlay.show().addClass(activeClass), timer);

    /**
     * Handle Image Overlays
     */
    if ($overlay.hasClass('fm-overlay-image')) {
      resizeOverlayImage();
      // handle image overlay resizing
      $window.resize(() => resizeOverlayImage());
    }

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
