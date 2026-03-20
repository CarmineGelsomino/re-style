document.documentElement.classList.add("js");

const serviceCards = document.querySelectorAll(".service-card");
const serviceModal = document.getElementById("serviceModal");
const serviceModalTitle = document.getElementById("serviceModalTitle");
const serviceModalDescription = document.getElementById("serviceModalDescription");
const closeServiceModal = document.getElementById("closeServiceModal");

if (serviceCards.length && serviceModal && serviceModalTitle && serviceModalDescription && closeServiceModal) {
    const closeModal = () => {
        serviceModal.classList.remove("is-active");
        serviceModal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    };

    serviceCards.forEach((card) => {
        card.addEventListener("click", () => {
            serviceModalTitle.textContent = card.dataset.title || "";
            serviceModalDescription.textContent = card.dataset.description || "";
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

            otherItem.classList.remove("is-open");

            if (otherButton) {
                otherButton.setAttribute("aria-expanded", "false");
            }

            if (otherAnswer) {
                otherAnswer.setAttribute("aria-hidden", "true");
            }
        });

        if (!isOpen) {
            item.classList.add("is-open");
            button.setAttribute("aria-expanded", "true");
            answer.setAttribute("aria-hidden", "false");
        }
    });
});
