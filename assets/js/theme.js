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
const videoModalEmbed = document.getElementById("videoModalEmbed");
const videoModalTitle = document.getElementById("videoModalTitle");

if (videoTipTriggers.length && videoModal && closeVideoModal && videoModalPlayer && videoModalSource && videoModalEmbed && videoModalTitle) {
    const openVideoModal = (mode, src, title) => {
        videoModalTitle.textContent = title;

        if (mode === "embed") {
            videoModalPlayer.pause();
            videoModalPlayer.currentTime = 0;
            videoModalSource.src = "";
            videoModalPlayer.load();
            videoModalPlayer.hidden = true;
            videoModalEmbed.hidden = false;
            videoModalEmbed.src = src;
        } else {
            videoModalEmbed.src = "";
            videoModalEmbed.hidden = true;
            videoModalPlayer.hidden = false;
            videoModalSource.src = src;
            videoModalPlayer.load();
        }

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
        videoModalPlayer.hidden = false;
        videoModalEmbed.src = "";
        videoModalEmbed.hidden = true;
        document.body.style.overflow = "";
    };

    videoTipTriggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
            openVideoModal(trigger.dataset.videoMode || "file", trigger.dataset.videoSrc || "", trigger.dataset.videoTitle || "");
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

const wishlistButtons = document.querySelectorAll(".re-style-wishlist-button");

if (wishlistButtons.length) {
    const wishlistStorageKey = "mio_wishlist_items";

    const getWishlistItems = () => {
        try {
            const rawValue = window.localStorage.getItem(wishlistStorageKey);
            const items = rawValue ? JSON.parse(rawValue) : [];
            return Array.isArray(items) ? items.map((item) => String(item)) : [];
        } catch (error) {
            return [];
        }
    };

    const setWishlistItems = (items) => {
        window.localStorage.setItem(wishlistStorageKey, JSON.stringify(items));
        document.dispatchEvent(new CustomEvent("re-style-wishlist-updated", { detail: { items } }));
    };

    const syncWishlistButtons = () => {
        const items = getWishlistItems();

        wishlistButtons.forEach((button) => {
            const productId = String(button.dataset.productId || "");
            const isActive = items.includes(productId);

            button.classList.toggle("is-active", isActive);
            button.setAttribute("aria-pressed", isActive ? "true" : "false");
        });
    };

    wishlistButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();

            const productId = String(button.dataset.productId || "");

            if (!productId) {
                return;
            }

            let items = getWishlistItems();

            if (items.includes(productId)) {
                items = items.filter((item) => item !== productId);
            } else {
                items.push(productId);
            }

            setWishlistItems(items);
            syncWishlistButtons();
        });
    });

    syncWishlistButtons();
    document.addEventListener("re-style-wishlist-updated", syncWishlistButtons);
    window.addEventListener("storage", syncWishlistButtons);
}

const quantityWrappers = document.querySelectorAll(".single-product div.product form.cart .quantity");

quantityWrappers.forEach((wrapper) => {
    const input = wrapper.querySelector("input.qty");
    const minusButton = wrapper.querySelector(".re-style-quantity-button--minus");
    const plusButton = wrapper.querySelector(".re-style-quantity-button--plus");

    if (!input || !minusButton || !plusButton) {
        return;
    }

    const min = Number.parseFloat(input.getAttribute("min") || "0");
    const max = Number.parseFloat(input.getAttribute("max") || "");
    const step = Number.parseFloat(input.getAttribute("step") || "1") || 1;

    const clampValue = (value) => {
        let nextValue = value;

        if (!Number.isNaN(min)) {
            nextValue = Math.max(min, nextValue);
        }

        if (!Number.isNaN(max)) {
            nextValue = Math.min(max, nextValue);
        }

        return nextValue;
    };

    const updateValue = (direction) => {
        const currentValue = Number.parseFloat(input.value || "0");
        const safeCurrent = Number.isNaN(currentValue) ? (Number.isNaN(min) ? 0 : min) : currentValue;
        const nextValue = clampValue(safeCurrent + (step * direction));
        const decimals = step % 1 === 0 ? 0 : (step.toString().split(".")[1] || "").length;

        input.value = nextValue.toFixed(decimals);
        input.dispatchEvent(new Event("change", { bubbles: true }));
    };

    minusButton.addEventListener("click", () => updateValue(-1));
    plusButton.addEventListener("click", () => updateValue(1));
});

