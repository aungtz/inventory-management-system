// --------------------
// Common Validation UI
// --------------------
function showInputError(input, message, { autoHide = true, duration = 5000 } = {}) {
    const wrapper = input.closest(".input-wrap");
    if (!wrapper) return;

    const errorText = wrapper.querySelector(".error-text");
    if (!errorText) return;

    // --- Cleanup function (defined here for access to local variables) ---
    const cleanupOnFocus = () => {
        // We use the same cleanup logic as setValid below, but add the listener removal.
        errorText.classList.add("hidden");
        wrapper.querySelectorAll(".error-icon").forEach(i => i.remove());
        input.classList.remove("border-red-500");
        input.classList.add("border-gray-300");
        
        // Remove the focus listener
        input.removeEventListener('focus', cleanupOnFocus);
        
        // Clear the stored reference
        delete input.cleanupListener; 
    };
    // ---------------------------------------------
    
    // Store the listener reference on the input so setValid can remove it later
    input.cleanupListener = cleanupOnFocus; 

    // Remove any old icon before setting a new one
    wrapper.querySelectorAll(".error-icon").forEach(i => i.remove());

    // Red border
    input.classList.remove("border-green-500");
    input.classList.remove("border-gray-300"); 
    input.classList.add("border-red-500");

    // Show error message
    errorText.textContent = message;
    errorText.classList.remove("hidden");
    
    // Add the focus listener
    input.addEventListener('focus', cleanupOnFocus);


    // Auto-hide after duration
    if (autoHide) {
        setTimeout(() => {
            // Only clean up if the error is still active
            if (input.classList.contains("border-red-500")) {
                cleanupOnFocus();
            }
        }, duration);
    }
}

function setValid(input) {
    const wrapper = input.closest(".input-wrap");
    if (!wrapper) return;
    
    const errorText = wrapper.querySelector(".error-text");

    // 1. Remove the error message and icons IMMEDIATELY
    if (errorText) {
        errorText.classList.add("hidden");
    }
    wrapper.querySelectorAll(".error-icon").forEach(i => i.remove());

    // 2. Remove the focus listener if it exists
    if (input.cleanupListener) {
        // Remove the listener using the stored reference
        input.removeEventListener('focus', input.cleanupListener);
        // Clean up the stored reference
        delete input.cleanupListener; 
    }
    
    // 3. Set the valid border color
    input.classList.remove('border-red-500');
    input.classList.remove('border-gray-300'); // Ensure default border is removed
    input.classList.add('border-green-500');
}

/**
 * Global function to remove the error state (message, icons, border, and listeners) 
 * from a given input field.
 */
