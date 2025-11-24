// --------------------
// Common Validation UI
// --------------------
function setValid(input) {
    if (!input) return;
    input.classList.remove('border-red-500');
    input.classList.add('border-green-500');

    const next = input.nextElementSibling;
    if (next && next.classList.contains('error-msg')) {
        next.remove();
    }
}

function setInvalid(input, msg = '') {
    if (!input) return;
    input.classList.remove('border-green-500');
    input.classList.add('border-red-500');

    const next = input.nextElementSibling;
    if (next && next.classList.contains('error-msg')) {
        next.textContent = msg;
        return;
    }

    const err = document.createElement('p');
    err.className = 'error-msg text-red-500 text-sm mt-1';
    err.textContent = msg;
    input.parentNode.appendChild(err);
}

function validateRequiredText(input, maxLength = 100) {
    const val = input.value.trim();

    if (!val) {
        setInvalid(input, 'This field is required');
    } else if (val.length > maxLength) {
        input.value = val.substring(0,100)
        setInvalid(input, `Cannot exceed ${maxLength} characters`);
    } else {
        setValid(input);
    }
}


document.addEventListener("DOMContentLoaded", () => {

    const itemCode = document.querySelector('input[name="Item_Code"]');

    itemCode.addEventListener('input', () => {
        validateItemCode(itemCode);
    });

});

function validateItemCode(input) {
    // Remove spaces live
    const cleaned = input.value.replace(/\s+/g, '');

    if (cleaned !== input.value) {
        input.value = cleaned;
        setInvalid(input, "Spaces are not allowed");
        return;
    }

    // Check empty
    if (cleaned.length === 0) {
        setInvalid(input, "Item Code is required");
        return;
    }

    // If all good
    setValid(input);
}
function validateMemo(input) {
    let val = input.value;

    // Remove leading spaces
    val = val.replace(/^\s+/g, '');
    input.value = val;
 if (val.length === 0) {
        setInvalid(input, "Memo cannot be empty.");
        return;
    }
    // Max 200 chars
    if (val.length > 200) {
        input.value = val.substring(0, 200);
        setInvalid(input, 'Memo cannot exceed 200 characters');
        return;
    }

    // Valid
    setValid(input);
}


function validateJanCode(input) {
    let val = input.value.replace(/\D/g, ''); // only digits
    input.value = val;

    if (val.length !== 13) {
        setInvalid(input, 'JAN must be 13 digits');
    } else if (val.startsWith('0')) {
        setInvalid(input, 'JAN cannot start with 0');
    } else {
        setValid(input);
    }
}

function validatePrice(input, maxDigits = 9) {
    if (!input || !input.value) return;

    let rawVal = input.value.replace(/,/g, '').replace(/\D/g, '');
    if (rawVal === '') {
        setInvalid(input, 'Must be a number');
        return;
    }

    rawVal = rawVal.slice(0, maxDigits);
    input.value = Number(rawVal).toLocaleString('ja-JP');
    input.style.textAlign = 'right';
    setValid(input);
}

function validateSkuDigits(input) {
    input.value = input.value.replace(/\D/g, '');
    if (input.value === '') setInvalid(input, 'Numbers only');
    else setValid(input);
}

function validateSkuJan(input) {
    const digits = input.value.replace(/\D/g, '');
    input.value = digits;

    if (digits.length === 0) setInvalid(input, 'Required');
    else if (digits.length !== 13) setInvalid(input, 'Must be 13 digits');
    else if (digits.startsWith('0')) setInvalid(input, 'Cannot start with 0');
    else setValid(input);
}

function validateSelect(input) {
    if (!input.value || input.value === '---') setInvalid(input, 'Select one');
    else setValid(input);
}

function validateSkuRow(row) {
    const sizeName = row.querySelector('.size-name');
    const colorName = row.querySelector('.color-name');
    const sizeCode = row.querySelector('.size-code');
    const colorCode = row.querySelector('.color-code');
    const janCode = row.querySelector('.jan-code');
    const stock = row.querySelector('.stock-quantity');

    // Required fields
    if (!sizeName.value.trim()) setInvalid(sizeName, 'Required'); else setValid(sizeName);
    if (!colorName.value.trim()) setInvalid(colorName, 'Required'); else setValid(colorName);
    if (!sizeCode.value.trim()) setInvalid(sizeCode, 'Required'); else setValid(sizeCode);
    if (!colorCode.value.trim()) setInvalid(colorCode, 'Required'); else setValid(colorCode);

    // JAN code validation
    validateSkuJan(janCode);

    // Stock ≥ 0
    if (stock.value === '' || isNaN(stock.value) || Number(stock.value) < 0) setInvalid(stock, 'Invalid');
    else setValid(stock);
}


// if validation not meet submit button will be disable functions


// const saveBtn = document.getElementById('saveSkusBtn');
// saveBtn.disabled = true;
// saveBtn.classList.add('opacity-50', 'cursor-not-allowed');

// function checkSkuValidation() {
//     const rows = document.querySelectorAll('.sku-row');
//     let allValid = true;

//     rows.forEach(row => {
//         // Validate each row
//         validateSkuRow(row);

//         // If any input has red border, mark as invalid
//         const invalidInput = row.querySelector('.border-red-500');
//         if (invalidInput) allValid = false;
//     });

//     // Enable/disable button
//     saveBtn.disabled = !allValid;
//     saveBtn.classList.toggle('opacity-50', !allValid);
//     saveBtn.classList.toggle('cursor-not-allowed', !allValid);
// }


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

//     // document.querySelectorAll('.sku-row input, .sku-row select').forEach(input => {
//     // input.addEventListener('input', checkSkuValidation);
//     // input.addEventListener('blur', checkSkuValidation);
// });

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
