<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Category Management</h1>
                    <p class="text-gray-500 text-sm mt-1">Organize your product categories</p>
                </div>
                <button id="addCategoryBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Add Category</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search and Controls Section -->
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
                            placeholder="Search categories...">
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Pagination Placeholder -->
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <span>Rows per page:</span>
                        <select class="border border-gray-300 rounded px-2 py-1">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Category Name</span>
                                    <button class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTable" class="bg-white divide-y divide-gray-200">
                        <!-- Categories will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 hidden">
                <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No categories found</h3>
                <p class="text-gray-500 mt-1">Get started by creating your first category.</p>
                <button id="emptyAddBtn" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-sm">
                    Add Category
                </button>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <span id="showingFrom">1</span> to <span id="showingTo">5</span> of <span id="totalItems">15</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Previous
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md slide-down">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 id="modalTitle" class="text-xl font-bold text-gray-900">Add New Category</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form id="categoryForm" class="p-6 space-y-6">
                <input type="hidden" id="categoryId">

                <div>
                    <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
                    <input
                        type="text"
                        id="categoryName"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter category name">
                </div>

                <div>
                    <label for="categoryDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea
                        id="categoryDescription"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter category description"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" id="cancelBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="saveCategoryBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Save Category
                    </button>
                </div>
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
                    <h3 class="text-lg font-bold text-gray-900">Delete Category</h3>
                    <p class="text-gray-500">Are you sure you want to delete this category?</p>
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
        // Sample category data
        let categories = [{
                id: 1,
                name: "Electronics",
                description: "Electronic devices and accessories including smartphones, laptops, and audio equipment",
                productCount: 42
            },
            {
                id: 2,
                name: "Clothing",
                description: "Apparel for men, women, and children including shirts, pants, and accessories",
                productCount: 128
            },
            {
                id: 3,
                name: "Home & Garden",
                description: "Furniture, home decor, and gardening supplies",
                productCount: 75
            },
            {
                id: 4,
                name: "Books",
                description: "Fiction, non-fiction, educational books and magazines",
                productCount: 210
            },
            {
                id: 5,
                name: "Sports & Outdoors",
                description: "Sports equipment, outdoor gear, and fitness accessories",
                productCount: 56
            }
        ];

        // DOM Elements
        const categoriesTable = document.getElementById('categoriesTable');
        const emptyState = document.getElementById('emptyState');
        const categoryModal = document.getElementById('categoryModal');
        const deleteModal = document.getElementById('deleteModal');
        const categoryForm = document.getElementById('categoryForm');
        const searchInput = document.getElementById('searchInput');

        // State
        let currentCategoryId = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderCategories();
            setupEventListeners();
            updatePaginationInfo();
        });

        // Event Listeners
        function setupEventListeners() {
            // Modal controls
            document.getElementById('addCategoryBtn').addEventListener('click', openAddModal);
            document.getElementById('emptyAddBtn').addEventListener('click', openAddModal);
            document.getElementById('closeModal').addEventListener('click', closeModal);
            document.getElementById('cancelBtn').addEventListener('click', closeModal);

            // Form submission
            categoryForm.addEventListener('submit', handleFormSubmit);

            // Delete controls
            document.getElementById('cancelDelete').addEventListener('click', closeDeleteModal);
            document.getElementById('confirmDelete').addEventListener('click', confirmDelete);

            // Search
            searchInput.addEventListener('input', filterCategories);
        }

        // Render categories table
        function renderCategories(filteredCategories = null) {
            const categoriesToRender = filteredCategories || categories;

            if (categoriesToRender.length === 0) {
                categoriesTable.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');

            categoriesTable.innerHTML = categoriesToRender.map(category => `
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-folder text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${category.name}</div>
                                <div class="text-xs text-gray-500">${category.productCount} products</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-md truncate">${category.description}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="openEditModal(${category.id})" class="text-blue-600 hover:text-blue-900 mr-3 transition-colors" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="openDeleteModal(${category.id})" class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Filter categories based on search
        function filterCategories() {
            const searchTerm = searchInput.value.toLowerCase();

            const filtered = categories.filter(category => {
                return category.name.toLowerCase().includes(searchTerm) ||
                    category.description.toLowerCase().includes(searchTerm);
            });

            renderCategories(filtered);
            updatePaginationInfo(filtered.length);
        }

        // Open modal for adding a new category
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Category';
            categoryForm.reset();
            currentCategoryId = null;
            categoryModal.classList.remove('hidden');
        }

        // Open modal for editing a category
        function openEditModal(id) {
            const category = categories.find(c => c.id === id);
            if (!category) return;

            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('categoryId').value = category.id;
            document.getElementById('categoryName').value = category.name;
            document.getElementById('categoryDescription').value = category.description;

            currentCategoryId = id;
            categoryModal.classList.remove('hidden');
        }

        // Close category modal
        function closeModal() {
            categoryModal.classList.add('hidden');
        }

        // Handle form submission
        function handleFormSubmit(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('categoryName').value,
                description: document.getElementById('categoryDescription').value
            };

            if (currentCategoryId) {
                // Update existing category
                updateCategory(currentCategoryId, formData);
            } else {
                // Add new category
                addCategory(formData);
            }

            closeModal();
        }

        // Add a new category
        function addCategory(categoryData) {
            // In a real app, this would be an API call
            // Example: await fetch('/api/categories', { method: 'POST', body: JSON.stringify(categoryData) })

            const newCategory = {
                id: categories.length > 0 ? Math.max(...categories.map(c => c.id)) + 1 : 1,
                ...categoryData,
                productCount: 0
            };

            categories.push(newCategory);
            renderCategories();
            updatePaginationInfo();

            // Show success message
            showNotification('Category added successfully!', 'success');
        }

        // Update an existing category
        function updateCategory(id, categoryData) {
            // In a real app, this would be an API call
            // Example: await fetch(`/api/categories/${id}`, { method: 'PUT', body: JSON.stringify(categoryData) })

            const index = categories.findIndex(c => c.id === id);
            if (index !== -1) {
                categories[index] = {
                    ...categories[index],
                    ...categoryData
                };
                renderCategories();

                // Show success message
                showNotification('Category updated successfully!', 'success');
            }
        }

        // Open delete confirmation modal
        function openDeleteModal(id) {
            currentCategoryId = id;
            deleteModal.classList.remove('hidden');
        }

        // Close delete confirmation modal
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Confirm and execute category deletion
        function confirmDelete() {
            // In a real app, this would be an API call
            // Example: await fetch(`/api/categories/${currentCategoryId}`, { method: 'DELETE' })

            categories = categories.filter(c => c.id !== currentCategoryId);
            renderCategories();
            updatePaginationInfo();
            closeDeleteModal();

            // Show success message
            showNotification('Category deleted successfully!', 'success');
        }

        // Update pagination information
        function updatePaginationInfo(total = null) {
            const totalItems = total || categories.length;
            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('showingFrom').textContent = 1;
            document.getElementById('showingTo').textContent = Math.min(5, totalItems);
        }

        // Show notification
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