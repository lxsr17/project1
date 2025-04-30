document.addEventListener('DOMContentLoaded', function () {
    const logoutAllBtn = document.querySelector('.logout-all-btn');
    const addVerificationBtn = document.querySelector('.add-verification-btn');
    const emailVerifiedBadge = document.getElementById('emailVerifiedBadge');
    const phoneVerifiedBadge = document.getElementById('phoneVerifiedBadge');
    const verifyEmailBtn = document.getElementById('verifyEmailBtn');
    const verifyPhoneBtn = document.getElementById('verifyPhoneBtn');

    // تحديث واجهة التحقق (واجهة فقط)
    function updateVerificationUI(type, status) {
        if (type === 'email') {
            if (status) {
                emailVerifiedBadge.style.display = 'flex';
                verifyEmailBtn?.remove();
            }
        } else if (type === 'phone') {
            if (status) {
                phoneVerifiedBadge.style.display = 'flex';
                verifyPhoneBtn?.remove();
            }
        }
    }

    // زر التحقق من الإيميل
    verifyEmailBtn?.addEventListener('click', () => {
        alert('تم إرسال رابط تحقق إلى بريدك الإلكتروني');
        updateVerificationUI('email', true);
    });

    // زر التحقق من الجوال
    verifyPhoneBtn?.addEventListener('click', () => {
        alert('تم إرسال رمز تحقق إلى رقم جوالك');
        updateVerificationUI('phone', true);
    });

    // زر تسجيل الخروج من جميع الجلسات
    logoutAllBtn?.addEventListener('click', () => {
        if (confirm('هل تريد تسجيل الخروج من جميع الجلسات؟')) {
            fetch('/logout-all-sessions', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
                .then(res => {
                    if (res.ok) {
                        alert('تم تسجيل الخروج من جميع الجلسات بنجاح');
                        location.reload();
                    } else {
                        alert('حدث خطأ أثناء تسجيل الخروج من الجلسات');
                    }
                })
                .catch(() => alert('فشل الاتصال بالخادم'));
        }
    });

    // زر إضافة وسيلة تحقق
    addVerificationBtn?.addEventListener('click', () => {
        alert('سيتم تحويلك إلى صفحة إعداد التحقق بخطوتين لاحقاً');
    });
    document.addEventListener('DOMContentLoaded', function () {
        const logoutAllBtn = document.querySelector('.logout-all-btn');
        const addVerificationBtn = document.querySelector('.add-verification-btn');
        const emailVerifiedBadge = document.getElementById('emailVerifiedBadge');
        const phoneVerifiedBadge = document.getElementById('phoneVerifiedBadge');
        const verifyEmailBtn = document.getElementById('verifyEmailBtn');
        const verifyPhoneBtn = document.getElementById('verifyPhoneBtn');
        const sessionsContent = document.getElementById('sessionsContent');
    
        // تحميل الجلسات النشطة
        function loadSessions() {
            fetch('/profile/sessions') // لازم يكون هذا الراوت شغال
                .then(response => response.json())
                .then(sessions => {
                    sessionsContent.innerHTML = '';
    
                    if (sessions.length === 0) {
                        sessionsContent.innerHTML = '<div class="empty-state">لا توجد جلسات نشطة حالياً</div>';
                        return;
                    }
    
                    sessions.forEach(session => {
                        const div = document.createElement('div');
                        div.className = 'session-row';
                        div.innerHTML = `
                            <div>${getDeviceType(session.user_agent)}</div>
                            <div>${session.ip_address}</div>
                            <div>${formatDate(session.created_at)}</div>
                            <div>${formatDate(session.last_activity)}</div>
                            <div>غير معروف</div>
                        `;
                        sessionsContent.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error('خطأ أثناء تحميل الجلسات:', error);
                    sessionsContent.innerHTML = '<div class="empty-state">حدث خطأ أثناء تحميل الجلسات</div>';
                });
        }
    
        // مساعدة: معرفة نوع الجهاز
        function getDeviceType(userAgent) {
            if (!userAgent) return 'غير معروف';
            if (/mobile/i.test(userAgent)) return 'جوال';
            if (/tablet/i.test(userAgent)) return 'تابلت';
            return 'كمبيوتر';
        }
    
        // مساعدة: تنسيق التاريخ
        function formatDate(datetime) {
            const date = new Date(datetime);
            return date.toLocaleString('ar-SA');
        }
    
        // زر التحقق من الإيميل
        verifyEmailBtn?.addEventListener('click', () => {
            alert('تم إرسال رابط تحقق إلى بريدك الإلكتروني');
            updateVerificationUI('email', true);
        });
    
        // زر التحقق من الجوال
        verifyPhoneBtn?.addEventListener('click', () => {
            alert('تم إرسال رمز تحقق إلى رقم جوالك');
            updateVerificationUI('phone', true);
        });
    
        // تحديث واجهة التحقق (واجهة فقط)
        function updateVerificationUI(type, status) {
            if (type === 'email') {
                if (status) {
                    emailVerifiedBadge.style.display = 'flex';
                    verifyEmailBtn?.remove();
                }
            } else if (type === 'phone') {
                if (status) {
                    phoneVerifiedBadge.style.display = 'flex';
                    verifyPhoneBtn?.remove();
                }
            }
        }
    
    // تسجيل الخروج من جميع الجلسات
    logoutAllBtn?.addEventListener('click', () => {
        if (confirm('هل أنت متأكد أنك تريد تسجيل الخروج من جميع الجلسات؟')) {
            fetch('/logout-all-sessions', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then(res => {
                if (res.ok) {
                    alert('تم تسجيل الخروج من جميع الجلسات بنجاح.');
                    window.location.reload();
                } else {
                    alert('حدث خطأ أثناء تسجيل الخروج.');
                }
            })
            .catch(() => {
                alert('فشل الاتصال بالخادم.');
            });
        }
    });

    // زر إضافة خيار تحقق
    addVerificationBtn?.addEventListener('click', () => {
        alert('سيتم تحويلك لاحقًا إلى صفحة إعداد التحقق بخطوتين.');
    });

    // جلب الجلسات
    function fetchSessions() {
        fetch('/sessions')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    sessionsContent.innerHTML = '';
                    data.forEach(session => {
                        sessionsContent.innerHTML += `
                            <div class="table-row">
                                <div class="cell">${session.device || 'غير معروف'}</div>
                                <div class="cell">${session.ip_address || '-'}</div>
                                <div class="cell">${session.created_at || '-'}</div>
                                <div class="cell">${session.last_activity || '-'}</div>
                                <div class="cell">${session.expires_at || '-'}</div>
                            </div>
                        `;
                    });
                } else {
                    sessionsContent.innerHTML = '<div class="empty-state">لا توجد جلسات نشطة حالياً</div>';
                }
            })
            .catch(() => {
                sessionsContent.innerHTML = '<div class="empty-state">فشل تحميل الجلسات</div>';
            });
    }

    fetchSessions();
});
