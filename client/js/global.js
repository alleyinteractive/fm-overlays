import '../scss/global.scss';

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

const fmOverlay = () => {
  const overlay = document.getElementById('fm-overlay');

  // If we have no overlay to work with, bail.
  if (!overlay) {
    return;
  }

  const overlayWrapper = overlay.querySelector('.fm-overlay-wrapper');
  const overlayFade = overlay.querySelector('.fm-overlay-fade');
  const overlayImage = overlay.querySelector('.fm-overlay-content.image img');
  const closeButton = overlayWrapper.querySelector('button.fm-overlay-close');
  const activeClass = 'visible';
  const cookieName = overlay.dataset.cookiename;
  const expiration = overlay.dataset.expiration; // eslint-disable-line prefer-destructuring
  // Image Overlay Variables
  let wrapperWidth = window.innerWidth * 0.75;
  let wrapperHeight = window.innerHeight * 0.75;
  let imgRatio;
  if (overlayImage) {
    imgRatio = overlayImage.getBoundingClientRect().width
    / overlayImage.getBoundingClientRect().height;
  }
  let wrapperRatio = wrapperWidth / wrapperHeight;

  /**
   * Resize Image Overlay
   * image should fill overlay wrapper while
   * maintaining aspect ratio
   */
  const resizeOverlayImage = () => {
    wrapperWidth = window.innerWidth * 0.75;
    wrapperHeight = window.innerHeight * 0.75;
    // eslint-disable-next-line max-len
    imgRatio = overlayImage.getBoundingClientRect().width / overlayImage.getBoundingClientRect().height;
    wrapperRatio = wrapperWidth / wrapperHeight;

    if (wrapperRatio >= imgRatio) {
      overlayImage.style.cssText = `width: auto; max-height: ${Math.ceil(wrapperHeight)};`;
      // eslint-disable-next-line max-len
      if (overlayImage.getBoundingClientRect().width < overlayWrapper.getBoundingClientRect().height) {
        overlayWrapper.style.width = 'auto';
      }
    } else {
      overlayWrapper.style.width = '75%';
      overlayImage.style.cssText = 'width: 100; max-height: auto;';
    }
  };

  /**
   * Hide overlay after fading out
   */
  const hideOverlay = () => {
    overlay.classList.remove(activeClass);
    window.removeEventListener('resize', resizeOverlayImage);
  };

  /**
   * Set Overlay cookies.
   */
  const setCookie = () => {
    const date = new Date();

    // set cookie for 2 hours
    date.setTime(date.getTime() + (expiration * 60 * 60 * 1000));

    const expires = `; expires=' + ${date.toGMTString()}`;
    document.cookie = `${cookieName} = ${true} ${expires}; path=/`;
  };

  /**
   * Display the overlay
   */
  if (overlay) {
    overlay.classList.add(activeClass);
    setCookie();

    if (overlay.classList.contains('fm-overlay-image')) {
      resizeOverlayImage();
      window.addEventListener('resize', resizeOverlayImage);
    }

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        hideOverlay();
      }
    });

    closeButton.addEventListener('click', hideOverlay);
    overlayFade.addEventListener('click', hideOverlay);
  }
};

/**
 * Initialize
 */
document.addEventListener('DOMContentLoaded', () => {
  fmOverlay();
});