const reviewSections = document.querySelectorAll(".single-product .re-style-single-reviews-section");

reviewSections.forEach((section) => {
    const reviewsRoot = section.querySelector("#reviews");

    if (!reviewsRoot) {
        return;
    }

    const allowedSelectors = ["#comments", "#review_form_wrapper", ".woocommerce-verification-required"];

    Array.from(reviewsRoot.children).forEach((child) => {
        const isAllowed = allowedSelectors.some((selector) => child.matches(selector));

        if (!isAllowed) {
            child.remove();
        }
    });

    reviewsRoot.querySelectorAll(
        "aside, .widget, .widget-area, .sidebar, .site-sidebar, #secondary, #primary-sidebar"
    ).forEach((node) => node.remove());
});

const shopFiltersToggle = document.querySelector(".shop-filters-toggle");
const shopFiltersPanel = document.getElementById("shop-filters-panel");
const shopFiltersClose = document.querySelector(".shop-filters-close");
const shopFiltersOverlay = document.querySelector(".shop-filters-overlay");
const shopForms = document.querySelectorAll(".shop-search, .shop-toolbar-actions, .shop-filters-card");
const shopSortSelects = document.querySelectorAll(".shop-toolbar-actions select");

const closeAllShopCustomSelects = (exception) => {
    document.querySelectorAll(".shop-custom-select.is-open").forEach((customSelect) => {
        if (exception && customSelect === exception) {
            return;
        }

        const trigger = customSelect.querySelector(".shop-custom-select__trigger");

        customSelect.classList.remove("is-open");

        if (trigger) {
            trigger.setAttribute("aria-expanded", "false");
        }
    });
};

