

document.querySelectorAll('.split-panels').forEach(panelSet => {
    const panels = panelSet.querySelectorAll('.panel');

    // Set background images from data attribute
    panels.forEach(panel => {
        const bg = panel.getAttribute('data-bg');
        if (bg) {
            panel.querySelector('.panel-content').style.backgroundImage = `url('${bg}')`;
        }
    });

    // Only add hover behavior on desktop (1025px and up)
    function setupPanelHover() {
        if (window.innerWidth >= 1025) {
            panels.forEach(panel => {
                panel.addEventListener('mouseenter', () => {
                    panels.forEach(p => p.classList.remove('active'));
                    panel.classList.add('active');
                });

                panel.addEventListener('click', e => {
                    if (!e.target.closest('a')) {
                        const title = panel.querySelector('h2') || panel.querySelector('.vertical-label');
                        if (title) console.log('Clicked:', title.textContent);
                    }
                });
            });
        } else {
            // Remove all event listeners if not desktop
            panels.forEach(panel => {
                panel.replaceWith(panel.cloneNode(true));
            });
        }
    }

    // Initial setup
    setupPanelHover();

    // Update on resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setupPanelHover, 250);
    });

    
});