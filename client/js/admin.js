import '../scss/admin.scss';

/**
 * fm-overlays-admin.js
 *
 * @author Alley Interactive
 * @package fm-overlays
 * @description JS manipulations to the fm-overlays admin area.
 *
 */

/**
  * Set a condition field's wrapper label to the same value as the current option.
  * @param {node} selectEl a <select> element
  */
const setLabelText = (selectEl) => {
  const wrapper = selectEl.closest('.fm-fm_overlays_conditionals');
  const label = wrapper.querySelector('.fm-label');
  label.innerText = `Condition: ${selectEl.options[selectEl.selectedIndex].text}`;
};

/**
 * Update condition field wrapper labels with the currently selected option.
 */
const updateConditionLabels = () => {
  const conditionWrappers = document.querySelectorAll('.fm-fm_overlays_conditionals');

  if (conditionWrappers.length) {
    conditionWrappers.forEach((condition) => {
      // Update all condition labels on page load.
      let select = condition.querySelector('select');
      setLabelText(select);

      // Update each condition label based on its select menu option.
      condition.addEventListener('input', (e) => {
        select = e.target;

        if (select.dataset.label === 'condition-select') {
          setLabelText(select);
        }
      });
    });
  }
};

/**
 * DOM ready
 */
document.addEventListener('DOMContentLoaded', () => {
  updateConditionLabels();
});
