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
  * Set a condition field's wrapper label to the same value as the current option
  * @param {node} selectEl a <select> element
  */
const setLabel = (selectEl) => {
  const wrapper = selectEl.closest('.fm-fm_overlays_conditionals');
  const label = wrapper.querySelector('.fm-label');
  label.innerText = `Condition: ${selectEl.options[selectEl.selectedIndex].text}`;
};

/**
 * Update all condition field wrapper labels with the currently selected option
 */
const conditionFieldLabelLoader = () => {
  const conditionWrappers = document.querySelectorAll('.fm-fm_overlays_conditionals');

  conditionWrappers.forEach((condition) => {
    let select = condition.querySelector('select');
    setLabel(select);

    condition.addEventListener('input', (e) => {
      select = e.target;

      if (select.dataset.label === 'condition-select') {
        setLabel(select);
      }
    });
  });


}

/**
 * DOM ready
 */
document.addEventListener('DOMContentLoaded', () => {
  conditionFieldLabelLoader();
});
