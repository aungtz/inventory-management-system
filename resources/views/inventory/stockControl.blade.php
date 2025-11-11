<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory / Stock Control</title>
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

        .low-stock {
            background-color: #fef3f2;
            border-left: 4px solid #f04438;
        }

        .out-of-stock {
            background-color: #fef3f2;
            border-left: 4px solid #d92d20;
        }

        .tooltip {
            position: relative;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
        }
    </style>
</head>
@if(session('success'))
<div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">
    {{ session('error') }}
</div>
@endif

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Inventory / Stock Control</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage your product inventory and stock levels</p>
                    <a href="/dashboard">Home</a>
                </div>
                <button id="addStockBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Add Stock</span>
                </button>
                <form action="{{ route('inventory.importExcel') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                    @csrf
                    <input type="file" name="file" accept=".xlsx,.csv" class="border px-2 py-1 rounded-lg">
                    <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-file-upload"></i>
                        <span>Import Excel</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Controls Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
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
                        </select>

                        <select id="stockFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Stock Status</option>
                            <option value="in-stock">In Stock</option>
                            <option value="low-stock">Low Stock</option>
                            <option value="out-of-stock">Out of Stock</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <!-- Export Buttons -->
                    <a href="{{ route('inventory.exportCSV') }}"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center space-x-2">
                        <i class="fas fa-file-csv text-green-600"></i>
                        <span>CSV</span>
                    </a>

                    <a href="{{ route('inventory.exportExcel') }}"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center space-x-2">
                        <i class="fas fa-file-excel text-green-600"></i>
                        <span>Excel</span>
                    </a>
                    <!-- PDF Export Button -->
                    <form action="{{ route('inventory.exportPDF') }}" method="GET" class="inline">
                        <button type="submit"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center space-x-2">
                            <i class="fas fa-file-pdf text-red-600"></i>
                            <span>PDF</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <!-- Inventory Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Product Name</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Category</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>SKU / Product Code</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Stock Quantity</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Unit Price</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTable" class="bg-white divide-y divide-gray-200">
                        <!-- Sample data - Replace with your database loop -->
                        @foreach($stocks as $stock)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{$stock->product_name}}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{$stock->category}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$stock->sku}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-yellow-700">{{$stock->quantity}}</span>
                                    <div class="tooltip" data-tooltip="Low stock warning">
                                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$stock->unit_price}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{$stock->low_stock}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button data-id="{{ $stock->id }}" class="text-blue-600 hover:text-blue-900 transition-colors edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button data-id="{{ $stock->id }}" class="text-green-600 hover:text-green-900 transition-colors history-btn">
                                        <i class="fas fa-history"></i>
                                    </button>
                                    <button data-id="{{ $stock->id }}" class="text-red-600 hover:text-red-900 transition-colors delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>



                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 hidden">
                <i class="fas fa-boxes text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No inventory items found</h3>
                <p class="text-gray-500 mt-1">Get started by adding your first stock item.</p>
                <button id="emptyAddBtn" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors shadow-sm">
                    Add Stock
                </button>

            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-500">
                        Showing <span id="showingFrom">1</span> to <span id="showingTo">8</span> of <span id="totalItems">24</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Stock Modal -->
    <div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md slide-down">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 id="modalTitle" class="text-xl font-bold text-gray-900">Add Stock</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form id="stockForm" class="p-6 space-y-6">
                <input type="hidden" id="stockId">

                <div>
                    <label for="productSelect" class="block text-sm font-medium text-gray-700 mb-1">Product *</label>
                    <select
                        id="productSelect"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a product</option>
                        <option value="1">Wireless Headphones</option>
                        <option value="2">Cotton T-Shirt</option>
                        <option value="3">Coffee Maker</option>
                        <option value="4">Smartphone</option>
                        <option value="5">Desk Lamp</option>
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                    <input
                        type="number"
                        id="quantity"
                        min="1"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter quantity">
                </div>

                <div>
                    <label for="stockDate" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                    <input
                        type="date"
                        id="stockDate"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea
                        id="notes"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Add any notes about this stock movement"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" id="cancelBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="saveStockBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Save Stock
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock History Modal -->
    <div id="historyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto slide-down">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Stock Movement History</h2>
                    <button id="closeHistoryModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p id="historyProductName" class="text-gray-500 mt-1">Product: Wireless Headphones</p>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTable" class="bg-white divide-y divide-gray-200">
                            <!-- Sample data - Replace with your database loop -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Wireless Headphones</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Electronics
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">WH-001-BLK</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-yellow-700">5</span>
                                        <div class="tooltip" data-tooltip="Low stock warning">
                                            <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$129.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Low Stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-history"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-tshirt text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Cotton T-Shirt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Clothing
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">CT-001-BLU-M</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">25</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$19.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-history"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-mug-hot text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Coffee Maker</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Home & Garden
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">CM-001-SLV</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">12</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$89.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-history"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-mobile-alt text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Smartphone</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Electronics
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">SP-001-BLK</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">8</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$699.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-history"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors out-of-stock">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-lightbulb text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Desk Lamp</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Home & Garden
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">DL-001-WHT</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-red-700">0</span>
                                        <div class="tooltip" data-tooltip="Out of stock">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$39.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-history"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
                    <h3 class="text-lg font-bold text-gray-900">Delete Stock Item</h3>
                    <p class="text-gray-500">Are you sure you want to delete this stock item?</p>
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
        // Sample inventory data


        // DOM Elements
        const inventoryTable = document.getElementById('inventoryTable');
        const emptyState = document.getElementById('emptyState');
        const stockModal = document.getElementById('stockModal');
        const historyModal = document.getElementById('historyModal');
        const deleteModal = document.getElementById('deleteModal');
        const stockForm = document.getElementById('stockForm');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const stockFilter = document.getElementById('stockFilter');
        const historyTable = document.getElementById('historyTable');

        // State
        let currentStockId = null;
        let currentProductId = null;
        let editingQuantity = false;

        setTimeout(() => {
            const alerts = document.querySelectorAll('.p-4.mb-4');
            alerts.forEach(a => a.remove());
        }, 5000); // 
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderInventory();
            setupEventListeners();
            updatePaginationInfo();

            // Set today's date as default in the form
            document.getElementById('stockDate').valueAsDate = new Date();
        });

        // Event Listeners
        function setupEventListeners() {
            // Modal controls
            document.getElementById('addStockBtn').addEventListener('click', openAddModal);
            document.getElementById('emptyAddBtn').addEventListener('click', openAddModal);
            document.getElementById('closeModal').addEventListener('click', closeModal);
            document.getElementById('cancelBtn').addEventListener('click', closeModal);
            document.getElementById('closeHistoryModal').addEventListener('click', closeHistoryModal);

            // Form submission
            stockForm.addEventListener('submit', handleFormSubmit);

            // Delete controls
            document.getElementById('cancelDelete').addEventListener('click', closeDeleteModal);
            document.getElementById('confirmDelete').addEventListener('click', confirmDelete);

            // Search and filter
            searchInput.addEventListener('input', filterInventory);
            categoryFilter.addEventListener('change', filterInventory);
            stockFilter.addEventListener('change', filterInventory);
        }

        // Render inventory table


        // Filter inventory based on search and filters
        function filterInventory() {
            const searchTerm = searchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;
            const stockValue = stockFilter.value;

            const filtered = inventory.filter(item => {
                const matchesSearch = item.name.toLowerCase().includes(searchTerm) ||
                    item.sku.toLowerCase().includes(searchTerm);
                const matchesCategory = !categoryValue || item.category === categoryValue;
                const matchesStock = !stockValue ||
                    (stockValue === 'in-stock' && item.quantity > item.lowStockThreshold) ||
                    (stockValue === 'low-stock' && item.quantity > 0 && item.quantity <= item.lowStockThreshold) ||
                    (stockValue === 'out-of-stock' && item.quantity === 0);

                return matchesSearch && matchesCategory && matchesStock;
            });

            renderInventory(filtered);
            updatePaginationInfo(filtered.length);
        }

        // Open modal for adding a new stock
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Stock';
            stockForm.reset();
            currentStockId = null;
            document.getElementById('stockDate').valueAsDate = new Date();
            stockModal.classList.remove('hidden');
        }

        // Edit button
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                openEditModal(id);
            });
        });

        // History button
        document.querySelectorAll('.history-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                openHistoryModal(id);
            });
        });

        // Delete button
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                openDeleteModal(id);
            });
        });

        // Open modal for editing a stock
        function openEditModal(id) {
            const item = inventory.find(i => i.id === id);
            if (!item) return;

            document.getElementById('modalTitle').textContent = 'Update Stock';
            document.getElementById('stockId').value = item.id;
            document.getElementById('productSelect').value = item.id;
            document.getElementById('quantity').value = '';
            document.getElementById('stockDate').valueAsDate = new Date();
            document.getElementById('notes').value = '';

            currentStockId = id;
            stockModal.classList.remove('hidden');
        }

        // Close stock modal
        function closeModal() {
            stockModal.classList.add('hidden');
        }

        // Handle form submission
        function handleFormSubmit(e) {
            e.preventDefault();

            const formData = {
                productId: document.getElementById('productSelect').value,
                quantity: parseInt(document.getElementById('quantity').value),
                date: document.getElementById('stockDate').value,
                notes: document.getElementById('notes').value
            };

            if (currentStockId) {
                // Update existing stock
                updateStock(currentStockId, formData);
            } else {
                // Add new stock movement
                addStock(formData);
            }

            closeModal();
        }

        // Add a new stock movement
        function addStock(stockData) {
            // In a real app, this would be an API call
            // Example: await fetch('/api/stock', { method: 'POST', body: JSON.stringify(stockData) })

            const productId = parseInt(stockData.productId);
            const productIndex = inventory.findIndex(i => i.id === productId);

            if (productIndex !== -1) {
                inventory[productIndex].quantity += stockData.quantity;
                renderInventory();

                // Show success message
                showNotification('Stock added successfully!', 'success');
            }
        }

        // Update an existing stock
        function updateStock(id, stockData) {
            // In a real app, this would be an API call
            // Example: await fetch(`/api/stock/${id}`, { method: 'PUT', body: JSON.stringify(stockData) })

            const productId = parseInt(stockData.productId);
            const productIndex = inventory.findIndex(i => i.id === productId);

            if (productIndex !== -1) {
                inventory[productIndex].quantity += stockData.quantity;
                renderInventory();

                // Show success message
                showNotification('Stock updated successfully!', 'success');
            }
        }

        // Open history modal
        function openHistoryModal(id) {
            const item = inventory.find(i => i.id === id);
            if (!item) return;

            document.getElementById('historyProductName').textContent = `Product: ${item.name}`;
            currentProductId = id;

            // Render history
            const history = stockHistory[id] || [];
            historyTable.innerHTML = history.length > 0 ? history.map(record => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${record.date}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${record.type === 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${record.type}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm ${record.type === 'IN' ? 'text-green-600' : 'text-red-600'}">
                        ${record.type === 'IN' ? '+' : '-'}${record.quantity}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${record.notes}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${record.user}</td>
                </tr>
            `).join('') : `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        No stock movement history found for this product.
                    </td>
                </tr>
            `;

            historyModal.classList.remove('hidden');
        }

        // Close history modal
        function closeHistoryModal() {
            historyModal.classList.add('hidden');
        }

        // Open delete confirmation modal
        function openDeleteModal(id) {
            currentStockId = id;
            deleteModal.classList.remove('hidden');
        }

        // Close delete confirmation modal
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Confirm and execute stock deletion
        function confirmDelete() {
            // In a real app, this would be an API call
            // Example: await fetch(`/api/stock/${currentStockId}`, { method: 'DELETE' })

            inventory = inventory.filter(i => i.id !== currentStockId);
            renderInventory();
            updatePaginationInfo();
            closeDeleteModal();

            // Show success message
            showNotification('Stock item deleted successfully!', 'success');
        }

        // Update pagination information
        function updatePaginationInfo(total = null) {
            const totalItems = total || inventory.length;
            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('showingFrom').textContent = 1;
            document.getElementById('showingTo').textContent = Math.min(8, totalItems);
        }

        // Helper functions
        function getCategoryColor(category) {
            const colors = {
                electronics: 'bg-purple-100 text-purple-800',
                clothing: 'bg-blue-100 text-blue-800',
                home: 'bg-green-100 text-green-800',
                books: 'bg-yellow-100 text-yellow-800'
            };
            return colors[category] || 'bg-gray-100 text-gray-800';
        }

        function formatCategory(category) {
            const formatted = {
                electronics: 'Electronics',
                clothing: 'Clothing',
                home: 'Home & Garden',
                books: 'Books'
            };
            return formatted[category] || category;
        }

        function getStockStatusClass(quantity, threshold) {
            if (quantity === 0) return 'bg-red-100 text-red-800';
            if (quantity <= threshold) return 'bg-yellow-100 text-yellow-800';
            return 'bg-green-100 text-green-800';
        }

        function getStockStatusText(quantity, threshold) {
            if (quantity === 0) return 'Out of Stock';
            if (quantity <= threshold) return 'Low Stock';
            return 'In Stock';
        }

        function showNotification(message, type = 'info') {
            // In a real app, this would show a toast notification
            alert(`${type.toUpperCase()}: ${message}`);
        }

        // Make functions available globally for onclick handlers
        window.openEditModal = openEditModal;
        window.openHistoryModal = openHistoryModal;
        window.openDeleteModal = openDeleteModal;
    </script>
</body>

</html>