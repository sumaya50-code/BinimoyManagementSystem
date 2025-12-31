<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Proposal - {{ $loanProposal->id }}</title>
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

        .guarantor-table {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Loan Proposal Form</h1>
        <p>Proposal ID: {{ $loanProposal->id }}</p>
    </div>

    <div class="section">
        <h3>Member Information</h3>
        <table>
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $loanProposal->member->name }}</td>
            </tr>
            <tr>
                <td><strong>Member ID:</strong></td>
                <td>{{ $loanProposal->member->id }}</td>
            </tr>
            <tr>
                <td><strong>Admission Date:</strong></td>
                <td>{{ $loanProposal->member->admission_date ? \Carbon\Carbon::parse($loanProposal->member->admission_date)->format('M d, Y') : 'N/A' }}
                </td>
            </tr>
        </table>
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
            <tr>
                <td><strong>Savings Balance:</strong></td>
                <td>{{ $loanProposal->savings_balance ? number_format($loanProposal->savings_balance, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>DPS Balance:</strong></td>
                <td>{{ $loanProposal->dps_balance ? number_format($loanProposal->dps_balance, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>{{ ucfirst(str_replace('_', ' ', $loanProposal->status)) }}</td>
            </tr>
        </table>
    </div>



    <div class="section">
        <h3>Approval Status</h3>
        <p>Current Status: {{ ucfirst(str_replace('_', ' ', $loanProposal->status)) }}</p>
        @if ($loanProposal->audit_approved_at)
            <p>Audit Approved: {{ \Carbon\Carbon::parse($loanProposal->audit_approved_at)->format('M d, Y H:i') }}</p>
        @endif
        @if ($loanProposal->manager_review_approved_at)
            <p>Manager Review Approved:
                {{ \Carbon\Carbon::parse($loanProposal->manager_review_approved_at)->format('M d, Y H:i') }}</p>
        @endif
        @if ($loanProposal->area_manager_approved_at)
            <p>Area Manager Approved:
                {{ \Carbon\Carbon::parse($loanProposal->area_manager_approved_at)->format('M d, Y H:i') }}</p>
        @endif
    </div>

    <div class="section">
        <p><em>Generated on: {{ now()->format('M d, Y H:i') }}</em></p>
    </div>
</body>

</html>
