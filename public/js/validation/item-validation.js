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

function showInputError(input, message) {
    // remove old tooltip if exists
    let old = input.parentNode.querySelector(".input-error-tooltip");
    if (old) old.remove();

    // create tooltip
    let tip = document.createElement("div");
    tip.className = "input-error-tooltip";
    tip.textContent = message;

    // ensure parent is position:relative
    input.parentNode.style.position = "relative";

    // insert after input
    input.parentNode.appendChild(tip);

    // auto remove
    setTimeout(() => {
        tip.remove();
    }, 1500);
}
function removeInputTooltip(input) {
    const old = input.parentNode.querySelector(".input-error-tooltip");
    if (old) old.remove();
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
        showInputError(input,"This field is required");
        return false;
    }

    if (val.length > maxLength) {
        input.value = val.substring(0, maxLength);
        setInvalid(input);
        showInputError(input,`Max ${maxLength} characters allowed`);
        return false;
    }

    setValid(input);
    return true;
}

function validateItemCode(input) {
    let cleaned = input.value.replace(/\s+/g, '');

    // Remove spaces
    if (cleaned !== input.value) {
        input.value = cleaned;
        setInvalid(input);
        showInputError(input, "Spaces are not allowed in Item Code");
        return false;
    }

    // ❌ Detect Japanese text (Hiragana, Katakana, Kanji, fullwidth symbols)
    const jpRegex = /[\u3000-\u30FF\u4E00-\u9FFF\uFF00-\uFFEF]/;

    if (jpRegex.test(cleaned)) {
        setInvalid(input);
        showInputError(input, "Japanese characters are not allowed");
        return false;
    }

    // ❌ Empty check
    if (cleaned.length === 0) {
        setInvalid(input);
        showInputError(input, "Item Code is required");
        return false;
    }

    // ✔ Valid
    setValid(input);
    return true;
}

function blockJapaneseInput(event) {
    // Allow navigation and control keys
    if (event.ctrlKey || event.altKey || event.metaKey) return true;
    
    // Allow function keys, navigation, etc.
    if (event.key.length > 1) return true;
    
    // Block if the key is a Japanese character
    const jpRegex = /[\u3000-\u30FF\u4E00-\u9FFF\uFF00-\uFFEF]/;
    if (jpRegex.test(event.key)) {
        event.preventDefault();
        return false;
    }
    
    return true;
}
function validateMemo(input) {
    let val = input.value.replace(/^\s+/g, '');
    input.value = val;

    if (val.length === 0) {
        setInvalid(input);
        showInputError(input,"Memo cannot be empty");
        return false;
    }

    if (val.length > 200) {
        input.value = val.substring(0, 200);
        setInvalid(input);
        showInputError(input,"Memo cannot exceed 200 characters");
        return false;
    }

    setValid(input);
    return true;
}
function validateJanGeneric(input, { enforceExact13 = false } = {}) {
  if (!input) return { ok: false, reason: 'missing input' };

  // sanitize digits only
  let raw = input.value.replace(/\D/g, '');

  // If first char is '0' => show message and refuse to accept that zero.
  if (raw.startsWith('0')) {
    // remove the leading zero(s). Show message and stop validation here.
    raw = raw.replace(/^0+/, ''); // remove all leading zeros safely
    input.value = raw;
    setInvalid(input);
    showInputError(input, 'JAN cannot start with 0');
    return { ok: false, reason: 'starts-with-0' };
  }

  // Trim to maximum 13 digits (prevents typing beyond)
  if (raw.length > 13) {
    raw = raw.slice(0, 13);
    input.value = raw;
    setInvalid(input);
    showInputError(input, 'JAN cannot exceed 13 digits');
    return { ok: false, reason: 'too-long' };
  }

  input.value = raw; // keep input synced

   if (raw.length === 0) {
        setInvalid(input);
        showInputError(input,"SKU JanCd is  cannot be empty. ")
        return false;
    }
  // Empty check
  if (raw.length === 0) {
    setInvalid(input);
    if (enforceExact13) {
      showInputError(input, 'JAN cannot be empty');
    }


   
    return { ok: false, reason: 'empty' };
  }

  // If we require exact 13 (for save) but not yet 13, show message
  if (enforceExact13 && raw.length !== 13) {
    setInvalid(input);
    showInputError(input, 'JAN must be exactly 13 digits');
    return { ok: false, reason: 'not-13' };
  }

  // Not enforcing exact13 (live typing): if <13 then accept as "incomplete" but mark invalid
  if (!enforceExact13) {
    if (raw.length < 13) {
      setInvalid(input);
      // show a light temporary tooltip (don't spam). optional:
      showInputError(input, `JAN incomplete (${raw.length}/13)`, { autoHide: 900 });
      return { ok: false, reason: 'incomplete' };
    }
  }

  // Exactly 13 digits => valid
  if (raw.length === 13) {
    setValid(input);
    removeInputTooltip(input);
    return { ok: true, exact13: true };
  }

  // Fallback (shouldn't reach)
 
  setInvalid(input);
    return false;
}

