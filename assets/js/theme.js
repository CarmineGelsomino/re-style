document.documentElement.classList.add("js");

const siteHeader = document.querySelector(".site-header");
const siteMenuToggle = document.querySelector(".site-header__menu-toggle");
const siteNavigation = document.getElementById("site-navigation");

if (siteHeader && siteMenuToggle && siteNavigation) {
    const closeSiteMenu = () => {
        siteHeader.classList.remove("is-menu-open");
        siteMenuToggle.setAttribute("aria-expanded", "false");
    };

    siteMenuToggle.addEventListener("click", () => {
        const isOpen = siteHeader.classList.toggle("is-menu-open");
        siteMenuToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    siteNavigation.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            if (window.innerWidth <= 782) {
                closeSiteMenu();
            }
        });
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth > 782) {
            closeSiteMenu();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeSiteMenu();
        }
    });
}

const serviceCards = document.querySelectorAll(".service-card");
const serviceModal = document.getElementById("serviceModal");
const serviceModalTitle = document.getElementById("serviceModalTitle");
const serviceModalDescription = document.getElementById("serviceModalDescription");
const closeServiceModal = document.getElementById("closeServiceModal");

if (serviceCards.length && serviceModal && serviceModalTitle && serviceModalDescription && closeServiceModal) {
    const closeModal = () => {
        serviceModal.classList.remove("active");
        serviceModal.classList.remove("is-active");
        serviceModal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    };

    serviceCards.forEach((card) => {
        card.addEventListener("click", () => {
            serviceModalTitle.textContent = card.dataset.title || "";
            serviceModalDescription.textContent = card.dataset.description || "";
            serviceModal.classList.add("active");
            serviceModal.classList.add("is-active");
            serviceModal.setAttribute("aria-hidden", "false");
            document.body.style.overflow = "hidden";
        });
    });

    closeServiceModal.addEventListener("click", closeModal);

    serviceModal.addEventListener("click", (event) => {
        if (event.target === serviceModal) {
            closeModal();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && serviceModal.classList.contains("is-active")) {
            closeModal();
        }
    });
}

const galleryCards = document.querySelectorAll(".gallery-card");

galleryCards.forEach((card) => {
    const img = card.querySelector("img");
    const images = (card.dataset.images || "").split(",").map((src) => src.trim()).filter(Boolean);

    if (!img || images.length < 2) {
        return;
    }

    let currentIndex = 0;
    let intervalId = null;

    card.addEventListener("mouseenter", () => {
        if (intervalId) {
            return;
        }

        intervalId = window.setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            img.style.opacity = "0";

            window.setTimeout(() => {
                img.src = images[currentIndex];
                img.style.opacity = "1";
            }, 140);
        }, 1200);
    });

    card.addEventListener("mouseleave", () => {
        if (intervalId) {
            window.clearInterval(intervalId);
            intervalId = null;
        }

        currentIndex = 0;
        img.src = images[0];
        img.style.opacity = "1";
    });
});

const faqItems = document.querySelectorAll(".faq-item");

faqItems.forEach((item) => {
    const button = item.querySelector(".faq-question");
    const answer = item.querySelector(".faq-answer");

    if (!button || !answer) {
        return;
    }

    button.addEventListener("click", () => {
        const isOpen = item.classList.contains("is-open");

        faqItems.forEach((otherItem) => {
            const otherButton = otherItem.querySelector(".faq-question");
            const otherAnswer = otherItem.querySelector(".faq-answer");

            otherItem.classList.remove("open");
            otherItem.classList.remove("is-open");

            if (otherButton) {
                otherButton.setAttribute("aria-expanded", "false");
            }

            if (otherAnswer) {
                otherAnswer.setAttribute("aria-hidden", "true");
            }
        });

        if (!isOpen) {
            item.classList.add("open");
            item.classList.add("is-open");
            button.setAttribute("aria-expanded", "true");
            answer.setAttribute("aria-hidden", "false");
        }
    });
});

const videoTipTriggers = document.querySelectorAll(".video-tip-trigger");
const videoModal = document.getElementById("videoModal");
const closeVideoModal = document.getElementById("closeVideoModal");
const videoModalPlayer = document.getElementById("videoModalPlayer");
const videoModalSource = document.getElementById("videoModalSource");
const videoModalTitle = document.getElementById("videoModalTitle");

if (videoTipTriggers.length && videoModal && closeVideoModal && videoModalPlayer && videoModalSource && videoModalTitle) {
    const openVideoModal = (src, title) => {
        videoModalSource.src = src;
        videoModalTitle.textContent = title;
        videoModalPlayer.load();
        videoModal.classList.add("active");
        videoModal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    };

    const closeVideo = () => {
        videoModal.classList.remove("active");
        videoModal.setAttribute("aria-hidden", "true");
        videoModalPlayer.pause();
        videoModalPlayer.currentTime = 0;
        videoModalSource.src = "";
        videoModalPlayer.load();
        document.body.style.overflow = "";
    };

    videoTipTriggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
            openVideoModal(trigger.dataset.videoSrc || "", trigger.dataset.videoTitle || "");
        });
    });

    closeVideoModal.addEventListener("click", closeVideo);

    videoModal.addEventListener("click", (event) => {
        if (event.target === videoModal) {
            closeVideo();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && videoModal.classList.contains("active")) {
            closeVideo();
        }
    });
}
