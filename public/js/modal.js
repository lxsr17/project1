// modal.js
export class Modal {
    constructor(options = {}) {
        this.options = {
            closeOnClickOutside: true,
            closeOnEscape: true,
            onClose: null,
            onOpen: null,
            ...options
        };
        
        this.isOpen = false;
        this.createModal();
        this.setupEventListeners();
    }

    createModal() {
        this.modal = document.createElement('div');
        this.modal.className = 'modal';

        this.content = document.createElement('div');
        this.content.className = 'modal-content';

        if (this.options.closeButton !== false) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'modal-close';
            closeBtn.innerHTML = '×';
            closeBtn.onclick = () => this.close();
            this.content.appendChild(closeBtn);
        }

        this.modal.appendChild(this.content);
        document.body.appendChild(this.modal);
    }

    setupEventListeners() {
        if (this.options.closeOnClickOutside) {
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) this.close();
            });
        }

        if (this.options.closeOnEscape) {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) this.close();
            });
        }
    }

    setContent(content) {
        if (typeof content === 'string') {
            this.content.innerHTML = content;
        } else if (content instanceof Element) {
            this.content.innerHTML = '';
            this.content.appendChild(content);
        }
        return this;
    }

    open() {
        this.isOpen = true;
        this.modal.classList.add('active');
        if (this.options.onOpen) this.options.onOpen();
        return this;
    }

    close() {
        this.isOpen = false;
        this.modal.classList.remove('active');
        if (this.options.onClose) this.options.onClose();
        return this;
    }

    destroy() {
        this.modal.remove();
    }
}

// ✅ تنفيذ المودال على زر الحذف
document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-confirm");
    const modalInstance = new Modal({ closeButton: false });

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const form = this.closest("form");

            const content = document.createElement("div");
            content.innerHTML = `
                <p>هل أنت متأكد أنك تريد حذف هذا المتجر؟ لا يمكن التراجع عن هذا الإجراء.</p>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button id="cancelModalBtn" style="padding: 0.5rem 1rem;">إلغاء</button>
                    <button id="confirmModalBtn" style="padding: 0.5rem 1rem; background: #dc3545; color: white;">حذف</button>
                </div>
            `;

            modalInstance.setContent(content).open();

            content.querySelector("#cancelModalBtn").onclick = () => modalInstance.close();
            content.querySelector("#confirmModalBtn").onclick = () => {
                form.submit();
                modalInstance.close();
            };
        });
    });
});
