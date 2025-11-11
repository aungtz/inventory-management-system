<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Stocks PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }
    </style>
</head>

<body>
    <h2>Stock List</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Low Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->product_name }}</td>
                <td>{{ $stock->category }}</td>
                <td>{{ $stock->sku }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>${{ number_format($stock->unit_price, 2) }}</td>
                <td>{{ $stock->low_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>