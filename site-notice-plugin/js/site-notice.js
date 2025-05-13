document.addEventListener("DOMContentLoaded", function () {
    const notice = document.querySelector(".site-notice-bar");
    const closeBtn = document.querySelector(".site-notice-close");

    if (notice && closeBtn) {
        closeBtn.addEventListener("click", function () {
            notice.style.display = "none";
            document.cookie = "site_notice_dismissed=true; path=/; max-age=" + 60 * 60 * 24 * 7;
        });
    }
});
