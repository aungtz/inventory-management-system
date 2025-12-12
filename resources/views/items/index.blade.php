<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List - Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        .modal-content {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 4xl;
            max-height: 90vh;
            overflow: auto;
            transform: scale(1);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        /* Custom styles to hide the original table headers on mobile */
        @media (max-width: 1024px) {
            .inventory-table thead {
                display: none;
            }
        }
        .sku-content {
    display: block;
}
#paginationControls {
    display: flex;
    gap: 8px;
    margin-top: 20px;
}

#paginationControls button {
    padding: 8px 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db; /* gray-300 */
    background: white;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s ease-in-out;
}

#paginationControls button:hover {
    background: #eef2ff; /* indigo-50 */
    border-color: #6366f1; /* indigo-500 */
    color: #4f46e5; /* indigo-600 */
}

#paginationControls button.active {
    background: #6366f1; /* indigo-500 */
    color: white;
    border-color: #4f46e5;
}

#paginationControls button:active {
    transform: scale(0.95);
}


    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen font-sans">
  @include('layout.sidebar')
   
<div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4 fade-in">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Item Inventory</h1>
                <p class="text-gray-600 mt-2">Comprehensive inventory management system</p>
            </div>
            <a href="{{ route('items.create') }}" 
               class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1 flex items-center gap-2 font-semibold">
                <i class="fas fa-plus-circle"></i>
                Create New Item
            </a>
        </div>

        <!-- Search and Export Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 fade-in">
            <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
                <!-- Search Box -->
                <div class="flex-1 w-full lg:w-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="searchInput"
                               placeholder="Search items by code, name, JAN, or maker..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                    </div>
                </div>

                <!-- Export Buttons (Kept for completeness) -->
           <div class="flex flex-wrap gap-2 w-full lg:w-auto">
   
  <a href="{{ route('export.all') }}"
   class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center gap-2 font-medium">
   <i class="fas fa-file-excel"></i>
   Export Items & SKUs
</a>

    <a href="#" id="exportCSV"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center gap-2 font-medium">
        <i class="fas fa-file-csv"></i>
        CSV
    </a>
</div>

            </div>
        </div>
<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg relative">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Import Items / SKUs</h2>

        <form id="importForm" class="flex flex-col gap-4">
            <!-- Import Items -->
            <div class="flex flex-col gap-1">
                <label for="importItems" class="font-medium">Import Items</label>
                <input type="file" id="importItems" accept=".xlsx,.xls,.csv" class="border p-2 rounded">
            </div>

            <!-- Import SKUs -->
            <div class="flex flex-col gap-1">
                <label for="importSkus" class="font-medium">Import SKUs</label>
                <input type="file" id="importSkus" accept=".xlsx,.xls,.csv" class="border p-2 rounded">
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded font-medium transition-all duration-200">
                Import
            </button>
        </form>
    </div>
</div>
<!-- Import modal -->
<!-- Import Items Modal -->
<div id="importItemsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg relative">
        <button id="closeItemsModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">&times;</button>
        <h2 class="text-xl font-semibold mb-4">Import Items</h2>

        <form id="importItemsForm" class="flex flex-col gap-4">
            <div class="flex flex-col gap-1">
                <label for="importItemsFile" class="font-medium">Import Items</label>
                <input type="file" id="importItemsFile" accept=".xlsx,.xls,.csv" class="border p-2 rounded">
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded font-medium transition-all duration-200">
                Preview Import
            </button>
        </form>

        <div id="previewItemsSummary" class="mt-4 hidden">
            <p id="totalItemsRows"></p>
            <p id="validItemsRows"></p>
            <p id="errorItemsRows"></p>
            <button id="confirmItemsImport" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mt-2">Confirm Import</button>
        </div>

        <div id="errorItemsDetails" class="mt-4 hidden">
            <h3 class="font-semibold mb-2">Error Details:</h3>
            <ul id="errorItemsList" class="list-disc list-inside text-red-600"></ul>
        </div>

        <div id="finalItemsSummary" class="mt-4 hidden p-4 bg-green-100 rounded"></div>
    </div>
