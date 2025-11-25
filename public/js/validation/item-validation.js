// --------------------
// Common Validation UI
// --------------------
function showAlert(message) {
    let box = document.getElementById("alert-box");

    if (!box) {
        box = document.createElement("div");
        box.id = "alert-box";
        box.className = "fixed top-5 right-5 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50";
        document.body.appendChild(box);
    }

    box.textContent = message;
    box.style.display = "block";

    setTimeout(() => {
        box.style.display = "none";
    }, 1500);
}


function setValid(input) {
    input.classList.remove('border-red-500');
    input.classList.add('border-green-500');
}

function setInvalid(input) {
    input.classList.remove('border-green-500');
    input.classList.add('border-red-500');
}
function validateRequiredText(input, maxLength = 100) {
    const val = input.value.trim();
    input.value = val;

    if (!val) {
        setInvalid(input);
        showAlert("This field is required");
        return false;
    }

    if (val.length > maxLength) {
        input.value = val.substring(0, maxLength);
        setInvalid(input);
        showAlert(`Max ${maxLength} characters allowed`);
        return false;
    }

    setValid(input);
    return true;
}


function validateItemCode(input) {
    let cleaned = input.value.replace(/\s+/g, '');

    if (cleaned !== input.value) {
        input.value = cleaned;
        setInvalid(input);
        showAlert("Spaces are not allowed in Item Code");
        return false;
    }

    if (cleaned.length === 0) {
        setInvalid(input);
        showAlert("Item Code is required");
        return false;
    }

    setValid(input);
    return true;
}
function validateMemo(input) {
    let val = input.value.replace(/^\s+/g, '');
    input.value = val;

    if (val.length === 0) {
        setInvalid(input);
        showAlert("Memo cannot be empty");
        return false;
    }

    if (val.length > 200) {
        input.value = val.substring(0, 200);
        setInvalid(input);
        showAlert("Memo cannot exceed 200 characters");
        return false;
    }

    setValid(input);
    return true;
}
function validateJanCode(input) {
    let val = input.value.replace(/\D/g, '');

    // ❗ If first digit is 0 — block it
    if (val.startsWith('0')) {
        showAlert("JAN cannot start with 0");
        val = val.substring(1); // remove the zero
    }

    input.value = val;

    // Empty
    if (val.length === 0) {
        setInvalid(input);
        return false;
    }

    // Must be 13 digits
    if (val.length !== 13) {
        setInvalid(input);
        showAlert("JAN must be 13 digits");
        return false;
    }

    setValid(input);
    return true;
}

function validatePrice(input) {
    let raw = input.value.replace(/,/g, '').replace(/\D/g, '');

    if (!raw) {
        setInvalid(input);
        showAlert("Price must be a number");
        return false;
    }

    raw = raw.slice(0, 9);
    input.value = Number(raw).toLocaleString('ja-JP');
    input.style.textAlign = 'right';

    setValid(input);
    return true;
}
function validateSkuDigits(input) {
    input.value = input.value.replace(/\D/g, '');

    if (input.value === '') {
        setInvalid(input);
        showAlert('Digits only — this field cannot be empty.');
    } else {
        setValid(input);
    }
}

function validateSkuJan(input) {
    const digits = input.value.replace(/\D/g, '');
    input.value = digits;

    if (digits.length === 0) {
        setInvalid(input);
        showAlert('JAN code is required.');
    }
    else if (digits.length !== 13) {
        setInvalid(input);
        showAlert('JAN code must be exactly 13 digits.');
    }
    else if (digits.startsWith('0')) {
        setInvalid(input);
        showAlert('JAN code cannot start with 0.');
    }
    else {
        setValid(input);
    }
}

