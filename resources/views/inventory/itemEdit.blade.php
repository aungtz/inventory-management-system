<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Registration</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            transition: background-color 0.5s, color 0.5s;
        }
        .image-preview-container {
            position: relative;
            display: inline-block;
        }
        .delete-image-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            border: 2px solid white;
            z-index: 10;
        }
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 50;
            padding: 1rem;
        }
        .modal-content {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 6xl;
            max-height: 90vh;
            overflow: auto;
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }
        .modal-enter {
            opacity: 1;
            transform: scale(1);
        }
        /* Style for dark mode simulation (optional but kept for robustness) */
        .dark {
            background: linear-gradient(135deg, #111827, #1e293b, #111827);
            color: #f9fafb;
        }
        .dark .modal-content {
            background: #1f2937;
            color: #f9fafb;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-cyan-100 text-gray-800">
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-700">Item Registration</h1>
            <a href="{{ route('items.index') }}" 
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-indigo-600 hover:bg-indigo-700 text-white flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                View Item List
            </a>
        </div>

        <!-- Item Registration Form -->
        <div class="bg-white/70 rounded-2xl shadow-xl p-6 transition-all duration-500 border border-gray-200">
            <!-- Form action is set to # for pure HTML demo -->
        @php
    $isEdit = isset($item);
@endphp

<form action="{{ $isEdit ? route('items.update', $item->id) : route('items.store') }}" 
      method="POST" enctype="multipart/form-data" class="space-y-6" id="itemForm">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <!-- Basic Information -->
    <div class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Item Code <span class="text-red-500">*</span></label>
                <input type="text" name="Item_Code" required
                       value="{{ old('Item_Code', $item->Item_Code ?? '') }}"
                       class="w-full p-2 rounded-md border focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block font-semibold mb-1">Item Name <span class="text-red-500">*</span></label>
                <input type="text" name="Item_Name" required
                       value="{{ old('Item_Name', $item->Item_Name ?? '') }}"
                       class="w-full p-2 rounded-md border focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">JanCD <span class="text-red-500">*</span></label>
                <input type="text" name="JanCD" maxlength="13" required
                       value="{{ old('JanCD', $item->JanCD ?? '') }}"
                       class="w-full p-2 rounded-md border focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block font-semibold mb-1">Maker Name <span class="text-red-500">*</span></label>
                <input type="text" name="MakerName" required
                       value="{{ old('MakerName', $item->MakerName ?? '') }}"
                       class="w-full p-2 rounded-md border focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
    </div>

    <!-- Pricing, Memo, Images, SKU sections remain the same -->
    <!-- Just pre-fill values like above using $item->field_name -->

    <div class="flex justify-end mt-6 space-x-3">
        <a href="{{ route('items.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
        <button type="submit"
                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 shadow-lg">
            {{ $isEdit ? 'Update Item' : 'Save Item' }}
        </button>
    </div>
</form>


        </div>
    </div>

    <!-- SKU Modal -->
    <div id="skuModal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-indigo-700">SKU Adding Form</h2>
                <button id="closeSkuModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-indigo-300/70">
                        <tr>
                            <th class="p-3 border">Delete</th>
                            <th class="p-3 border">Size Name<br><small class="font-normal">(Horizontal axis options)</small></th>
                            <th class="p-3 border">Color Name<br><small class="font-normal">(Vertical axis options)</small></th>
                            <th class="p-3 border">Size Code</th>
                            <th class="p-3 border">Color Code</th>
                            <th class="p-3 border">JAN Code</th>
                            <th class="p-3 border">Qty-flag</th>
                            <th class="p-3 border">Number in Stock</th>
                        </tr>
                    </thead>
                    <tbody id="skuModalBody">
                        <!-- Rows will be added here by JavaScript -->
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-6 space-x-3 pt-4 border-t border-gray-200">
                <button type="button" id="closeModalBtn" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    Close
                </button>
                <button type="button" id="saveSkusBtn" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save SKUs
                </button>
            </div>
        </div>
    </div>

  <script>
document.addEventListener("DOMContentLoaded", function () {

    const state = {
        skus: [],
        productImages: [] 
    };

    const elements = {
        skuModal: document.getElementById('skuModal'),
        openSkuModal: document.getElementById('openSkuModal'),
        closeSkuModal: document.getElementById('closeSkuModal'),
        closeModalBtn: document.getElementById('closeModalBtn'),
        saveSkusBtn: document.getElementById('saveSkusBtn'),
        skuModalBody: document.getElementById('skuModalBody'),
        skuTableBody: document.getElementById('skuTableBody'),
        emptySkuState: document.getElementById('emptySkuState'),

        imageUpload: document.getElementById('imageUpload'),
        imageGallery: document.getElementById('imageGallery'),
        emptyImageState: document.getElementById('emptyImageState'),
        imageCount: document.getElementById('imageCount'),
        imageCountNumber: document.getElementById('imageCountNumber'),

        itemForm: document.getElementById('itemForm')
    };

    /* ====================================================
       IMAGE UPLOAD / PREVIEW
    ==================================================== */

    function handleImageUpload(event) {
        const files = Array.from(event.target.files || []);

        files.forEach(file => {
            if (!state.productImages.some(f => f.file.name === file.name && f.file.size === file.size)) {
                state.productImages.push({
                    file: file,
                    name: file.name,
                    size: file.size,
                    url: URL.createObjectURL(file)
                });
            }
        });

        event.target.value = '';
        renderImageGallery();
    }

    function deleteImage(index) {
        if (!state.productImages[index]) return;

        URL.revokeObjectURL(state.productImages[index].url);
        state.productImages.splice(index, 1);

        renderImageGallery();
    }

    function renderImageGallery() {
        const gallery = elements.imageGallery;
        gallery.innerHTML = '';

        if (!state.productImages.length) {
            gallery.appendChild(elements.emptyImageState);
            elements.imageCount.classList.add('hidden');
            return;
        }

        if (elements.emptyImageState.parentNode === gallery) {
            elements.emptyImageState.remove();
        }

        state.productImages.forEach((entry, index) => {
            const container = document.createElement('div');
            container.className = 'image-preview-container';

            container.innerHTML = `
                <div class="relative group">
                    <img src="${entry.url}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 group-hover:border-indigo-400 transition-colors">
                    <button type="button" data-index="${index}" class="delete-image-btn">×</button>

                    <div class="absolute inset-x-0 bottom-0 bg-black/60 text-white text-xs p-2 rounded-b-lg opacity-0 group-hover:opacity-100 transition-opacity">
                        <p class="truncate">${entry.file.name}</p>
                    </div>
                </div>
            `;

            container.querySelector('.delete-image-btn').addEventListener('click', () => deleteImage(index));

            gallery.appendChild(container);
        });

        elements.imageCountNumber.textContent = state.productImages.length;
        elements.imageCount.classList.remove('hidden');
    }

    /* ====================================================
       SKU MODAL
    ==================================================== */

    function openSkuModal() {
        elements.skuModal.style.display = 'flex';
        setTimeout(() => elements.skuModal.classList.add('modal-enter'), 10);
        renderSkuModal();
    }

    function closeSkuModal() {
        elements.skuModal.classList.remove('modal-enter');
        setTimeout(() => elements.skuModal.style.display = 'none', 200);
    }

    function renderSkuModal() {
        elements.skuModalBody.innerHTML = '';

        state.skus.forEach((sku, index) => {
            const row = document.createElement('tr');
            row.className = "border hover:bg-gray-50";

            row.innerHTML = `
                <td class="p-3 text-center"><button type="button" class="text-red-500 font-bold">&times;</button></td>

                <td class="p-2"><input type="text" value="${sku.sizeName}" class="w-full p-2 border sku-size-name"></td>
                <td class="p-2"><input type="text" value="${sku.colorName}" class="w-full p-2 border sku-color-name"></td>

                <td class="p-2"><input type="text" value="${sku.sizeCode}" class="w-full p-2 border sku-size-code"></td>
                <td class="p-2"><input type="text" value="${sku.colorCode}" class="w-full p-2 border sku-color-code"></td>

                <td class="p-2"><input type="text" maxlength="13" value="${sku.janCode}" class="w-full p-2 border sku-jan-code"></td>

                <td class="p-2">
                    <select class="w-full p-2 border sku-qty-flag">
                        <option value="soldout" ${sku.qtyFlag === 'soldout' ? 'selected' : ''}>Sold out (00)</option>
                        <option value="manual" ${sku.qtyFlag === 'manual' ? 'selected' : ''}>Manual</option>
                    </select>
                </td>

                <td class="p-2"><input type="number" value="${sku.stockQty}" class="w-full p-2 border sku-stock-qty"></td>
            `;

            row.querySelector('button').addEventListener('click', () => deleteSkuRow(index));

            row.querySelector('.sku-size-name').addEventListener('input', e => {
                sku.sizeName = e.target.value; 
                renderSkuTable();
            });

            row.querySelector('.sku-color-name').addEventListener('input', e => {
                sku.colorName = e.target.value; 
                renderSkuTable();
            });

            row.querySelector('.sku-size-code').addEventListener('input', e => sku.sizeCode = e.target.value);
            row.querySelector('.sku-color-code').addEventListener('input', e => sku.colorCode = e.target.value);
            row.querySelector('.sku-jan-code').addEventListener('input', e => sku.janCode = e.target.value);

            row.querySelector('.sku-qty-flag').addEventListener('change', e => sku.qtyFlag = e.target.value);

            row.querySelector('.sku-stock-qty').addEventListener('input', e => {
                sku.stockQty = parseInt(e.target.value) || 0;
                renderSkuTable();
            });

            elements.skuModalBody.appendChild(row);
        });

        const addRow = document.createElement('tr');
        addRow.innerHTML = `
            <td colspan="8" class="text-center py-4">
                <button type="button" class="bg-indigo-500 text-white px-4 py-2 rounded-lg">Add New Row</button>
            </td>
        `;
        addRow.querySelector('button').addEventListener('click', addSkuRow);

        elements.skuModalBody.appendChild(addRow);
    }

    /* ====================================================
       SKU TABLE (MAIN)
    ==================================================== */

    function renderSkuTable() {
        elements.skuTableBody.innerHTML = '';

        document.querySelectorAll('input[name^="skus["]').forEach(e => e.remove());

        if (!state.skus.length) {
            elements.skuTableBody.appendChild(elements.emptySkuState);
            return;
        }

        if (elements.emptySkuState.parentNode === elements.skuTableBody) {
            elements.emptySkuState.remove();
        }

        state.skus.forEach((sku, index) => {
            const row = document.createElement('tr');
            row.className = 'text-center border';

            row.innerHTML = `
                <td class="p-3 border">${sku.colorName || '-'}</td>
                <td class="p-3 border">${sku.sizeName || '-'}</td>
                <td class="p-3 border">${sku.stockQty || 0}</td>
            `;

            elements.skuTableBody.appendChild(row);

            const form = elements.itemForm;
            [
                ['ColorName', sku.colorName],
                ['SizeName', sku.sizeName],
                ['StockQty', sku.stockQty],
                ['SizeCode', sku.sizeCode],
                ['ColorCode', sku.colorCode],
                ['JanCode', sku.janCode],
                ['QtyFlag', sku.qtyFlag]
            ].forEach(([key, val]) => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = `skus[${index}][${key}]`;
                inp.value = val ?? '';
                form.appendChild(inp);
            });
        });
    }

    function addSkuRow() {
        state.skus.push({ 
            sizeName: '',
            colorName: '',
            sizeCode: '',
            colorCode: '',
            janCode: '',
            qtyFlag: 'manual',
            stockQty: 0
        });

        renderSkuModal();
        renderSkuTable();
    }

    function deleteSkuRow(index) {
        state.skus.splice(index, 1);
        renderSkuModal();
        renderSkuTable();
    }

    /* ====================================================
       EVENT LISTENERS
    ==================================================== */

    elements.imageUpload.addEventListener('change', handleImageUpload);

    elements.openSkuModal.addEventListener('click', openSkuModal);
    elements.closeSkuModal.addEventListener('click', closeSkuModal);
    elements.closeModalBtn.addEventListener('click', closeSkuModal);
    elements.saveSkusBtn.addEventListener('click', closeSkuModal);

    /* ====================================================
       FORM SUBMIT (LOG ONLY)
    ==================================================== */

    elements.itemForm.addEventListener('submit', function (e) {

        const form = this;
        const fd = new FormData(form);

        console.log("==============================================");
        console.log("Form Submit Data");
        console.log("==============================================");

        console.log("Basic Fields:");
        for (let pair of fd.entries()) {
            if (!pair[0].startsWith('skus[') && pair[0] !== 'images[]') {
                console.log(pair[0] + ": " + pair[1]);
            }
        }

        console.log("\nSKU Data:");
        console.log(JSON.stringify(state.skus, null, 2));

        console.log("\nImages:");
        state.productImages.forEach((img, i) => {
            console.log(`${i + 1}. ${img.file.name} (${img.file.size} bytes)`);
        });
        

        const submitButton = form.querySelector('button[type="submit"]');
        const original = submitButton.innerHTML;

        submitButton.innerHTML = "Saved!";
        submitButton.classList.add('bg-indigo-500');

        setTimeout(() => {
            submitButton.innerHTML = original;
            submitButton.classList.remove('bg-indigo-500');
        }, 1500);
    });

});
</script>
 <!-- this code is only left image sku and items are work latest keep -->


</body>
</html>