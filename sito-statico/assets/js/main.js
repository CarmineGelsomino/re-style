const serviceCards = document.querySelectorAll('.service-card');
    const serviceModal = document.getElementById('serviceModal');
    const serviceModalTitle = document.getElementById('serviceModalTitle');
    const serviceModalDescription = document.getElementById('serviceModalDescription');
    const closeServiceModal = document.getElementById('closeServiceModal');

    serviceCards.forEach(card => {
        card.addEventListener('click', () => {
            const title = card.getAttribute('data-title');
            const description = card.getAttribute('data-description');

            serviceModalTitle.textContent = title;
            serviceModalDescription.textContent = description;

            serviceModal.classList.add('active');
            serviceModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeModal() {
        serviceModal.classList.remove('active');
        serviceModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    closeServiceModal.addEventListener('click', closeModal);

    serviceModal.addEventListener('click', (e) => {
        if (e.target === serviceModal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && serviceModal.classList.contains('active')) {
            closeModal();
        }
    });
const galleryCards = document.querySelectorAll('.gallery-card');

galleryCards.forEach((card) => {
    const img = card.querySelector('img');
    const images = card.dataset.images.split(',').map(src => src.trim());

    let currentIndex = 0;
    let intervalId = null;
    let isAnimating = false;

    const preload = (src) => {
        return new Promise((resolve) => {
            const preImg = new Image();
            preImg.src = src;

            if (preImg.decode) {
                preImg.decode().then(resolve).catch(resolve);
            } else {
                preImg.onload = resolve;
                preImg.onerror = resolve;
            }
        });
    };

    Promise.all(images.map(preload));

    const changeImage = async (nextIndex) => {
        if (isAnimating) return;
        isAnimating = true;

        const nextSrc = images[nextIndex];
        await preload(nextSrc);

        img.style.opacity = '0';

        const onFadeOut = () => {
            img.removeEventListener('transitionend', onFadeOut);

            img.src = nextSrc;

            requestAnimationFrame(() => {
                img.style.opacity = '1';
                currentIndex = nextIndex;
                isAnimating = false;
            });
        };

        img.addEventListener('transitionend', onFadeOut, { once: true });
    };

    card.addEventListener('mouseenter', () => {
        if (intervalId) return;

        intervalId = setInterval(() => {
            const nextIndex = (currentIndex + 1) % images.length;
            changeImage(nextIndex);
        }, 1200);
    });

    card.addEventListener('mouseleave', () => {
        clearInterval(intervalId);
        intervalId = null;
        changeImage(0);
    });
});
/* Dropdown Shop */
const shopDropdown = document.querySelector('.nav-dropdown');
const shopToggle = document.querySelector('.nav-dropdown-toggle');

if (shopDropdown && shopToggle) {
    shopToggle.addEventListener('click', (e) => {
        e.stopPropagation();

        const isOpen = shopDropdown.classList.toggle('open');
        shopToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', (e) => {
        if (!shopDropdown.contains(e.target)) {
            shopDropdown.classList.remove('open');
            shopToggle.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            shopDropdown.classList.remove('open');
            shopToggle.setAttribute('aria-expanded', 'false');
        }
    });
}
/* Videoconsigli */
const videoTipTriggers = document.querySelectorAll(".video-tip-trigger");
const videoModal = document.getElementById("videoModal");
const closeVideoModalBtn = document.getElementById("closeVideoModal");
const videoModalPlayer = document.getElementById("videoModalPlayer");
const videoModalSource = document.getElementById("videoModalSource");
const videoModalTitle = document.getElementById("videoModalTitle");

if (
    videoTipTriggers.length &&
    videoModal &&
    closeVideoModalBtn &&
    videoModalPlayer &&
    videoModalSource &&
    videoModalTitle
) {
    const openVideoModal = (src, title) => {
        videoModalSource.src = src;
        videoModalTitle.textContent = title;
        videoModalPlayer.load();
        videoModal.classList.add("active");
        videoModal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    };

    const closeVideoModal = () => {
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
            const src = trigger.dataset.videoSrc;
            const title = trigger.dataset.videoTitle || "Videoconsiglio";
            openVideoModal(src, title);
        });
    });

    closeVideoModalBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        closeVideoModal();
    });

    videoModal.addEventListener("click", (e) => {
        if (e.target === videoModal) {
            closeVideoModal();
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && videoModal.classList.contains("active")) {
            closeVideoModal();
        }
    });
}
/* FAQ */
const faqItems = document.querySelectorAll(".faq-item");

faqItems.forEach((item) => {
    const button = item.querySelector(".faq-question");
    const answer = item.querySelector(".faq-answer");

    button.addEventListener("click", () => {
        const isOpen = item.classList.contains("open");

        faqItems.forEach((otherItem) => {
            const otherButton = otherItem.querySelector(".faq-question");
            const otherAnswer = otherItem.querySelector(".faq-answer");

            otherItem.classList.remove("open");
            otherButton.setAttribute("aria-expanded", "false");
            otherAnswer.setAttribute("aria-hidden", "true");
        });

        if (!isOpen) {
            item.classList.add("open");
            button.setAttribute("aria-expanded", "true");
            answer.setAttribute("aria-hidden", "false");
        }
    });
});