function validateImportedRows(rows) {
    const jpRegex = /[\u3000-\u30FF\u4E00-\u9FFF\uFF00-\uFFEF]/;
    const spaceRegex = /\s/;

    return rows.map((raw, index) => {
        let errors = [];
        let warnings = [];
        let vaild = [];

        const lineNo = index + 1;

        // ------------------------------------------
        // Normalize Excel column names ↓↓↓
        // ------------------------------------------
        const row = {
            Item_Code: (raw.Item_Code ?? raw["Item Code"] ?? raw["item_code"] ?? "").toString(),
            Item_Name: (raw.Item_Name ?? raw["Item Name"] ?? raw["item_name"] ?? "").toString(),
            JanCD: (raw.JanCD ?? raw["Jan Code"] ?? raw["JAN"] ?? "").toString(),
            MakerName: (raw.MakerName ?? raw["Maker Name"] ?? raw["maker_name"] ?? "").toString(),
            Memo: (raw.Memo ?? raw["Description"] ?? "").toString(),
            ListPrice: (raw.ListPrice ?? raw["List Price"] ?? raw["List_Price"] ?? "").toString(),
            SalePrice: (raw.SalePrice ?? raw["Sale Price"] ?? raw["Sale_Price"] ?? "").toString(),
        };

        // ------------------------------------------
        // Force scientific notation → full number string
        // ------------------------------------------
        function fixExcelNumber(val) {
            if (!val) return "";
            val = val.toString();

            // Excel scientific notation like "1.2345E+12"
            if (/e\+/i.test(val)) {
                return Number(val).toString();
            }
            return val;
        }

        row.JanCD = fixExcelNumber(row.JanCD);
        row.ListPrice = row.ListPrice.replace(/,/g, "").trim() ? row.ListPrice : "";
        row.SalePrice = row.SalePrice.replace(/,/g, "").trim() ? row.SalePrice : "";

        // Trim all safely
        const Item_Code = row.Item_Code.trim();
        const Item_Name = row.Item_Name.trim();
        const JanCD = row.JanCD.trim();
        const MakerName = row.MakerName.trim();
        const Memo = row.Memo.trim();
        const ListPrice = row.ListPrice.trim();
        const SalePrice = row.SalePrice.trim();

        // -------------------------
        // 1. Item_Code
        // -------------------------
        if (!Item_Code) {
            errors.push("Item_Code is required");
        } else {
            if (spaceRegex.test(Item_Code)) errors.push("Item_Code cannot contain spaces");
            if (jpRegex.test(Item_Code)) errors.push("Item_Code cannot contain Japanese characters");
            if (Item_Code.length > 50) errors.push("Item_Code max length is 50");
            if (!/^[A-Za-z0-9\-_]+$/.test(Item_Code))
                errors.push("Item_Code allowed: A-Z, 0-9, -, _");
        }

        // -------------------------
        // 2. Item_Name
        // -------------------------
        if (!Item_Name) {
            errors.push("Item_Name is required");
        } else if (Item_Name.length > 255) {
            errors.push("Item_Name max length is 255");
        }

        // -------------------------
        // 3. JanCD
        // -------------------------
        if (JanCD !== "") {
            let janStr = JanCD.replace(/,/g, "");
            if (!/^[0-9]+$/.test(janStr)) {
                errors.push("JanCD must contain digits only");
            } else if (!(janStr.length === 8 || janStr.length === 13)) {
                errors.push(`JAN Code must be 8 or 13 digits (got ${janStr.length})`);
            }
        }

        // -------------------------
        // 4. MakerName
        // -------------------------
        if (!MakerName) {
            errors.push("MakerName is required");
        } else if (MakerName.length > 255) {
            errors.push("MakerName max length is 255");
        }

        // -------------------------
        // 5. Memo
        // -------------------------
        if (Memo && Memo.length > 500) {
            errors.push("Memo max length is 500");
        }

        // -------------------------
        // 6. ListPrice  (keep commas)
        // -------------------------
        if (!ListPrice) {
            errors.push("ListPrice is required");
        } else {
            const numCheck = ListPrice.replace(/,/g, "");
            if (!/^[0-9]+(\.[0-9]+)?$/.test(numCheck)) {
                errors.push("ListPrice must be a valid number");
            }
        }

        // -------------------------
        // 7. SalePrice (keep commas)
        // -------------------------
        if (!SalePrice) {
            errors.push("SalePrice is required");
        } else {
            const numCheck = SalePrice.replace(/,/g, "");
            if (!/^[0-9]+(\.[0-9]+)?$/.test(numCheck)) {
                errors.push("SalePrice must be a valid number");
            } else if (parseFloat(numCheck) === 0) {
                warnings.push("SalePrice is zero — check if intentional");
            }
        }

        // Status decision
        let status = "Valid";
        if (errors.length > 0) status = "Error";
        else if (warnings.length > 0) status = "Warning";

        return {
            lineNo,
            ...row,
            errors,
            warnings,
            status
        };
    });
}


