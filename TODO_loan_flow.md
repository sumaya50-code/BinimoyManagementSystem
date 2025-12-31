# TODO: Implement Loan Management Flow

## Migration Tasks
- [ ] Run existing migrations for loan proposals and guarantors

## Model Updates
- [ ] Update LoanProposal model if needed for new fields

## Controller Updates
- [x] Remove guarantor handling from LoanProposalController store/update
- [x] Create LoanGuarantorController with CRUD for guarantors per proposal (already exists)
- [x] Add generatePdf method in LoanProposalController
- [x] Add disburse form in proposal show view (linked to loans.create with proposal_id)

## View Updates
- [x] Update loan_proposals/show.blade.php to add disburse button when approved
- [x] Update loan_proposals/show.blade.php to link to manage guarantors
- [x] Create views for loan_guarantors (index, create, edit, show) (already exist)
- [x] Update pdf.blade.php if needed

## Route Updates
- [ ] Update routes/web.php for loan_guarantors and PDF

## Package Installation
- [ ] Install dompdf package

## Followup Steps
- [ ] Test proposal creation without guarantors
- [ ] Test guarantor CRUD
- [ ] Test approval workflow
- [ ] Test disbursement
- [ ] Test PDF generation
- [ ] Test penalty processing
