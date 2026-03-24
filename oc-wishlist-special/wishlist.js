jQuery(document).ready(function($) {
    'use strict';

    const WISHLIST_KEY = 'mio_wishlist_items';
    const settings = mio_wishlist_data.settings;
    let injectTimeout = null;

    function getWishlist() {
        const wishlist = localStorage.getItem(WISHLIST_KEY);
        return wishlist ? JSON.parse(wishlist) : [];
    }

    function saveWishlist(wishlist) {
        localStorage.setItem(WISHLIST_KEY, JSON.stringify(wishlist));
        $(document).trigger('wishlist_updated');
    }

    function showPopup(message) {
        $('.mio-wishlist-popup').remove();
        const popup = $('<div class="mio-wishlist-popup">' + message + '</div>');
        $('body').append(popup);
        setTimeout(() => popup.addClass('show'), 10);
        setTimeout(() => {
            popup.removeClass('show');
            setTimeout(() => popup.remove(), 300);
        }, 3000);
    }

    function getProductId($product) {
        let productId = null;

        const $button = $product.find('.add_to_cart_button[data-product_id], .single_add_to_cart_button[data-product_id]').first();
        const $dataLink = $product.find('[data-product_id]').first();

        if ($button.length) {
            productId = $button.data('product_id');
        } else if ($dataLink.length) {
            productId = $dataLink.data('product_id');
        } else {
            const classAttr = $product.attr('class') || '';
            const match = classAttr.match(/\bpost-(\d+)\b/);

            if (match && match[1]) {
                productId = match[1];
            }
        }

        return productId ? String(productId) : null;
    }

    function getProductContainers(context) {
        const $context = context ? $(context) : $(document.body);

        return $context.find('li.product, .wc-block-grid__product, .product.type-product').filter(function() {
            const $product = $(this);

            if (!$product.is('li.product, .wc-block-grid__product, .product.type-product')) {
                return false;
            }

            if ($product.closest('li.product, .wc-block-grid__product, .product.type-product')[0] !== this) {
                return false;
            }

            return true;
        });
    }

    function updateIcons() {
        const wishlist = getWishlist();

        $('.mio-wishlist-icon-wrapper').each(function() {
            const productId = String($(this).data('product-id'));
            const icon = $(this).find('.mio-wishlist-icon');

            if (wishlist.includes(productId)) {
                icon.addClass('added');
            } else {
                icon.removeClass('added');
            }
        });
    }

    function injectWishlistIcons(context) {
        getProductContainers(context).each(function() {
            const $product = $(this);

            if ($product.data('mioWishlistProcessed')) {
                return;
            }

            if ($product.children('.mio-wishlist-icon-wrapper').length) {
                $product.data('mioWishlistProcessed', true);
                return;
            }

            const productId = getProductId($product);

            if (!productId) {
                return;
            }

            const iconHtml = mio_wishlist_data.icon_html.replace('%d', productId);
            $product.prepend(iconHtml);
            $product.data('mioWishlistProcessed', true);
        });

        updateIcons();
    }

    function scheduleInject(context) {
        clearTimeout(injectTimeout);
        injectTimeout = setTimeout(() => {
            injectWishlistIcons(context);
        }, 150);
    }

    $(document).on('click', '.mio-wishlist-icon-wrapper', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const productId = String($(this).data('product-id'));
        let wishlist = getWishlist();

        if (wishlist.includes(productId)) {
            wishlist = wishlist.filter(id => id !== productId);
            showPopup(settings.label_removed);
        } else {
            wishlist.push(productId);
            showPopup(settings.label_added);
        }

        saveWishlist(wishlist);
    });

    function renderWishlistPage() {
        const wishlist = getWishlist();
        const container = $('#wishlist-grid-container');
        const emptyContainer = $('#wishlist-empty-container');

        if (!container.length) {
            return;
        }

        if (wishlist.length === 0) {
            container.hide();
            emptyContainer.show();
            return;
        }

        container.show();
        emptyContainer.hide();
        container.html('<p>Caricamento dei tuoi prodotti preferiti...</p>');

        $.post(mio_wishlist_data.ajax_url, {
            action: 'get_wishlist_products',
            nonce: mio_wishlist_data.nonce,
            product_ids: wishlist
        }, function(response) {
            if (!response.success) {
                return;
            }

            container.empty();

            if (response.data.length === 0) {
                container.hide();
                emptyContainer.show();
                return;
            }

            response.data.forEach(product => {
                const itemHtml = `
                    <div class="wishlist-item" data-product-id="${product.id}">
                        <a href="${product.permalink}">
                            <img src="${product.image_url || ''}" alt="${product.name}" class="wishlist-item-image">
                        </a>
                        <div class="wishlist-item-content">
                            <h3 class="wishlist-item-name">${product.name}</h3>
                            <div class="wishlist-item-price"><span class="price-label">${settings.label_price}</span> ${product.price_html}</div>
                            <button class="wishlist-item-remove" data-product-id="${product.id}">${settings.label_remove_item}</button>
                        </div>
                    </div>`;
                container.append(itemHtml);
            });
        });
    }

    $(document).on('click', '.wishlist-item-remove', function() {
        const productId = String($(this).data('product-id'));
        let wishlist = getWishlist();
        wishlist = wishlist.filter(id => id !== productId);
        saveWishlist(wishlist);
        showPopup(settings.label_removed);
    });

    $(document).on('wishlist_updated', function() {
        updateIcons();

        if ($('#mio-wishlist-page').length) {
            renderWishlistPage();
        }
    });

    injectWishlistIcons();

    if ($('#mio-wishlist-page').length) {
        renderWishlistPage();
    }

    const targetNode = document.body;

    if (targetNode) {
        const observer = new MutationObserver(function(mutationsList) {
            const hasRelevantNodes = mutationsList.some((mutation) => {
                return Array.from(mutation.addedNodes).some((node) => {
                    if (!(node instanceof Element)) {
                        return false;
                    }

                    return node.matches('li.product, .wc-block-grid__product, .product.type-product') ||
                        node.querySelector('li.product, .wc-block-grid__product, .product.type-product');
                });
            });

            if (hasRelevantNodes) {
                scheduleInject(document.body);
            }
        });

        observer.observe(targetNode, {
            childList: true,
            subtree: true
        });
    }
});