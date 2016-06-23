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
  const $overlay = $('#fm-overlay');
  const $overlayWrapper = $overlay.children('.fm-overlay-wrapper');
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

  const wrapper = $(window);
  const image = new Image();
  const overlayImage = $overlay.find('.entry-thumbnail');

  image.src = overlayImage.children().first().attr('srcset');

  const wrapperWidth = wrapper.width() * 0.25;
  const wrapperHeight = wrapper.height() * 0.25;
  const imgWidth = image.naturalWidth;
  const imgHeight = image.naturalHeight;

  const imgRatio = imgWidth / imgHeight;
  const wrapperRatio = wrapperWidth / wrapperHeight;

  console.log(imgRatio, wrapperRatio);

  if (wrapperRatio > imgRatio) {
    overlayImage.css({
      height: '100%',
      width: 'auto',
    })
    .data('orientation', 'height');
  } else {
    overlayImage.css({
      height: 'auto',
      width: '100%',
    })
    .data('orientation', 'width');
  }

  if ($overlay.length) {
    /**
     * Display the overlay
     */
    setTimeout(() => $overlay.show().addClass(activeClass), timer);

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
    $overlayWrapper.click(() => hideOverlay());
  }
}

/**
 * Initialize
 */
$(document).ready(() => fmOverlay());
