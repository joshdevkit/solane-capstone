<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report</title>
    <style>
        /* General styling */
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
        }

        /* Main container */
        .report-container {
            padding: 3rem;
            margin: 0 auto;
            max-width: 100%;
        }

        /* Report Header */
        .report-header {
            background-color: #2b6cb0;
            /* Blue color */
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .report-header h1 {
            margin: 0;
        }

        /* Report Period */
        .report-period {
            background-color: #e2e8f0;
            /* Light Gray */
            color: #2b6cb0;
            padding: 0.5rem;
            font-weight: bold;
            text-align: center;
            margin-top: 1rem;
        }

        /* Report Subheader */
        .report-subheader {
            background-color: #2b6cb0;
            /* Blue color */
            color: white;
            padding: 1rem;
            text-align: center;
            margin-top: 2rem;
            font-weight: bold;
        }

        /* Table Styling */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .report-table th,
        .report-table td {
            padding: 1rem;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .report-table th {
            background-color: #edf2f7;
            font-weight: bold;
        }

        .report-table tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .report-table tr:hover {
            background-color: #e2e8f0;
        }


        .report-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            font-size: 1rem;
            font-weight: bold;
            color: #2b6cb0;
        }

        .stats-left {
            text-align: left;
        }

        .stats-right {
            text-align: right;
        }

        .report-date-time {
            font-size: 12px;
            font-weight: bold;
            color: #2b6cb0;
        }
    </style>
</head>

<body>

    <div class="report-container">
        <div class="report-header">
            <h1>PURCHASE REPORT</h1>
        </div>
        <div class="report-period">
            REPORT PERIOD: {{ date('F d, Y', strtotime($startDate)) }} - {{ date('F d, Y', strtotime($endDate)) }}
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reference No</th>
                    <th>Supplier</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalAmount = 0; // Initialize total amount variable
                @endphp
                @foreach ($purchase as $pcs)
                    @php
                        $totalAmountRow = $pcs->quantity * $pcs->products->price;
                        $totalAmount += $totalAmountRow;
                    @endphp
                    <tr>
                        <td>{{ date('F d, Y', strtotime($pcs->created_at)) }}</td>
                        <td>{{ $pcs->purchase_no }}</td>
                        <td>{{ $pcs->supplier->name }}</td>
                        <td>{{ $pcs->products->name }}</td>
                        <td>{{ $pcs->quantity }}</td>
                        <td>{{ number_format($pcs->products->price, 2) }}</td>
                        <td>{{ number_format($totalAmountRow, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>


        <div class="report-stats">
            <div class="stats-left">
                <div class="report-date-time">
                    Report Generated On: {{ date('F d, Y h:i A') }}
                </div>
            </div>
            <div class="stats-right">
                <p><strong>Total Amount:</strong> {{ number_format($totalAmount, 2) }}</p>
                <p><strong>Total Quantity:</strong> {{ $totalQuantity }}</p>
            </div>


        </div>
    </div>



</body>

</html>
