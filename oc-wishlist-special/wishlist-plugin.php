<?php
/**
 * Plugin Name:       O|C Wishlist Special
 * Plugin URI:        https://www.oc-corporation.it/
 * Description:       Aggiunge una funzionalità di lista dei preferiti a WooCommerce, con opzioni di personalizzazione complete.
 * Version:           1.0.0
 * Author:            O|C Corporation
 * Author URI:        https://www.oc-corporation.it/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mio-wishlist
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Mio_Wishlist_Plugin {

    private $settings;

    public function __construct() {
        $this->settings = get_option('mio_wishlist_settings', [
            'icon_color' => '#ff6b6b', 'icon_color_added' => '#e03131',
            'add_icon_custom' => '', 'remove_icon_custom' => '',
            'popup_bg_color' => '#333333', 'popup_text_color' => '#ffffff',
            'page_accent_color' => '#ff6b6b', 'page_bg_color' => '#f8f9fa',
            'label_added' => 'Prodotto aggiunto ai preferiti!', 'label_removed' => 'Prodotto rimosso dai preferiti.',
            'label_page_title' => 'La Mia Lista dei Preferiti', 'label_empty_list' => 'La tua lista dei preferiti è vuota.',
            'label_go_to_shop' => 'Torna allo shop', 'label_price' => 'Prezzo:', 'label_remove_item' => 'Rimuovi',
        ]);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_get_wishlist_products', [$this, 'get_wishlist_products_ajax']);
        add_action('wp_ajax_nopriv_get_wishlist_products', [$this, 'get_wishlist_products_ajax']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_head', [$this, 'add_dynamic_styles']);
        add_shortcode('mia_lista_preferiti', [$this, 'render_wishlist_page']);
        register_activation_hook(plugin_dir_path(__FILE__) . 'mio-wishlist.php', [$this, 'create_wishlist_page_on_activation']);
    }

    public function create_wishlist_page_on_activation() {
        if (get_page_by_path('lista-preferiti') === null) {
            wp_insert_post(['post_title' => 'Lista Preferiti', 'post_content' => '[mia_lista_preferiti]', 'post_status' => 'publish', 'post_author' => 1, 'post_type' => 'page']);
        }
    }

    public function add_admin_menu() {
        add_submenu_page('woocommerce', 'Impostazioni Wishlist', 'Impostazioni Wishlist', 'manage_options', 'mio-wishlist-settings', [$this, 'settings_page_html']);
    }

    public function settings_page_html() {
        if (!current_user_can('manage_options')) { return; }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php settings_fields('mio_wishlist_settings_group'); do_settings_sections('mio-wishlist-settings'); submit_button('Salva Impostazioni'); ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('mio_wishlist_settings_group', 'mio_wishlist_settings');
        add_settings_section('mio_wishlist_colors_section', 'Colori e Icone', null, 'mio-wishlist-settings');
        $this->add_color_field('icon_color', 'Colore Icona (Default)', 'mio_wishlist_colors_section');
        $this->add_color_field('icon_color_added', 'Colore Icona (Aggiunto)', 'mio_wishlist_colors_section');
        $this->add_text_field('add_icon_custom', 'URL Icona "Aggiungi" (Opzionale)', 'mio_wishlist_colors_section', 'Lascia vuoto per usare l\'icona a cuore di default.');
        $this->add_text_field('remove_icon_custom', 'URL Icona "Rimuovi" (Opzionale)', 'mio_wishlist_colors_section', 'Lascia vuoto per usare l\'icona a cuore di default.');
        add_settings_section('mio_wishlist_popup_section', 'Popup di Notifica', null, 'mio-wishlist-settings');
        $this->add_color_field('popup_bg_color', 'Colore Sfondo Popup', 'mio_wishlist_popup_section');
        $this->add_color_field('popup_text_color', 'Colore Testo Popup', 'mio_wishlist_popup_section');
        add_settings_section('mio_wishlist_page_section', 'Pagina Lista Preferiti', null, 'mio-wishlist-settings');
        $this->add_color_field('page_accent_color', 'Colore Accento Pagina', 'mio_wishlist_page_section');
        $this->add_color_field('page_bg_color', 'Colore Sfondo Pagina', 'mio_wishlist_page_section');
        add_settings_section('mio_wishlist_labels_section', 'Etichette e Testi', null, 'mio-wishlist-settings');
        $this->add_text_field('label_added', 'Testo Popup (Aggiunto)', 'mio_wishlist_labels_section');
        $this->add_text_field('label_removed', 'Testo Popup (Rimosso)', 'mio_wishlist_labels_section');
        $this->add_text_field('label_page_title', 'Titolo Pagina Preferiti', 'mio_wishlist_labels_section');
        $this->add_text_field('label_empty_list', 'Testo Lista Vuota', 'mio_wishlist_labels_section');
        $this->add_text_field('label_go_to_shop', 'Testo Bottone "Torna allo shop"', 'mio_wishlist_labels_section');
        $this->add_text_field('label_price', 'Etichetta Prezzo', 'mio_wishlist_labels_section');
        $this->add_text_field('label_remove_item', 'Etichetta Bottone "Rimuovi"', 'mio_wishlist_labels_section');
    }
    
    private function add_text_field($id, $title, $section, $description = '') {
        add_settings_field($id, $title, function() use ($id, $description) { printf('<input type="text" id="%1$s" name="mio_wishlist_settings[%1$s]" value="%2$s" class="regular-text" /><p class="description">%3$s</p>', esc_attr($id), esc_attr($this->settings[$id]), esc_html($description)); }, 'mio-wishlist-settings', $section);
    }
    private function add_color_field($id, $title, $section) {
        add_settings_field($id, $title, function() use ($id) { printf('<input type="color" id="%1$s" name="mio_wishlist_settings[%1$s]" value="%2$s" />', esc_attr($id), esc_attr($this->settings[$id])); }, 'mio-wishlist-settings', $section);
    }

    public function add_dynamic_styles() {
        $default_icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
        $add_icon_url = !empty($this->settings['add_icon_custom']) ? 'url(' . esc_url($this->settings['add_icon_custom']) . ')' : 'url("data:image/svg+xml,'.rawurlencode($default_icon_svg).'")';
        $remove_icon_url = !empty($this->settings['remove_icon_custom']) ? 'url(' . esc_url($this->settings['remove_icon_custom']) . ')' : 'url("data:image/svg+xml,'.rawurlencode($default_icon_svg).'")';
        ?>
        <style>
            :root {
                --wishlist-icon-color: <?php echo esc_attr($this->settings['icon_color']); ?>; --wishlist-icon-color-added: <?php echo esc_attr($this->settings['icon_color_added']); ?>;
                --wishlist-popup-bg: <?php echo esc_attr($this->settings['popup_bg_color']); ?>; --wishlist-popup-text: <?php echo esc_attr($this->settings['popup_text_color']); ?>;
                --wishlist-page-accent: <?php echo esc_attr($this->settings['page_accent_color']); ?>; --wishlist-page-bg: <?php echo esc_attr($this->settings['page_bg_color']); ?>;
            }
            /* Stile per il contenitore del prodotto per garantire il posizionamento corretto */
            .product, .wc-block-grid__product { position: relative !important; }
            .mio-wishlist-icon-wrapper { position: absolute; top: 10px; left: 10px; z-index: 10; cursor: pointer; }
            .mio-wishlist-icon { width: 28px; height: 28px; background-color: var(--wishlist-icon-color); -webkit-mask: <?php echo $add_icon_url; ?> no-repeat center; mask: <?php echo $add_icon_url; ?> no-repeat center; transition: transform 0.2s ease, background-color 0.2s ease; }
            .mio-wishlist-icon:hover { transform: scale(1.15); }
            .mio-wishlist-icon.added { background-color: var(--wishlist-icon-color-added); -webkit-mask: <?php echo $remove_icon_url; ?> no-repeat center; mask: <?php echo $remove_icon_url; ?> no-repeat center; }
            .mio-wishlist-popup { position: fixed; bottom: 20px; right: 20px; background-color: var(--wishlist-popup-bg); color: var(--wishlist-popup-text); padding: 15px 25px; border-radius: 8px; z-index: 9999; opacity: 0; transform: translateY(20px); transition: opacity 0.3s ease, transform 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
            .mio-wishlist-popup.show { opacity: 1; transform: translateY(0); }
            #mio-wishlist-page { background-color: var(--wishlist-page-bg); padding: 2em; border-radius: 8px; }
            #mio-wishlist-page .wishlist-title { color: var(--wishlist-page-accent); text-align: center; margin-bottom: 2em; font-size: 2.5em; }
            .wishlist-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; }
            .wishlist-item { background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; flex-direction: column; transition: transform 0.2s ease; }
            .wishlist-item:hover { transform: translateY(-5px); }
            .wishlist-item-image { width: 100%; height: 200px; object-fit: cover; }
            .wishlist-item-content { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
            .wishlist-item-name { font-size: 1.1em; font-weight: 600; margin: 0 0 10px 0; flex-grow: 1; }
            .wishlist-item-price { margin: 0 0 15px 0; font-size: 1.2em; font-weight: bold; color: #333; }
            .wishlist-item-price .price-label { font-weight: normal; font-size: 0.9em; color: #666; }
            .wishlist-item-remove { background-color: var(--wishlist-page-accent); color: #fff; border: none; padding: 10px; border-radius: 5px; cursor: pointer; text-align: center; text-decoration: none; transition: background-color 0.2s ease; }
            .wishlist-item-remove:hover { opacity: 0.85; }
            .wishlist-empty { text-align: center; padding: 4em 2em; }
            .wishlist-empty p { font-size: 1.2em; margin-bottom: 2em; }
            .wishlist-empty .button { background-color: var(--wishlist-page-accent); color: #fff; padding: 12px 25px; border-radius: 5px; text-decoration: none; }
        </style>
        <?php
    }

    public function enqueue_assets() {
        wp_enqueue_script('mio-wishlist-js', plugin_dir_url(__FILE__) . 'wishlist.js', ['jquery'], '1.3.0', true);
        wp_localize_script('mio-wishlist-js', 'mio_wishlist_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wishlist_nonce'),
            'settings' => $this->settings,
            'shop_url' => get_permalink(wc_get_page_id('shop')),
            'icon_html' => '<div class="mio-wishlist-icon-wrapper" data-product-id="%d"><div class="mio-wishlist-icon"></div></div>',
        ]);
    }

    public function get_wishlist_products_ajax() {
        check_ajax_referer('wishlist_nonce', 'nonce');
        $product_ids = isset($_POST['product_ids']) ? array_map('intval', $_POST['product_ids']) : [];
        if (empty($product_ids)) { wp_send_json_success([]); }
        $products_data = [];
        foreach ($product_ids as $id) {
            $product = wc_get_product($id);
            if ($product) {
                $products_data[] = [
                    'id' => $id, 'name' => $product->get_name(), 'price_html' => $product->get_price_html(),
                    'image_url' => wp_get_attachment_image_url($product->get_image_id(), 'medium'),
                    'permalink' => $product->get_permalink(),
                ];
            }
        }
        wp_send_json_success($products_data);
    }

    public function render_wishlist_page() {
        ob_start();
        ?>
        <div id="mio-wishlist-page">
            <h1 class="wishlist-title"><?php echo esc_html($this->settings['label_page_title']); ?></h1>
            <div id="wishlist-grid-container" class="wishlist-grid"></div>
            <div id="wishlist-empty-container" class="wishlist-empty" style="display: none;">
                 <p><?php echo esc_html($this->settings['label_empty_list']); ?></p>
                 <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button">
                    <?php echo esc_html($this->settings['label_go_to_shop']); ?>
                 </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

new Mio_Wishlist_Plugin();
