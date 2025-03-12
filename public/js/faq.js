import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const isAdmin = localStorage.getItem('isAdmin') === 'true';
    const adminControls = document.getElementById('adminControls');
    const faqList = document.getElementById('faqList');
    const faqModal = document.getElementById('faqModal');
    const faqForm = document.getElementById('faqForm');
    const addFaqBtn = document.getElementById('addFaqBtn');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const modalTitle = document.getElementById('modalTitle');

    // Show admin controls if user is admin
    if (isAdmin) {
        adminControls.style.display = 'flex';
    }

    // Sample FAQ data
    const defaultFaqs = [
        {
            id: 1,
            question: 'هل خدمة تحقق مجانية؟ وهل يوجد رسوم للتسجيل؟',
            answer: 'خدمة تحقق مجانية وكل ما عليك هو التسجيل عبر الرابط https://sa'
        },
        {
            id: 2,
            question: 'كيف أسجل في تحقق؟',
            answer: 'التسجيل في معروف سهل وبسيط عن طريق الرابط https://tajir.maroof.sa/Agreement'
        }
    ];

    // Load FAQs from localStorage or use default
    let faqs = JSON.parse(localStorage.getItem('faqs')) || defaultFaqs;

    // Save FAQs to localStorage
    function saveFaqs() {
        localStorage.setItem('faqs', JSON.stringify(faqs));
    }

    // Create FAQ item HTML
    function createFaqItem(faq) {
        const faqItem = document.createElement('div');
        faqItem.className = 'faq-item';
        faqItem.dataset.id = faq.id;

        faqItem.innerHTML = `
            <div class="faq-question">
                <span class="question-text">${faq.question}</span>
                <div class="faq-actions" ${isAdmin ? '' : 'style="display: none;"'}>
                    <button class="action-btn edit-btn" title="تعديل">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/pen.svg" alt="Edit">
                    </button>
                    <button class="action-btn delete-btn" title="حذف">
                        <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/trash.svg" alt="Delete">
                    </button>
                </div>
                <div class="faq-toggle">
                    <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/chevron-down.svg" alt="Toggle">
                </div>
            </div>
            <div class="faq-answer">
                ${faq.answer.replace(/\n/g, '<br>')}
            </div>
        `;

        return faqItem;
    }

    // Display all FAQs
    function displayFaqs() {
        if (!faqList) return;
        faqList.innerHTML = '';
        faqs.forEach(faq => {
            faqList.appendChild(createFaqItem(faq));
        });
    }

    // Initialize FAQ list
    displayFaqs();

    // Add FAQ button click handler
    addFaqBtn?.addEventListener('click', () => {
        modalTitle.textContent = 'إضافة سؤال جديد';
        faqForm.reset();
        faqModal.classList.add('active');
    });

    // Close modal handlers
    closeModal?.addEventListener('click', () => faqModal.classList.remove('active'));
    cancelBtn?.addEventListener('click', () => faqModal.classList.remove('active'));

    // Handle form submission
    faqForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(faqForm);
        const newFaq = {
            id: Date.now(),
            question: formData.get('question'),
            answer: formData.get('answer')
        };

        faqs.push(newFaq);
        saveFaqs();
        displayFaqs();
        faqModal.classList.remove('active');
    });
});