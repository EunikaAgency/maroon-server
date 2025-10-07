document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            if (isActive) {
                // Collapse
                answer.style.height = answer.scrollHeight + 'px'; // set current height
                requestAnimationFrame(() => {
                    answer.style.height = '0';
                });
                item.classList.remove('active');
            } else {
                // Collapse any currently active FAQ
                const currentlyActive = document.querySelector('.faq-item.active');
                if (currentlyActive) {
                    const activeAnswer = currentlyActive.querySelector('.faq-answer');
                    activeAnswer.style.height = activeAnswer.scrollHeight + 'px';
                    requestAnimationFrame(() => {
                        activeAnswer.style.height = '0';
                    });
                    currentlyActive.classList.remove('active');
                }

                // Expand clicked FAQ
                item.classList.add('active');
                answer.style.height = answer.scrollHeight + 'px';
            }
        });

        // Reset height after transition for dynamic content
        answer.addEventListener('transitionend', () => {
            if (item.classList.contains('active')) {
                answer.style.height = 'auto';
            }
        });
    });
});