// wrappers for existing names (keeps your code compatible)
function validateJanCode(input) {
  return validateJanGeneric(input, { enforceExact13: false }); // form-level live validation
}
function validateSkuJan(input) {
  return validateJanGeneric(input, { enforceExact13: false }); // live validation in modal
}

function validatePrice(input,maxDigits) {
    let raw = input.value.replace(/,/g, '').replace(/\D/g, '');

    if (!raw) {
        setInvalid(input);
        showInputError(input,"Price must be a number and canot be empty");
        return false;
    }
    if(raw.length > maxDigits){
        raw =raw.slice(0,maxDigits);
        showInputError(input,`Price cannot exceed ${maxDigits} digits`);
    }

    
    input.value = Number(raw).toLocaleString('ja-JP');
    input.style.textAlign = 'right';

    setValid(input);
    return true;
}
function validateSkuDigits(input) {
    let val = input.value.replace(/\D/g, '');
    input.value = val;

    // --- STOCK FIELD SPECIAL RULE ---
    const isStock = input.classList.contains("stock-quantity");

    // Empty
    //  if (val.length === 0) {
    //     setInvalid(input);
    //     showInputError(input,"SKU JanCd is  cannot be empty. ")
    //     return false;
    // }
    if (val.length === 0) {
        setInvalid(input);
        showInputError(input,"cannot be empty")
        if (isStock) {
            // showAlert("Stock cannot be empty and must be a number");
                    showInputError(input,"cannot be empty")

        } else {
            showInputError(input, "Digits only — cannot be empty");
        }

        return false;
    }

    // Valid
    setValid(input);
    removeInputTooltip(input);
    return true;
}


function validateSkuJan(input) {
    let digits = input.value.replace(/\D/g, '');

    // ❌ Don't allow first digit = 0
    if (digits.startsWith("0")) {
        showInputError(input,"JAN cannot start with 0");
        digits = digits.substring(1); // remove the leading zero
    }

    // ❌ Limit to 13 digits max
    if (digits.length > 13) {
        digits = digits.substring(0, 13); // cut extra digits
        showInputError(input,"JAN cannot be more than 13 digits");
    }
if (digits.length < 13) {
        showInputError(input,"JAN cannot be Less than 13 digits");
    }
    input.value = digits;

    // ❌ If empty → invalid
    if (digits.length === 0) {
        setInvalid(input);
        showInputError(input,"SKU JanCd is  cannot be empty. ")
        return false;
    }

    // ❗ Exactly 13 digits = valid
    if (digits.length === 13) {
        setValid(input);
        return true;
    }

    // Otherwise incomplete → invalid
    setInvalid(input);
    return false;
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
        showInputError(input,'Size Name is required.');
    } else setValid(sizeName);

    // Color Name
    if (!colorName.value.trim()) {
        setInvalid(colorName);
        showInputError(input,'Color Name is required.');
    } else setValid(colorName);

    // Size Code
    if (!sizeCode.value.trim()) {
        setInvalid(sizeCode);
        showInputError(input,'Size Code is required.');
    } else setValid(sizeCode);

    // Color Code
    if (!colorCode.value.trim()) {
        setInvalid(colorCode);
        showInputError(input,'Color Code is required.');
    } else setValid(colorCode);

    // JAN Code
    validateSkuJan(janCode);

    // Stock
    if (stock.value === '' || isNaN(stock.value) || Number(stock.value) < 0) {
        setInvalid(stock);
        showInputError(input,'Stock must be a number and cannot be negative.');
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
    // closeSkuModal();
});
