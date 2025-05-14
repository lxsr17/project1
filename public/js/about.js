import { insertUserHeader } from './components/user-header.js';

document.addEventListener('DOMContentLoaded', function() {
    // Insert user header
    insertUserHeader();

    const isAdmin = localStorage.getItem('isAdmin') === 'true';
    const adminControls = document.getElementById('adminControls');
    const editContentBtn = document.getElementById('editContentBtn');
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');
    const cancelEdit = document.getElementById('cancelEdit');
    const editContentForm = document.getElementById('editContentForm');

    // Show admin controls if user is admin
    if (isAdmin) {
        adminControls.style.display = 'flex';
    }

    // Get content elements
    const aboutText = document.getElementById('aboutText');
    const editAboutText = document.getElementById('editAboutText');

    // Load saved content from localStorage
    function loadContent() {
        const savedContent = JSON.parse(localStorage.getItem('aboutContent') || '{}');
        if (savedContent.about) aboutText.innerHTML = savedContent.about;
    }

    // Save content to localStorage
    function saveContent(content) {
        localStorage.setItem('aboutContent', JSON.stringify(content));
    }

    // Show edit modal
    editContentBtn?.addEventListener('click', () => {
        editAboutText.value = aboutText.innerHTML.trim();
        editModal.classList.add('active');
    });

    // Close modal
    function closeEditModal() {
        editModal.classList.remove('active');
    }

    closeModal?.addEventListener('click', closeEditModal);
    cancelEdit?.addEventListener('click', closeEditModal);

    // Close modal when clicking outside
    editModal?.addEventListener('click', (e) => {
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Handle form submission
    editContentForm?.addEventListener('submit', (e) => {
        e.preventDefault();

        const content = {
            about: editAboutText.value.trim()
        };

        // Update content
        aboutText.innerHTML = content.about;

        // Save to localStorage
        saveContent(content);

        // Close modal
        closeEditModal();

        // Show success message
        alert('تم حفظ التغييرات بنجاح');
    });

    // Load initial content
    loadContent();
});