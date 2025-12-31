<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guarantor Form - {{ $loanProposal->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h3 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Guarantor Form</h1>
        <p>Loan Proposal ID: {{ $loanProposal->id }}</p>
        <p>Member: {{ $loanProposal->member->name }}</p>
    </div>

    <div class="section">
        <h3>Loan Details</h3>
        <table>
            <tr>
                <td><strong>Proposed Amount:</strong></td>
                <td>{{ number_format($loanProposal->proposed_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Business Type:</strong></td>
                <td>{{ $loanProposal->business_type }}</td>
            </tr>
            <tr>
                <td><strong>Proposal Date:</strong></td>
                <td>{{ $loanProposal->loan_proposal_date ? \Carbon\Carbon::parse($loanProposal->loan_proposal_date)->format('M d, Y') : \Carbon\Carbon::parse($loanProposal->created_at)->format('M d, Y') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Guarantor Information</h3>
        @if ($loanProposal->guarantors->count() > 0)
            @foreach ($loanProposal->guarantors as $guarantor)
                <div style="margin-bottom: 20px; border: 1px solid #ddd; padding: 15px;">
                    <h4>Guarantor {{ $loop->iteration }}</h4>
                    <table>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $guarantor->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Guardian Name:</strong></td>
                            <td>{{ $guarantor->guardian_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $guarantor->address }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $guarantor->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Relationship:</strong></td>
                            <td>{{ $guarantor->relationship ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Occupation:</strong></td>
                            <td>{{ $guarantor->occupation ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Monthly Income:</strong></td>
                            <td>{{ $guarantor->monthly_income ? number_format($guarantor->monthly_income, 2) : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Assets:</strong></td>
                            <td>{{ $guarantor->assets ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        @else
            <p>No guarantors found for this loan proposal.</p>
        @endif
    </div>

    <div class="section">
        <h3>Declaration</h3>
        <p>I hereby declare that I am willing to guarantee the loan amount mentioned above and understand that I will be
            responsible for repayment in case the borrower fails to pay.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Guarantor Signature</p>
            <br><br><br>
            <p>___________________________</p>
            <p>Date: _______________</p>
        </div>
        <div class="signature-box">
            <p>Witness Signature</p>
            <br><br><br>
            <p>___________________________</p>
            <p>Date: _______________</p>
        </div>
    </div>

    <div class="section">
        <p><em>Generated on: {{ now()->format('M d, Y H:i') }}</em></p>
    </div>
</body>

</html>