function parseAndValidate(file) {
    const reader = new FileReader();

    reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        const firstSheet = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheet];

        const importedData = XLSX.utils.sheet_to_json(worksheet);

        // Validate
        const validatedRows = validateImportedRows(importedData);

        // Save
        sessionStorage.setItem('previewData', JSON.stringify(validatedRows));

        // Check status counts
        const hasError = validatedRows.some(r => r.status === "Error");
        const hasWarning = validatedRows.some(r => r.status === "Warning");

        let message = "";

        // if (hasError) {
        //     message = "Some rows contain ERRORS.\n\nYou can review them in the preview page.";
        // } else if (hasWarning) {
        //     message = "Import contains WARNING rows.\n\nYou can review them in the preview page.";
        // } else {
        //     message = "All rows are valid!\n\nClick OK to continue.";
        // }

        // // Show alert, then redirect
        // alert(message);
        window.location.href = '/itemPreview';
    };

    reader.readAsArrayBuffer(file);
}

function validateSKUImported(rows) {
    const jpRegex = /[\u3000-\u30FF\u4E00-\u9FFF\uFF00-\uFFEF]/;
    const spaceRegex = /\s/;

    function fixExcelNumber(val) {
        if (!val) return "";
        val = val.toString();
        if (/e\+/i.test(val)) return Number(val).toString(); // Excel scientific notation fix
        return val;
    }

    return rows.map((raw, index) => {
        let errors = [];
        let warnings = [];

        const lineNo = index + 1;

        // Normalize column names
        const row = {
            Item_Code: (raw.Item_Code ?? raw["Item Code"] ?? "").toString(),
            SizeName: (raw.SizeName ?? raw["Size Name"] ?? "").toString(),
            ColorName: (raw.ColorName ?? raw["Color Name"] ?? "").toString(),
            SizeCode: (raw.SizeCode ?? raw["Size Code"] ?? raw.size_code ?? "").toString(),
            ColorCode: (raw.ColorCode ?? raw["Color Code"] ?? raw.color_code ?? "").toString(),
            JanCD: fixExcelNumber(raw.JanCD ?? raw["Jan Code"] ?? raw["JAN"] ?? ""),
            Quantity: (raw.Quantity ?? raw["Qty"] ?? raw["Quantity"] ?? "").toString(),
        };

        // Trim safely
        const Item_Code = row.Item_Code.trim();
        const SizeName = row.SizeName.trim();
        const ColorName = row.ColorName.trim();
        const SizeCode = row.SizeCode.trim();
        const ColorCode = row.ColorCode.trim();
        const JanCD = row.JanCD.trim();
        const Quantity = row.Quantity.trim();

        // -----------------------------
        // 1. Item_Code
        // -----------------------------
        if (!Item_Code) {
            errors.push("Item Code is required");
        } else {
            if (spaceRegex.test(Item_Code)) errors.push("Item Code cannot contain spaces");
            if (jpRegex.test(Item_Code)) errors.push("Item Code cannot contain Japanese characters");
        }

        // -----------------------------
        // 2. Size Name
        // -----------------------------
        if (!SizeName) errors.push("Size Name is required");
        else if (SizeName.length > 50) errors.push("Size Name max length is 50");

        // -----------------------------
        // 3. Color Name
        // -----------------------------
        if (!ColorName) errors.push("Color Name is required");
        else if (ColorName.length > 50) errors.push("Color Name max length is 50");

        // -----------------------------
        // 4. Size Code
        // -----------------------------
        if (!SizeCode) errors.push("Size Code is required");
        else if (!/^[0-9]+$/.test(SizeCode)) errors.push("Size Code must be digits only");

        // -----------------------------
        // 5. Color Code
        // -----------------------------
        if (!ColorCode) errors.push("Color Code is required");
        else if (!/^[0-9]+$/.test(ColorCode)) errors.push("Color Code must be digits only");

        // -----------------------------
        // 6. Jan Code
        // -----------------------------
        if (JanCD !== "") {
            if (!/^[0-9]+$/.test(JanCD)) {
                errors.push("JAN Code must contain digits only");
            } else if (!(JanCD.length === 8 || JanCD.length === 13)) {
                errors.push(`JAN Code must be 8 or 13 digits (got ${JanCD.length})`);
            }
        }

        // -----------------------------
        // 7. Quantity
        // -----------------------------
        if (!Quantity) {
            errors.push("Quantity is required");
        } else if (!/^[0-9]+$/.test(Quantity)) {
            errors.push("Quantity must be a number");
        } else if (parseInt(Quantity) === 0) {
            warnings.push("Quantity is zero — check if intentional");
        }

        let status = "Valid";
        if (errors.length > 0) status = "Error";
        else if (warnings.length > 0) status = "Warning";

        return {
            lineNo,
            ...row,
            errors,
            warnings,
            status
        };
    });
}

function parseAndValidateSKU(file) {
    const reader = new FileReader();

    reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        const firstSheet = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheet];

        const importedData = XLSX.utils.sheet_to_json(worksheet);

        // Validate (SKU version)
        const validatedRows = validateSKUImported(importedData);

        // Save to session for preview page
        sessionStorage.setItem('skuPreviewData', JSON.stringify(validatedRows));

        // Status counts
        const hasError = validatedRows.some(r => r.status === "Error");
        const hasWarning = validatedRows.some(r => r.status === "Warning");

        let message = "";

    

        // Redirect to SKU preview page
        window.location.href = '/skuPreview';
    };

    reader.readAsArrayBuffer(file);
}