function validateSkuRow(row) {
    const sizeName = row.querySelector('.size-name');
    const colorName = row.querySelector('.color-name');
    const sizeCode = row.querySelector('.size-code');
    const colorCode = row.querySelector('.color-code');
    const janCode = row.querySelector('.jan-code');
    const stock = row.querySelector('.stock-quantity');

    // Size Name
    if (!sizeName.value.trim()) {
        setInvalid(sizeName);
        showAlert('Size Name is required.');
    } else setValid(sizeName);

    // Color Name
    if (!colorName.value.trim()) {
        setInvalid(colorName);
        showAlert('Color Name is required.');
    } else setValid(colorName);

    // Size Code
    if (!sizeCode.value.trim()) {
        setInvalid(sizeCode);
        showAlert('Size Code is required.');
    } else setValid(sizeCode);

    // Color Code
    if (!colorCode.value.trim()) {
        setInvalid(colorCode);
        showAlert('Color Code is required.');
    } else setValid(colorCode);

    // JAN Code
    validateSkuJan(janCode);

    // Stock
    if (stock.value === '' || isNaN(stock.value) || Number(stock.value) < 0) {
        setInvalid(stock);
        showAlert('Stock must be a number and cannot be negative.');
    } else {
        setValid(stock);
    }
}
// --------------------
// DOM Loaded
// --------------------
document.addEventListener('DOMContentLoaded', () => {
    const itemCode = document.querySelector('input[name="Item_Code"]');
    const janCode = document.querySelector('input[name="JanCD"]');
    const requiredText = document.querySelectorAll('input[name="MakerName"], textarea[name="Item_Name"]');
    const priceInputs = document.querySelectorAll('input[name="BasicPrice"], input[name="ListPrice"], input[name="CostPrice"]');
    const memoInput = document.querySelector('textarea[name="Memo"]');

    // Prevent typing spaces entirely
    itemCode.addEventListener('keydown', (e) => {
        if (e.key === ' ') e.preventDefault();
    });

    // Remove spaces on input (for paste/copy)
    itemCode.addEventListener('input', () => {
        const cursorPos = itemCode.selectionStart;
        itemCode.value = itemCode.value.replace(/\s+/g, '');
        itemCode.setSelectionRange(cursorPos, cursorPos);
        validateItemCode(itemCode);
    });

    itemCode.addEventListener('blur', () => {
        itemCode.value = itemCode.value.replace(/\s+/g, '');
        validateItemCode(itemCode);
    });

    janCode.addEventListener('input', () => validateJanCode(janCode));
    janCode.addEventListener('blur', () => validateJanCode(janCode));

    requiredText.forEach(input => {
        input.addEventListener('input', () => validateRequiredText(input));
        input.addEventListener('blur', () => validateRequiredText(input));
    });
    memoInput.addEventListener('input',()=> validateMemo(memoInput));
    memoInput.addEventListener('blur', () => validateMemo(memoInput));


    priceInputs.forEach(input => {
        input.addEventListener('input', () => validatePrice(input, 9));
        input.addEventListener('blur', () => validatePrice(input, 9));
    });

    // SKU live validation
    document.querySelectorAll('.sku-row').forEach(row => {
        row.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => validateSkuRow(row));
            input.addEventListener('blur', () => validateSkuRow(row));
        });
    });


});

// --------------------
// SKU Row Attach Validation
// --------------------
function attachSkuRowValidation(row) {
   row.querySelectorAll('.size-name, .color-name').forEach(input => {
    // Validate as required text
    input.addEventListener('input', () => validateRequiredText(input));
    input.addEventListener('blur', () => validateRequiredText(input));
});

    row.querySelectorAll('.size-code, .color-code, .stock-quantity').forEach(n => {
        n.addEventListener('input', () => validateSkuDigits(n));
    });

    const skuJan = row.querySelector('.jan-code');
    if (skuJan) {
        skuJan.addEventListener('input', () => validateSkuJan(skuJan));
        skuJan.addEventListener('blur', () => validateSkuJan(skuJan));
    }
}

function sanitizeAllSkuFields() {
    document.querySelectorAll('#skuModalBody input').forEach(i => {
        i.value = i.value.trim();
        if (i.classList.contains('size-code') ||
            i.classList.contains('color-code') ||
            i.classList.contains('stock-quantity') ||
            i.classList.contains('jan-code')) {
            i.value = i.value.replace(/\D/g, '');
        }
    });
}

document.getElementById('saveSkusBtn').addEventListener('click', () => {
    sanitizeAllSkuFields();
    closeSkuModal();
});
