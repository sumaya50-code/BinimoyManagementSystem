<?php

use App\Http\Controllers\AuditLogController;

use App\Http\Controllers\CashAssetController;
use App\Http\Controllers\CompanyFundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestmentApplicationController;
use App\Http\Controllers\LoanCollectionController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanGuarantorController;
use App\Http\Controllers\LoanInstallmentController;
use App\Http\Controllers\LoanProposalController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationLogController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::get('/roles-data', [RoleController::class, 'getData'])->name('roles.data');



    Route::resource('products', ProductController::class);
    Route::get('members/data', [MemberController::class, 'getData'])->name('members.data');
    Route::get('members/summary', [MemberController::class, 'summary'])->name('members.summary');
    Route::get('members/summary-data', [MemberController::class, 'summaryData'])->name('members.summary.data');
    Route::resource('members', MemberController::class);
    Route::get('members/{member}/toggle-status', [MemberController::class, 'toggleStatus'])
        ->name('members.toggleStatus');


    Route::get('/users-data', [UserController::class, 'getUsers'])->name('users.data');
    Route::resource('users', UserController::class);



    Route::resource('loans', LoanController::class);
    Route::get('/loans-data', [LoanController::class, 'getData'])->name('loans.data');

    Route::get('loan_proposals/get-savings-balance', [LoanProposalController::class, 'getSavingsBalance'])->name('loan_proposals.get_savings_balance');
    Route::resource('loan_proposals', LoanProposalController::class);
    Route::get('/loan-proposals-data', [LoanProposalController::class, 'getData'])->name('loan_proposals.data');
    Route::get('loan_proposals/{loanProposal}/pdf', [LoanProposalController::class, 'generatePdf'])->name('loan_proposals.pdf');
    Route::get('loan_proposals/{loanProposal}/guarantor-pdf', [LoanProposalController::class, 'generateGuarantorPdf'])->name('loan_proposals.guarantor_pdf');

    // Loan proposal approval workflow
    Route::patch('loan_proposals/{loanProposal}/submit_audit', [LoanProposalController::class, 'submitForAudit'])->name('loan_proposals.submit_audit');
    Route::patch('loan_proposals/{loanProposal}/approve_audit', [LoanProposalController::class, 'approveAudit'])->name('loan_proposals.approve_audit');
    Route::patch('loan_proposals/{loanProposal}/reject_audit', [LoanProposalController::class, 'rejectAudit'])->name('loan_proposals.reject_audit');
    Route::patch('loan_proposals/{loanProposal}/approve_manager', [LoanProposalController::class, 'approveManagerReview'])->name('loan_proposals.approve_manager');
    Route::patch('loan_proposals/{loanProposal}/reject_manager', [LoanProposalController::class, 'rejectManagerReview'])->name('loan_proposals.reject_manager');
    Route::patch('loan_proposals/{loanProposal}/approve_area', [LoanProposalController::class, 'approveAreaManager'])->name('loan_proposals.approve_area');
    Route::patch('loan_proposals/{loanProposal}/reject_area', [LoanProposalController::class, 'rejectAreaManager'])->name('loan_proposals.reject_area');

    // Loan proposal approval and disbursement
    Route::post('loans/proposal/{id}/approve', [LoanController::class, 'approveProposal'])->name('loans.proposal.approve');
    Route::post('loans/proposal/{id}/disburse', [LoanController::class, 'disburse'])->name('loans.proposal.disburse');

    // Loan collections: field officer entry and admin verification
    Route::post('loan-collections', [LoanController::class, 'collectInstallment'])->name('loan.collections.store');
    Route::post('loan-collections/{id}/verify', [LoanController::class, 'verifyCollection'])->name('loan.collections.verify');

    // Resource routes for newly scaffolded modules
    Route::resource('partners', PartnerController::class);
    Route::resource('loan_guarantors', LoanGuarantorController::class);
    Route::resource('loan_installments', LoanInstallmentController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('loan_collections', LoanCollectionController::class)->only(['index', 'show', 'create', 'destroy']);

    // Field officer collection submission handled by LoanController.collectInstallment
    Route::post('loan-collections', [\App\Http\Controllers\LoanController::class, 'collectInstallment'])->name('loan.collections.store');
    Route::resource('cash_assets', CashAssetController::class);

    // Custom manual approval / interest / withdrawal routes (defined before resource to avoid conflicts)
    Route::get('admin/savings/deposit-approve/{id}', [SavingsController::class, 'approveDeposit'])->name('savings.approveDeposit');
    Route::post('admin/savings/post-interest', [SavingsController::class, 'postInterest'])->name('savings.postInterest');
    Route::get('admin/savings/withdrawals', [SavingsController::class, 'withdrawals'])->name('savings.withdrawals');
    Route::post('admin/savings/withdraw-request', [SavingsController::class, 'withdrawalRequest'])->name('savings.withdrawRequest');
    Route::get('admin/savings/withdraw-approve/{id}', [SavingsController::class, 'approveWithdrawal'])->name('savings.approveWithdrawal');
    Route::get('admin/savings/voucher/{id}', [SavingsController::class, 'voucher'])->name('savings.voucher');
    Route::get('admin/savings/statement/{memberId}', [SavingsController::class, 'statement'])->name('savings.statement');
    Route::get('admin/savings/pending-deposits-data', [SavingsController::class, 'getPendingDepositsData'])->name('savings.pendingDepositsData');
    Route::get('admin/savings/summary', [SavingsController::class, 'summary'])->name('savings.summary');

    Route::resource('admin/savings', SavingsController::class);

    // Company fund & admin logs
    Route::get('admin/company-fund', [\App\Http\Controllers\CompanyFundController::class, 'index'])->name('companyfund.index');
    Route::get('admin/notifications', [\App\Http\Controllers\NotificationLogController::class, 'index'])->name('notifications.index');
    Route::get('admin/audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit_logs.index');

    // Investments
    Route::resource('investments', InvestmentApplicationController::class)->except(['edit', 'update', 'destroy']);
    Route::post('investments/{id}/approve', [InvestmentApplicationController::class, 'approve'])->name('investments.approve');

    // Investment Withdrawals
    Route::get('investments/withdrawals', [InvestmentApplicationController::class, 'withdrawals'])->name('investments.withdrawals');
    Route::get('investments/request-withdrawal', [InvestmentApplicationController::class, 'requestWithdrawal'])->name('investments.request_withdrawal');
    Route::post('investments/store-withdrawal', [InvestmentApplicationController::class, 'storeWithdrawal'])->name('investments.store_withdrawal');
    Route::post('investments/{id}/approve-withdrawal', [InvestmentApplicationController::class, 'approveWithdrawal'])->name('investments.approve_withdrawal');

    // Withdrawals
    Route::resource('withdrawals', WithdrawalController::class)->except(['edit', 'update']);
    Route::post('withdrawals/{id}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');

    // Reports
    Route::get('admin/reports/profit-loss', [\App\Http\Controllers\ReportsController::class, 'profitLoss'])->name('reports.profit_loss');
    Route::get('admin/reports/balance-sheet', [\App\Http\Controllers\ReportsController::class, 'balanceSheet'])->name('reports.balance_sheet');
    Route::get('admin/reports/cash-flow', [\App\Http\Controllers\ReportsController::class, 'cashFlow'])->name('reports.cash_flow');
    Route::get('admin/reports/collections', [\App\Http\Controllers\ReportsController::class, 'collectionReport'])->name('reports.collections');
});
