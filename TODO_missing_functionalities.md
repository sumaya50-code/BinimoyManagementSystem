# TODO: Implement Missing Functionalities from System Flow

## 1. Investment Withdrawal for Partners
- [x] Create InvestmentWithdrawalRequest model and migration
- [x] Add withdrawal request form in InvestmentApplicationController
- [x] Add approval method for investment withdrawals
- [x] Update Partner model to handle capital reduction
- [x] Create views for investment withdrawal requests
- [x] Update routes for investment withdrawals

## 2. Multi-Level Loan Approval Workflow
- [x] Update LoanProposalController to handle workflow steps (audit, manager, area manager)
- [x] Add methods for each approval stage in LoanProposalController
- [x] Create views for each approval stage
- [x] Update loan_proposals show view with workflow buttons
- [x] Add permissions for different approval levels
- [x] Test the full workflow

## 3. Collection Reports
- [x] Add collectionReports method to ReportsController
- [x] Create views for officer-wise, date-wise, and overdue collection reports
- [x] Add export functionality (PDF, Excel) for collection reports
- [x] Update routes for collection reports

## 4. Expense Tracking
- [x] Create Expense model and migration
- [x] Create ExpenseController with CRUD operations
- [x] Add expense categories
- [x] Integrate expenses into CompanyFund and CashAsset
- [x] Add expense tracking to financial reports
- [x] Create views for expense management

## 5. Partner Capital Withdrawal
- [x] Create PartnerWithdrawalRequest model and migration
- [x] Add withdrawal request form in PartnerController
- [x] Add approval method for capital withdrawals
- [x] Update Partner model to handle capital withdrawal
- [x] Create views for partner withdrawal requests
- [x] Update routes for partner withdrawals

## Followup Steps
- [x] Test all new functionalities
- [x] Update permissions and roles if needed
- [x] Run migrations
- [x] Verify integration with existing cash flow and company fund
