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
function validateRequiredText(input) {
    if (!input.value.trim()) {
        setInvalid(input, 'This field is required');
    } else {
        setValid(input);
    }
}
function validateJanCode(input) {
    const val = input.value.replace(/\D/g, ''); // only digits
    input.value = val;

    if (val.length !== 13) {
        setInvalid(input, 'JAN must be 13 digits');
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

    // Limit digits
    rawVal = rawVal.slice(0, maxDigits);

    // Format to JP style
    input.value = Number(rawVal).toLocaleString('ja-JP');
    input.style.textAlign = 'right';

    setValid(input);
}
function validateSkuDigits(input) {
    input.value = input.value.replace(/\D/g, '');
    if (input.value === '') {
        setInvalid(input, 'Numbers only');
    } else {
        setValid(input);
    }
}
function validateSkuJan(input) {
    const digits = input.value.replace(/\D/g, '');
    input.value = digits;

    if (digits.length === 0) {
        setInvalid(input, 'Required');
        return;
    }
    if (digits.length !== 13) {
        setInvalid(input, 'Must be 13 digits');
        return;
    }
    setValid(input);
}
function validateSelect(input) {
    if (!input.value || input.value === '---') {
        setInvalid(input, 'Select one');
    } else {
        setValid(input);
    }
}
document.addEventListener('DOMContentLoaded', () => {

    // -------- Required Fields --------
    const requiredText = document.querySelectorAll(
        'input[name="Item_Code"], input[name="MakerName"], textarea[name="Item_Name"]'
    );
    requiredText.forEach(input => {
        input.addEventListener('input', () => validateRequiredText(input));
        input.addEventListener('blur', () => validateRequiredText(input));
    });

    // -------- JAN Field --------
    const janInput = document.querySelector('input[name="JanCD"]');
    janInput.addEventListener('input', () => validateJanCode(janInput));
    janInput.addEventListener('blur', () => validateJanCode(janInput));

    // -------- Prices --------
    const priceInputs = document.querySelectorAll(
        'input[name="BasicPrice"], input[name="ListPrice"], input[name="CostPrice"]'
    );
    priceInputs.forEach(input => {
        input.addEventListener('input', () => validatePrice(input, 9));
        input.addEventListener('blur', () => validatePrice(input, 9));
    });

});
function attachSkuRowValidation(row) {
    row.querySelectorAll('.sizeName, .colorName').forEach(select => {
        select.addEventListener('change', () => validateSelect(select));
    });

    row.querySelectorAll('.sizeCode, .colorCode, .stockQty').forEach(n => {
        n.addEventListener('input', () => validateSkuDigits(n));
    });

    const skuJan = row.querySelector('.skuJan');
    if (skuJan) {
        skuJan.addEventListener('input', () => validateSkuJan(skuJan));
        skuJan.addEventListener('blur', () => validateSkuJan(skuJan));
    }
}
function sanitizeAllSkuFields() {
    document.querySelectorAll('#skuModalBody input').forEach(i => {
        i.value = i.value.trim();
        if (i.classList.contains('sizeCode') ||
            i.classList.contains('colorCode') ||
            i.classList.contains('stockQty') ||
            i.classList.contains('skuJan')) {
            i.value = i.value.replace(/\D/g, '');
        }
    });
}

document.getElementById('saveSkusBtn').addEventListener('click', () => {
    sanitizeAllSkuFields();
    closeSkuModal();
});
