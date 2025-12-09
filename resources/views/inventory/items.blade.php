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

    /* .sku-row:hover {
      background-color: rgba(249, 250, 251, 0.8);
      transform: translateX(4px);
    } */

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

/* Error text below input */
.error-text {
    color: #dc2626; /* red-600 */
    font-size: 0.875rem; /* 14px */
    margin-top: 0.25rem; /* 4px spacing below input */
    font-weight: 500;
    line-height: 1.2;
    display: block;
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

/* When showing error */
.error-text:not(.hidden) {
    opacity: 1;
}

/* Warning icon inside input */
.error-icon {
    position: absolute;
    right: 0.75rem; /* 12px from right */
    top: 50%;
    transform: translateY(-50%);
    font-size: 1rem; /* 16px */
    color: #dc2626; /* red-600 */
    pointer-events: none; /* icon is not clickable */
}

/* Input border colors */
input.border-red-500 {
    border-color: #dc2626 !important;
}

input.border-green-500 {
    border-color: #16a34a !important; /* green-600 */
}




  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 text-gray-800">

  @include('layout.sidebar')

<!-- main contents -->
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
      <form id="itemForm" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Basic Information Section -->
        <div class="fade-in">
          <div class="flex gap-6">
            <!-- Left Column -->
            <div class="w-[600px]">
              <!-- Top Row Grid -->
              <div class="grid grid-cols-3 gap-4 mb-4">
                <!-- Item Code -->
               <div class="transform transition-all duration-300 hover:scale-[1.02]">
            <label class="block font-semibold mb-2 text-gray-700 text-sm">Item Code <span class="text-red-500">*</span></label>
           <div class="input-wrap">
            <input type="text" name="Item_Code" id="Item_Code" required
                  class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-sm">
             <p class="error-text hidden"></p>
</div>
              </div>

                <!-- JAN Code -->
               <div class="transform transition-all duration-300 hover:scale-[1.02]">
  <label class="block font-semibold mb-2 text-gray-700 text-sm">JAN Code <span class="text-red-500">*</span></label>
  <div class="input-wrap">
  <input type="text" name="JanCD" maxlength="13" required
      id="janInput"   class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-sm">
          <p class="error-text hidden" id="janError"></p>
</div>
        </div>

      <!-- Maker Name -->
      <div class="transform transition-all duration-300 hover:scale-[1.02]">
        <label class="block font-semibold mb-2 text-gray-700 text-sm">Maker Name <span class="text-red-500">*</span></label>
         <div class="input-wrap">

        <input type="text" name="MakerName" required
              class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-sm">
                <p class="error-text hidden"></p>
            </div>
            </div>
      </div>

      <!-- Item Name -->
      <div class="transform transition-all duration-300 hover:scale-[1.02]">
        <label class="block font-semibold mb-2 text-gray-700 text-sm">Item Name <span class="text-red-500">*</span></label>
                 <div class="input-wrap">

        <textarea name="Item_Name" rows="2" required
            class="input-focus w-full p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 resize-none text-sm"></textarea>
                <p class="error-text hidden"></p>
            </div>
          </div>
      </div>


            <!-- Memo Right Column -->
            <div class="flex-1 transform transition-all duration-300 hover:scale-[1.01]">
              <label class="block font-semibold mb-2 text-gray-700">Memo</label>
                <div class="input-wrap">
              <textarea name="Memo" rows="10"
                      class="input-focus w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 resize-y"></textarea>
                        <p class="error-text hidden"></p>
            </div>
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
        <label class="block font-semibold mb-2 text-gray-700 text-sm">Basic Price <span class="text-red-500">*</span></label>
        <div class="flex items-center input-wrap">
            <div class="input-wrap">
          <input type="text" name="BasicPrice" required placeholder="0" 
                 class="price-input input-focus flex-1 p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-sm" />
          <p class="error-text hidden"></p>
          
        </div>
                 <!-- <span class="ml-3 text-gray-600 font-medium text-sm">円</span> -->
          
          </div>
      </div>

               <div class="transform transition-all duration-300 hover:scale-[1.02]">
        <label class="block font-semibold mb-2 text-gray-700 text-sm">List Price <span class="text-red-500">*</span></label>
        <div class="flex items-center">
          <div class="input-wrap">
          <input type="text" name="ListPrice" required placeholder="0" 
                 class="price-input input-focus flex-1 p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-sm" />
          <p class="error-text hidden"></p>
            </div>
                 <!-- <span class="ml-3 text-gray-600 font-medium text-sm">円</span> -->
        </div>
      </div>


             <div class="transform transition-all duration-300 hover:scale-[1.02]">
        <label class="block font-semibold mb-2 text-gray-700 text-sm">Cost Price <span class="text-red-500">*</span></label>
        <div class="flex items-center">
          <div class="input-wrap">
          <input type="text" name="CostPrice" required placeholder="0" 
                 class="price-input input-focus flex-1 p-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-sm" />
         <p class="error-text hidden"></p>
            </div>
                 <!-- <span class="ml-3 text-gray-600 font-medium text-sm">円</span> -->
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
                  <tr id="emptySkuState" class="pulse-gentle">
                    <td colspan="3" class="p-8 text-center text-gray-500 bg-gray-50/50">
                      <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <span class="text-lg">No SKUs added yet</span>
                        <p class="text-sm text-gray-400 mt-1">Click "Add SKU" to create variants</p>
                      </div>
                    </td>
                  </tr>
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

        <!-- Submit Buttons -->
        <div class="flex justify-end mt-8 space-x-4 pt-6 border-t border-gray-200 slide-in-up">
          <a href="{{ route('items.index') }}" 
             class="px-8 py-3 rounded-xl font-medium transition-all duration-300 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105">
            Cancel
          </a>
          <button type="submit"   id="submitButton"
                  class="btn-success px-8 py-3 rounded-xl text-white font-medium flex items-center gap-2 transition-all duration-300 submitBtn">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
             <span>Fix Errors to Save</span>
          
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Enhanced SKU Modal -->
  <div id="skuModal" class="modal-overlay fixed inset-0 z-50 items-start justify-center pt-20 bg-black/40 backdrop-blur">
    <div class="modal-content bg-white rounded-3xl shadow-2xl p-8 border border-gray-200/80 mx-4 max-h-[85vh] overflow-hidden flex flex-col max-w-7xl">
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


  {{-- JavaScript: image handling + SKU modal + form submit --}}
   <script src="{{ asset('js/validation/item-validation.js') }}?v={{ time() }}"></script>

<script>
  // State
  const state = {
    productImages: [null, null, null, null, null],
    skus: []
  };

  document.addEventListener('DOMContentLoaded', () => {
    for (let i = 0; i < 5; i++) {
      setupImageSlot(i);
    }
    setupSkuModal();
  });


// function setupImageSlot(i) {
//     const input = document.getElementById(`imageInput${i}`);
//     const preview = document.getElementById(`imagePreview${i}`);
//     const nameInput = document.getElementById(`imageName${i}`);
//     const btn = document.getElementById(`imageBtn${i}`);
//     const removeBtn = document.getElementById(`imageRemove${i}`);

//     btn.addEventListener('click', () => input.click());

//     removeBtn.addEventListener('click', () => {
//       input.value = "";               // reset file input
//       state.productImages[i] = null;  // clear state
//       preview.innerHTML = '<div class="text-center">No Image</div>';
//       nameInput.value = "";
//       nameInput.disabled = true;
//       btn.textContent = "Upload";

//         state.productImages[i] = null;
//         preview.innerHTML = '<div class="text-center">No Image</div>';
//         nameInput.value = '';
//         nameInput.disabled = true;
//         btn.textContent = 'Upload';
        
//     });

//     nameInput.addEventListener('input', () => {
//         if (!state.productImages[i]) state.productImages[i] = { file: null, name: '' };
//         state.productImages[i].name = nameInput.value;
//     });

//     input.addEventListener('change', (e) => {
//         const file = e.target.files[0];
//         if (!file) return;

//         if (file.size > 2 * 1024 * 1024) { // max 2MB
//             alert('File size must be less than 2MB');
//             input.value = '';
//             return;
//         }

//         const reader = new FileReader();
//         reader.onload = function(ev) {
//             preview.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover rounded-xl" alt="Preview">`;
//         };
//         reader.readAsDataURL(file);

//         nameInput.disabled = false;
//         if (!nameInput.value) nameInput.value = file.name;

//         btn.textContent = 'Edit';
//         state.productImages[i] = {
//             file: file,
//             name: nameInput.value || file.name,
//             url: null
//         };
//     });
// }

// --- helpers (keep these above) ---
window.state = window.state || {};
window.state.productImages = window.state.productImages || [];

function padSerial(n, width = 3) {
  return String(n).padStart(width, '0');
}

function slugifyForFilename(text) {
  if (!text) return 'image';
  return String(text)
    .trim()
    .replace(/\s+/g, '-')           // spaces -> hyphen
    .replace(/[^a-zA-Z0-9\-_]/g, '')// remove odd chars
    .toLowerCase();
}

// --- Replace setupImageSlot with this version ---
function setupImageSlot(i, options = {}) {
  const input = document.getElementById(`imageInput${i}`);
  const preview = document.getElementById(`imagePreview${i}`);
  const nameInput = document.getElementById(`imageName${i}`);
  const btn = document.getElementById(`imageBtn${i}`);
  const removeBtn = document.getElementById(`imageRemove${i}`);

  const itemCodeSelector = options.itemCodeSelector || '#Item_Code';
  const itemNameSelector = options.itemNameSelector || '#Item_Name';
  const padWidth = options.padWidth || 3;
  const forceAutoName = options.forceAutoName ?? false;

  if (!input || !preview || !nameInput || !btn || !removeBtn) {
    console.warn('setupImageSlot: missing DOM elements for slot', i);
    return;
  }

  if (!window.state.productImages[i]) window.state.productImages[i] = null;

  btn.addEventListener('click', () => input.click());

  removeBtn.addEventListener('click', () => {
    input.value = "";
    window.state.productImages[i] = null;
    preview.innerHTML = '<div class="text-center">No Image</div>';
    nameInput.value = "";
    nameInput.disabled = !!forceAutoName;
    btn.textContent = "Upload";
    console.log('slot', i, 'removed, state now:', window.state.productImages);
  });

  nameInput.addEventListener('input', () => {
    if (!window.state.productImages[i]) window.state.productImages[i] = { file: null, name: '' };
    window.state.productImages[i].name = nameInput.value;
  });

  input.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
      alert('File size must be less than 2MB');
      input.value = '';
      return;
    }

    const reader = new FileReader();
    reader.onload = function(ev) {
      preview.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover rounded-xl" alt="Preview">`;
    };
    reader.readAsDataURL(file);

    // --- Build base from Item_Code (preferred) or Item_Name ---
    let base = '';
    const itemCodeEl = document.querySelector(itemCodeSelector);
    const itemNameEl = document.querySelector(itemNameSelector);
    if (itemCodeEl && itemCodeEl.value) base = itemCodeEl.value;
    else if (itemNameEl && itemNameEl.value) base = itemNameEl.value;
    else base = 'item';

    // Display base (keep casing) but sanitize for final name
    let displayBase = base.trim();
    if (!displayBase) displayBase = 'item';

    // slug for matching (lowercase, safe)
    const slugBase = slugifyForFilename(base);

    // --- Collect existing serial numbers ---
    const existingNumbers = new Set();

    // 1) scan current JS state
    window.state.productImages.forEach((slot, idx) => {
      if (!slot || !slot.name) return;
      const nm = slot.name.toString();
      const m = nm.match(new RegExp(`${slugBase}[-_]?([0-9]{1,})`, 'i'));
      if (m && m[1]) existingNumbers.add(parseInt(m[1], 10));
    });

    // 2) scan all name input DOM fields (helps when state isn't fully populated)
    document.querySelectorAll('input[name^="image_names"]').forEach((el) => {
      const nm = (el.value || '').toString();
      if (!nm) return;
      const m = nm.match(new RegExp(`${slugBase}[-_]?([0-9]{1,})`, 'i'));
      if (m && m[1]) existingNumbers.add(parseInt(m[1], 10));
    });

    // Debug: show what was found
    console.log('slot', i, 'base:', displayBase, 'slug:', slugBase, 'existing:', Array.from(existingNumbers));

    // Find smallest available serial
    let serial = 1;
    while (existingNumbers.has(serial)) serial++;

    // Determine extension from original file
    const extMatch = file.name.match(/(\.[^./\\]+)$/);
    const extension = extMatch ? extMatch[1].toLowerCase() : '';

    // Final name format: DisplayBase-001.ext  (hyphen between)
    // sanitize displayBase for final filename: remove unwanted chars but keep casing
    const displayBaseSanitized = displayBase
      .trim()
      .replace(/\s+/g, '-')            // spaces -> hyphen
      .replace(/[^A-Za-z0-9\-_]/g, ''); // remove other chars

    const finalFilename = `${displayBaseSanitized}-${padSerial(serial, padWidth)}${extension}`;

    // Apply
    nameInput.value = finalFilename;
    nameInput.disabled = !!forceAutoName;
    btn.textContent = 'Edit';

    window.state.productImages[i] = {
      file: file,
      name: finalFilename,
      url: null
    };

    console.log('slot', i, 'set name ->', finalFilename, 'state now:', window.state.productImages);
  });
}


 function setupSkuModal() {
    const skuModal = document.getElementById('skuModal');
    const openSku = document.getElementById('openSkuModal');
    const closeSku = document.getElementById('closeSkuModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const saveSkusBtn = document.getElementById('saveSkusBtn');
    const addSkuRowBtn = document.getElementById('addSkuRowBtn');
    const skuModalBody = document.getElementById('skuModalBody');

    openSku.addEventListener('click', () => {
        populateModalWithExistingSkus();
        skuModal.classList.add('active');
    });

    closeSku.addEventListener('click', () => skuModal.classList.remove('active'));
    closeModalBtn.addEventListener('click', () => skuModal.classList.remove('active'));
    addSkuRowBtn.addEventListener('click', () => addSkuRow());

    // SAVE BUTTON
    saveSkusBtn.addEventListener('click', () => {

        const newSkus = [];
        let duplicateFound = false;
        let janError = false;

        skuModalBody.querySelectorAll('tr').forEach(row => {

            const sizeName = row.querySelector('.size-name')?.value.trim() || '';
            const colorName = row.querySelector('.color-name')?.value.trim() || '';
            const sizeCode = row.querySelector('.size-code')?.value.trim() || '';
            const colorCode = row.querySelector('.color-code')?.value.trim() || '';
            const janCodeInput = row.querySelector('.jan-code');
            const janCode = janCodeInput?.value.trim() || '';
            const qtyFlag = row.querySelector('.qty-flag')?.value || 'false';
            const stockQuantity = row.querySelector('.stock-quantity')?.value || '0';

            // Skip empty entire row
            if (!sizeName && !colorName && !sizeCode && !colorCode && !janCode) return;

            // ❗ VALIDATE JAN HERE
            if (!validateSkuJan(janCodeInput)) {
                janError = true;
            }

            // Build keys
            const keyName = `${sizeName}__${colorName}`;
            const keyCode = `${sizeCode}__${colorCode}`;

            // Check duplicates
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

        // ❌ Stop saving if JAN invalid
        if (janError) {
            alert("Fix JAN Code before saving.");
            return;
        }

        // ❌ Stop saving if duplicates found
        if (duplicateFound) {
            alert("Duplicate SKUs found! Size+Color or Code+Code must be unique.");
            return;
        }

        // SAVE CLEAN SKUS
        state.skus = newSkus.map(({ _key, ...sku }) => sku);
        document.getElementById('skus_json').value = JSON.stringify(state.skus);

        renderSkuTable();
        skuModal.classList.remove('active');
    });
}



  function populateModalWithExistingSkus() {
    const skuModalBody = document.getElementById('skuModalBody');
    skuModalBody.innerHTML = '';

    state.skus.forEach(sku => {
      addSkuRow(sku);
    });

    if (state.skus.length === 0) {
      addSkuRow();
    }
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
});



  function addSkuRow(skuData = {}) {
    const skuModalBody = document.getElementById('skuModalBody');
    const rowId = Date.now() + Math.random();
    
    const row = document.createElement('tr');
  row.className = 'sku-row border-b border-gray-200';
row.innerHTML = `
  <td class="p-3 border-r">
    <button type="button" class="delete-row-btn text-red-500 p-1 rounded transition-none" data-row-id="${rowId}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
      </svg>
    </button>
  </td>
  <td class="p-3 border-r">
  <div class="input-wrap">
    <input type="text" class="size-name w-full p-2 border border-gray-300 rounded-lg transition-none" 
           value="${skuData.sizeName || ''}" placeholder="Enter size name">
           <p class="error-text hidden"></p>
            </div>
  </td>
  <td class="p-3 border-r">
  <div class="input-wrap">
    <input type="text" class="color-name w-full p-2 border border-gray-300 rounded-lg transition-none" 
           value="${skuData.colorName || ''}" placeholder="Enter color name">
           <p class="error-text hidden"></p>
            </div>
  </td>
  <td class="p-3 border-r">
  <div class="input-wrap">
    <input type="text" class="size-code w-full p-2 border border-gray-300 rounded-lg transition-none" 
           value="${skuData.sizeCode || ''}" placeholder="Size code">
           <p class="error-text hidden"></p>
            </div>
  </td>
  <td class="p-3 border-r">
  <div class="input-wrap">
    <input type="text" class="color-code w-full p-2 border border-gray-300 rounded-lg transition-none" 
           value="${skuData.colorCode || ''}" placeholder="Color code">
           <p class="error-text hidden"></p>
            </div>
  </td>
  <td class="p-3 border-r">
  <div class="input-wrap">
    <input type="text" class="jan-code w-full p-2 border border-gray-300 rounded-lg transition-none" 
           value="${skuData.janCode || ''}" placeholder="JAN code">
            <p class="error-text hidden"></p>
            </div>
  </td>
  <td class="p-3 border-r **w-48**">
  <div class="input-wrap">
        <select class="qty-flag **w-full** p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
      <option value="true" ${skuData.qtyFlag === 'true' ? 'selected' : ''}>Yes</option>
      <option value="false" ${skuData.qtyFlag === 'false' || !skuData.qtyFlag ? 'selected' : ''}>No</option>
    </select>
    <p class="error-text hidden"></p>
            </div>
  </td>
  <td class="p-3">
  <div class="input-wrap">
    <input type="number" class="stock-quantity text-right w-full p-2 border border-gray-300 rounded-lg transition-none" 
           value="${skuData.stockQuantity || '0'}" placeholder="0" min="0">
           <p class="error-text hidden"></p>
            </div>
  </td>
`;

    skuModalBody.appendChild(row);
    row.querySelector('.delete-row-btn').addEventListener('click', (e) => {
      e.preventDefault();
      row.remove();
    });
    attachSkuRowValidation(row);
    
    // checkSkuValidation();

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
        row.className = 'border-b border-gray-200 transition-all duration-200';
        row.innerHTML = `
          <td class="p-4 border-r">${escapeHtml(sku.colorName || '-')}</td>
          <td class="p-4 border-r">${escapeHtml(sku.sizeName || '-')}</td>
          <td class="p-4 border-r">${escapeHtml(sku.stockQuantity || '0')}</td>
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

document.getElementById('itemForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // stop normal submit

    const itemCode = document.querySelector('input[name="Item_Code"]').value.trim();

    // Check duplicate item code first
    const response = await fetch(`/check-item-code?code=${itemCode}`);
    const data = await response.json();

    if (data.exists) {
        alert("❌ Item Code already exists. Please use another one.");
        return;
    }

    // No duplicate → submit form normally
    this.submit();
});

</script>
<!-- <script src="{{ asset('js/validation/item-validation.js') }}"></script> -->

</body>
</html>
