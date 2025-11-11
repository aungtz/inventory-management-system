<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales / Order Management</title>
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

        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                background: white !important;
                font-size: 12pt;
            }

            .invoice-container {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                margin: 0 !important;
                padding: 20px !important;
            }
        }

        .print-only {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Sales / Orders</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage your sales and customer orders</p>
                </div>
                <button id="newSaleBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>New Sale</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 no-print">
        <!-- Sales History Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Sales</h2>
            </div>

            <!-- Search and Controls -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Search invoices or customers...">
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 90 days</option>
                        </select>

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

            <!-- Sales Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Invoice No</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Customer Name</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Total Amount</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Date</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Sample Sales Data -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">INV-2023-001</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">John Smith</div>
                                <div class="text-xs text-gray-500">john@example.com</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">$249.97</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 15, 2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewInvoice('INV-2023-001')" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="printInvoice('INV-2023-001')" class="text-green-600 hover:text-green-900 transition-colors" title="Print Invoice">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button onclick="deleteInvoice('INV-2023-001')" class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">INV-2023-002</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Sarah Johnson</div>
                                <div class="text-xs text-gray-500">sarah@example.com</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">$89.99</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 18, 2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewInvoice('INV-2023-002')" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="printInvoice('INV-2023-002')" class="text-green-600 hover:text-green-900 transition-colors" title="Print Invoice">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button onclick="deleteInvoice('INV-2023-002')" class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-500">
                        Showing <span>1</span> to <span>2</span> of <span>24</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded text-sm text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">1</button>
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

    <!-- Invoice Details Modal -->
    <div id="invoiceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden no-print">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto slide-down">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Invoice Details</h2>
                    <div class="flex space-x-2">
                        <button onclick="printCurrentInvoice()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                            <i class="fas fa-print"></i>
                            <span>Print</span>
                        </button>
                        <button id="closeInvoiceModal" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div id="invoiceDetails" class="invoice-container bg-white p-6 rounded-lg border border-gray-200">
                    <!-- Invoice content will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Printable Invoice (Hidden until printing) -->
    <div id="printableInvoice" class="hidden print-only">
        <!-- Printable invoice content will be inserted here -->
    </div>

    <!-- New Sale Modal -->
    <div id="saleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden no-print">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto slide-down">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">New Sale</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <!-- Product Selection -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Products</h3>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                            <select
                                id="productSelect"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select a product</option>
                                <option value="1" data-price="129.99" data-stock="25">Wireless Headphones - $129.99 (25 in stock)</option>
                                <option value="2" data-price="19.99" data-stock="50">Cotton T-Shirt - $19.99 (50 in stock)</option>
                                <option value="3" data-price="89.99" data-stock="12">Coffee Maker - $89.99 (12 in stock)</option>
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input
                                type="number"
                                id="quantity"
                                min="1"
                                value="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
                            <input
                                type="text"
                                id="unitPrice"
                                readonly
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
                                value="$0.00">
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <button id="addToCart" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded-lg transition-colors">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Cart Items</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems" class="bg-white divide-y divide-gray-200">
                                <tr id="emptyCart" class="text-center">
                                    <td colspan="5" class="px-6 py-8 text-gray-500">
                                        <i class="fas fa-shopping-cart text-3xl mb-2 text-gray-300"></i>
                                        <p>Your cart is empty</p>
                                        <p class="text-sm">Add products to get started</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Customer and Notes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="customerName" class="block text-sm font-medium text-gray-700 mb-1">Customer Name (Optional)</label>
                        <input
                            type="text"
                            id="customerName"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter customer name">
                    </div>
                    <div>
                        <label for="customerEmail" class="block text-sm font-medium text-gray-700 mb-1">Customer Email (Optional)</label>
                        <input
                            type="email"
                            id="customerEmail"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter customer email">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea
                        id="notes"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Add any notes about this sale"></textarea>
                </div>

                <!-- Total and Actions -->
                <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
                        <div class="text-2xl font-bold text-green-700" id="totalAmount">$0.00</div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button id="cancelSale" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button id="saveSale" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                            Complete Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden no-print">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 slide-down">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Delete Invoice</h3>
                    <p class="text-gray-500">Are you sure you want to delete this invoice?</p>
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
        // Cart state
        let cart = [];
        let currentInvoiceToDelete = null;
        let currentInvoiceData = null;

        // Sample invoice data
        const invoiceData = {
            'INV-2023-001': {
                invoiceNo: 'INV-2023-001',
                customerName: 'John Smith',
                customerEmail: 'john@example.com',
                date: 'October 15, 2023',
                items: [{
                        name: 'Wireless Headphones',
                        quantity: 1,
                        price: 129.99,
                        subtotal: 129.99
                    },
                    {
                        name: 'Cotton T-Shirt',
                        quantity: 2,
                        price: 19.99,
                        subtotal: 39.98
                    },
                    {
                        name: 'Coffee Maker',
                        quantity: 1,
                        price: 89.99,
                        subtotal: 89.99
                    }
                ],
                subtotal: 259.96,
                tax: 25.00,
                total: 284.96,
                notes: 'Thank you for your business!'
            },
            'INV-2023-002': {
                invoiceNo: 'INV-2023-002',
                customerName: 'Sarah Johnson',
                customerEmail: 'sarah@example.com',
                date: 'October 18, 2023',
                items: [{
                    name: 'Coffee Maker',
                    quantity: 1,
                    price: 89.99,
                    subtotal: 89.99
                }],
                subtotal: 89.99,
                tax: 9.00,
                total: 98.99,
                notes: 'Special discount applied'
            }
        };

        // DOM Elements
        const saleModal = document.getElementById('saleModal');
        const invoiceModal = document.getElementById('invoiceModal');
        const deleteModal = document.getElementById('deleteModal');
        const productSelect = document.getElementById('productSelect');
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unitPrice');
        const addToCartBtn = document.getElementById('addToCart');
        const cartItems = document.getElementById('cartItems');
        const emptyCart = document.getElementById('emptyCart');
        const totalAmount = document.getElementById('totalAmount');
        const customerName = document.getElementById('customerName');
        const customerEmail = document.getElementById('customerEmail');
        const notes = document.getElementById('notes');
        const saveSaleBtn = document.getElementById('saveSale');
        const cancelSaleBtn = document.getElementById('cancelSale');
        const cancelDeleteBtn = document.getElementById('cancelDelete');
        const confirmDeleteBtn = document.getElementById('confirmDelete');
        const closeInvoiceModal = document.getElementById('closeInvoiceModal');
        const invoiceDetails = document.getElementById('invoiceDetails');
        const printableInvoice = document.getElementById('printableInvoice');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
        });

        // Event Listeners
        function setupEventListeners() {
            // Modal controls
            document.getElementById('newSaleBtn').addEventListener('click', openSaleModal);
            document.getElementById('closeModal').addEventListener('click', closeSaleModal);
            cancelSaleBtn.addEventListener('click', closeSaleModal);
            closeInvoiceModal.addEventListener('click', closeInvoiceDetails);

            // Product selection
            productSelect.addEventListener('change', updateUnitPrice);
            addToCartBtn.addEventListener('click', addToCart);

            // Form submission
            saveSaleBtn.addEventListener('click', completeSale);

            // Delete modal
            cancelDeleteBtn.addEventListener('click', closeDeleteModal);
            confirmDeleteBtn.addEventListener('click', confirmDelete);
        }

        // View Invoice Details
        function viewInvoice(invoiceNo) {
            currentInvoiceData = invoiceData[invoiceNo];
            if (!currentInvoiceData) {
                alert('Invoice not found');
                return;
            }

            // Generate invoice HTML
            const invoiceHTML = generateInvoiceHTML(currentInvoiceData);
            invoiceDetails.innerHTML = invoiceHTML;
            invoiceModal.classList.remove('hidden');
        }

        // Print Invoice
        function printInvoice(invoiceNo) {
            currentInvoiceData = invoiceData[invoiceNo];
            if (!currentInvoiceData) {
                alert('Invoice not found');
                return;
            }

            // Generate printable invoice HTML
            const printableHTML = generatePrintableInvoiceHTML(currentInvoiceData);
            printableInvoice.innerHTML = printableHTML;

            // Trigger print
            window.print();
        }

        // Print current invoice from view modal
        function printCurrentInvoice() {
            if (!currentInvoiceData) return;

            const printableHTML = generatePrintableInvoiceHTML(currentInvoiceData);
            printableInvoice.innerHTML = printableHTML;
            window.print();
        }

        // Generate invoice HTML for view modal
        function generateInvoiceHTML(invoice) {
            return `
                <div class="bg-white p-8 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">INVOICE</h1>
                            <p class="text-gray-600">#${invoice.invoiceNo}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">Date: ${invoice.date}</p>
                            <p class="text-gray-600">Status: <span class="text-green-600 font-semibold">Paid</span></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Bill To:</h3>
                            <p class="text-gray-900 font-medium">${invoice.customerName}</p>
                            <p class="text-gray-600">${invoice.customerEmail}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">From:</h3>
                            <p class="text-gray-900 font-medium">Your Company Name</p>
                            <p class="text-gray-600">123 Business Street</p>
                            <p class="text-gray-600">City, State 12345</p>
                            <p class="text-gray-600">contact@yourcompany.com</p>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Items</h3>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Qty</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">Price</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${invoice.items.map(item => `
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">${item.name}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">${item.quantity}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">$${item.price.toFixed(2)}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">$${item.subtotal.toFixed(2)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="flex justify-end mb-6">
                        <div class="w-64">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">$${invoice.subtotal.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Tax (10%):</span>
                                <span class="font-medium">$${invoice.tax.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-300 pt-2">
                                <span class="text-lg font-semibold">Total:</span>
                                <span class="text-lg font-semibold">$${invoice.total.toFixed(2)}</span>
                            </div>
                        </div>
                    </div>
                    
                    ${invoice.notes ? `
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Notes:</h4>
                            <p class="text-gray-600 text-sm">${invoice.notes}</p>
                        </div>
                    ` : ''}
                </div>
            `;
        }

        // Generate printable invoice HTML
        function generatePrintableInvoiceHTML(invoice) {
            return `
                <div class="p-8">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                            <p class="text-gray-600 text-lg">#${invoice.invoiceNo}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600 text-lg">Date: ${invoice.date}</p>
                            <p class="text-gray-600 text-lg">Status: <span class="text-green-600 font-semibold">Paid</span></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Bill To:</h3>
                            <p class="text-gray-900 font-medium text-lg">${invoice.customerName}</p>
                            <p class="text-gray-600 text-lg">${invoice.customerEmail}</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">From:</h3>
                            <p class="text-gray-900 font-medium text-lg">Your Company Name</p>
                            <p class="text-gray-600 text-lg">123 Business Street</p>
                            <p class="text-gray-600 text-lg">City, State 12345</p>
                            <p class="text-gray-600 text-lg">contact@yourcompany.com</p>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Items</h3>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-3 text-left text-lg">Description</th>
                                    <th class="border border-gray-300 px-4 py-3 text-center text-lg">Qty</th>
                                    <th class="border border-gray-300 px-4 py-3 text-right text-lg">Price</th>
                                    <th class="border border-gray-300 px-4 py-3 text-right text-lg">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${invoice.items.map(item => `
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-3 text-lg">${item.name}</td>
                                        <td class="border border-gray-300 px-4 py-3 text-center text-lg">${item.quantity}</td>
                                        <td class="border border-gray-300 px-4 py-3 text-right text-lg">$${item.price.toFixed(2)}</td>
                                        <td class="border border-gray-300 px-4 py-3 text-right text-lg">$${item.subtotal.toFixed(2)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="flex justify-end mb-6">
                        <div class="w-80">
                            <div class="flex justify-between mb-3 text-lg">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">$${invoice.subtotal.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between mb-3 text-lg">
                                <span class="text-gray-600">Tax (10%):</span>
                                <span class="font-medium">$${invoice.tax.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-300 pt-3 text-xl">
                                <span class="font-semibold">Total:</span>
                                <span class="font-semibold">$${invoice.total.toFixed(2)}</span>
                            </div>
                        </div>
                    </div>
                    
                    ${invoice.notes ? `
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Notes:</h4>
                            <p class="text-gray-600 text-lg">${invoice.notes}</p>
                        </div>
                    ` : ''}
                    
                    <div class="mt-12 pt-8 border-t border-gray-300 text-center text-gray-500">
                        <p>Thank you for your business!</p>
                    </div>
                </div>
            `;
        }

        // Close invoice details modal
        function closeInvoiceDetails() {
            invoiceModal.classList.add('hidden');
        }

        // Delete Invoice
        function deleteInvoice(invoiceNo) {
            currentInvoiceToDelete = invoiceNo;
            deleteModal.classList.remove('hidden');
        }

        // Confirm Delete
        function confirmDelete() {
            if (currentInvoiceToDelete) {
                alert(`Invoice ${currentInvoiceToDelete} has been deleted.`);
                closeDeleteModal();
                currentInvoiceToDelete = null;
            }
        }

        // Close Delete Modal
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            currentInvoiceToDelete = null;
        }

        // Open sale modal
        function openSaleModal() {
            saleModal.classList.remove('hidden');
            resetForm();
        }

        // Close sale modal
        function closeSaleModal() {
            saleModal.classList.add('hidden');
        }

        // Reset form to initial state
        function resetForm() {
            cart = [];
            productSelect.value = '';
            quantityInput.value = 1;
            unitPriceInput.value = '$0.00';
            customerName.value = '';
            customerEmail.value = '';
            notes.value = '';
            updateCartDisplay();
            updateTotalAmount();
        }

        // Update unit price based on selected product
        function updateUnitPrice() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption.value) {
                const price = selectedOption.getAttribute('data-price');
                unitPriceInput.value = `$${price}`;
            } else {
                unitPriceInput.value = '$0.00';
            }
        }

        // Add product to cart
        function addToCart() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (!selectedOption.value) {
                alert('Please select a product');
                return;
            }

            const productId = selectedOption.value;
            const productName = selectedOption.text.split(' - ')[0];
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const quantity = parseInt(quantityInput.value);

            if (quantity < 1) {
                alert('Quantity must be at least 1');
                return;
            }

            // Check if product already in cart
            const existingItemIndex = cart.findIndex(item => item.id === productId);

            if (existingItemIndex !== -1) {
                cart[existingItemIndex].quantity += quantity;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: price,
                    quantity: quantity
                });
            }

            updateCartDisplay();
            updateTotalAmount();

            // Reset form
            productSelect.value = '';
            quantityInput.value = 1;
            unitPriceInput.value = '$0.00';
        }

        // Remove item from cart
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCartDisplay();
            updateTotalAmount();
        }

        // Update cart display
        function updateCartDisplay() {
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <tr id="emptyCart" class="text-center">
                        <td colspan="5" class="px-6 py-8 text-gray-500">
                            <i class="fas fa-shopping-cart text-3xl mb-2 text-gray-300"></i>
                            <p>Your cart is empty</p>
                            <p class="text-sm">Add products to get started</p>
                        </td>
                    </tr>
                `;
                return;
            }

            emptyCart.remove();

            cartItems.innerHTML = cart.map(item => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${item.name}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${item.quantity}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${item.price.toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$${(item.price * item.quantity).toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="removeFromCart('${item.id}')" class="text-red-600 hover:text-red-900 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Update total amount
        function updateTotalAmount() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            totalAmount.textContent = `$${total.toFixed(2)}`;
        }

        // Complete sale
        function completeSale() {
            if (cart.length === 0) {
                alert('Please add at least one product to the cart');
                return;
            }

            const invoiceNo = `INV-${new Date().getFullYear()}-${Math.floor(1000 + Math.random() * 9000)}`;

            const saleData = {
                invoiceNo: invoiceNo,
                customerName: customerName.value,
                customerEmail: customerEmail.value,
                notes: notes.value,
                items: cart,
                total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
                date: new Date().toLocaleDateString()
            };

            console.log('Sale completed:', saleData);

            alert(`Sale completed successfully!\n\nInvoice Number: ${invoiceNo}\nTotal Amount: $${saleData.total.toFixed(2)}`);

            closeSaleModal();
            resetForm();
        }

        // Make functions available globally for onclick handlers
        window.removeFromCart = removeFromCart;
        window.viewInvoice = viewInvoice;
        window.printInvoice = printInvoice;
        window.deleteInvoice = deleteInvoice;
        window.printCurrentInvoice = printCurrentInvoice;
    </script>
</body>

</html>