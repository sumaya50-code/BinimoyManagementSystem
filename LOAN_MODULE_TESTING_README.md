# Loan Module Testing Suite

This document provides comprehensive testing coverage for the entire loan module in the Binimoy Management System.

## Overview

The loan module testing suite includes:
- **Unit Tests**: Testing individual models and their methods
- **Feature Tests**: Testing controllers and full workflows
- **Integration Tests**: Testing complete loan lifecycle
- **Edge Case Tests**: Testing boundary conditions and error scenarios
- **Manual Test Scripts**: Quick validation scripts for development

## Test Structure

```
tests/
├── Unit/
│   ├── LoanModelTest.php              # Loan model functionality
│   ├── LoanInstallmentModelTest.php   # Installment model relationships
│   └── PreviousLoanModelTest.php      # Previous loan model
├── Feature/
│   ├── LoanControllerTest.php         # Loan management operations
│   └── EdgeCasesTest.php              # Edge cases and error handling
database/factories/
├── LoanProposalFactory.php            # Loan proposal factory
├── LoanInstallmentFactory.php         # Installment factory
└── PreviousLoanFactory.php            # Previous loan factory

run_loan_tests.php                     # Manual test runner
LOAN_MODULE_TESTING_README.md          # This documentation
```

## Test Categories

### 1. Unit Tests

#### LoanModelTest
- **Installment Generation**: Verifies correct installment creation with proper amounts and dates
- **Model Relationships**: Tests relationships between Loan, LoanProposal, and Member models
- **Installment Calculations**: Validates principal and interest distribution

#### LoanInstallmentModelTest
- **Relationships**: Tests belongs-to relationship with Loan and has-many with Collections
- **Payment Tracking**: Verifies paid amount updates and status changes
- **Penalty Application**: Tests penalty amount storage and overdue status

#### PreviousLoanModelTest
- **Data Storage**: Tests all fillable attributes are properly stored
- **Status Validation**: Verifies different loan statuses (active, completed, defaulted)

### 2. Feature Tests

#### LoanControllerTest
- **Loan Management**: CRUD operations for loans
- **Disbursement Logic**: Tests loan disbursement with fund validation
- **Collection Verification**: Tests installment collection and verification process
- **Penalty Calculation**: Automatic penalty application for overdue installments

#### EdgeCasesTest
- **Insufficient Funds**: Tests disbursement rejection when company fund is low
- **Invalid Workflows**: Tests rejection of invalid approval state transitions
- **Partial Payments**: Tests handling of partial installment payments
- **Zero Values**: Tests edge cases with zero amounts and rates
- **Duplicate Operations**: Prevents double disbursement and verification

### 3. Integration Tests (Manual Runner)

#### Business Rule Validation
- **Savings Requirements**: Minimum 10% savings balance validation
- **Previous Loan Status**: Rejection of proposals with defaulted previous loans
- **Fund Availability**: Company fund balance checks before disbursement

#### Financial Calculations
- **Interest Calculation**: Proper interest distribution across installments
- **Penalty Application**: Correct penalty calculation for overdue installments
- **Balance Updates**: Accurate tracking of loan remaining amounts

#### Workflow Integrity
- **State Transitions**: Valid approval workflow state changes
- **Fund Management**: Company fund and cash asset balance changes
- **Audit Trail**: Complete audit trail for all financial operations

## Running Tests

### PHPUnit Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Unit/LoanModelTest.php

# Run with coverage
php artisan test --coverage
```

### Manual Test Script
```bash
# Run comprehensive manual tests
php run_loan_tests.php
```

### Individual Test Scripts
```bash
# Test loan proposal form
php test_loan_proposal_form.php

# Test loan flow
php test_loan_flow.php

