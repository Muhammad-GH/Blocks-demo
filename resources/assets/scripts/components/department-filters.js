export default function init(element) {
  const buttons = element.querySelectorAll('[data-filter]');
  const resetButton = element.querySelector('[data-filter="false"]');

  const isActive = (el) => !el.parentNode.classList.contains('is-style-outline');
  const removeAllActive = () => Array.from(buttons).forEach((b) => removeActive(b));

  const setActive = (el) => {
    el.parentNode.classList.remove('is-style-outline')

    const targetId = el.dataset.filter;

    if (targetId === 'false') {
      Array.from(buttons)
        .filter((b) => b !== resetButton)
        .forEach((b, idx) => {
          const targetId = b.dataset.filter;
          const target = document.getElementById(targetId);

          target.removeAttribute('hidden');

          if (idx === 0) {
            target.scrollIntoView({scrollBehavior: 'smooth'});
          }
        });


    } else {
      const target = document.getElementById(targetId);
      target.removeAttribute('hidden');
      target.scrollIntoView({scrollBehavior: 'smooth'});
    }
  };

  const removeActive = (el) => {
    el.parentNode.classList.add('is-style-outline');

    const targetId = el.dataset.filter;
    if (targetId !== 'false') {
      document.getElementById(targetId).setAttribute('hidden', '');
    }
  };


  console.log(buttons);

  for (const button of buttons) {
    button.addEventListener('click', ({target}) => {
      if (!isActive(target)) {
        removeAllActive();
        setActive(target);
      }
    })
  }
}