shopSortSelects.forEach((select, selectIndex) => {
    if (!(select instanceof HTMLSelectElement) || select.dataset.customized === "true") {
        return;
    }

    const form = select.closest("form");
    const wrapper = document.createElement("div");
    const trigger = document.createElement("button");
    const list = document.createElement("div");
    const optionButtons = [];

    select.dataset.customized = "true";
    select.classList.add("shop-native-select");

    wrapper.className = "shop-custom-select";
    trigger.className = "shop-custom-select__trigger";
    trigger.type = "button";
    trigger.setAttribute("aria-haspopup", "listbox");
    trigger.setAttribute("aria-expanded", "false");
    trigger.setAttribute("aria-controls", `shop-custom-select-${selectIndex}`);

    list.className = "shop-custom-select__list";
    list.id = `shop-custom-select-${selectIndex}`;
    list.setAttribute("role", "listbox");
    list.tabIndex = -1;

    const openSelect = () => {
        closeAllShopCustomSelects(wrapper);
        wrapper.classList.add("is-open");
        trigger.setAttribute("aria-expanded", "true");
    };

    const closeSelect = () => {
        wrapper.classList.remove("is-open");
        trigger.setAttribute("aria-expanded", "false");
    };

    const syncSelectedOption = () => {
        const selectedOption = select.options[select.selectedIndex];
        const selectedValue = selectedOption ? selectedOption.value : "";
        const selectedLabel = selectedOption ? selectedOption.textContent.trim() : "";

        trigger.textContent = selectedLabel;

        optionButtons.forEach((button) => {
            const isSelected = button.dataset.value === selectedValue;

            button.classList.toggle("is-selected", isSelected);
            button.setAttribute("aria-selected", isSelected ? "true" : "false");
        });
    };

    Array.from(select.options).forEach((option) => {
        const optionButton = document.createElement("button");

        optionButton.type = "button";
        optionButton.className = "shop-custom-select__option";
        optionButton.setAttribute("role", "option");
        optionButton.dataset.value = option.value;
        optionButton.textContent = option.textContent.trim();

        optionButton.addEventListener("click", () => {
            if (select.value !== option.value) {
                select.value = option.value;
                select.dispatchEvent(new Event("change", { bubbles: true }));

                if (!select.getAttribute("onchange") && form instanceof HTMLFormElement) {
                    if (typeof form.requestSubmit === "function") {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            }

            syncSelectedOption();
            closeSelect();
            trigger.focus();
        });

        optionButton.addEventListener("keydown", (event) => {
            const currentIndex = optionButtons.indexOf(optionButton);
            const previousButton = optionButtons[currentIndex - 1];
            const nextButton = optionButtons[currentIndex + 1];

            if (event.key === "ArrowDown") {
                event.preventDefault();
                (nextButton || optionButtons[0])?.focus();
            }

            if (event.key === "ArrowUp") {
                event.preventDefault();
                (previousButton || optionButtons[optionButtons.length - 1])?.focus();
            }

            if (event.key === "Escape") {
                event.preventDefault();
                closeSelect();
                trigger.focus();
            }
        });

        optionButtons.push(optionButton);
        list.append(optionButton);
    });

    trigger.addEventListener("click", () => {
        const isOpen = wrapper.classList.contains("is-open");

        if (isOpen) {
            closeSelect();
            return;
        }

        openSelect();
    });

    trigger.addEventListener("keydown", (event) => {
        if (event.key === "ArrowDown" || event.key === "ArrowUp" || event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            openSelect();

            const selectedButton = optionButtons.find((button) => button.classList.contains("is-selected"));
            (selectedButton || optionButtons[0])?.focus();
        }

        if (event.key === "Escape") {
            closeSelect();
        }
    });

    select.addEventListener("change", syncSelectedOption);

    wrapper.append(trigger, list);
    select.insertAdjacentElement("afterend", wrapper);
    syncSelectedOption();
});

shopForms.forEach((form) => {
    if (!(form instanceof HTMLFormElement) || form.method.toLowerCase() !== "get") {
        return;
    }

    form.addEventListener("submit", () => {
        const fields = form.querySelectorAll("input[name], select[name], textarea[name]");

        fields.forEach((field) => {
            if (
                field instanceof HTMLInputElement ||
                field instanceof HTMLSelectElement ||
                field instanceof HTMLTextAreaElement
            ) {
                const isCheckbox = field instanceof HTMLInputElement && (field.type === "checkbox" || field.type === "radio");
                const value = typeof field.value === "string" ? field.value.trim() : "";

                if ((isCheckbox && !field.checked) || (!isCheckbox && value === "")) {
                    field.disabled = true;
                }
            }
        });
    });
});

document.addEventListener("click", (event) => {
    if (!(event.target instanceof Element) || event.target.closest(".shop-custom-select")) {
        return;
    }

    closeAllShopCustomSelects();
});

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
        closeAllShopCustomSelects();
    }
});

if (shopFiltersToggle && shopFiltersPanel && shopFiltersClose && shopFiltersOverlay) {
    const mobileBreakpoint = 1024;

    const closeShopFilters = () => {
        document.body.classList.remove("shop-filters-open");
        shopFiltersToggle.setAttribute("aria-expanded", "false");
        shopFiltersPanel.setAttribute("aria-hidden", "true");
    };

    const openShopFilters = () => {
        document.body.classList.add("shop-filters-open");
        shopFiltersToggle.setAttribute("aria-expanded", "true");
        shopFiltersPanel.setAttribute("aria-hidden", "false");
    };

    if (window.innerWidth <= mobileBreakpoint) {
        shopFiltersPanel.setAttribute("aria-hidden", "true");
    }

    shopFiltersToggle.addEventListener("click", () => {
        const isOpen = document.body.classList.contains("shop-filters-open");

        if (isOpen) {
            closeShopFilters();
            return;
        }

        openShopFilters();
    });

    shopFiltersClose.addEventListener("click", closeShopFilters);
    shopFiltersOverlay.addEventListener("click", closeShopFilters);

    window.addEventListener("resize", () => {
        if (window.innerWidth > mobileBreakpoint) {
            document.body.classList.remove("shop-filters-open");
            shopFiltersToggle.setAttribute("aria-expanded", "false");
            shopFiltersPanel.setAttribute("aria-hidden", "false");
            return;
        }

        if (!document.body.classList.contains("shop-filters-open")) {
            shopFiltersPanel.setAttribute("aria-hidden", "true");
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && document.body.classList.contains("shop-filters-open")) {
            closeShopFilters();
        }
    });
}
