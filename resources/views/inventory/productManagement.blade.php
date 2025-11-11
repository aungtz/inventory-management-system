<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .slide-down {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Product Management</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage your product inventory</p>
                </div>
                <button id="addProductBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Add Product</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input
                            type="text"
                            id="searchInput"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search products...">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <select id="categoryFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="home">Home & Garden</option>
                        <option value="books">Books</option>
                        <option value="sports">Sports</option>
                    </select>

                    <select id="stockFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Stock Status</option>
                        <option value="in-stock">In Stock</option>
                        <option value="low-stock">Low Stock</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTable" class="bg-white divide-y divide-gray-200">
                        <!-- Products will be dynamically inserted here -->
                    <tbody id="productsTable">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>

                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ">

                                    {{ $product->category }}
                                </span>
                            </td>


                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$product->price}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $product->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- ✅ Edit Button -->
                                <button type="button"
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- ✅ Delete Form -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 hidden">
                <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                <p class="text-gray-500 mt-1">Get started by adding your first product.</p>
                <button id="emptyAddBtn" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Add Product
                </button>
            </div>
        </div>
    </main>

    <!-- Add/Edit Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto slide-down">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 id="modalTitle" class="text-xl font-bold text-gray-900">Add New Product</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form id="productForm" method="" action="">
                @csrf
                <input type="hidden" id="productId" name="id">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="category" name="category" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" step="0.01" id="price" name="price" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" id="stock" name="stock" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" class="w-full px-3 py-2 border rounded-lg"></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Save Product
                </button>
            </form>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 slide-down">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Delete Product</h3>
                    <p class="text-gray-500">Are you sure you want to delete this product?</p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button id="cancelDelete" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        // Sample product data
        let products = [{
                id: 1,
                name: "Wireless Headphones",
                category: "electronics",
                price: 129.99,
                stock: 25,
                description: "High-quality wireless headphones with noise cancellation",
                variants: [{
                        color: "Black",
                        size: "Standard",
                        admin_no: "WH-BLK-001"
                    },
                    {
                        color: "White",
                        size: "Standard",
                        admin_no: "WH-WHT-001"
                    }
                ]
            },
            {
                id: 2,
                name: "Cotton T-Shirt",
                category: "clothing",
                price: 19.99,
                stock: 50,
                description: "Comfortable 100% cotton t-shirt",
                variants: [{
                        color: "Blue",
                        size: "M",
                        admin_no: "TS-BLU-M"
                    },
                    {
                        color: "Red",
                        size: "L",
                        admin_no: "TS-RED-L"
                    }
                ]
            },
            {
                id: 3,
                name: "Coffee Maker",
                category: "home",
                price: 89.99,
                stock: 10,
                description: "Programmable coffee maker with thermal carafe",
                variants: []
            }
        ];

        // DOM Elements
        const productsTable = document.getElementById('productsTable');
        const emptyState = document.getElementById('emptyState');
        const productModal = document.getElementById('productModal');
        const deleteModal = document.getElementById('deleteModal');
        const productForm = document.getElementById('productForm');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const stockFilter = document.getElementById('stockFilter');
        const variantsContainer = document.getElementById('variantsContainer');

        // State
        let currentProductId = null;
        let variantCounter = 0;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            setupEventListeners();
        });

        // Event Listeners
        function setupEventListeners() {
            // Modal controls
            document.getElementById('addProductBtn').addEventListener('click', openAddModal);
            document.getElementById('emptyAddBtn').addEventListener('click', openAddModal);
            document.getElementById('closeModal').addEventListener('click', closeModal);

            // Form submission
            productForm.addEventListener('submit', handleFormSubmit);

            // Delete controls
            document.getElementById('cancelDelete').addEventListener('click', closeDeleteModal);
            document.getElementById('confirmDelete').addEventListener('click', confirmDelete);

            // Search and filter
            searchInput.addEventListener('input', filterProducts);
            categoryFilter.addEventListener('change', filterProducts);
            stockFilter.addEventListener('change', filterProducts);

            // Variants
        }

        // Render products table
        function renderProducts(filteredProducts = null) {
            const productsToRender = filteredProducts || products;

            if (productsToRender.length === 0) {
                productsTable.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');

            productsTable.innerHTML = productsToRender.map(product => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                ${product.variants && product.variants.length > 0 ? 
                                    `<div class="text-xs text-gray-500">${product.variants.length} variant(s)</div>` : ''}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            bg-green-100 text-green-800
                            ${getCategoryColor(product.category)}">
                            ${formatCategory(product.category)}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${product.price.toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            ${getStockStatusClass(product.stock)}">
                            ${product.stock}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">${product.description}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="openEditModal(${product.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="openDeleteModal(${product.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Filter products based on search and filters
        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;
            const stockValue = stockFilter.value;

            const filtered = products.filter(product => {
                const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                    product.description.toLowerCase().includes(searchTerm);
                const matchesCategory = !categoryValue || product.category === categoryValue;
                const matchesStock = !stockValue ||
                    (stockValue === 'in-stock' && product.stock > 10) ||
                    (stockValue === 'low-stock' && product.stock > 0 && product.stock <= 10) ||
                    (stockValue === 'out-of-stock' && product.stock === 0);

                return matchesSearch && matchesCategory && matchesStock;
            });

            renderProducts(filtered);
        }

        // Open modal for adding a new product
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Product';
            productForm.reset();
            currentProductId = null;
            const methodInput = document.querySelector('#productForm input[name="_method"]');
            if (methodInput) methodInput.remove();
            productModal.classList.remove('hidden');
        }

        // Open modal for editing a product
        function openEditModal(id) {
            const product = products.find(p => p.id === id);
            if (!product) return;

            document.getElementById('modalTitle').textContent = 'Edit Product';
            document.getElementById('productId').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('category').value = product.category;
            document.getElementById('price').value = product.price;
            document.getElementById('stock').value = product.stock;
            document.getElementById('description').value = product.description;

            // Load variants
            const form = document.getElementById('productForm');
            form.action = `/products/${product.id}`; // update route

            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';
            document.getElementById('productModal').classList.remove('hidden');
        }

        // Close product modal
        function closeModal() {
            productModal.classList.add('hidden');
        }

        // Handle form submission
        function handleFormSubmit(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('name').value,
                category: document.getElementById('category').value,
                price: parseFloat(document.getElementById('price').value),
                stock: parseInt(document.getElementById('stock').value),
                description: document.getElementById('description').value,
                variants: collectVariantsData()
            };

            if (currentProductId) {
                // Update existing product
                updateProduct(currentProductId, formData);
            } else {
                // Add new product
                addProduct(formData);
            }

            closeModal();
        }

        // Add a new product
        function addProduct(productData) {
            // In a real app, this would be an API call
            const newProduct = {
                id: products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1,
                ...productData
            };

            products.push(newProduct);
            renderProducts();

            // Show success message
            showNotification('Product added successfully!', 'success');
        }

        // Update an existing product
        function updateProduct(id, productData) {
            // In a real app, this would be an API call
            const index = products.findIndex(p => p.id === id);
            if (index !== -1) {
                products[index] = {
                    ...products[index],
                    ...productData
                };
                renderProducts();

                // Show success message
                showNotification('Product updated successfully!', 'success');
            }
        }

        // Open delete confirmation modal
        function openDeleteModal(id) {
            currentProductId = id;
            deleteModal.classList.remove('hidden');
        }

        // Close delete confirmation modal
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Confirm and execute product deletion
        function confirmDelete() {
            // In a real app, this would be an API call
            products = products.filter(p => p.id !== currentProductId);
            renderProducts();
            closeDeleteModal();

            // Show success message
            showNotification('Product deleted successfully!', 'success');
        }

        // Add a variant row to the form
        function addVariantRow(variantData = null) {
            variantCounter++;
            const variantId = `variant-${variantCounter}`;

            const variantRow = document.createElement('div');
            variantRow.className = 'variant-row border border-gray-200 rounded-lg p-4 bg-gray-50';
            variantRow.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <input 
                            type="text" 
                            class="variant-color w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Color"
                            value="${variantData ? variantData.color : ''}"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                        <input 
                            type="text" 
                            class="variant-size w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Size"
                            value="${variantData ? variantData.size : ''}"
                        >
                    </div>
                    <div class="flex items-end space-x-2">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Admin No.</label>
                            <input 
                                type="text" 
                                class="variant-admin_no w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Admin Number"
                                value="${variantData ? variantData.admin_no : ''}"
                            >
                        </div>
                        <button type="button" class="remove-variant text-red-600 hover:text-red-800 p-2">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;


            // Add event listener to remove button
            variantRow.querySelector('.remove-variant').addEventListener('click', function() {
                variantRow.remove();
            });
        }

        // Collect variants data from the form
        function collectVariantsData() {
            const variants = [];
            const variantRows = document.querySelectorAll('.variant-row');

            variantRows.forEach(row => {
                const color = row.querySelector('.variant-color').value;
                const size = row.querySelector('.variant-size').value;
                const admin_no = row.querySelector('.variant-admin_no').value;

                if (color || size || admin_no) {
                    variants.push({
                        color,
                        size,
                        admin_no
                    });
                }
            });

            return variants;
        }

        // Helper functions
        function getCategoryColor(category) {
            const colors = {
                electronics: 'bg-purple-100 text-purple-800',
                clothing: 'bg-blue-100 text-blue-800',
                home: 'bg-green-100 text-green-800',
                books: 'bg-yellow-100 text-yellow-800',
                sports: 'bg-red-100 text-red-800'
            };
            return colors[category] || 'bg-gray-100 text-gray-800';
        }

        function formatCategory(category) {
            const formatted = {
                electronics: 'Electronics',
                clothing: 'Clothing',
                home: 'Home & Garden',
                books: 'Books',
                sports: 'Sports'
            };
            return formatted[category] || category;
        }

        function getStockStatusClass(stock) {
            if (stock === 0) return 'bg-red-100 text-red-800';
            if (stock <= 10) return 'bg-yellow-100 text-yellow-800';
            return 'bg-green-100 text-green-800';
        }

        function showNotification(message, type = 'info') {
            // In a real app, this would show a toast notification
            alert(`${type.toUpperCase()}: ${message}`);
        }

        // Make functions available globally for onclick handlers
        window.openEditModal = openEditModal;
        window.openDeleteModal = openDeleteModal;
    </script>
</body>

</html>