</div>




        <!-- Table Container - Converted to Responsive Cards on small screens -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden fade-in inventory-table">
            @if($items->count() > 0)
                
                <!-- Desktop/Large Screen Header -->
                <table class="w-full hidden lg:table">
                    <thead class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider w-[15%]">Image & Code</th>
                            <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider w-[40%]">Product Details</th>
                            <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider w-[30%]">Pricing & SKU Stock</th>
                            <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider w-[15%]">Actions</th>
                        </tr>
                    </thead>
                </table>

                <!-- Item List Body (Using divs for responsiveness) -->
                <div id="itemTableBody">
                    @foreach($items as $item)
                        @php
                        $item_id = $item->id;

                        // Real SKU data from database
                        $skus = $item->skus;

                        // Total stock and count
                        $totalStock = $skus->sum('Quantity');
                        $skuCount = $skus->count();
                        @endphp

                        
                        <!-- Item Row/Card -->
                        <div class="border-b border-gray-200 p-4 lg:p-0 
                                    lg:grid lg:grid-cols-[15%_40%_30%_15%] 
                                    hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300"
                             data-searchable="{{ strtolower($item->Item_Code . ' ' . $item->Item_Name . ' ' . $item->JanCD . ' ' . $item->MakerName) }}"
                             id="item-row-{{ $item_id }}">
                            
                            <!-- 1. Image & Code -->
                            <div class="lg:px-6 lg:py-4 lg:border-r border-gray-100 flex items-center gap-4 lg:block">
                                <div class="relative w-24 h-24 rounded-xl overflow-hidden border-2 border-gray-200 shadow-md group-hover:border-indigo-400 transition-colors cursor-pointer flex-shrink-0" 
                                 data-images='@json($item->images->values())'
     data-name="{{ $item->Item_Name }}"
     onclick="openImageGalleryFromElement(this)"
