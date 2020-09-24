import '../css/admin.scss';

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
const conditionFieldLabelLoader = () => {
  const conditionWrapper = document.querySelector('.fm-fm_overlays_conditionals-wrapper');

  conditionWrapper.addEventListener('input', (e) => {
    const input = e.target;

    if (input.dataset.label === 'condition-select') {
      const wrapper = e.target.closest('.fm-fm_overlays_conditionals ');
      const label = wrapper.querySelector('.fm-label');
      label.innerText = `Condition: ${input.options[input.selectedIndex].text}`;
    }
  });
}

/**
 * DOM ready
 */
document.addEventListener('DOMContentLoaded', () => {
  conditionFieldLabelLoader();
});