# Test edge cases
php test_edge_cases.php
```

## Test Data Setup

The tests use Laravel model factories to create consistent test data:

- **Members**: Created with valid personal information
- **Loan Proposals**: Various statuses (pending, approved, rejected)
- **Loans**: Different states (active, completed, overdue)
- **Installments**: Various payment statuses and amounts
- **Company Funds**: Initialized with sufficient balances for testing

## Key Test Scenarios

### Happy Path Scenarios
1. **Complete Loan Lifecycle**:
   - Proposal creation → Approval workflow → Disbursement → Collections → Completion

2. **Standard Installment Payment**:
   - Full payment of installment amount
   - Status update to 'paid'
   - Loan remaining amount reduction

3. **Approval Workflow**:
   - Sequential approval through all required stages
   - Proper status transitions

### Edge Cases
1. **Insufficient Savings**: Proposal rejected when savings < 10% of loan amount
2. **Defaulted History**: Proposal rejected for members with defaulted previous loans
3. **Fund Shortage**: Disbursement blocked when company fund balance is insufficient
4. **Partial Payments**: Multiple partial payments summing to full installment amount
5. **Overdue Penalties**: Automatic penalty calculation and application
6. **Zero Interest Loans**: Proper handling of interest-free loans

### Error Scenarios
1. **Invalid State Transitions**: Attempting to approve already approved proposals
2. **Duplicate Operations**: Prevention of double disbursement/verification
3. **Invalid Amounts**: Rejection of zero or negative amounts

## Test Coverage Metrics

### Models (100% Coverage Target)
- ✅ Loan: Relationships, installment generation, calculations
- ✅ LoanInstallment: Payment tracking, penalty application
- ✅ PreviousLoan: Data integrity, status validation

### Controllers (95% Coverage Target)
- ✅ LoanController: Management, disbursement, collections
- ✅ Business logic integration

### Business Rules (100% Coverage Target)
- ✅ Savings validation (10% minimum)
- ✅ Previous loan status checks
- ✅ Fund availability validation

### Edge Cases (90% Coverage Target)
- ✅ Boundary value testing
- ✅ Error condition handling
- ✅ Invalid input validation

## Manual Test Runner Results

The `run_loan_tests.php` script provides 10 comprehensive test scenarios:

1. **Model Relationships** - Verifies proper model associations
2. **Installment Generation** - Tests automatic installment creation
3. **Approval Workflow** - Validates multi-step approval process
4. **Business Rule: Insufficient Savings** - Tests savings validation
5. **Business Rule: Defaulted Previous Loan** - Tests loan history validation
6. **Loan Disbursement** - Tests fund transfers and installment creation
7. **Collection and Verification** - Tests payment processing
8. **Penalty Application** - Tests overdue penalty calculations
9. **Zero Interest Rate** - Tests interest-free loan handling
10. **Partial Payments** - Tests multiple payment handling

## Continuous Integration

### Recommended CI Pipeline
```yaml
name: Loan Module Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test --coverage
```

## Maintenance Guidelines

### Adding New Tests
1. **Identify Test Type**: Unit, Feature, or Integration
2. **Follow Naming Convention**: `TestClassTest.php`
3. **Use Factories**: Leverage existing model factories for data creation
4. **Test Isolation**: Each test should be independent with proper cleanup
5. **Coverage Goals**: Aim for >90% code coverage

### Test Data Management
1. **Factory Usage**: Use factories for consistent, realistic test data
2. **Cleanup**: Implement proper teardown to avoid test pollution
3. **Seed Data**: Use database seeders for complex relationship setups

## Troubleshooting

### Common Issues
1. **Factory Errors**: Ensure all required model factories exist
2. **Permission Errors**: Set up proper user roles and permissions in tests
3. **Database Constraints**: Handle foreign key constraints in test cleanup

### Debug Tips
1. **Verbose Output**: Use `--verbose` flag for detailed test output
2. **Single Test Focus**: Run individual tests with `php artisan test --filter TestName`
3. **Database Inspection**: Check test database state with tinker

## Future Enhancements

### Planned Improvements
1. **API Testing**: Add comprehensive API endpoint tests
2. **Performance Testing**: Load testing for high-volume scenarios
3. **Security Testing**: Authorization and authentication validation
4. **Browser Testing**: JavaScript and frontend interaction tests

---

## Quick Start

1. **Install Dependencies**:
   ```bash
   composer install
   ```

2. **Run Database Migrations**:
   ```bash
   php artisan migrate
   ```

3. **Execute Test Suite**:
   ```bash
   php artisan test
   ```

4. **Run Manual Tests**:
   ```bash
   php run_loan_tests.php
   ```

The loan module testing suite provides comprehensive coverage ensuring reliability, maintainability, and confidence in the loan management functionality.