>
                                    @if($item->images && $item->images->count() > 0)
                                        <img src="{{ asset('storage/items/' . $item->images->first()->Image_Name) }}" alt="{{ $item->Item_Name }}">

                                        
                                        @if($item->images->count() > 1)
                                            <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-white text-xs font-bold opacity-0 hover:opacity-100 transition-opacity p-1">
                                                <i class="fas fa-camera text-xl mb-1"></i>
                                                View {{ $item->images->count() }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-images text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-2 lg:mt-3">
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Code</span>
                                    <a href="{{ route('items.edit', $item->Item_Code) }}">
                                    <p class="font-bold text-gray-800 text-base">{{ $item->Item_Code ?? '-' }}</p>
                               </a>
                                </div>
                            </div>

                            <!-- 2. Product Details -->
                            <div class="lg:px-6 lg:py-4 lg:border-r border-gray-100 pt-4 lg:pt-0">
                                <div class="space-y-4">
                                    {{-- Item Name - Main Focus --}}
                                    <div class="pb-2 border-b-2 border-indigo-100">
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Name</span>
                                     <a href="{{ route('items.edit', $item->Item_Code) }}">
                                        <p class="font-extrabold text-2xl text-gray-800 mt-1">{{ $item->Item_Name ?? '-' }}</p>
</a>
                                    </div>

                                    {{-- JAN / Maker Details --}}
                                    <div class="grid grid-cols-2 gap-3 bg-gray-50 p-3 rounded-lg border border-gray-100 shadow-sm text-sm">
                                        <div>
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">JAN Code</span>
                                            <p class="font-mono text-gray-700">{{ $item->JanCD ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Maker</span>
                                            <p class="text-gray-700">{{ $item->MakerName ?? '-' }}</p>
                                        </div>
                                    </div>

                                    {{-- Memo --}}
                                    @if($item->Memo)
                                    <div class="p-3 rounded-lg border border-gray-200 bg-white shadow-sm">
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide flex items-center gap-1 mb-1">
                                            <i class="fas fa-sticky-note text-yellow-500"></i> Memo
                                        </span>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $item->Memo }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                  <!-- 3. Pricing & SKU Stock -->
                            <div class="lg:px-6 lg:py-4 lg:border-r border-gray-100 pt-4 lg:pt-0">
                                <div class="space-y-4">
                                    
                                   {{-- ========================================================= --}}
{{-- 1. JavaScript Functions (Define before usage) --}}
{{-- ========================================================= --}}

<script>
     window.showSkuTable = function(button, itemCode) {
        // သက်ဆိုင်ရာ item အတွက် container ကို ရယူပါ
        const containerId = `skuTableContainer-${itemCode}`;
        const contentId = `skuTableContent-${itemCode}`;
        
        const container = document.getElementById(containerId);
        const content = document.getElementById(contentId);

        // အကယ်၍ container က ပွင့်နေပြီးသားဆိုရင် ပြန်ပိတ်ရန်
        if (!container.classList.contains('hidden')) {
            container.classList.add('hidden');
            return;
        }

        // URL encoded data ကို decode လုပ်ပြီး JSON အဖြစ် ပြောင်းပါ
        const pivotData = JSON.parse(decodeURIComponent(button.dataset.pivotSkus));

        if (!pivotData || pivotData.length === 0) {
            content.innerHTML = '<p class="text-gray-500 text-center">No SKUs available.</p>';
            container.classList.remove('hidden');
            return;
        }

        // Pivot table ကို စတင်တည်ဆောက်ခြင်း
        let tableHTML = `
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 font-semibold text-gray-700">
                    <tr>
                        <th class="p-2 border-b">Color</th>
                        <th class="p-2 border-b">S</th>
                        <th class="p-2 border-b">M</th>
                        <th class="p-2 border-b">L</th>
                        <th class="p-2 border-b">XL</th>
                    </tr>
                </thead>
                <tbody>
        `;

        pivotData.forEach(row => {
            tableHTML += `
                <tr class="border-b">
                    <td class="p-2">${row.Color_Name}</td>
                    <td class="p-2">${row.S}</td>
                    <td class="p-2">${row.M}</td>
                    <td class="p-2">${row.L}</td>
                    <td class="p-2">${row.XL}</td>
                </tr>
            `;
        });

        tableHTML += `</tbody></table>`;

        // Content ကို ထည့်သွင်းပြီး Container ကို ပြသပါ
        content.innerHTML = tableHTML;
        container.classList.remove('hidden');
    };
</script>



                            <div class="lg:px-6 lg:py-4 lg:border-r border-gray-100 pt-4 lg:pt-0">
                                <div class="space-y-4">
                                    {{-- Total Stock Card & Toggle Button --}}
                                    <div class="p-4 rounded-xl bg-indigo-50 border border-indigo-200 shadow-lg">
                                        <div class="flex justify-between items-center mb-1">
                                            {{-- ... Stock Title ... --}}
                                            
                                            @if($skuCount > 0)
                                                {{-- item ၏ သက်ဆိုင်ရာ Pivot Data ကို ဤနေရာတွင် စစ်ထုတ်သည် --}}
                                                @php
                                                    // $pivotSkus ကို controller မှ ပို့ထားပြီး၊ $item သည် loop အတွင်းမှဖြစ်မည်။
                                                    $itemPivotSkus = collect($pivotSkus)->where('Item_Code', $item->Item_Code)->values();
                                                @endphp

                                            <button
                                                    onclick="showSkuTable(this, '{{ $item->Item_Code }}')" {{-- function အသစ်ကို ခေါ်ပြီး Item Code ကို ထည့်ပေးသည် --}}
                                                    data-pivot-skus="{{ urlencode(json_encode($itemPivotSkus)) }}"
                                                    class="text-indigo-500 hover:text-indigo-700 p-1 rounded hover:bg-indigo-100"
                                                >
                                                    <i class="fas fa-eye"></i> View SKUs
                                                </button>
                                            @endif
                                        </div>
                                        
                                        <p class="font-extrabold text-4xl mt-1 {{ $totalStock > 0 ? 'text-indigo-800' : 'text-red-600' }}">
                                            {{ $totalStock }}
                                        </p>
                                    </div>
                                    
                                    {{-- Modal Structure --}}
                                    <div 
                                        id="skuTableContainer-{{ $item->Item_Code }}" {{-- Item Code ဖြင့် ID ပေးသည် --}}
                                        class="p-4 rounded-xl border border-gray-200 shadow-sm hidden" {{-- စစချင်းမှာ ဝှက်ထားသည် --}}
                                    >
                                        <h3 class="text-lg font-semibold text-gray-700 mb-3">SKU Details (Pivot)</h3>
                                        
                                        {{-- Table ကို ထည့်သွင်းရန် နေရာ --}}
                                        <div id="skuTableContent-{{ $item->Item_Code }}" 
                                            class="space-y-2 max-h-96 overflow-y-auto" {{-- Scrollbar ပါရှိသည် --}}
                                        >
                                            </div>
                                    </div>
                                </div>
                            </div>
                                                                
                                    {{-- Pricing Metrics --}}
                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div class="p-3 rounded-lg bg-white border border-gray-100 shadow-sm">
                                            <span class="text-xs font-semibold text-green-700 block mb-1">List Price</span>
                                            <span class="font-bold text-lg text-green-700 block">¥{{ $item->ListPrice ? number_format($item->ListPrice) : '0' }}</span>
                                        </div>
                                        <div class="p-3 rounded-lg bg-white border border-gray-100 shadow-sm">
                                            <span class="text-xs font-semibold text-red-700 block mb-1">Cost Price</span>
                                            <span class="font-bold text-lg text-red-700 block">¥{{ $item->CostPrice ? number_format($item->CostPrice) : '0' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Actions -->
                            <div class="lg:px-6 lg:py-4 pt-4 lg:pt-0" style="
    margin-top: 15px;">
                                <div class="flex flex-col space-y-3">
                                   <a href="{{ route('items.edit', $item->Item_Code) }}"
   class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-4 py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 font-semibold shadow-md transform hover:scale-[1.02]">
    <i class="fas fa-edit"></i>
    Edit
</a>

                                    <button type="button" 
                                            onclick="confirmDelete(`{{ $item->Item_Code }}`, `{{ e($item->Item_Name) }}`)"

                                            class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-4 py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 font-semibold shadow-md transform hover:scale-[1.02]">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <i class="fas fa-boxes text-indigo-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">No Inventory Items</h3>
                        <p class="text-gray-500 mb-6">Start building your inventory by adding the first item.</p>
                        <a href="{{ route('items.create') }}" 
                           class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-xl shadow-lg transition-all duration-300 inline-flex items-center gap-2 font-semibold">
                            <i class="fas fa-plus-circle"></i>
                            Create First Item
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Stats Footer (Kept as is) -->
        @if($items->count() > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in">
            <!-- <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold">Total Items</p>
                        <p class="text-3xl font-bold mt-2">{{ $items->count() }}</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-400 rounded-xl flex items-center justify-center bg-opacity-20">
                        <i class="fas fa-box text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold">Total SKUs</p>
                        <p class="text-3xl font-bold mt-2">{{ $items->sum(fn($item) => $item->skus ? $item->skus->count() : 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-green-400 rounded-xl flex items-center justify-center bg-opacity-20">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold">With Images</p>
                        <p class="text-3xl font-bold mt-2">{{ $items->filter(fn($item) => $item->images && $item->images->count() > 0)->count() }}</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-400 rounded-xl flex items-center justify-center bg-opacity-20">
                        <i class="fas fa-images text-2xl"></i>
                    </div>
                </div>
            </div> -->
    <div class="col-span-1 md:col-span-2 lg:col-span-4 flex justify-end">
                    
                               <div id="pagination" class="flex justify-end items-center gap-2 mt-4"></div>
                </div>
        </div>
        @endif
        
    </div>


    
    <!-- Image Gallery Modal -->
    <div id="imageGalleryModal" class="modal-overlay">
        <div class="modal-content max-w-4xl">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-6">
                <h2 id="galleryTitle" class="text-2xl font-semibold text-indigo-700">Product Image Gallery</h2>
                <button onclick="closeImageGallery()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <div id="galleryContent" class="grid grid-cols-2 md:grid-cols-4 gap-4 max-h-[70vh] overflow-y-auto p-2">
                <!-- Images will be injected here by JavaScript -->
            </div>
            
            <div id="galleryEmptyMessage" class="text-center text-gray-500 py-10" style="display: none;">
                <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                <p>No images were found for this item.</p>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
<div id="deleteModal"
     class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white w-[400px] p-6 rounded-xl shadow-lg space-y-4">
        
        <h2 class="text-xl font-bold text-red-600">Confirm Delete</h2>

        <p class="text-gray-700">
            Are you sure you want to delete this item?
        </p>

        <div class="bg-gray-100 p-3 rounded-md">
            <p><strong>ID:</strong> <span id="deleteItemId"></span></p>
            <p><strong>Name:</strong> <span id="deleteItemName"></span></p>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Confirm Delete
                </button>
            </div>
        </form>
    </div>
</div>

   
    <script>

        window.openSkuModal = function(button) {
    const modal = document.getElementById('skuModal');
    const content = document.getElementById('skuModalContent');

    // Decode the JSON safely
    const pivotData = JSON.parse(decodeURIComponent(button.dataset.pivotSkus));

    if (!pivotData || pivotData.length === 0) {
        content.innerHTML = '<p class="text-gray-500 text-center">No SKUs available.</p>';
        modal.classList.remove('hidden');
        return;
    }

    // Build pivot table
    let tableHTML = `
        <table class="w-full text-sm text-left border border-gray-200">
            <thead class="bg-gray-100 font-semibold text-gray-700">
                <tr>
                    <th class="p-2 border-b">Color</th>
                    <th class="p-2 border-b">S</th>
                    <th class="p-2 border-b">M</th>
                    <th class="p-2 border-b">L</th>
                    <th class="p-2 border-b">XL</th>
                </tr>
            </thead>
            <tbody>
    `;

    pivotData.forEach(row => {
        tableHTML += `
            <tr class="border-b">
                <td class="p-2">${row.Color_Name}</td>
                <td class="p-2">${row.S}</td>
                <td class="p-2">${row.M}</td>
                <td class="p-2">${row.L}</td>
                <td class="p-2">${row.XL}</td>
            </tr>
        `;
    });

    tableHTML += `</tbody></table>`;

    content.innerHTML = tableHTML;
    modal.classList.remove('hidden');
};

window.closeSkuModal = function() {
    document.getElementById('skuModal').classList.add('hidden');
};

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('importItemsModal');
    const closeBtn = document.getElementById('closeItemsModal');
    const form = document.getElementById('importItemsForm');
    const fileInput = document.getElementById('importItemsFile');

    const previewSummary = document.getElementById('previewItemsSummary');
    const totalEl = document.getElementById('totalItemsRows');
    const validEl = document.getElementById('validItemsRows');
    const errorEl = document.getElementById('errorItemsRows');
    const confirmBtn = document.getElementById('confirmItemsImport');

    const errorDetails = document.getElementById('errorItemsDetails');
    const errorList = document.getElementById('errorItemsList');

    const finalSummary = document.getElementById('finalItemsSummary');

    let validRows = [];

    // Close modal
    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        previewSummary.classList.add('hidden');
        errorDetails.classList.add('hidden');
        finalSummary.classList.add('hidden');
    });

    // Preview import
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!fileInput.files.length) {
            alert('Please select a file.');
            return;
        }

        const formData = new FormData();
        formData.append('items_file', fileInput.files[0]);

        fetch('/import-items/preview', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            totalEl.textContent = `Total Rows: ${data.total}`;
            validEl.textContent = `Valid Rows: ${data.valid}`;
            errorEl.textContent = `Error Rows: ${data.errors}`;

            validRows = data.validRows;

            if (data.errors > 0) {
                errorList.innerHTML = '';
                data.errorRows.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = `Row ${err.row || 'N/A'}: ${err.Error_Msg}`;
                    errorList.appendChild(li);
                });
                errorDetails.classList.remove('hidden');
            } else {
                errorDetails.classList.add('hidden');
            }

            previewSummary.classList.remove('hidden');
        })
        .catch(err => console.error(err));
    });

    // Confirm import
    confirmBtn.addEventListener('click', function () {
        if (!validRows.length) {
            alert('No valid rows to import.');
            return;
        }

        fetch('/import-items/import', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ valid_rows: validRows })
        })
        .then(res => res.json())
        .then(data => {
            previewSummary.classList.add('hidden');
            errorDetails.classList.add('hidden');

            finalSummary.innerHTML = `
                <p>${data.message}</p>
                <p>ImportLog ID: ${data.ImportLog_ID}</p>
            `;
            finalSummary.classList.remove('hidden');
        })
        .catch(err => console.error(err));
    });
});





        /**
         * Toggles the visibility of the SKU details section for a specific item.
         * @param {number} itemId - The ID of the item.
         */
    function toggleSkus(itemId) {
    const details = document.getElementById(`sku-details-${itemId}`);
    const icon = document.getElementById(`sku-toggle-icon-${itemId}`);

    if (!details || !icon) {
        console.warn('SKU details or icon not found for item ID:', itemId);
        return;
    }

    if (details.style.maxHeight === '0px' || details.style.maxHeight === '') {
        requestAnimationFrame(() => {
            details.style.maxHeight = details.scrollHeight + 'px';
        });
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        details.style.maxHeight = '0px';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

function openImageGalleryFromElement(el) {
    const itemName = el.getAttribute('data-name');
    let images = el.getAttribute('data-images');

    try {
        images = JSON.parse(images);
    } catch (e) {
        console.error("JSON Error:", e, images);
        images = [];
    }

    openImageGallery(itemName, images);
}

        /**
         * Generic Function to open the Image Gallery Modal
         * @param {string} itemName - The name of the item to display in the modal title.
         * @param {Array<Object>} images - An array of image objects, each containing an Image_Name property.
         */
      function openImageGallery(itemName, images) {
    if (images && !Array.isArray(images)) {
        images = Object.values(images);
    }

    const modal = document.getElementById('imageGalleryModal');
    const content = document.getElementById('galleryContent');
    const title = document.getElementById('galleryTitle');
    const emptyMessage = document.getElementById('galleryEmptyMessage');

    content.innerHTML = '';
    title.textContent = `Image Gallery: ${itemName}`;

    if (!images || images.length === 0) {
        emptyMessage.style.display = 'block';
        content.style.display = 'none';
    } else {
        emptyMessage.style.display = 'none';
        content.style.display = 'grid';

        images.forEach((image, index) => {
            const imageUrl = `/storage/items/${image.Image_Name}`;
            const div = document.createElement('div');
            div.className = "w-full aspect-square rounded-lg overflow-hidden shadow";
            div.innerHTML = `<img src="${imageUrl}" class="w-full h-full object-cover">`;
            content.appendChild(div);
        });
    }

    modal.style.display = 'flex';
}



        function closeImageGallery() {
            document.getElementById('imageGalleryModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('imageGalleryModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('imageGalleryModal')) {
                closeImageGallery();
            }
        });

        // Placeholder for confirmDelete function (since it's not defined)
      function confirmDelete(id, name) {
    // show modal
    document.getElementById('deleteModal').classList.remove('hidden');

    // show data inside modal
    document.getElementById('deleteItemId').textContent = id;
    document.getElementById('deleteItemName').textContent = name;

    // set form action
    document.getElementById('deleteForm').action = `/items/${id}`;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
const rows = document.getElementById("itemTableBody").children;
const itemsPerPage = 10;
let currentPage = 1;
let filteredRows = Array.from(rows);

function renderTable() {
    Array.from(rows).forEach(r => (r.style.display = "none"));

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    filteredRows.slice(start, end).forEach(r => (r.style.display = ""));

    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
    const container = document.getElementById("pagination");
    container.innerHTML = ""; // Reset first

    // --- Prev Button ---
    const prevBtn = document.createElement("button");
    prevBtn.textContent = "Prev";
    prevBtn.className = "px-3 py-1 bg-gray-200 rounded";
    prevBtn.disabled = currentPage === 1;
    prevBtn.onclick = () => {
        currentPage--;
        renderTable();
    };
    container.appendChild(prevBtn);

    // --- Page Number Buttons ---
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement("button");
        pageBtn.textContent = i;
        pageBtn.className =
            "px-3 py-1 rounded " +
            (i === currentPage ? "bg-indigo-500 text-white" : "bg-gray-200");

        pageBtn.onclick = () => {
            currentPage = i;
            renderTable();
        };

        container.appendChild(pageBtn);
    }

    // --- Next Button ---
    const nextBtn = document.createElement("button");
    nextBtn.textContent = "Next";
    nextBtn.className = "px-3 py-1 bg-gray-200 rounded";
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => {
        currentPage++;
        renderTable();
    };
    container.appendChild(nextBtn);
}

// --- Search with comma support ---
document.getElementById("searchInput").addEventListener("keyup", function () {
    const input = this.value.toLowerCase();

    const keywords = input
        .split(",")
        .map(k => k.trim())
        .filter(k => k.length > 0);

    filteredRows = Array.from(rows).filter(row => {
        const searchable = row.getAttribute("data-searchable").toLowerCase();
        if (keywords.length === 0) return true;
        return keywords.some(keyword => searchable.includes(keyword));
    });

    currentPage = 1; // Reset page after search
    renderTable();
});

// Initial display
renderTable();


    </script>
</body>

</html>