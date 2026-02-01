
    function refresh() {
        if (typeof tab === 'undefined') {
            return;
        }
        fetch('/admin/orders-refresh?tab=' + tab, {
            method: "GET",
            headers: { "Accept": "application/json" }
        })
        .then(res => res.json())
        .then(response => {
            if (!response.success) return;

            const tbody = document.getElementById("orders-data");
            tbody.innerHTML = "";

            if (response.data.length === 0) {
    tbody.innerHTML = `
        <tr>
            <td colspan="10" class="py-6 text-center text-slate-500">
                No data found
            </td>
        </tr>`;
    return; // Stop here
}


            response.data.forEach(order => {

                // Format time
                const createdAt = new Date(order.created_at);
                const formattedCreated = createdAt.toLocaleString('en-GB', { hour12: false });

                const createdPlus35 = new Date(createdAt.getTime() + (35 * 60 * 1000));
                const formattedPlus35 = createdPlus35.toLocaleString('en-GB', { hour12: false });

                // Status HTML depending on tab
                 
                let statusHTML = "";

                if (tab !== "history") {
                       
                    statusHTML = `
                        <select id="orderStatus" class="status-select px-2 py-1 border rounded text-xs"
                                data-id="${order.id}">
                            ${['placed','picking','picked','indelivery','completed','cancelled','pending']
                                .map(st => `
                                    <option value="${st}" ${order.status === st ? 'selected' : ''}>
                                        ${st.charAt(0).toUpperCase() + st.slice(1)}
                                    </option>
                                `)
                                .join('')}
                        </select>
                    `;
                } else {
                    const bgClass = order.status === 'completed' ? 'bgordercomplete' : 'bgordercanceled';
                    statusHTML = `
                        <span class="status-select px-2 py-1 border rounded text-xs ${bgClass}"
                              data-id="${order.id}">
                            ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                        </span>
                    `;
                }

                // Build final row
                tbody.innerHTML += `
                    <tr class="border-b hover:bg-slate-50">
                        <td class="py-3 px-4">${order.id}</td>
                        <td class="py-3 px-4">${order.manager_notes ?? '-'}</td>
                        <td class="py-3 px-4">${order.customer_name}</td>

                        <td class="py-3 px-4">
                            ${statusHTML}
                        </td>

                        <td class="py-3 px-4">${formattedCreated}</td>
                        <td class="py-3 px-4">${formattedPlus35}</td>
                        <td class="py-3 px-4">${order.area ?? '-'}</td>
                        <td class="py-3 px-4">-</td>

                        <td class="py-3 px-4 text-right">
                            <a href="/admin/orders/${order.id}" class="text-emerald-600 text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                `;
            });
        });
    }

    refresh();
    setInterval(refresh, 5000);

