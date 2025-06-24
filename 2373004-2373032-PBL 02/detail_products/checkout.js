document.addEventListener('DOMContentLoaded', function() {
  // Ambil data dari localStorage
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  
  // Jika keranjang kosong, redirect ke homepage
  if (cart.length === 0) {
    window.location.href = '../home/homepage.html';
    return;
  }

  // Ambil item pertama (untuk contoh sederhana)
  const item = cart[0];

  // Update tampilan dengan data item
  document.getElementById('itemColor').textContent = item.color || 'Black';
  document.getElementById('itemSize').textContent = item.size || 'M';
  document.getElementById('itemQuantity').value = item.quantity || 1;
  document.getElementById('itemPrice').textContent = item.price ? item.price.replace('$', '') : '360.00';
  
  // Hitung subtotal dan total
  updateTotals();

  // Event listeners untuk quantity
  document.querySelector('.quantity-minus').addEventListener('click', function() {
    const input = document.getElementById('itemQuantity');
    if (input.value > 1) {
      input.value--;
      updateTotals();
      updateCartInStorage();
    }
  });

  document.querySelector('.quantity-plus').addEventListener('click', function() {
    const input = document.getElementById('itemQuantity');
    input.value++;
    updateTotals();
    updateCartInStorage();
  });

  document.getElementById('itemQuantity').addEventListener('change', function() {
    if (this.value < 1) this.value = 1;
    updateTotals();
    updateCartInStorage();
  });

  // Remove item
  document.querySelector('.remove-item').addEventListener('click', function() {
    localStorage.removeItem('cart');
    window.location.href = '../home/homepage.html';
  });

  function updateTotals() {
    const quantity = parseInt(document.getElementById('itemQuantity').value);
    const price = parseFloat(document.getElementById('itemPrice').textContent);
    const subtotal = quantity * price;
    
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('estimatedTotal').textContent = subtotal.toFixed(2);
  }

  function updateCartInStorage() {
    const quantity = parseInt(document.getElementById('itemQuantity').value);
    const price = parseFloat(document.getElementById('itemPrice').textContent);
    
    const updatedItem = {
      ...item,
      quantity: quantity,
      total: `$${(quantity * price).toFixed(2)}`
    };
    
    localStorage.setItem('cart', JSON.stringify([updatedItem]));
  }
});

document.addEventListener('DOMContentLoaded', function() {
  // Get cart from localStorage
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const orderItemsContainer = document.getElementById('orderItems');
  const emptyState = document.getElementById('emptyState');
  
  // Show empty state if cart is empty
  if (cart.length === 0) {
    orderItemsContainer.classList.add('d-none');
    emptyState.classList.remove('d-none');
    updateTotals(0);
    return;
  }

  // Render all cart items
  renderCartItems(cart);
  
  // Update totals
  updateTotals(calculateSubtotal(cart));

  // Quantity controls event delegation
  orderItemsContainer.addEventListener('click', function(e) {
    const itemId = e.target.closest('[data-item-id]')?.getAttribute('data-item-id');
    if (!itemId) return;

    if (e.target.classList.contains('quantity-minus')) {
      updateQuantity(itemId, -1);
    } else if (e.target.classList.contains('quantity-plus')) {
      updateQuantity(itemId, 1);
    } else if (e.target.classList.contains('remove-item')) {
      removeItem(itemId);
    }
  });

  // Input change event
  orderItemsContainer.addEventListener('change', function(e) {
    if (e.target.classList.contains('quantity-input')) {
      const itemId = e.target.closest('[data-item-id]').getAttribute('data-item-id');
      const newQuantity = parseInt(e.target.value) || 1;
      updateItemQuantity(itemId, newQuantity);
    }
  });

  // Render cart items function
  function renderCartItems(items) {
    orderItemsContainer.innerHTML = items.map(item => `
      <div class="order-item mb-4 pb-4 border-bottom" data-item-id="${item.id || '1'}">
        <div class="row">
          <div class="col-3">
            <img src="${item.image}" alt="${item.name}" class="img-fluid rounded">
          </div>
          <div class="col-6">
            <h3 class="h6">${item.name}</h3>
            ${item.color ? `<p class="small mb-1">Color: <span>${item.color}</span></p>` : ''}
            ${item.size ? `<p class="small mb-1">Size: <span>${item.size}</span></p>` : ''}
            <div class="quantity-selector d-flex align-items-center mt-2">
              <button class="btn btn-sm btn-outline-secondary quantity-minus">-</button>
              <input type="number" class="form-control quantity-input mx-2 text-center" 
                     value="${item.quantity || 1}" min="1">
              <button class="btn btn-sm btn-outline-secondary quantity-plus">+</button>
            </div>
          </div>
          <div class="col-3 text-end">
            <p class="mb-1 fw-bold">$${item.price ? parseFloat(item.price.replace('$', '')).toFixed(2) : '0.00'}</p>
            <button class="btn btn-link btn-sm text-danger p-0 remove-item">Remove</button>
          </div>
        </div>
      </div>
    `).join('');
  }

  // Update quantity function
  function updateQuantity(itemId, change) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const itemIndex = cart.findIndex(item => (item.id || '1') === itemId);
    
    if (itemIndex !== -1) {
      const newQuantity = cart[itemIndex].quantity + change;
      if (newQuantity < 1) return;
      
      cart[itemIndex].quantity = newQuantity;
      localStorage.setItem('cart', JSON.stringify(cart));
      
      // Update UI
      const quantityInput = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
      if (quantityInput) quantityInput.value = newQuantity;
      
      updateTotals(calculateSubtotal(cart));
    }
  }

  // Update item quantity function
  function updateItemQuantity(itemId, newQuantity) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const itemIndex = cart.findIndex(item => (item.id || '1') === itemId);
    
    if (itemIndex !== -1 && newQuantity > 0) {
      cart[itemIndex].quantity = newQuantity;
      localStorage.setItem('cart', JSON.stringify(cart));
      updateTotals(calculateSubtotal(cart));
    }
  }

  // Remove item function
  function removeItem(itemId) {
    if (!confirm('Are you sure you want to remove this item?')) return;
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => (item.id || '1') !== itemId);
    localStorage.setItem('cart', JSON.stringify(cart));
    
    if (cart.length === 0) {
      orderItemsContainer.classList.add('d-none');
      emptyState.classList.remove('d-none');
    } else {
      renderCartItems(cart);
    }
    
    updateTotals(calculateSubtotal(cart));
  }

  // Calculate subtotal function
  function calculateSubtotal(items) {
    return items.reduce((total, item) => {
      const price = item.price ? parseFloat(item.price.replace('$', '')) : 0;
      return total + (price * (item.quantity || 1));
    }, 0);
  }

  // Update totals function
  function updateTotals(subtotal) {
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('estimatedTotal').textContent = subtotal.toFixed(2);
  }
});