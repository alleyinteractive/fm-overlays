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

  const $window = $(window);
  const image = new Image();
  const $overlayImage = $overlay.find('img', '.fm-image');

  image.src = $overlay.find('.fm-image').children().first().attr('srcset');

  let wrapperWidth = $window.innerWidth() * 0.75;
  let wrapperHeight = $window.innerHeight() * 0.75;
  const imgWidth = image.naturalWidth;
  const imgHeight = image.naturalHeight;

  let imgRatio = imgWidth / imgHeight;
  let wrapperRatio = wrapperWidth / wrapperHeight;

  console.log('image natural width & height', imgWidth, imgHeight);
  console.log('wrapper width & height', wrapperWidth, wrapperHeight);
  console.log('imgRatio: ', imgRatio, wrapperRatio);

  function resizeOverlayImage() {
    wrapperWidth = $window.innerWidth() * 0.75;
    wrapperHeight = $window.innerHeight() * 0.75;
    imgRatio = $overlayImage.width() / $overlayImage.height();
    wrapperRatio = wrapperWidth / wrapperHeight;

    if (wrapperRatio >= imgRatio) {
      $overlayImage.css({
        width: 'auto',
        'max-height': wrapperHeight,
      });

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

  resizeOverlayImage();

  $(window).resize(() => resizeOverlayImage());

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
