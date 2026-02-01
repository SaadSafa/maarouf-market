

  
    
//to update the badge of order in sidebar
async function updateOrderBadge() {
    try {
        const res = await fetch('/admin/orders/pending-count', {
            credentials: 'same-origin'
        });

        if (!res.ok) {
            throw new Error('HTTP error: ' + res.status);
        }

        const data = await res.json();
        const badge = document.getElementById('orders-badge');

        if (!badge) {
            
            return;
        }

        const count = data.PendingOrders ?? 0;

        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.textContent = '';
            badge.classList.add('hidden');
        }

    } catch (e) {
        
    }
}

setInterval(updateOrderBadge, 5000);

updateOrderBadge();

    /* =======================
       STATUS CHANGE
    ======================= */
    document.addEventListener('change', function (e) {
    if (!e.target.classList.contains('status-select')) return;

    let select = e.target;
    let status = select.value;
    let orderId = select.dataset.id;


    fetch(`/admin/orders/${orderId}/status`, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.csrf
        },
        body: JSON.stringify({ status })
    })
    .then(res => res.json())
    .then(data => {
       
    })
    .catch(err => console.error(err));
});

    /* =======================
       UPDATE CART UI
    ======================= */
    window.updateCartUI = function(items) {
        let html = '';
        let total = 0;

        items.forEach(item => {
            total += parseFloat(item.quantity) * parseFloat(item.price);

            html += `
                <tr class="border-b" id="item-${item.id}">
                    <td class="py-3 px-4">
                        <img src="/storage/${item.product.image}" 
                             class="h-12 w-12 rounded-lg object-cover border">
                    </td>

                    <td class="py-3 px-4">${item.product.name}</td>

                    <td class="py-3 px-4">${item.price} LBP</td>

                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="updateQty(${item.id}, -1)"
                                class="px-2 py-1 bg-slate-200 rounded">-</button>

                            <span id="qty-${item.id}">${item.quantity}</span>

                            <button onclick="updateQty(${item.id}, 1)"
                                class="px-2 py-1 bg-slate-200 rounded">+</button>
                        </div>
                    </td>

                    <td class="py-3 px-4 text-right font-semibold">
                        ${(item.quantity * item.price).toLocaleString()} LBP
                    </td>

                    <td class="py-3 px-4 text-right">
                        <button onclick="deleteItem(${item.id})"
                                class="text-red-600">Remove</button>
                    </td>
                </tr>
            `;
        });

        document.getElementById('cartBody').innerHTML = html;
        document.getElementById('orderTotal').innerText = total.toLocaleString();
    };


    /* =======================
       UPDATE QUANTITY
    ======================= */
    window.updateQty = function(id, change) {
        let qtyEl = document.getElementById('qty-' + id);
        let qty = parseInt(qtyEl.innerText) + change;

        if (qty < 1) qty = 1;

        qtyEl.innerText = qty;

        fetch(`/admin/orders/items/${id}/update`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.csrf
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(res => res.json())
        .then(data => updateCartUI(data.items));
    };


    /* =======================
       DELETE ITEM
    ======================= */
    window.deleteItem = function(id) {
        if (!confirm("Remove this item?")) return;

        fetch(`/admin/orders/items/${id}/delete`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": window.csrf
            }
        })
        .then(res => res.json())
        .then(data => updateCartUI(data.items));
    };


    /* =======================
       ADD ITEM
    ======================= */
    window.addItem = function(orderId) {

        let productId = document.getElementById('productId').value;
        let qty = document.getElementById('addQty').value;

        fetch(`/admin/orders/${orderId}/items/add`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.csrf
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: qty
            })
        })
        .then(res => res.json())
        .then(data => updateCartUI(data.items));
    };


