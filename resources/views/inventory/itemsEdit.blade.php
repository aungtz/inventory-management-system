{{-- resources/views/items/create.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Item Registration</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    @keyframes slideInDown {
      from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .modal-overlay { 
      display: none; 
      animation: fadeIn 0.3s ease-out;
    }
    
    .modal-overlay.active { 
      display: flex; 
    }

    .modal-content {
      max-width: 1100px;
      width: 95%;
      animation: slideInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      transform-origin: top center;
    }

    .card-hover {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .input-focus {
      transition: all 0.2s ease-in-out;
    }

    .input-focus:focus {
      transform: translateY(-1px);
      box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1), 0 4px 6px -2px rgba(99, 102, 241, 0.05);
    }

    .image-preview {
      transition: all 0.3s ease-in-out;
    }

    .image-preview:hover {
      transform: scale(1.02);
    }

    .sku-row {
      transition: all 0.2s ease-in-out;
    }

    .sku-row:hover {
      background-color: rgba(249, 250, 251, 0.8);
      transform: translateX(4px);
    }

    .btn-primary {
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
      background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
    }

    .btn-success {
      background: linear-gradient(135deg, #059669 0%, #10b981 100%);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
      background: linear-gradient(135deg, #047857 0%, #0d9468 100%);
    }

    .pricing-card {
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      border: 1px solid rgba(226, 232, 240, 0.8);
      transition: all 0.3s ease-in-out;
    }

    .pricing-card:hover {
      background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
      border-color: rgba(99, 102, 241, 0.3);
    }

    .image-upload-box {
      border: 2px dashed #d1d5db;
      transition: all 0.3s ease-in-out;
    }

    .image-upload-box:hover {
      border-color: #4f46e5;
      background-color: rgba(79, 70, 229, 0.05);
    }

    .image-upload-box.dragover {
      border-color: #4f46e5;
      background-color: rgba(79, 70, 229, 0.1);
      transform: scale(1.05);
    }

    .fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }

    .slide-in-up {
      animation: slideInUp 0.4s ease-out;
    }

    .pulse-gentle {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .backdrop-blur {
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    /* Hide scrollbar for all elements */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
     .input-error-tooltip {
    position: absolute;
    background: #dc2626;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    top: -28px;            /* SHOW ABOVE INPUT */
    left: 0;
    z-index: 50;
    animation: fadeIn 0.2s ease-in-out;
    white-space: nowrap;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-3px); }
    to   { opacity: 1; transform: translateY(0); }
}
.input-wrapper {
    position: relative;   /* IMPORTANT so tooltip positions correctly */
}

  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 text-gray-800">
 @include('layout.sidebar')
 
<div class="max-w-6xl mx-auto p-6 animate__animated animate__fadeIn">
  
    <!-- Header with smooth entrance -->
    <div class="flex justify-between items-center mb-8 slide-in-up">
      <div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
          Item Registration
        </h1>
        <p class="text-gray-600 mt-2">Create new product with detailed specifications</p>
      </div>
      <a href="{{ route('items.index') }}" 
         class="btn-primary px-6 py-3 rounded-xl text-white font-medium flex items-center gap-2 shadow-lg hover:shadow-xl transition-all duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        View Item List
      </a>
    </div>

    <!-- Main Form Container -->
    <div class="bg-white/80 backdrop-blur rounded-2xl shadow-xl p-8 transition-all duration-500 border border-gray-200/80 card-hover">
      <form id="itemForm" 
        action="{{ route('items.update', $item->Item_Code) }}"
            method="POST" 
            enctype="multipart/form-data" 
      class="space-y-8">
    @csrf
    @method('PUT')        @csrf

        <!-- Basic Information Section -->
        <div class="fade-in">
          <div class="flex gap-6">
            <!-- Left Column -->
            <div class="w-[600px]">
              <!-- Top Row Grid -->
              <div class="grid grid-cols-3 gap-4 mb-4">
                <!-- Item Code -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                  <label class="block font-semibold mb-2 text-gray-700">Item Code <span class="text-red-500">*</span></label>
                  <input type="text" name="Item_Code" required   id="Item_Code"    value="{{ $item->Item_Code }}" readonly 

                         class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                   <!-- <p class="item-code-error text-red-500 text-sm mt-1 hidden"></p> -->

                        </div>

                <!-- JAN Code -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                  <label class="block font-semibold mb-2 text-gray-700">JAN Code <span class="text-red-500">*</span></label>
                  <input type="text" name="JanCD" maxlength="13" required        value="{{ $item->JanCD }}"

                         class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                </div>

                <!-- Maker Name -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                  <label class="block font-semibold mb-2 text-gray-700">Maker Name <span class="text-red-500">*</span></label>
                  <input type="text" name="MakerName" required value="{{ $item->MakerName }}"
                         class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                </div>
              </div>

              <!-- Item Name -->
              <div class="transform transition-all duration-300 hover:scale-[1.02]">
                <label class="block font-semibold mb-2 text-gray-700">Item Name <span class="text-red-500">*</span></label>
                <textarea name="Item_Name" rows="2" required value=""
                    class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 resize-none">
                    {{ $item->Item_Name }}</textarea>
              </div>
            </div>
            <!-- Memo Right Column -->
            <div class="flex-1 transform transition-all duration-300 hover:scale-[1.01]">
              <label class="block font-semibold mb-2 text-gray-700">Memo</label>
              <textarea name="Memo" rows="10"
                      class="input-focus w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 resize-y">{{ $item->Memo }}</textarea>
            </div>
          </div>
        </div>

        <!-- Pricing Information -->
        <div class="fade-in">
          <div class="pricing-card p-6 rounded-2xl border border-gray-200/80 transition-all duration-300">
            <h3 class="text-xl font-bold mb-6 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
              Pricing Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="transform transition-all duration-300 hover:scale-[1.02]">
                <label class="block font-semibold mb-2 text-gray-700">Basic Price <span class="text-red-500">*</span></label>
                <div class="flex items-center">
                  <input type="text" name="BasicPrice" required placeholder="0" value="{{ $item->BasicPrice }}"
                         class="price-input input-focus flex-1 p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" />
                  <span class="ml-3 text-gray-600 font-medium">円</span>
                </div>
              </div>

              <div class="transform transition-all duration-300 hover:scale-[1.02]">
                <label class="block font-semibold mb-2 text-gray-700">List Price <span class="text-red-500">*</span></label>
                <div class="flex items-center">
                  <input type="text" name="ListPrice" required placeholder="0" value="{{ $item->ListPrice }}"
                         class="price-input input-focus flex-1 p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" />
                  <span class="ml-3 text-gray-600 font-medium">円</span>
                </div>
              </div>

              <div class="transform transition-all duration-300 hover:scale-[1.02]">
                <label class="block font-semibold mb-2 text-gray-700">Cost Price <span class="text-red-500">*</span></label>
                <div class="flex items-center">
                  <input type="text" name="CostPrice" required placeholder="0" value="{{ $item->CostPrice }}"
                         class="price-input input-focus flex-1 p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" />
                  <span class="ml-3 text-gray-600 font-medium">円</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SKU Section -->
        <div class="fade-in">
          <div class="border-t border-gray-200 pt-8">
            <div class="flex justify-between items-center mb-6">
              <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                  SKU List
                </h2>
                <p class="text-gray-600 text-sm mt-1">Manage product variants and inventory</p>
              </div>

              <button type="button" id="openSkuModal" 
                      class="btn-primary px-6 py-3 rounded-xl text-white font-medium flex items-center gap-2 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add SKU
              </button>
            </div>

            <div class="overflow-x-auto no-scrollbar rounded-2xl border border-gray-200 shadow-sm">
              <table class="min-w-full border-collapse">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                  <tr>
                    <th class="p-4 border-b font-semibold text-left">Color</th>
                    <th class="p-4 border-b font-semibold text-left">Size</th>
                    <th class="p-4 border-b font-semibold text-left">Qty</th>
                  </tr>
                </thead>

            <tbody id="skuTableBody">
    @if ($item->skus->isEmpty())
        {{-- Empty State --}}
        <tr id="emptySkuState" class="pulse-gentle">
            <td colspan="3" class="p-8 text-center text-gray-500 bg-gray-50/50">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <span class="text-lg">No SKUs added yet</span>
                    <p class="text-sm text-gray-400 mt-1">Click "Add SKU" to create variants</p>
                </div>
            </td>
        </tr>
    @else
        {{-- SKU List --}}
        @foreach ($item->skus as $sku)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4">{{ $sku->Color_Name }}</td>
                <td class="p-4">{{ $sku->Size_Name }}</td>
                <td class="p-4">{{ $sku->Quantity }}</td>
            </tr>
        @endforeach
    @endif
</tbody>


              </table>
            </div>
          </div>
        </div>

        <!-- Product Images -->
        <div class="fade-in">
          <div class="border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
              Product Images
            </h2>

            <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @for($i = 0; $i < 5; $i++)
                  <div class="group space-y-3 p-4 bg-gray-50/50 rounded-xl border-2 border-dashed border-gray-300 image-upload-box transition-all duration-300">
                    <!-- Preview -->
                    <div id="imagePreview{{ $i }}" 
                         class="image-preview w-full aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center overflow-hidden shadow-inner">
                      <div class="text-center">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-400 text-xs">No Image</span>
                      </div>
                    </div>

                    <!-- Name Input -->
                    <input id="imageName{{ $i }}" name="image_names[]" type="text" placeholder="Image name" 
                           class="w-full p-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" disabled>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                      <label class="flex-1">
                        <button id="imageBtn{{ $i }}" type="button" 
                                class="btn-primary w-full px-3 py-2 text-sm text-white rounded-lg transition-all duration-300">
                          Upload
                        </button>
                        <input id="imageInput{{ $i }}" name="images[]" type="file" accept="image/*" class="hidden">
                      </label>

                      <button id="imageRemove{{ $i }}" type="button" 
                              class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300 transform hover:scale-105" 
                              title="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </div>
                  </div>
                @endfor
              </div>

              <input type="hidden" name="images_meta" id="imagesMeta" value="">
            </div>
          </div>
        </div>

        <!-- Hidden SKU Data -->
        <input type="hidden" name="skus_json" id="skus_json" >
        <input type="hidden" name="image_existing[{{ $i }}]" id="imageExisting{{ $i }}">
        <input type="hidden" name="image_delete[{{ $i }}]" id="imageDelete{{ $i }}">
        <input type="hidden" name="image_newname[{{ $i }}]" id="imageNewName{{ $i }}">

        <!-- Submit Buttons -->
        <div class="flex justify-end mt-8 space-x-4 pt-6 border-t border-gray-200 slide-in-up">
          <a href="{{ route('items.index') }}" 
             class="px-8 py-3 rounded-xl font-medium transition-all duration-300 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105">
            Cancel
          </a>
          <button type="submit" 
                  class="btn-success px-8 py-3 rounded-xl text-white font-medium flex items-center gap-2 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Update Item
          </button>
        </div>
        @for($i = 0; $i < 5; $i++)
    <input type="hidden" name="imageNames[]" id="hiddenImageName{{ $i }}">
    <input type="hidden" name="imageStates[]" id="hiddenImageState{{ $i }}">
@endfor

      </form>
    </div>
  </div>

  <!-- Enhanced SKU Modal -->
  <div id="skuModal" class="modal-overlay fixed inset-0 z-50 items-start justify-center pt-20 bg-black/40 backdrop-blur">
    <div class="modal-content bg-white rounded-3xl shadow-2xl p-8 border border-gray-200/80 mx-4 max-h-[85vh] overflow-hidden flex flex-col">
      <!-- Modal Header -->
      <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200">
        <div>
          <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            SKU Management
          </h2>
          <p class="text-gray-600 mt-2">Add and manage product variants</p>
        </div>
        <button id="closeSkuModal" class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-110">
          <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Modal Content -->
      <div class="flex-1 no-scrollbar">
        <table class="w-full border text-sm rounded-xl overflow-hidden">
          <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white sticky top-0">
            <tr>
              <th class="p-4 border-r border-white/20 font-semibold">Delete</th>
              <th class="p-4 border-r border-white/20 font-semibold">
                Size Name<br><small class="font-normal opacity-90">(Horizontal axis)</small>
              </th>
              <th class="p-4 border-r border-white/20 font-semibold">
                Color Name<br><small class="font-normal opacity-90">(Vertical axis)</small>
              </th>
              <th class="p-4 border-r border-white/20 font-semibold">Size Code</th>
              <th class="p-4 border-r border-white/20 font-semibold">Color Code</th>
              <th class="p-4 border-r border-white/20 font-semibold">JAN Code</th>
              <th class="p-4 border-r border-white/20 font-semibold **w-40**">Qty-flag</th>
              <th class="p-4 font-semibold">Number in Stock</th>
            </tr>
          </thead>
          <tbody id="skuModalBody" class="bg-white">
            <!-- JS will inject rows here -->
          </tbody>
        </table>
      </div>

      <!-- Modal Footer -->
      <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
        <button id="addSkuRowBtn" type="button" 
                class="bg-indigo-100 text-indigo-800 px-6 py-3 rounded-xl font-medium hover:bg-indigo-200 transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add Row
        </button>

        <div class="flex items-center gap-3">
          <button type="button" id="closeModalBtn" 
                  class="px-8 py-3 rounded-xl font-medium transition-all duration-300 bg-gray-500 text-white hover:bg-gray-600 transform hover:scale-105">
            Close
          </button>
          <button type="button" id="saveSkusBtn" 
                  class="btn-success px-8 py-3 rounded-xl text-white font-medium flex items-center gap-2 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Save SKUs
          </button>
        </div>
      </div>
    </div>
  </div>
@php
$existingImages = $item->images->map(function($img) {
    return [
        'filename' => $img->Image_Name,
        'url' => asset('storage/items/' . $img->Image_Name),
    ];
});
@endphp
<!-- <script src="{{ asset('js/validation/item-validation.js') }}"></script> -->
      <script src="{{ asset('js/validation/item-validation.js') }}"></script>
<script>
      const existingSkus = @json($item->skus);
      const existingImages = @json($existingImages);


  // State
  const state = {
    productImages: [null, null, null, null, null],
    skus: []
  };

  document.addEventListener('DOMContentLoaded', () => {
    
    setupSkuModal();
  });


function setupImageSlot(i) {
    const input = document.getElementById(`imageInput${i}`);
    const preview = document.getElementById(`imagePreview${i}`);
    const nameInput = document.getElementById(`imageName${i}`);
    const btn = document.getElementById(`imageBtn${i}`);
    const removeBtn = document.getElementById(`imageRemove${i}`);

    btn.addEventListener('click', () => input.click());

    removeBtn.addEventListener('click', () => {
      input.value = "";               // reset file input
      state.productImages[i] = null;  // clear state
      preview.innerHTML = '<div class="text-center">No Image</div>';
      nameInput.value = "";
      nameInput.disabled = true;
      btn.textContent = "Upload";

        state.productImages[i] = null;
        preview.innerHTML = '<div class="text-center">No Image</div>';
        nameInput.value = '';
        nameInput.disabled = true;
        btn.textContent = 'Upload';
        
    });

    nameInput.addEventListener('input', () => {
        if (!state.productImages[i]) state.productImages[i] = { file: null, name: '' };
        state.productImages[i].name = nameInput.value;
    });

    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) { // max 2MB
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(ev) {
            preview.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover rounded-xl" alt="Preview">`;
        };
        reader.readAsDataURL(file);

        nameInput.disabled = false;
        if (!nameInput.value) nameInput.value = file.name;

        btn.textContent = 'Edit';
        state.productImages[i] = {
            file: file,
            name: nameInput.value || file.name,
            url: null
        };
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const itemCodeInput = document.getElementById("Item_Code");
    const itemId = "{{ $item->id ?? '' }}"; // empty for create

    itemCodeInput.addEventListener("input", function () {
        const itemCode = itemCodeInput.value.trim();

        if (itemCode === "") return;

        fetch(`/check-itemcode?item_code=${itemCode}&id=${itemId}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    showAlert("Item Code already exists!");
                    itemCodeInput.classList.add("is-invalid");
                } else {
                    itemCodeInput.classList.remove("is-invalid");
                }
            });
    });
});
function loadExistingImages() {
    if (!existingImages || existingImages.length === 0) return;

    existingImages.forEach((img, index) => {
        if (index >= 5) return;

        const preview = document.getElementById(`imagePreview${index}`);
        const nameInput = document.getElementById(`imageName${index}`);
        const btn = document.getElementById(`imageBtn${index}`);

        preview.innerHTML = `
            <img src="${img.url}" class="w-full h-full object-cover rounded-xl">
        `;

        nameInput.disabled = false;
        nameInput.value = img.filename;
        btn.textContent = "Edit";

        state.productImages[index] = {
            file: null,
            name: img.filename,
            url: img.url
        };
    });
}


window.addEventListener("DOMContentLoaded", () => {
    loadExistingImages();

    for (let i = 0; i < 5; i++) {
        setupImageSlot(i);
    }
});


  function setupSkuModal() {
    const skuModal = document.getElementById('skuModal');
    const openSku = document.getElementById('openSkuModal');
    const closeSku = document.getElementById('closeSkuModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const saveSkusBtn = document.getElementById('saveSkusBtn');
    const addSkuRowBtn = document.getElementById('addSkuRowBtn');
    const skuModalBody = document.getElementById('skuModalBody');

        loadExistingSkusIntoModal();

    openSku.addEventListener('click', () => {
      populateModalWithExistingSkus();
      skuModal.classList.add('active');
    });

    closeSku.addEventListener('click', () => skuModal.classList.remove('active'));
    closeModalBtn.addEventListener('click', () => skuModal.classList.remove('active'));
    addSkuRowBtn.addEventListener('click', () => addSkuRow());

  saveSkusBtn.addEventListener('click', () => {
  const newSkus = [];
  let duplicateFound = false;

  skuModalBody.querySelectorAll('tr').forEach(row => {
    const sizeName = row.querySelector('.size-name')?.value.trim() || '';
    const colorName = row.querySelector('.color-name')?.value.trim() || '';
    const sizeCode = row.querySelector('.size-code')?.value.trim() || '';
    const colorCode = row.querySelector('.color-code')?.value.trim() || '';
    const janCode = row.querySelector('.jan-code')?.value.trim() || '';
    const qtyFlag = row.querySelector('.qty-flag')?.value || 'false';
    const stockQuantity = row.querySelector('.stock-quantity')?.value || '0';

    // Skip empty rows
    if (!sizeName && !colorName && !sizeCode && !colorCode && !janCode) return;

    // Build a unique key for validation
const keyName = `${sizeName}__${colorName}`;
    const keyCode = `${sizeCode}__${colorCode}`;

    // Check for duplicates in current collection
    if (newSkus.some(s => s.keyName === keyName || s.keyCode === keyCode)) {
        duplicateFound = true;
    } else {
        newSkus.push({
            keyName,
            keyCode,
            sizeName,
            colorName,
            sizeCode,
            colorCode,
            janCode,
            qtyFlag,
            stockQuantity: parseInt(stockQuantity) || 0
        });
    }
});

if (duplicateFound) {
    alert("Duplicate SKUs found! Size+Color or Code+Code must be unique.");
    return;
}

  // Save cleaned SKUs to state
  state.skus = newSkus.map(({ _key, ...sku }) => sku);
  document.getElementById('skus_json').value = JSON.stringify(state.skus);

  renderSkuTable();
  skuModal.classList.remove('active');
});


 function populateModalWithExistingSkus() {
    const skuModalBody = document.getElementById('skuModalBody');
    skuModalBody.innerHTML = '';

    state.skus.forEach(sku => addSkuRow(sku));
    if (state.skus.length === 0) addSkuRow();
}


function formatPriceInput(input) {
    let value = input.value.replace(/,/g, '');        // remove commas
    value = value.replace(/\D/g, '');                // remove non-digits

    if (value === '') {
        input.value = '';
        return;
    }

    input.value = Number(value).toLocaleString('ja-JP'); // add commas
}

// --- Remove commas before submit ---
function unformatPrice(value) {
    return value.replace(/,/g, '');
}

// Apply to all 3 price fields
document.querySelectorAll('.price-input').forEach(input => {
    input.addEventListener('input', () => formatPriceInput(input));
    input.addEventListener('blur', () => formatPriceInput(input));
});

  document.getElementById('itemForm').addEventListener('submit', function() {
    document.getElementById('skus_json').value = JSON.stringify(state.skus);

    const priceFields = document.querySelectorAll('.price-input');
    priceFields.forEach(f => {
        f.value = unformatPrice(f.value); 
    });

    for (let i = 0; i < 5; i++) {
    let img = state.productImages[i];
    let nameInput = document.getElementById(`hiddenImageName${i}`);
    let stateInput = document.getElementById(`hiddenImageState${i}`);

    if (!img) {
        nameInput.value = "";
        stateInput.value = "delete"; // means backend should delete this slot
    }
    else if (img.file) {
        nameInput.value = img.name;  
        stateInput.value = "new"; // backend should create/update with file
    }
    else if (img.url) {
        nameInput.value = img.name;
        stateInput.value = "existing"; // keep old image
    }
}

});

 function addSkuRow(skuData = {}) {
    const rowId = Date.now(); // unique row ID
    const row = document.createElement('tr');
    const isQtyFlagTrue = skuData.qtyFlag === true || skuData.Quantity > 0;
    row.className = 'sku-row border-b border-gray-200 hover:bg-gray-50/50 transition-all duration-200';
    row.innerHTML = `
        <td class="p-3 border-r">
            <button type="button" class="delete-row-btn text-red-500 hover:text-red-700 transition-colors p-1 rounded hover:bg-red-50" data-row-id="${rowId}">
                <!-- SVG delete icon -->
            </button>
        </td>
        <td class="p-3 border-r">
            <input type="text" class="size-name w-full p-2 border rounded-lg" value="${skuData.sizeName || ''}" placeholder="Enter size name" name="skus[size_name][]">
        </td>
        <td class="p-3 border-r">
            <input type="text" class="color-name w-full p-2 border rounded-lg" value="${skuData.colorName || ''}" placeholder="Enter color name" name="skus[color_name][]">
        </td>
        <td class="p-3 border-r">
            <input type="text" class="size-code w-full p-2 border rounded-lg" value="${skuData.sizeCode || ''}" placeholder="Size code"  name="skus[color_code][]">
        </td>
        <td class="p-3 border-r">
            <input type="text" class="color-code w-full p-2 border rounded-lg" value="${skuData.colorCode || ''}" placeholder="Color code"  name="skus[jan][]">
        </td>
        <td class="p-3 border-r">
            <input type="text" class="jan-code w-full p-2 border rounded-lg" value="${skuData.janCode || ''}" placeholder="JAN code" name="skus[stock][]">
        </td>
        <td class="p-3 border-r" **w-48**">
        <select class="qty-flag **w-full** p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                <option value="true" ${isQtyFlagTrue  ? 'selected' : ''}>Yes</option>
                <option value="false" ${!isQtyFlagTrue ? 'selected' : ''}>No</option>
            </select>
        </td>
        <td class="p-3">
            <input type="number" class="stock-quantity text-right w-full p-2 border rounded-lg" value="${skuData.Quantity || 0}" min="0">
        </td>
    `;
    skuModalBody.appendChild(row);

    // delete button
    row.querySelector('.delete-row-btn').addEventListener('click', () => row.remove());
}
document.querySelectorAll('.image-name').forEach(input => {
    input.addEventListener('blur', () => {
        let name = input.value.trim();

        if (!name) return;

        if (!/\.(jpg|jpeg|png|gif|svg)$/i.test(name)) {
            input.value = name + ".jpg";
        }
    });
});


function loadExistingSkusIntoModal() {
    const skuModalBody = document.getElementById("skuModalBody");
    skuModalBody.innerHTML = "";

    if (!existingSkus || existingSkus.length === 0) return;

    // Update GLOBAL state
    state.skus = existingSkus.map(s => ({
        sizeName: s.Size_Name,
        colorName: s.Color_Name,
        sizeCode: s.Size_Code,
        colorCode: s.Color_Code,
        janCode: s.JanCode,
        stockQuantity: s.Quantity
    }));
}

}

  function renderSkuTable() {
    const skuTableBody = document.getElementById('skuTableBody');
    const emptyState = document.getElementById('emptySkuState');

    const existingRows = skuTableBody.querySelectorAll('tr:not(#emptySkuState)');
    existingRows.forEach(row => row.remove());
    
    if (state.skus.length === 0) {
      if (!emptyState) {
        const newEmptyState = document.createElement('tr');
        newEmptyState.id = 'emptySkuState';
        newEmptyState.className = 'pulse-gentle';
        newEmptyState.innerHTML = `
          <td colspan="3" class="p-8 text-center text-gray-500 bg-gray-50/50">
            <div class="flex flex-col items-center justify-center">
              <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
              </svg>
              <span class="text-lg">No SKUs added yet</span>
              <p class="text-sm text-gray-400 mt-1">Click "Add SKU" to create variants</p>
            </div>
          </td>
        `;
        skuTableBody.appendChild(newEmptyState);
      } else {
        emptyState.style.display = '';
      }
    } else {
      if (emptyState) emptyState.style.display = 'none';
      state.skus.forEach((sku, index) => {
        const row = document.createElement('tr');
        row.className = 'border-b border-gray-200 hover:bg-gray-50/50 transition-all duration-200';
        row.innerHTML = `
          <td class="p-4 border-r">${escapeHtml(sku.colorName || '-')}</td>
          <td class="p-4 border-r">${escapeHtml(sku.sizeName  || '-')}</td>
          <td class="p-4 border-r">${escapeHtml(sku.stockQuantity  || '0')}</td>
        `;
        skuTableBody.appendChild(row);
      });
    }
  }

  function escapeHtml(text) {
    if (!text && text !== 0) return '';
    return String(text).replace(/[&<>"'\/]/g, function (s) {
      const entityMap = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '/': '&#x2F;' };
      return entityMap[s];
    });
  }

// document.getElementById('itemForm').addEventListener('submit', async function(e) {
//     e.preventDefault(); // stop normal submit

//     const itemCode = document.querySelector('input[name="Item_Code"]').value.trim();

//     // Check duplicate item code first
//     const response = await fetch(`/check-item-code?code=${itemCode}`);
//     const data = await response.json();


//     // No duplicate → submit form normally
//     this.submit();
// });

</script>
</body>
</html>
