<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Savings Withdrawal Voucher</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            width: 700px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        h3 {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #1a202c;
        }

        .details p {
            font-size: 16px;
            line-height: 1.6;
            margin: 8px 0;
        }

        .details p strong {
            width: 150px;
            display: inline-block;
            color: #1a202c;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .footer .signature {
            text-align: center;
        }

        .footer .signature span {
            display: block;
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-weight: 600;
        }

        @media print {
            body {
                background-color: #fff;
            }

            .container {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Savings Withdrawal Voucher</h3>

        <div class="details">
            <p><strong>Member:</strong> {{ $withdrawal->member->name }}</p>
            <p><strong>Amount:</strong> {{ number_format($withdrawal->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($withdrawal->status) }}</p>
            <p><strong>Approved By:</strong> {{ $withdrawal->approver->name ?? 'Pending' }}</p>
            <p><strong>Date:</strong> {{ $withdrawal->approved_at ?? 'Pending' }}</p>
        </div>

        <div class="footer">
            <div class="signature">
                <span>Member Signature</span>
            </div>
            <div class="signature">
                <span>Authorized Signature</span>
            </div>
        </div>
    </div>
</body>

</html>
