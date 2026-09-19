/**
 * ElectroStore - Frontend Interactive Engine
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Live Search with Debounce & Rust indicator
    const searchInput = document.getElementById('globalSearchInput');
    const searchDropdown = document.getElementById('searchDropdown');

    let debounceTimer;
    if (searchInput && searchDropdown) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            const query = e.target.value.trim();

            if (query.length < 2) {
                searchDropdown.style.display = 'none';
                searchDropdown.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`${BASE_URL}/api/live-search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            let html = `<div class="p-2 border-bottom text-muted small d-flex justify-content-between align-items-center">
                                <span>Gợi ý sản phẩm (${data.results.length})</span>
                                <span class="badge bg-light text-muted border rounded-pill px-2 py-0">Chính Hãng</span>
                            </div>`;
                            data.results.forEach(item => {
                                html += `
                                    <a href="${BASE_URL}/product/${item.slug}" class="search-item">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold text-truncate" style="max-width: 380px;">${item.name}</div>
                                            <div class="text-primary fw-bold small">${item.price}</div>
                                        </div>
                                    </a>
                                `;
                            });
                            searchDropdown.innerHTML = html;
                            searchDropdown.style.display = 'block';
                        } else {
                            searchDropdown.innerHTML = '<div class="p-3 text-muted text-center small">Không tìm thấy thiết bị phù hợp.</div>';
                            searchDropdown.style.display = 'block';
                        }
                    })
                    .catch(() => {
                        searchDropdown.style.display = 'none';
                    });
            }, 250);
        });

        // Close search on outside click
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                searchDropdown.style.display = 'none';
            }
        });
    }

    // 2. AJAX Add to Cart
    document.querySelectorAll('.btn-ajax-add-cart').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-product-id');
            const qtyInput = document.getElementById(`qty_${productId}`);
            const quantity = qtyInput ? qtyInput.value : 1;

            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Đang thêm...';
            btn.disabled = true;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            if (csrfToken) {
                formData.append('csrf_token', csrfToken);
            }

            const cartAddUrl = `${BASE_URL}/cart/add`;
            console.log('Adding to cart. URL:', cartAddUrl, 'Product ID:', productId, 'Quantity:', quantity);

            fetch(cartAddUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(res => {
                    console.log('Response status:', res.status);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;

                    if (data.success) {
                        showToast(data.message, 'success');
                        updateCartBadge(data.cart.total_items);
                    } else {
                        showToast(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                    showToast('Không thể thêm sản phẩm vào giỏ. Vui lòng thử lại.', 'danger');
                });
        });
    });

    // 3. Update Cart Badge Count
    function updateCartBadge(count) {
        const badge = document.getElementById('cartBadgeCount');
        if (badge) {
            badge.innerText = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    // 4. Toast notification helper
    function showToast(message, type = 'success') {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-bg-${type} border-0 show shadow-lg mb-2`;
        toastEl.setAttribute('role', 'alert');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body fw-medium">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        container.appendChild(toastEl);

        setTimeout(() => {
            toastEl.remove();
        }, 3500);
    }

    // 5. Query Rust microservice health on header
    const rustStatusBadge = document.getElementById('rustEngineBadge');
    if (rustStatusBadge) {
        fetch(`${BASE_URL}/api/rust-status`)
            .then(res => res.json())
            .then(data => {
                if (data.available) {
                    rustStatusBadge.innerHTML = '<i class="bi bi-cpu-fill text-warning me-1"></i> <span class="text-white">Rust Engine:</span> <span class="badge bg-success ms-1">Active</span>';
                } else {
                    rustStatusBadge.innerHTML = '<i class="bi bi-cpu me-1 text-muted"></i> <span class="text-white-50">Engine:</span> <span class="badge bg-secondary ms-1">PHP Core</span>';
                }
            })
            .catch(() => {
                rustStatusBadge.innerHTML = '<i class="bi bi-cpu me-1 text-muted"></i> <span class="badge bg-secondary ms-1">PHP Core</span>';
            });
    }
});
