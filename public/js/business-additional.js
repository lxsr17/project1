document.addEventListener('DOMContentLoaded', function () {
    // ✅ تفرغ البيانات المحفوظة عند فتح الصفحة
    localStorage.removeItem('businessData');

    const form = document.getElementById('businessAdditionalForm');
    const backBtn = document.getElementById('backBtn');

    function isValidUrl(url) {
        return url.startsWith('http://') || url.startsWith('https://');
    }

    form?.addEventListener('submit', function (e) {
        e.preventDefault();

        const twitter = form['twitter'].value.trim();
        const instagram = form['instagram'].value.trim();
        const tiktok = form['tiktok'].value.trim();
        const website = form['website'].value.trim();
        const whatsapp = form['whatsapp'].value.trim();
        const androidApp = form['androidApp'].value.trim();
        const iosApp = form['iosApp'].value.trim();
        const telegram = form['telegram'].value.trim();

        // ✅ تحقق من وجود حساب واحد على الأقل
        if (!twitter && !instagram && !tiktok) {
            alert("يجب إدخال حساب واحد على الأقل من (تويتر، انستقرام، أو تيك توك).");
            return;
        }

        const socialLinks = {
            "تويتر": twitter,
            "انستقرام": instagram,
            "تيك توك": tiktok
        };

        for (let [label, value] of Object.entries(socialLinks)) {
            if (value && !isValidUrl(value)) {
                alert(`الرابط غير صالح في: ${label}`);
                return;
            }
        }

        if (!website) {
            alert("الرجاء إدخال رابط الموقع الإلكتروني.");
            return;
        }
        if (!isValidUrl(website)) {
            alert("رابط الموقع الإلكتروني غير صالح.");
            return;
        }

        if (!whatsapp) {
            alert("الرجاء إدخال رابط محادثة واتساب.");
            return;
        }
        if (!isValidUrl(whatsapp)) {
            alert("رابط واتساب غير صالح.");
            return;
        }

        if (androidApp && !isValidUrl(androidApp)) {
            alert("رابط تطبيق Android غير صالح.");
            return;
        }

        if (iosApp && !isValidUrl(iosApp)) {
            alert("رابط تطبيق iOS غير صالح.");
            return;
        }

        if (telegram && !isValidUrl(telegram)) {
            alert("رابط تيليجرام غير صالح.");
            return;
        }

        // ✅ حفظ مؤقت إذا احتجت
        const data = {
            twitter, instagram, tiktok,
            showTwitter: form['showTwitter'].checked,
            showInstagram: form['showInstagram'].checked,
            showTiktok: form['showTiktok'].checked,
            website, androidApp, iosApp, whatsapp, telegram
        };

        localStorage.setItem('businessData', JSON.stringify(data));
        form.submit();
    });

    backBtn?.addEventListener('click', () => {
        window.location.href = './business-policies';
    });

});
