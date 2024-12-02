@php
    $setting = app(\App\Services\Setting\SettingService::class)->getSetting();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .title {
            color: #387eff;
            text-transform: uppercase
        }

        h1 {
            color: #2c3e50;
            margin: 0;
        }

        .report-info {
            margin-bottom: 20px;
        }

        .report-info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }

        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <h1 class="title">{{ $setting['app_title'] }}</h1>
            <h1>{{ $title }}</h1>
        </div>
    </div>

    <div class="report-info">
        @if (!empty($filters['periods']) && $filters['periods'] !== 'custom')
            <p><strong>Transaction Period:</strong> {{ $filters['periods'] }}</p>
        @elseif(!empty($filters['start_date']) && !empty($filters['end_date']))
            <p><strong>Transaction Period:</strong>
                {{ \Carbon\Carbon::parse($filters['start_date'])->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($filters['end_date'])->format('d M Y') }}
            </p>
        @else
            <p><strong>Transaction Period:</strong> All Transactions</p>
        @endif

        @if (!empty($filters['categories']))
            <p><strong>Category:</strong> {{ $filters['categories_name'] ?? 'Unknown' }}</p>
        @else
            <p><strong>Category:</strong> All Categories</p>
        @endif

        <p><strong>Generated on:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Product</th>
                <th>Category</th>
                <th>User</th>
                <th>Quantity</th>
                <th>Supplier</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->products->name }}</td>
                    <td>{{ $item->products->categories->name }}</td>
                    <td>{{ $item->users->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->products->suppliers->name }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->notes ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem Manajemen Inventori.
            <br />
        {{ $setting['app_title'] }} &copy; 2024 Semua hak dilindungi.</p>
    </div>
</body>

</html>