function clearErrorState(input) {
    const wrapper = input.closest(".input-wrap");
    if (!wrapper) return;

    const errorText = wrapper.querySelector(".error-text");
    if (errorText) {
        errorText.classList.add("hidden");
    }

    wrapper.querySelectorAll(".error-icon").forEach(i => i.remove());
    
    input.classList.remove("border-red-500");
    input.classList.add("border-gray-300"); // Add back a default border if needed

    // CRUCIAL: Remove the listener used for immediate cleanup on focus.
    // We need to pass a reference to the function used to attach it. 
    // Since we can't easily reference the 'cleanupError' function used previously,
    // we need to slightly restructure the logic in showInputError.
    
    // For simplicity and direct control, we'll rely on setValid to override everything.
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

    // if (val.length > maxLength) {
    //     input.value = val.substring(0, maxLength);
    //     setInvalid(input);
    //     showInputError(input,`Max ${maxLength} characters allowed`);
    //     return false;
    // }
    


    setValid(input);
    return true;
}
function validateItemCode(input) {
    // 1. Define the Regular Expression (No change here, it's correct)
    const forbiddenCharsRegex = /[\s&*^$#@%\u3000-\u30FF\u4E00-\u9FFF\uFF00-\uFFEF]/g;

    const originalValue = input.value; 

    // 2. Create the 'cleaned' value.
    let cleaned = originalValue.replace(forbiddenCharsRegex, '');
    
    // 3. Check for change and update input.
    if (cleaned !== originalValue) {
        input.value = cleaned; 
        
        // --- START OF ERROR MESSAGE FIX ---
        
        // A. If the input is empty AFTER cleaning (all input was forbidden chars):
        if (cleaned.length === 0) {
            setInvalid(input);
            // Give a specific error for why the field is now empty.
            showInputError(input, "All characters were removed. Item Code is required.");
            return false;
        }
        
        // B. If the input is NOT empty AFTER cleaning (some forbidden chars were removed, but some valid chars remain):
        setInvalid(input); // Use invalid state temporarily for the warning
        showInputError(input, "Invalid characters (spaces, Japanese, $, #, @, %) were removed.");
        
        // NOTE: We don't return false here, as the input field is now considered valid, 
        // but we show the error message to notify the user.
    }

    // 4. Final Empty check on the cleaned value (This only runs if no invalid characters were present, OR 
    //    if the previous block ran but didn't return false).
    
    // ❌ Empty check (Only runs if the field was empty to begin with, or the cleaning didn't happen)
    if (cleaned.length === 0 && cleaned === originalValue) {
        setInvalid(input);
        showInputError(input, "Item Code is required");
        return false;
    }

    // IMPORTANT: The validateItemCodeLength function handles setting setValid/setInvalid
    // and showing the length error message. If it returns false, we stop here.
  if (!validateItemCodeLength(input)) {
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

    // if (val.length > 200) {
    //     input.value = val.substring(0, 200);
    //     setInvalid(input);
    //     showInputError(input,"Memo cannot exceed 200 characters");
    //     return false;
    // }
    if (!validateMemoLength(input)) {
        return false;
    }

    setValid(input);
    return true;
}



//old code for janCD
// function validateJanGeneric(input, { enforceExact13 = false } = {}) {
//   if (!input) return { ok: false, reason: 'missing input' };

//   // sanitize digits only
//   let raw = input.value.replace(/\D/g, '');

//   // If first char is '0' => show message and refuse to accept that zero.
//   if (raw.startsWith('0')) {
//     // remove the leading zero(s). Show message and stop validation here.
//     raw = raw.replace(/^0+/, ''); // remove all leading zeros safely
//     input.value = raw;
//     setInvalid(input);
    
//     showInputError(input, 'JAN cannot start with 0');
//     return { ok: false, reason: 'starts-with-0' };
//   }

//   // Trim to maximum 13 digits (prevents typing beyond)
//   if (raw.length > 13) {
//     raw = raw.slice(0, 13);
//     input.value = raw;
//     setInvalid(input);
//     showInputError(input, 'JAN cannot exceed 13 digits');
//     return { ok: false, reason: 'too-long' };
//   }

//   input.value = raw; // keep input synced

//    if (raw.length === 0) {
//         setInvalid(input);
//         showInputError(input,"SKU JanCd is  cannot be empty. ")
//         return false;
//     }
//   // Empty check
//   if (raw.length === 0) {
//     setInvalid(input);
//     if (enforceExact13) {
//       showInputError(input, 'JAN cannot be empty');
//     }


   
//     return { ok: false, reason: 'empty' };
//   }

//   // If we require exact 13 (for save) but not yet 13, show message
//   if (enforceExact13 && raw.length !== 13) {
//     setInvalid(input);
//     showInputError(input, 'JAN must be exactly 13 digits');
//     return { ok: false, reason: 'not-13' };
//   }

//   // Not enforcing exact13 (live typing): if <13 then accept as "incomplete" but mark invalid
//   if (!enforceExact13) {
//     if (raw.length < 13) {
//       setInvalid(input);
//       // show a light temporary tooltip (don't spam). optional:
//       showInputError(input, `JAN incomplete (${raw.length}/13)`, { autoHide: 900 });
//       return { ok: false, reason: 'incomplete' };
//     }
//   }

//   // Exactly 13 digits => valid
//   if (raw.length === 13) {
//     setValid(input);
//     return { ok: true, exact13: true };
//   }

//   // Fallback (shouldn't reach)
 
//   setInvalid(input);
//     return false;
// }




         const janInput = document.getElementById('janInput');
        const janError = document.getElementById('janError');
        const submitButton = document.getElementById('submitButton');


 function validateJanGeneric(input, { enforceExact13 = false } = {}) {
            if (!input) return { ok: false, reason: 'missing input', raw: '' };

            // 1. Sanitize: Keep digits only
            let raw = input.value.replace(/\D/g, '');

            // Update input value immediately (to remove non-digits)
            input.value = raw;
            
            // 2. Max length check (if input is still longer than 13 after sanitization, which shouldn't happen with type="text" but is good practice)
            if (raw.length > 13) {
                raw = raw.slice(0, 13);
                input.value = raw;
                setInvalid(input);
                showInputError(input, 'JAN cannot exceed 13 digits');
                return { ok: false, reason: 'too-long', raw };
            }

            // 3. Empty check (Highest priority)
            if (raw.length === 0) {
                setInvalid(input);
                showInputError(input, 'JAN cannot be empty');
                if (enforceExact13) {
                    showInputError(input, 'JAN cannot be empty');
                }
                return { ok: false, reason: 'empty', raw };
            }

            // 4. Leading zero check (Highest priority after empty)
            if (raw.startsWith('0')) {
                // We keep the input synced but inform the user this is an error
                setInvalid(input);
                showInputError(input, 'JAN cannot start with 0');
                return { ok: false, reason: 'starts-with-0', raw };
            }

            // --- Check for Validity based on length ---

            // Check 5A: Exact 13 digits => Valid
            if (raw.length === 13) {
                setValid(input);
                // NOTE: Check digit validation would happen here if implemented.
                return { ok: true, reason: 'valid', raw };
            }

            // Check 5B: Enforcing exact 13 (e.g., on submit) but length is wrong
            if (enforceExact13 && raw.length !== 13) {
                setInvalid(input);
                showInputError(input, `JAN must be exactly 13 digits (currently ${raw.length})`);
                return { ok: false, reason: 'not-13', raw };
            }

            // Check 5C: Not enforcing exact 13 (live typing) and length < 13 => Incomplete
            if (!enforceExact13 && raw.length < 13) {
                setInvalid(input);
                // Only show a temporary, non-blocking error for being incomplete
                showInputError(input, `JAN incomplete (${raw.length}/13)`, { autoHide: 900 });
                return { ok: false, reason: 'incomplete', raw };
            }
            
            // Fallback (e.g., if somehow raw.length is 14 but didn't trigger length check)
            setInvalid(input);
            showInputError(input, 'Unknown validation error');
            return { ok: false, reason: 'unknown', raw };
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
    let val = input.value.replace(/,/g, '').replace(/\D/g, '');
    
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
        validateItemNameLength(input)
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
    
    // 1. Separate variables for MakerName and Item_Name
    const makerNameInput = document.querySelector('input[name="MakerName"]');
    const itemNameInput = document.querySelector('textarea[name="Item_Name"]');
    
    const priceInputs = document.querySelectorAll('input[name="SalePrice"], input[name="ListPrice"], input[name="CostPrice"]');
    const memoInput = document.querySelector('textarea[name="Memo"]');

    // =========================================================================
    // ITEM CODE LISTENERS (No change needed here)
    // =========================================================================
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

    // =========================================================================
    // JAN CODE LISTENERS (No change needed here)
    // =========================================================================
    // Note: Assuming validateJanCode now calls validateJanCDLength
    janCode.addEventListener('input', () => validateJanCode(janCode)); 
    janCode.addEventListener('blur', () => validateJanCode(janCode));

    // =========================================================================
    // REQUIRED TEXT LISTENERS (Replaced the generic loop)
    // =========================================================================
    
    // 2. Maker Name Listeners (Calls its specific length/required function)
    makerNameInput.addEventListener('input', () => validateMakerNameLength(makerNameInput));
    makerNameInput.addEventListener('blur', () => validateMakerNameLength(makerNameInput));
    
    // 3. Item Name Listeners (Calls its specific length/required function)
    itemNameInput.addEventListener('input', () => validateItemNameLength(itemNameInput));
    itemNameInput.addEventListener('blur', () => validateItemNameLength(itemNameInput));
    
    // =========================================================================
    // MEMO LISTENERS (No change needed here)
    // =========================================================================
    // Note: Assuming validateMemo now calls validateMemoLength
    memoInput.addEventListener('input',()=> validateMemo(memoInput)); 
    memoInput.addEventListener('blur', () => validateMemo(memoInput));


    // =========================================================================
    // PRICE LISTENERS (No change needed here)
    // =========================================================================
    priceInputs.forEach(input => {
        input.addEventListener('input', () => validatePrice(input, 9));
        input.addEventListener('blur', () => validatePrice(input, 9));
    });

    // =========================================================================
    // SKU LISTENERS (No change needed here)
    // =========================================================================
    document.querySelectorAll('.sku-row').forEach(row => {
        row.querySelectorAll('input').forEach(input => {
            // NOTE: validateSkuRow should internally call the specific length/digit validators
            input.addEventListener('input', () => validateSkuRow(row)); 
            input.addEventListener('blur', () => validateSkuRow(row));
        });
    });


});

// --------------------
// SKU Row Attach Validation
// --------------------
function attachSkuRowValidation(row) {
// --- 1. Size Name Validation (NVARCHAR(100) / 200 bytes) ---
    row.querySelectorAll('.size-name').forEach(input => {
        // Calls the correct function: validateSizeNameLength
        input.addEventListener('input', () => validateSizeNameLength(input));
        input.addEventListener('blur', () => validateSizeNameLength(input));
    });

    // --- 2. Color Name Validation (NVARCHAR(100) / 200 bytes) ---
    row.querySelectorAll('.color-name').forEach(input => {
        // Calls the correct function: validateColorNameLength
        input.addEventListener('input', () => validateColorNameLength(input));
        input.addEventListener('blur', () => validateColorNameLength(input));
    });
row.querySelectorAll('.size-code').forEach(input => {
        // Calls the correct function: validateSizeCodeLength
        input.addEventListener('input', () => validateSizeCodeLength(input));
        input.addEventListener('blur', () => validateSizeCodeLength(input));
    });

    // --- 4. Color Code Validation (CHAR(4) / 4 bytes) ---
    row.querySelectorAll('.color-code').forEach(input => {
        // Calls the correct function: validateColorCodeLength
        input.addEventListener('input', () => validateColorCodeLength(input));
        input.addEventListener('blur', () => validateColorCodeLength(input));
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



// length validation

/**
 * Calculates the byte length of a string.
 * Assumes 1 byte for ASCII (0x0000 - 0x007F) and 2 bytes for other common CJK/Unicode characters.
 * @param {string} str - The string to measure.
 * @returns {number} The calculated byte length.
 */
function getStringByteLength(str) {
    if (!str) return 0;
    let byteLength = 0;
    for (let i = 0; i < str.length; i++) {
        const charCode = str.charCodeAt(i);
        // ASCII characters (0-127) are 1 byte
        if (charCode >= 0x0000 && charCode <= 0x007F) {
            byteLength += 1;
        } else {
            // Assume other characters (including Japanese) are 2 bytes
            byteLength += 2;
        }
    }
    return byteLength;
}

/**
 * Validates the input against max byte length and required status.
 * @param {HTMLInputElement} input - The input element.
 * @param {number} maxBytes - The maximum allowed byte length.
 * @param {string} name - The display name of the field.
 * @param {boolean} isRequired - Whether the field must not be empty.
 * @returns {boolean} True if valid, false otherwise.
 */
function validateByteLength(input, maxBytes, name, isRequired = true) {
    let value = input.value;
    
    // --- Empty Check ---
    if (isRequired && value.length === 0) {
        setInvalid(input);
        showInputError(input, `${name} is required.`);
        return false;
    }

    // --- Byte Length Check ---
    let currentBytes = getStringByteLength(value);

    if (currentBytes > maxBytes) {
        // Truncate the value to fit the max byte limit
        let truncatedValue = '';
        let currentTruncatedBytes = 0;

        for (let i = 0; i < value.length; i++) {
            const char = value.charAt(i);
            const charCode = value.charCodeAt(i);
            const charBytes = (charCode >= 0x0000 && charCode <= 0x007F) ? 1 : 2;

            if (currentTruncatedBytes + charBytes <= maxBytes) {
                currentTruncatedBytes += charBytes;
                truncatedValue += char;
            } else {
                break;
            }
        }
        
        input.value = truncatedValue;

        setInvalid(input);
        showInputError(input, `${name} exceeds the limit of ${maxBytes} bytes.`);
        return false;
    }
    
    // Final check for valid state
    setValid(input);
    return true;
}

function validateItemCodeLength(input) {
    // NVARCHAR(50) = 100 bytes
    return validateByteLength(input, 100, "Item Code", true); 
    console.log("length is working")
}

function validateItemNameLength(input) {
    // NVARCHAR(100) = 200 bytes
    if (!validateRequiredText(input)) {
        return false;
    }
    return validateByteLength(input, 200, "Item Name", true);
}


function validateMakerNameLength(input) {
    // NVARCHAR(50) = 100 bytes
    if (!validateRequiredText(input)) {
        return false;
    }
    return validateByteLength(input, 100, "Maker Name", false); // Assuming not required
}

    function validateMemoLength(input) {
        // NVARCHAR(255) = 510 bytes
        return validateByteLength(input, 510, "Memo", false); // Assuming not required
    }

function validateSizeCodeLength(input) {
    // CHAR(4) = 4 bytes
    if (!validateSkuDigits(input)) {
        return false;
    }
    return validateByteLength(input, 4, "Size Code", true); 
}

function validateColorCodeLength(input) {
    // CHAR(4) = 4 bytes
    if (!validateSkuDigits(input)) {
        return false;
    }
    return validateByteLength(input, 4, "Color Code", true); 
}

function validateSizeNameLength(input) {
    // NVARCHAR(100) = 200 bytes

    if (!validateRequiredText(input)) {
        return false;
    }
    return validateByteLength(input, 200, "Size Name", false); // Assuming not required
}

function validateColorNameLength(input) {
    // NVARCHAR(100) = 200 bytes
     if (!validateRequiredText(input)) {
        return false;
    }
    return validateByteLength(input, 200, "Color Name", false); // Assuming not required
}

function validateSkuJanCodeLength(input) {
    
    return validateJanCDLength(input);
}