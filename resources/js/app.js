import './bootstrap';
import '../css/app.css';
import './user/cart';
import './user/cart-add';
import './user/cart-count';
import './user/order-cancel';
import './user/toast';
import './user/cart-popover';
import './user/category-product-ajax.js';
import './user/category-slider';
import './user/password-toggle';
import './user/fetch-location.js';

if (document.documentElement.classList.contains('admin-page')) {
    import('../js/admin/order-show.js');
    import('../js/admin/product-status.js');
    import('../js/admin/searching-items-for-orders.js');
    import('../js/admin/orders-refresh.js');
}
import Alpine from 'alpinejs';

window.Alpine = Alpine;



Alpine.start();
