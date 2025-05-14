function insertUserHeader() {
    const header = document.querySelector('header');
    if (header) {
        header.innerHTML += '<p>مرحباً بك!</p>';
    }
}

document.addEventListener('DOMContentLoaded', async function () {
    const recentReviews = document.getElementById('recentReviews');
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || '{}');

    try {
        const response = await fetch("/recent-reviews", {
            credentials: "include"
        });

        const reviews = await response.json();
        if (!Array.isArray(reviews)) throw new Error("البيانات المستلمة غير صالحة");

        recentReviews.innerHTML = '';

        reviews.forEach(review => {
            const reviewBox = document.createElement("div");
            reviewBox.classList.add("review-box");
            reviewBox.style.cursor = "pointer";
            reviewBox.style.position = "relative";

            reviewBox.innerHTML = `
                <h3 class="store-name"> - ${review.store_name}</h3>
                <p class="review-comment">"${review.comment}"</p>
                <div class="review-rating">
                    ${"★".repeat(review.rating)}${"☆".repeat(5 - review.rating)}
                </div>
                <p class="review-meta">بواسطة <strong>${review.reviewer}</strong> - ${new Date(review.review_date).toLocaleDateString("ar-EG")}</p>
            `;

            // ✅ إذا المستخدم الحالي هو صاحب التعليق، أضف زر الحذف
            if (review.user_id === currentUser.id) {
                const deleteBtn = document.createElement("button");
                deleteBtn.textContent = "حذف";
                deleteBtn.style.cssText = `
                    position: absolute;
                   bottom: 15px;
                    right: 10px;
                    color: red;
                    border: none;
                    padding: 5px 10px;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: bold;
                `;

                deleteBtn.addEventListener("click", async (e) => {
                    e.stopPropagation();
                    if (!confirm("هل أنت متأكد أنك تريد حذف هذا التقييم؟")) return;

                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(`/reviews/${review.review_id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": csrf
                        }
                    });

                    if (res.ok) {
                        reviewBox.remove();
                    } else {
                        alert("فشل في حذف التقييم.");
                    }
                });

                reviewBox.appendChild(deleteBtn);
            }

            // عند النقر على الكرت، يذهب لتفاصيل المتجر
            reviewBox.onclick = () => {
                window.location.href = `/store-details/${review.store_id}#review-${review.review_id}`;
            };

            recentReviews.appendChild(reviewBox);
        });

    } catch (error) {
        console.error("خطأ:", error);
        recentReviews.innerHTML = "<p>حدث خطأ أثناء تحميل التقييمات.</p>";
    }
});

    // البحث
    searchForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        const query = e.target.q.value.trim().toLowerCase();
        if (query) {
            window.location.href = `./stores.html?q=${encodeURIComponent(query)}`;
        }



        
    });
