import './bootstrap';
import '../css/app.css';
import './cart';
import './cart-add';
import './cart-count';
import './order-cancel';
import './toast';

import '../js/admin/order-show.js';
import '../js/admin/product-status.js';
import '../js/admin/searching-items-for-orders.js';
import '../js/admin/orders-refresh.js';
import Alpine from 'alpinejs';

window.Alpine = Alpine;



Alpine.start();
