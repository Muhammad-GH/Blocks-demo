
const mediumBreakpoint = window.matchMedia('(max-width: 781px)');


export default function init(element) {
  const tabs = element.querySelectorAll('[role="tab"]');
  const panels = element.querySelectorAll('[role="tabpanel"]');

  // On mobile, unselect all options by default
  if (mediumBreakpoint.matches) {
    Array.from(tabs).forEach((t) => t.setAttribute('aria-selected', 'false'));
    Array.from(panels).forEach((t) => t.setAttribute('hidden', ''));
  }

  const closeTab = (tab) => {
    const panelId = tab.getAttribute('aria-controls');
    const panel = document.getElementById(panelId);

    tab.setAttribute('aria-selected', 'false');
    panel.setAttribute('hidden', '');

    // On mobile, move the tab panel back
    if (mediumBreakpoint.matches) {
      element.appendChild(panel);
    }
  }

  const openTab = (tab) => {
    const panelId = tab.getAttribute('aria-controls');
    const panel = document.getElementById(panelId);

    tab.setAttribute('aria-selected', 'true');
    panel.removeAttribute('hidden');

    // On mobile, move the tab panel into the tab itself.
    if (mediumBreakpoint.matches) {
      tab.appendChild(panel);
    }
  }

  for (const tab of tabs) {
    tab.addEventListener('click', (e) => {
      // On mobile ensure you clicked the button, not the inner accordion
      if (!e.target.matches('[role="tab"] > span')) {
        return;
      }

      const isActive = tab.getAttribute('aria-selected') === 'true';

      window.requestAnimationFrame(() => {
        // Close all other tabs
        Array.from(tabs)
          .filter((t) => t !== tab)
          .forEach((t) => closeTab(t));

        if (mediumBreakpoint.matches) {
          if (isActive) {
            closeTab(tab);
          } else {
            openTab(tab);
          }
        } else {
          openTab(tab);
        }
      });
    })
  }
}
