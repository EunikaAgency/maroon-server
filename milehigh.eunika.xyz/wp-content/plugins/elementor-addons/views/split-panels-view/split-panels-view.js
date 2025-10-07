document.addEventListener('DOMContentLoaded', function() {
    // Wait for page to be fully loaded before enabling animations
    function initializePanels() {
        document.querySelectorAll('.split-panels').forEach(panelSet => {
            const panels = panelSet.querySelectorAll('.panel');
            
            if (!panels.length) return;

            // Skip the first panel (LCP image) as it's already loaded
            const otherPanels = Array.from(panels).slice(1);
            
            if (otherPanels.length) {
                // Lazy load backgrounds for non-LCP panels only
                const imageObserver = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const panel = entry.target;
                            const bg = panel.getAttribute('data-bg');
                            if (bg) {
                                const panelBg = panel.querySelector('.panel-bg');
                                if (panelBg && !panelBg.style.backgroundImage) {
                                    panelBg.style.backgroundImage = `url('${bg}')`;
                                }
                            }
                            obs.unobserve(panel);
                        }
                    });
                }, { 
                    rootMargin: '50px 0px',
                    threshold: 0.1 
                });

                // Observe non-LCP panels for lazy loading
                otherPanels.forEach(panel => imageObserver.observe(panel));
            }

            // Rest of the JavaScript remains the same...
            // Enable hover/animation behavior only on desktop after a delay
            function enablePanelInteractions() {
                if (window.innerWidth >= 1025) {
                    // Add class to enable animations only after page is stable
                    setTimeout(() => {
                        panelSet.classList.add('panels-ready');
                    }, 100); // Small delay to ensure layout is stable

                    panels.forEach(panel => {
                        // Use passive event listeners for better performance
                        panel.addEventListener('mouseenter', handleMouseEnter, { passive: true });
                        panel.addEventListener('mouseleave', handleMouseLeave, { passive: true });
                        panel.addEventListener('click', handlePanelClick, { passive: true });
                    });
                } else {
                    // Remove animations class on mobile/tablet
                    panelSet.classList.remove('panels-ready');
                }
            }

            function handleMouseEnter() {
                // Only animate if panels are ready
                if (panelSet.classList.contains('panels-ready')) {
                    panels.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                }
            }

            function handleMouseLeave() {
                // Keep content visible on mouse leave to prevent layout shifts
                this.classList.remove('active');
            }

            function handlePanelClick(e) {
                if (!e.target.closest('a') && panelSet.classList.contains('panels-ready')) {
                    const title = this.querySelector('h2') || this.querySelector('.vertical-label');
                    if (title) {
                        console.log('Clicked:', title.textContent);
                    }
                }
            }

            // Initialize interactions
            enablePanelInteractions();

            // Debounced resize handler to prevent excessive recalculations
            let resizeTimer;
            function handleResize() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    // Clean up existing event listeners
                    panels.forEach(panel => {
                        panel.removeEventListener('mouseenter', handleMouseEnter);
                        panel.removeEventListener('mouseleave', handleMouseLeave);
                        panel.removeEventListener('click', handlePanelClick);
                        panel.classList.remove('active');
                    });
                    
                    // Re-initialize with current viewport
                    enablePanelInteractions();
                }, 250);
            }

            window.addEventListener('resize', handleResize, { passive: true });

            // Cleanup function for memory management
            function cleanup() {
                if (otherPanels.length) {
                    imageObserver.disconnect();
                }
                window.removeEventListener('resize', handleResize);
                panels.forEach(panel => {
                    panel.removeEventListener('mouseenter', handleMouseEnter);
                    panel.removeEventListener('mouseleave', handleMouseLeave);
                    panel.removeEventListener('click', handlePanelClick);
                });
            }

            // Store cleanup function for potential later use
            panelSet._splitPanelsCleanup = cleanup;
        });
    }

    // Initialize immediately if page is already loaded, otherwise wait
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializePanels);
    } else {
        // Use requestAnimationFrame to ensure DOM is fully rendered
        requestAnimationFrame(initializePanels);
    }
});