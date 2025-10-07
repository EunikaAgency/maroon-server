document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.ea-faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.ea-faq-question');
        const answer = item.querySelector('.ea-faq-answer');

        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            if (isActive) {
                // Collapse
                answer.style.height = answer.scrollHeight + 'px'; 
                requestAnimationFrame(() => {
                    answer.style.height = '0';
                });
                item.classList.remove('active');
            } else {
                // Collapse currently active
                const activeItem = document.querySelector('.ea-faq-item.active');
                if (activeItem) {
                    const activeAnswer = activeItem.querySelector('.ea-faq-answer');
                    activeAnswer.style.height = activeAnswer.scrollHeight + 'px';
                    requestAnimationFrame(() => {
                        activeAnswer.style.height = '0';
                    });
                    activeItem.classList.remove('active');
                }

                // Expand clicked
                item.classList.add('active');
                answer.style.height = answer.scrollHeight + 'px';
            }
        });

        // After transition, lock to auto height
        answer.addEventListener('transitionend', () => {
            if (item.classList.contains('active')) {
                answer.style.height = 'auto';
            }
        });
    });
});
