<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKU Details Log</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Simple table styling */
        .table-container {
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .sticky-header th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        /* Size and color indicators */
        .size-badge {
            display: inline-block;
            padding: 2px 8px;
            background: #e5e7eb;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .color-badge {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
            vertical-align: middle;
        }
        
        /* Scrollbar */
        .table-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: #888;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
        @include('layout.sidebar')

    <main class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">SKU Details Log</h1>
                    <p class="text-gray-600">Import ID: IMP-2024-002-SKU | Date: 2024-01-14 03:45 PM</p>
                </div>
                <a href="/import-log" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Import Log
                </a>
            </div>
            
            <!-- Summary -->
            <div class="bg-white rounded-lg p-4 shadow mb-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Total SKUs</p>
                        <p class="text-lg font-semibold">2,845</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Import Status</p>
                        <p class="text-lg font-semibold text-green-600">Completed</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Imported By</p>
                        <p class="text-lg font-semibold">Jane Smith</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">File Name</p>
                        <p class="text-lg font-semibold">skus_import_20240114.csv</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SKU Details Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Imported SKUs</h2>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-100 sticky-header">
                        <tr>
                            <th class="p-3 text-left font-medium text-gray-700">Item_Code</th>
                            <th class="p-3 text-left font-medium text-gray-700">Size_Name</th>
                            <th class="p-3 text-left font-medium text-gray-700">Color_Name</th>
                            <th class="p-3 text-left font-medium text-gray-700">Size_Code</th>
                            <th class="p-3 text-left font-medium text-gray-700">Color_Code</th>
                            <th class="p-3 text-left font-medium text-gray-700">JanCode</th>
                            <th class="p-3 text-left font-medium text-gray-700">Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-001</td>
                            <td class="p-3"><span class="size-badge">XL</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #dc2626;"></span>
                                    Red
                                </div>
                            </td>
                            <td class="p-3 font-mono">XL001</td>
                            <td class="p-3 font-mono">RED01</td>
                            <td class="p-3 font-mono">4901234567890</td>
                            <td class="p-3 font-medium">50</td>
                        </tr>
                        
                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-001</td>
                            <td class="p-3"><span class="size-badge">M</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #2563eb;"></span>
                                    Blue
                                </div>
                            </td>
                            <td class="p-3 font-mono">M001</td>
                            <td class="p-3 font-mono">BLU01</td>
                            <td class="p-3 font-mono">4901234567891</td>
                            <td class="p-3 font-medium">35</td>
                        </tr>
                        
                        <!-- Row 3 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-001</td>
                            <td class="p-3"><span class="size-badge">L</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #000000;"></span>
                                    Black
                                </div>
                            </td>
                            <td class="p-3 font-mono">L001</td>
                            <td class="p-3 font-mono">BLK01</td>
                            <td class="p-3 font-mono">4901234567892</td>
                            <td class="p-3 font-medium">42</td>
                        </tr>
                        
                        <!-- Row 4 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-002</td>
                            <td class="p-3"><span class="size-badge">L</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #000000;"></span>
                                    Black
                                </div>
                            </td>
                            <td class="p-3 font-mono">L002</td>
                            <td class="p-3 font-mono">BLK01</td>
                            <td class="p-3 font-mono">4909876543210</td>
                            <td class="p-3 font-medium">120</td>
                        </tr>
                        
                        <!-- Row 5 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-002</td>
                            <td class="p-3"><span class="size-badge">M</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #dc2626;"></span>
                                    Red
                                </div>
                            </td>
                            <td class="p-3 font-mono">M002</td>
                            <td class="p-3 font-mono">RED02</td>
                            <td class="p-3 font-mono">4909876543211</td>
                            <td class="p-3 font-medium">85</td>
                        </tr>
                        
                        <!-- Row 6 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-003</td>
                            <td class="p-3"><span class="size-badge">32</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #1e40af;"></span>
                                    Navy Blue
                                </div>
                            </td>
                            <td class="p-3 font-mono">32</td>
                            <td class="p-3 font-mono">NAV01</td>
                            <td class="p-3 font-mono">4905551234567</td>
                            <td class="p-3 font-medium">65</td>
                        </tr>
                        
                        <!-- Row 7 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-003</td>
                            <td class="p-3"><span class="size-badge">34</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #1e40af;"></span>
                                    Navy Blue
                                </div>
                            </td>
                            <td class="p-3 font-mono">34</td>
                            <td class="p-3 font-mono">NAV01</td>
                            <td class="p-3 font-mono">4905551234568</td>
                            <td class="p-3 font-medium">58</td>
                        </tr>
                        
                        <!-- Row 8 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-004</td>
                            <td class="p-3"><span class="size-badge">9</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #ffffff; border: 1px solid #ccc;"></span>
                                    White
                                </div>
                            </td>
                            <td class="p-3 font-mono">9</td>
                            <td class="p-3 font-mono">WHT01</td>
                            <td class="p-3 font-mono">4907778889999</td>
                            <td class="p-3 font-medium">90</td>
                        </tr>
                        
                        <!-- Row 9 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-004</td>
                            <td class="p-3"><span class="size-badge">10</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #000000;"></span>
                                    Black
                                </div>
                            </td>
                            <td class="p-3 font-mono">10</td>
                            <td class="p-3 font-mono">BLK02</td>
                            <td class="p-3 font-mono">4907778889990</td>
                            <td class="p-3 font-medium">75</td>
                        </tr>
                        
                        <!-- Row 10 -->
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-mono">ITM-005</td>
                            <td class="p-3"><span class="size-badge">OS</span></td>
                            <td class="p-3">
                                <div class="flex items-center">
                                    <span class="color-badge" style="background-color: #78350f;"></span>
                                    Brown
                                </div>
                            </td>
                            <td class="p-3 font-mono">OS</td>
                            <td class="p-3 font-mono">BRN01</td>
                            <td class="p-3 font-mono">4904443332221</td>
                            <td class="p-3 font-medium">120</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-4 border-t">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Showing 1 to 10 of 2,845 SKUs
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded text-sm">Previous</button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">1</button>
                        <button class="px-3 py-1 border rounded text-sm">2</button>
                        <button class="px-3 py-1 border rounded text-sm">3</button>
                        <button class="px-3 py-1 border rounded text-sm">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>