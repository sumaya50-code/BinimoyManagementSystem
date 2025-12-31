-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 01:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bnsnewdbtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `auditable_type` varchar(255) DEFAULT NULL,
  `auditable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `auditable_type`, `auditable_id`, `action`, `old_values`, `new_values`, `ip`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'login', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:01:04', '2025-12-30 06:01:04'),
(2, 1, 'App\\Models\\Member', 1, 'created', NULL, '{\"name\":\"Abdul Karim\",\"guardian_name\":\"Late Abdul Hakim\",\"nid\":\"1993657821456\",\"phone\":\"01690253986\",\"email\":\"lammi8776@gmail.com\",\"present_address\":\"uttara 10\",\"permanent_address\":\"CTG\",\"nominee_name\":\"Rokaya Bagum\",\"nominee_relation\":\"wife\",\"gender\":\"Male\",\"dob\":\"1995-04-05\",\"marital_status\":\"Married\",\"education\":\"HSC\",\"dependents\":\"2\",\"member_no\":\"M00001\",\"status\":\"Active\",\"updated_at\":\"2025-12-30T12:02:42.000000Z\",\"created_at\":\"2025-12-30T12:02:42.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:02:42', '2025-12-30 06:02:42'),
(3, 1, 'App\\Models\\Member', 2, 'created', NULL, '{\"name\":\"Mira Khan\",\"guardian_name\":\"Kobir Zamman\",\"nid\":\"1993657821458\",\"phone\":\"01790253986\",\"email\":\"mira2@gmail.com\",\"present_address\":\"Mirpur 12\",\"permanent_address\":\"Mirpur 12\",\"nominee_name\":\"Sharifa Khatun\",\"nominee_relation\":\"Mother\",\"gender\":\"Female\",\"dob\":\"1997-12-15\",\"marital_status\":\"Single\",\"education\":\"MSC\",\"dependents\":\"1\",\"member_no\":\"M00002\",\"status\":\"Active\",\"updated_at\":\"2025-12-30T12:04:25.000000Z\",\"created_at\":\"2025-12-30T12:04:25.000000Z\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:25', '2025-12-30 06:04:25'),
(4, 1, 'App\\Models\\SavingsAccount', 1, 'created', NULL, '{\"member_id\":\"1\",\"balance\":0,\"interest_rate\":5,\"updated_at\":\"2025-12-30T12:04:51.000000Z\",\"created_at\":\"2025-12-30T12:04:51.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:51', '2025-12-30 06:04:51'),
(5, 1, 'App\\Models\\SavingsAccount', 1, 'updated', '[]', '{\"member_id\":\"1\",\"balance\":0,\"interest_rate\":5,\"updated_at\":\"2025-12-30 12:04:51\",\"created_at\":\"2025-12-30 12:04:51\",\"id\":1,\"account_no\":\"SA000001\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:51', '2025-12-30 06:04:51'),
(6, 1, 'App\\Models\\SavingsTransaction', 1, 'created', NULL, '{\"savings_account_id\":1,\"type\":\"deposit\",\"amount\":\"8000000\",\"remarks\":\"Savings Deposit\",\"status\":\"pending\",\"transaction_date\":\"2025-12-30T12:04:51.051209Z\",\"updated_at\":\"2025-12-30T12:04:51.000000Z\",\"created_at\":\"2025-12-30T12:04:51.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:51', '2025-12-30 06:04:51'),
(7, 1, 'App\\Models\\SavingsTransaction', 1, 'updated', '{\"id\":1,\"savings_account_id\":1,\"type\":\"deposit\",\"amount\":\"8000000.00\",\"remarks\":\"Savings Deposit\",\"status\":\"pending\",\"transaction_date\":\"2025-12-30\",\"created_at\":\"2025-12-30T12:04:51.000000Z\",\"updated_at\":\"2025-12-30T12:04:51.000000Z\"}', '{\"status\":\"approved\",\"updated_at\":\"2025-12-30 12:04:56\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:56', '2025-12-30 06:04:56'),
(8, 1, 'App\\Models\\SavingsAccount', 1, 'updated', '{\"id\":1,\"account_no\":\"SA000001\",\"member_id\":1,\"balance\":\"0.00\",\"interest_rate\":\"5.00\",\"created_at\":\"2025-12-30T12:04:51.000000Z\",\"updated_at\":\"2025-12-30T12:04:51.000000Z\"}', '{\"balance\":8000000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:56', '2025-12-30 06:04:56'),
(9, 1, 'App\\Models\\CompanyFund', 1, 'updated', '{\"id\":1,\"balance\":\"0.00\",\"created_at\":\"2025-12-30T11:59:33.000000Z\",\"updated_at\":\"2025-12-30T11:59:33.000000Z\"}', '{\"balance\":8000000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:04:56', '2025-12-30 06:04:56'),
(10, 1, 'App\\Models\\SavingsAccount', 2, 'created', NULL, '{\"member_id\":\"2\",\"balance\":0,\"interest_rate\":5,\"updated_at\":\"2025-12-30T12:05:10.000000Z\",\"created_at\":\"2025-12-30T12:05:10.000000Z\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:05:10', '2025-12-30 06:05:10'),
(11, 1, 'App\\Models\\SavingsAccount', 2, 'updated', '[]', '{\"member_id\":\"2\",\"balance\":0,\"interest_rate\":5,\"updated_at\":\"2025-12-30 12:05:10\",\"created_at\":\"2025-12-30 12:05:10\",\"id\":2,\"account_no\":\"SA000002\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:05:10', '2025-12-30 06:05:10'),
(12, 1, 'App\\Models\\SavingsTransaction', 2, 'created', NULL, '{\"savings_account_id\":2,\"type\":\"deposit\",\"amount\":\"12000000\",\"remarks\":\"Savings Deposit\",\"status\":\"pending\",\"transaction_date\":\"2025-12-30T12:05:10.886123Z\",\"updated_at\":\"2025-12-30T12:05:10.000000Z\",\"created_at\":\"2025-12-30T12:05:10.000000Z\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:05:10', '2025-12-30 06:05:10'),
(13, 1, 'App\\Models\\SavingsTransaction', 2, 'updated', '{\"id\":2,\"savings_account_id\":2,\"type\":\"deposit\",\"amount\":\"12000000.00\",\"remarks\":\"Savings Deposit\",\"status\":\"pending\",\"transaction_date\":\"2025-12-30\",\"created_at\":\"2025-12-30T12:05:10.000000Z\",\"updated_at\":\"2025-12-30T12:05:10.000000Z\"}', '{\"status\":\"approved\",\"updated_at\":\"2025-12-30 12:05:16\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:05:16', '2025-12-30 06:05:16'),
(14, 1, 'App\\Models\\SavingsAccount', 2, 'updated', '{\"id\":2,\"account_no\":\"SA000002\",\"member_id\":2,\"balance\":\"0.00\",\"interest_rate\":\"5.00\",\"created_at\":\"2025-12-30T12:05:10.000000Z\",\"updated_at\":\"2025-12-30T12:05:10.000000Z\"}', '{\"balance\":12000000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:05:16', '2025-12-30 06:05:16'),
(15, 1, 'App\\Models\\CompanyFund', 1, 'updated', '{\"id\":1,\"balance\":\"8000000.00\",\"created_at\":\"2025-12-30T11:59:33.000000Z\",\"updated_at\":\"2025-12-30T12:04:56.000000Z\"}', '{\"balance\":20000000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:05:16', '2025-12-30 06:05:16'),
(16, 1, 'App\\Models\\LoanProposal', 1, 'created', NULL, '{\"member_id\":\"1\",\"proposed_amount\":\"10000\",\"status\":\"pending\",\"business_type\":\"Retail Business\",\"loan_proposal_date\":\"2025-12-08\",\"savings_balance\":\"8000000\",\"dps_balance\":\"0\",\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"approved_amount_audit\":null,\"auditor_signature\":null,\"verified_by_manager\":null,\"approved_amount_manager\":null,\"manager_signature\":null,\"verified_by_area_manager\":null,\"approved_amount_area\":null,\"date_approved\":null,\"authorized_signatory_signature\":null,\"updated_at\":\"2025-12-30T12:07:06.000000Z\",\"created_at\":\"2025-12-30T12:07:06.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:07:06', '2025-12-30 06:07:06'),
(17, 1, 'App\\Models\\LoanProposal', 1, 'updated', '{\"id\":1,\"member_id\":1,\"proposed_amount\":\"10000.00\",\"approved_amount\":null,\"status\":\"pending\",\"business_type\":\"Retail Business\",\"created_at\":\"2025-12-30T12:07:06.000000Z\",\"updated_at\":\"2025-12-30T12:07:06.000000Z\",\"loan_proposal_date\":\"2025-12-08\",\"savings_balance\":\"8000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":null,\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', '{\"status\":\"under_audit\",\"updated_at\":\"2025-12-30 12:08:18\",\"submitted_at\":\"2025-12-30T12:08:18.501659Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:08:18', '2025-12-30 06:08:18'),
(18, 1, 'App\\Models\\LoanProposal', 1, 'updated', '{\"id\":1,\"member_id\":1,\"proposed_amount\":\"10000.00\",\"approved_amount\":null,\"status\":\"under_audit\",\"business_type\":\"Retail Business\",\"created_at\":\"2025-12-30T12:07:06.000000Z\",\"updated_at\":\"2025-12-30T12:08:18.000000Z\",\"loan_proposal_date\":\"2025-12-08\",\"savings_balance\":\"8000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":\"2025-12-30 12:08:18\",\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', '{\"status\":\"manager_review\",\"updated_at\":\"2025-12-30 12:12:50\",\"audited_at\":\"2025-12-30T12:12:50.685430Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:12:50', '2025-12-30 06:12:50'),
(19, 1, 'App\\Models\\LoanProposal', 1, 'updated', '{\"id\":1,\"member_id\":1,\"proposed_amount\":\"10000.00\",\"approved_amount\":null,\"status\":\"manager_review\",\"business_type\":\"Retail Business\",\"created_at\":\"2025-12-30T12:07:06.000000Z\",\"updated_at\":\"2025-12-30T12:12:50.000000Z\",\"loan_proposal_date\":\"2025-12-08\",\"savings_balance\":\"8000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":\"2025-12-30 12:08:18\",\"audited_at\":\"2025-12-30 12:12:50\",\"manager_approved_at\":null,\"area_manager_approved_at\":null}', '{\"status\":\"area_manager_approval\",\"updated_at\":\"2025-12-30 12:12:58\",\"manager_approved_at\":\"2025-12-30T12:12:58.689648Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:12:58', '2025-12-30 06:12:58'),
(20, 1, 'App\\Models\\LoanProposal', 1, 'updated', '{\"id\":1,\"member_id\":1,\"proposed_amount\":\"10000.00\",\"approved_amount\":null,\"status\":\"area_manager_approval\",\"business_type\":\"Retail Business\",\"created_at\":\"2025-12-30T12:07:06.000000Z\",\"updated_at\":\"2025-12-30T12:12:58.000000Z\",\"loan_proposal_date\":\"2025-12-08\",\"savings_balance\":\"8000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":\"2025-12-30 12:08:18\",\"audited_at\":\"2025-12-30 12:12:50\",\"manager_approved_at\":\"2025-12-30 12:12:58\",\"area_manager_approved_at\":null}', '{\"status\":\"approved\",\"updated_at\":\"2025-12-30 12:13:45\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(21, 1, 'App\\Models\\Loan', 1, 'created', NULL, '{\"loan_proposal_id\":1,\"member_id\":1,\"loan_amount\":\"10000.00\",\"disbursed_amount\":\"10000\",\"remaining_amount\":\"10000\",\"interest_rate\":\"2\",\"installment_count\":\"10\",\"installment_type\":\"weekly\",\"disbursement_date\":\"2025-12-30T12:13:45.707602Z\",\"status\":\"active\",\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(22, 1, 'App\\Models\\CompanyFund', 1, 'updated', '{\"id\":1,\"balance\":\"20000000.00\",\"created_at\":\"2025-12-30T11:59:33.000000Z\",\"updated_at\":\"2025-12-30T12:05:16.000000Z\"}', '{\"balance\":19990000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(23, 1, 'App\\Models\\LoanInstallment', 1, 'created', NULL, '{\"installment_no\":1,\"due_date\":\"2025-12-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(24, 1, 'App\\Models\\LoanInstallment', 2, 'created', NULL, '{\"installment_no\":2,\"due_date\":\"2026-01-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(25, 1, 'App\\Models\\LoanInstallment', 3, 'created', NULL, '{\"installment_no\":3,\"due_date\":\"2026-03-02\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":3}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(26, 1, 'App\\Models\\LoanInstallment', 4, 'created', NULL, '{\"installment_no\":4,\"due_date\":\"2026-03-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(27, 1, 'App\\Models\\LoanInstallment', 5, 'created', NULL, '{\"installment_no\":5,\"due_date\":\"2026-04-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(28, 1, 'App\\Models\\LoanInstallment', 6, 'created', NULL, '{\"installment_no\":6,\"due_date\":\"2026-05-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(29, 1, 'App\\Models\\LoanInstallment', 7, 'created', NULL, '{\"installment_no\":7,\"due_date\":\"2026-06-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(30, 1, 'App\\Models\\LoanInstallment', 8, 'created', NULL, '{\"installment_no\":8,\"due_date\":\"2026-07-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(31, 1, 'App\\Models\\LoanInstallment', 9, 'created', NULL, '{\"installment_no\":9,\"due_date\":\"2026-08-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":9}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(32, 1, 'App\\Models\\LoanInstallment', 10, 'created', NULL, '{\"installment_no\":10,\"due_date\":\"2026-09-30\",\"principal_amount\":1000,\"interest_amount\":0.56,\"amount\":1000.56,\"status\":\"pending\",\"loan_id\":1,\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"id\":10}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(33, 1, 'App\\Models\\LoanCollection', 1, 'created', NULL, '{\"loan_installment_id\":\"1\",\"collector_id\":1,\"amount\":\"1000.56\",\"status\":\"pending\",\"transaction_date\":\"2025-12-30T12:19:55.666760Z\",\"remarks\":\"good\",\"updated_at\":\"2025-12-30T12:19:55.000000Z\",\"created_at\":\"2025-12-30T12:19:55.000000Z\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:19:55', '2025-12-30 06:19:55'),
(34, 1, 'App\\Models\\LoanInstallment', 1, 'updated', '{\"id\":1,\"loan_id\":1,\"due_date\":\"2025-12-30\",\"amount\":\"1000.56\",\"status\":\"Pending\",\"created_at\":\"2025-12-30T12:13:45.000000Z\",\"updated_at\":\"2025-12-30T12:13:45.000000Z\",\"installment_no\":1,\"principal_amount\":\"1000.00\",\"interest_amount\":\"0.56\",\"paid_amount\":\"0.00\",\"penalty_amount\":\"0.00\",\"paid_at\":null}', '{\"status\":\"paid\",\"updated_at\":\"2025-12-30 12:21:36\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:21:36', '2025-12-30 06:21:36'),
(35, NULL, 'App\\Models\\LoanProposal', 2, 'created', NULL, '{\"member_id\":1,\"proposed_amount\":15000,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":\"8000000.00\",\"dps_balance\":1000,\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"approved_amount_audit\":14000,\"auditor_signature\":\"Auditor Signature 2\",\"verified_by_manager\":\"Manager Name 2\",\"approved_amount_manager\":13500,\"manager_signature\":\"Manager Signature 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"approved_amount_area\":13000,\"date_approved\":\"2024-02-05\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"updated_at\":\"2025-12-30T12:28:29.000000Z\",\"created_at\":\"2025-12-30T12:28:29.000000Z\",\"id\":2}', '127.0.0.1', 'Symfony', '2025-12-30 06:28:29', '2025-12-30 06:28:29'),
(36, NULL, 'App\\Models\\SavingsAccount', 1, 'deleted', '{\"id\":1,\"account_no\":\"SA000001\",\"member_id\":1,\"balance\":\"8000000.00\",\"interest_rate\":\"5.00\",\"created_at\":\"2025-12-30T12:04:51.000000Z\",\"updated_at\":\"2025-12-30T12:04:56.000000Z\"}', NULL, '127.0.0.1', 'Symfony', '2025-12-30 06:28:29', '2025-12-30 06:28:29'),
(37, NULL, 'App\\Models\\SavingsAccount', 3, 'created', NULL, '{\"member_id\":1,\"account_no\":\"SAV0001\",\"balance\":2000,\"updated_at\":\"2025-12-30T12:29:10.000000Z\",\"created_at\":\"2025-12-30T12:29:10.000000Z\",\"id\":3}', '127.0.0.1', 'Symfony', '2025-12-30 06:29:10', '2025-12-30 06:29:10'),
(38, NULL, 'App\\Models\\LoanProposal', 3, 'created', NULL, '{\"member_id\":1,\"proposed_amount\":15000,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":2000,\"dps_balance\":1000,\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"approved_amount_audit\":14000,\"auditor_signature\":\"Auditor Signature 2\",\"verified_by_manager\":\"Manager Name 2\",\"approved_amount_manager\":13500,\"manager_signature\":\"Manager Signature 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"approved_amount_area\":13000,\"date_approved\":\"2024-02-05\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"updated_at\":\"2025-12-30T12:29:10.000000Z\",\"created_at\":\"2025-12-30T12:29:10.000000Z\",\"id\":3}', '127.0.0.1', 'Symfony', '2025-12-30 06:29:10', '2025-12-30 06:29:10'),
(39, NULL, 'App\\Models\\SavingsAccount', 3, 'deleted', '{\"member_id\":1,\"account_no\":\"SAV0001\",\"balance\":2000,\"updated_at\":\"2025-12-30T12:29:10.000000Z\",\"created_at\":\"2025-12-30T12:29:10.000000Z\",\"id\":3}', NULL, '127.0.0.1', 'Symfony', '2025-12-30 06:29:10', '2025-12-30 06:29:10'),
(40, NULL, 'App\\Models\\SavingsAccount', 4, 'created', NULL, '{\"member_id\":1,\"account_no\":\"SAV0001\",\"balance\":2000,\"updated_at\":\"2025-12-30T12:32:20.000000Z\",\"created_at\":\"2025-12-30T12:32:20.000000Z\",\"id\":4}', '127.0.0.1', 'Symfony', '2025-12-30 06:32:21', '2025-12-30 06:32:21'),
(41, NULL, 'App\\Models\\LoanProposal', 4, 'created', NULL, '{\"member_id\":1,\"proposed_amount\":15000,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":2000,\"dps_balance\":1000,\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"approved_amount_audit\":14000,\"auditor_signature\":\"Auditor Signature 2\",\"verified_by_manager\":\"Manager Name 2\",\"approved_amount_manager\":13500,\"manager_signature\":\"Manager Signature 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"approved_amount_area\":13000,\"date_approved\":\"2024-02-05\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"updated_at\":\"2025-12-30T12:32:21.000000Z\",\"created_at\":\"2025-12-30T12:32:21.000000Z\",\"id\":4}', '127.0.0.1', 'Symfony', '2025-12-30 06:32:21', '2025-12-30 06:32:21'),
(42, NULL, 'App\\Models\\LoanProposal', 4, 'deleted', '{\"id\":4,\"member_id\":1,\"proposed_amount\":\"15000.00\",\"approved_amount\":null,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"created_at\":\"2025-12-30T12:32:21.000000Z\",\"updated_at\":\"2025-12-30T12:32:21.000000Z\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":\"2000.00\",\"dps_balance\":\"1000.00\",\"approved_amount_audit\":\"14000.00\",\"approved_amount_manager\":\"13500.00\",\"approved_amount_area\":\"13000.00\",\"auditor_signature\":\"Auditor Signature 2\",\"manager_signature\":\"Manager Signature 2\",\"area_manager_signature\":null,\"date_approved\":\"2024-02-05\",\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"verified_by_manager\":\"Manager Name 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"submitted_at\":null,\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', NULL, '127.0.0.1', 'Symfony', '2025-12-30 06:32:21', '2025-12-30 06:32:21'),
(43, NULL, 'App\\Models\\SavingsAccount', 4, 'deleted', '{\"member_id\":1,\"account_no\":\"SAV0001\",\"balance\":2000,\"updated_at\":\"2025-12-30T12:32:20.000000Z\",\"created_at\":\"2025-12-30T12:32:20.000000Z\",\"id\":4}', NULL, '127.0.0.1', 'Symfony', '2025-12-30 06:32:21', '2025-12-30 06:32:21'),
(44, NULL, 'App\\Models\\SavingsAccount', 5, 'created', NULL, '{\"member_id\":1,\"account_no\":\"SAV0001\",\"balance\":2000,\"updated_at\":\"2025-12-30T12:32:47.000000Z\",\"created_at\":\"2025-12-30T12:32:47.000000Z\",\"id\":5}', '127.0.0.1', 'Symfony', '2025-12-30 06:32:47', '2025-12-30 06:32:47'),
(45, NULL, 'App\\Models\\LoanProposal', 5, 'created', NULL, '{\"member_id\":1,\"proposed_amount\":15000,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":2000,\"dps_balance\":1000,\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"approved_amount_audit\":14000,\"auditor_signature\":\"Auditor Signature 2\",\"verified_by_manager\":\"Manager Name 2\",\"approved_amount_manager\":13500,\"manager_signature\":\"Manager Signature 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"approved_amount_area\":13000,\"date_approved\":\"2024-02-05\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"updated_at\":\"2025-12-30T12:32:47.000000Z\",\"created_at\":\"2025-12-30T12:32:47.000000Z\",\"id\":5}', '127.0.0.1', 'Symfony', '2025-12-30 06:32:47', '2025-12-30 06:32:47'),
(46, NULL, 'App\\Models\\LoanProposal', 5, 'deleted', '{\"id\":5,\"member_id\":1,\"proposed_amount\":\"15000.00\",\"approved_amount\":null,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"created_at\":\"2025-12-30T12:32:47.000000Z\",\"updated_at\":\"2025-12-30T12:32:47.000000Z\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":\"2000.00\",\"dps_balance\":\"1000.00\",\"approved_amount_audit\":\"14000.00\",\"approved_amount_manager\":\"13500.00\",\"approved_amount_area\":\"13000.00\",\"auditor_signature\":\"Auditor Signature 2\",\"manager_signature\":\"Manager Signature 2\",\"area_manager_signature\":null,\"date_approved\":\"2024-02-05\",\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"verified_by_manager\":\"Manager Name 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"submitted_at\":null,\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', NULL, '127.0.0.1', 'Symfony', '2025-12-30 06:32:47', '2025-12-30 06:32:47'),
(47, NULL, 'App\\Models\\SavingsAccount', 5, 'deleted', '{\"member_id\":1,\"account_no\":\"SAV0001\",\"balance\":2000,\"updated_at\":\"2025-12-30T12:32:47.000000Z\",\"created_at\":\"2025-12-30T12:32:47.000000Z\",\"id\":5}', NULL, '127.0.0.1', 'Symfony', '2025-12-30 06:32:47', '2025-12-30 06:32:47'),
(48, 1, 'App\\Models\\LoanProposal', 6, 'created', NULL, '{\"member_id\":\"2\",\"proposed_amount\":\"56000\",\"status\":\"pending\",\"business_type\":\"Farm Business\",\"loan_proposal_date\":\"2025-12-30\",\"savings_balance\":\"12000000\",\"dps_balance\":\"0\",\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"approved_amount_audit\":null,\"auditor_signature\":null,\"verified_by_manager\":null,\"approved_amount_manager\":null,\"manager_signature\":null,\"verified_by_area_manager\":null,\"approved_amount_area\":null,\"date_approved\":null,\"authorized_signatory_signature\":null,\"updated_at\":\"2025-12-30T12:41:13.000000Z\",\"created_at\":\"2025-12-30T12:41:13.000000Z\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:41:13', '2025-12-30 06:41:13'),
(49, 1, 'App\\Models\\LoanProposal', 2, 'deleted', '{\"id\":2,\"member_id\":1,\"proposed_amount\":\"15000.00\",\"approved_amount\":null,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"created_at\":\"2025-12-30T12:28:29.000000Z\",\"updated_at\":\"2025-12-30T12:28:29.000000Z\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":\"8000000.00\",\"dps_balance\":\"1000.00\",\"approved_amount_audit\":\"14000.00\",\"approved_amount_manager\":\"13500.00\",\"approved_amount_area\":\"13000.00\",\"auditor_signature\":\"Auditor Signature 2\",\"manager_signature\":\"Manager Signature 2\",\"area_manager_signature\":null,\"date_approved\":\"2024-02-05\",\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"verified_by_manager\":\"Manager Name 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"submitted_at\":null,\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:41:26', '2025-12-30 06:41:26'),
(50, 1, 'App\\Models\\LoanProposal', 3, 'deleted', '{\"id\":3,\"member_id\":1,\"proposed_amount\":\"15000.00\",\"approved_amount\":null,\"status\":\"pending\",\"business_type\":\"Wholesale Business\",\"created_at\":\"2025-12-30T12:29:10.000000Z\",\"updated_at\":\"2025-12-30T12:29:10.000000Z\",\"loan_proposal_date\":\"2024-02-01\",\"savings_balance\":\"2000.00\",\"dps_balance\":\"1000.00\",\"approved_amount_audit\":\"14000.00\",\"approved_amount_manager\":\"13500.00\",\"approved_amount_area\":\"13000.00\",\"auditor_signature\":\"Auditor Signature 2\",\"manager_signature\":\"Manager Signature 2\",\"area_manager_signature\":null,\"date_approved\":\"2024-02-05\",\"applicant_signature\":\"Jane Doe Signature\",\"employee_signature\":\"Employee Signature 2\",\"audited_verified\":\"Auditor Name 2\",\"verified_by_manager\":\"Manager Name 2\",\"verified_by_area_manager\":\"Area Manager Name 2\",\"authorized_signatory_signature\":\"Authorized Signature 2\",\"submitted_at\":null,\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:41:30', '2025-12-30 06:41:30'),
(51, 1, 'App\\Models\\LoanProposal', 6, 'updated', '{\"id\":6,\"member_id\":2,\"proposed_amount\":\"56000.00\",\"approved_amount\":null,\"status\":\"pending\",\"business_type\":\"Farm Business\",\"created_at\":\"2025-12-30T12:41:13.000000Z\",\"updated_at\":\"2025-12-30T12:41:13.000000Z\",\"loan_proposal_date\":\"2025-12-30\",\"savings_balance\":\"12000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":null,\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', '{\"status\":\"under_audit\",\"updated_at\":\"2025-12-30 12:42:16\",\"submitted_at\":\"2025-12-30T12:42:16.695234Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:42:16', '2025-12-30 06:42:16'),
(52, 1, 'App\\Models\\LoanProposal', 6, 'updated', '{\"id\":6,\"member_id\":2,\"proposed_amount\":\"56000.00\",\"approved_amount\":null,\"status\":\"under_audit\",\"business_type\":\"Farm Business\",\"created_at\":\"2025-12-30T12:41:13.000000Z\",\"updated_at\":\"2025-12-30T12:42:16.000000Z\",\"loan_proposal_date\":\"2025-12-30\",\"savings_balance\":\"12000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":\"2025-12-30 12:42:16\",\"audited_at\":null,\"manager_approved_at\":null,\"area_manager_approved_at\":null}', '{\"status\":\"manager_review\",\"updated_at\":\"2025-12-30 12:42:25\",\"audited_at\":\"2025-12-30T12:42:25.439909Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:42:25', '2025-12-30 06:42:25'),
(53, 1, 'App\\Models\\LoanProposal', 6, 'updated', '{\"id\":6,\"member_id\":2,\"proposed_amount\":\"56000.00\",\"approved_amount\":null,\"status\":\"manager_review\",\"business_type\":\"Farm Business\",\"created_at\":\"2025-12-30T12:41:13.000000Z\",\"updated_at\":\"2025-12-30T12:42:25.000000Z\",\"loan_proposal_date\":\"2025-12-30\",\"savings_balance\":\"12000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":\"2025-12-30 12:42:16\",\"audited_at\":\"2025-12-30 12:42:25\",\"manager_approved_at\":null,\"area_manager_approved_at\":null}', '{\"status\":\"area_manager_approval\",\"updated_at\":\"2025-12-30 12:42:32\",\"manager_approved_at\":\"2025-12-30T12:42:32.372951Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:42:32', '2025-12-30 06:42:32'),
(54, 1, 'App\\Models\\LoanProposal', 6, 'updated', '{\"id\":6,\"member_id\":2,\"proposed_amount\":\"56000.00\",\"approved_amount\":null,\"status\":\"area_manager_approval\",\"business_type\":\"Farm Business\",\"created_at\":\"2025-12-30T12:41:13.000000Z\",\"updated_at\":\"2025-12-30T12:42:32.000000Z\",\"loan_proposal_date\":\"2025-12-30\",\"savings_balance\":\"12000000.00\",\"dps_balance\":\"0.00\",\"approved_amount_audit\":null,\"approved_amount_manager\":null,\"approved_amount_area\":null,\"auditor_signature\":null,\"manager_signature\":null,\"area_manager_signature\":null,\"date_approved\":null,\"applicant_signature\":null,\"employee_signature\":null,\"audited_verified\":null,\"verified_by_manager\":null,\"verified_by_area_manager\":null,\"authorized_signatory_signature\":null,\"submitted_at\":\"2025-12-30 12:42:16\",\"audited_at\":\"2025-12-30 12:42:25\",\"manager_approved_at\":\"2025-12-30 12:42:32\",\"area_manager_approved_at\":null}', '{\"status\":\"approved\",\"updated_at\":\"2025-12-30 12:43:03\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:03', '2025-12-30 06:43:03'),
(55, 1, 'App\\Models\\Loan', 2, 'created', NULL, '{\"loan_proposal_id\":6,\"member_id\":2,\"loan_amount\":\"56000.00\",\"disbursed_amount\":\"56000\",\"remaining_amount\":\"56000\",\"interest_rate\":\"2\",\"installment_count\":\"4\",\"installment_type\":\"weekly\",\"disbursement_date\":\"2025-12-30T12:43:03.953648Z\",\"status\":\"active\",\"updated_at\":\"2025-12-30T12:43:03.000000Z\",\"created_at\":\"2025-12-30T12:43:03.000000Z\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:03', '2025-12-30 06:43:03'),
(56, 1, 'App\\Models\\CompanyFund', 1, 'updated', '{\"id\":1,\"balance\":\"19990000.00\",\"created_at\":\"2025-12-30T11:59:33.000000Z\",\"updated_at\":\"2025-12-30T12:13:45.000000Z\"}', '{\"balance\":19934000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:03', '2025-12-30 06:43:03'),
(57, 1, 'App\\Models\\LoanInstallment', 11, 'created', NULL, '{\"installment_no\":1,\"due_date\":\"2025-12-30\",\"principal_amount\":14000,\"interest_amount\":3.11,\"amount\":14003.11,\"status\":\"pending\",\"loan_id\":2,\"updated_at\":\"2025-12-30T12:43:04.000000Z\",\"created_at\":\"2025-12-30T12:43:04.000000Z\",\"id\":11}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:04', '2025-12-30 06:43:04'),
(58, 1, 'App\\Models\\LoanInstallment', 12, 'created', NULL, '{\"installment_no\":2,\"due_date\":\"2026-01-30\",\"principal_amount\":14000,\"interest_amount\":3.11,\"amount\":14003.11,\"status\":\"pending\",\"loan_id\":2,\"updated_at\":\"2025-12-30T12:43:04.000000Z\",\"created_at\":\"2025-12-30T12:43:04.000000Z\",\"id\":12}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:04', '2025-12-30 06:43:04'),
(59, 1, 'App\\Models\\LoanInstallment', 13, 'created', NULL, '{\"installment_no\":3,\"due_date\":\"2026-03-02\",\"principal_amount\":14000,\"interest_amount\":3.11,\"amount\":14003.11,\"status\":\"pending\",\"loan_id\":2,\"updated_at\":\"2025-12-30T12:43:04.000000Z\",\"created_at\":\"2025-12-30T12:43:04.000000Z\",\"id\":13}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:04', '2025-12-30 06:43:04'),
(60, 1, 'App\\Models\\LoanInstallment', 14, 'created', NULL, '{\"installment_no\":4,\"due_date\":\"2026-03-30\",\"principal_amount\":14000,\"interest_amount\":3.11,\"amount\":14003.11,\"status\":\"pending\",\"loan_id\":2,\"updated_at\":\"2025-12-30T12:43:04.000000Z\",\"created_at\":\"2025-12-30T12:43:04.000000Z\",\"id\":14}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-30 06:43:04', '2025-12-30 06:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:53:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"role-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"role-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"role-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"role-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"user-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"user-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:9:\"user-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"user-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:11:\"member-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:13:\"member-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:11:\"member-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:13:\"member-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"saving-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:13:\"saving-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"saving-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:11:\"saving-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:13:\"saving-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:20:\"saving-post-interest\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"saving-withdraw\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:23:\"saving-approve-withdraw\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"saving-voucher\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:9:\"loan-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:11:\"loan-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:9:\"loan-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:11:\"loan-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:12:\"partner-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"partner-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:12:\"partner-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:14:\"partner-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"investment-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:17:\"investment-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:18:\"investment-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:15:\"withdrawal-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:17:\"withdrawal-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:18:\"withdrawal-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:15:\"cash-asset-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:17:\"cash-asset-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:15:\"cash-asset-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:17:\"cash-asset-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"companyfund-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:11:\"report-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"notification-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:10:\"audit-view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:18:\"loan-proposal-list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:20:\"loan-proposal-create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:18:\"loan-proposal-edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:20:\"loan-proposal-delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:21:\"loan-proposal-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:17:\"loan-installments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:16:\"loan-collections\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:19:\"loan-proposal-audit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:28:\"loan-proposal-manager-review\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:26:\"loan-proposal-area-approve\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}}}', 1767183170);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_assets`
--

CREATE TABLE `cash_assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('cash_in_hand','bank') NOT NULL DEFAULT 'cash_in_hand',
  `name` varchar(255) DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `details` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash_asset_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('inflow','outflow') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `reference_type` varchar(255) DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('asset','liability','equity','income','expense') NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `code`, `name`, `type`, `parent_id`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1000', 'Cash on Hand', 'asset', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(2, '1010', 'Bank Account', 'asset', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(3, '1100', 'Loan Receivable', 'asset', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(4, '2000', 'Savings Liability', 'liability', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(5, '2100', 'Loan Payable', 'liability', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(6, '3000', 'Equity', 'equity', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(7, '4000', 'Interest Income', 'income', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(8, '4100', 'Penalty Income', 'income', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(9, '5000', 'Interest Expense', 'expense', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33'),
(10, '5001', 'Cash Outflow Expense', 'expense', NULL, NULL, 1, '2025-12-30 05:59:33', '2025-12-30 05:59:33');

-- --------------------------------------------------------

--
-- Table structure for table `company_funds`
--

CREATE TABLE `company_funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_funds`
--

INSERT INTO `company_funds` (`id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 19934000.00, '2025-12-30 05:59:33', '2025-12-30 06:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `expense_date` date NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investment_applications`
--

CREATE TABLE `investment_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `partner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `investment_no` varchar(255) NOT NULL,
  `application_date` date NOT NULL,
  `applied_amount` decimal(15,2) NOT NULL,
  `approved_amount` decimal(15,2) DEFAULT NULL,
  `investment_date` date DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `trade_license_no` varchar(255) DEFAULT NULL,
  `business_address` text DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investment_withdrawal_requests`
--

CREATE TABLE `investment_withdrawal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_type` varchar(255) DEFAULT NULL,
  `transactionable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transactionable_type` varchar(255) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id`, `journal_type`, `transactionable_id`, `transactionable_type`, `narration`, `created_by`, `posted_at`, `created_at`, `updated_at`) VALUES
(1, 'auto', 1, 'App\\Models\\SavingsTransaction', 'Savings txn #1 (deposit)', 1, '2025-12-30 06:04:56', '2025-12-30 06:04:56', '2025-12-30 06:04:56'),
(2, 'auto', 2, 'App\\Models\\SavingsTransaction', 'Savings txn #2 (deposit)', 1, '2025-12-30 06:05:16', '2025-12-30 06:05:16', '2025-12-30 06:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `ledger_entries`
--

CREATE TABLE `ledger_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledger_entries`
--

INSERT INTO `ledger_entries` (`id`, `journal_id`, `account_id`, `debit`, `credit`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8000000.00, 0.00, 'Cash/Bank (deposit)', '2025-12-30 06:04:56', '2025-12-30 06:04:56'),
(2, 1, 4, 0.00, 8000000.00, 'Savings Liability', '2025-12-30 06:04:56', '2025-12-30 06:04:56'),
(3, 2, 1, 12000000.00, 0.00, 'Cash/Bank (deposit)', '2025-12-30 06:05:16', '2025-12-30 06:05:16'),
(4, 2, 4, 0.00, 12000000.00, 'Savings Liability', '2025-12-30 06:05:16', '2025-12-30 06:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_proposal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `disbursed_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Active','Completed','Overdue') NOT NULL DEFAULT 'Active',
  `disbursement_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `interest_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `penalty_rate` decimal(5,2) NOT NULL DEFAULT 0.50,
  `installment_count` int(11) NOT NULL DEFAULT 0,
  `installment_type` enum('daily','weekly','monthly') NOT NULL DEFAULT 'monthly',
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `loan_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `loan_proposal_id`, `disbursed_amount`, `remaining_amount`, `status`, `disbursement_date`, `created_at`, `updated_at`, `interest_rate`, `penalty_rate`, `installment_count`, `installment_type`, `member_id`, `loan_amount`, `created_by`, `approved_by`, `remarks`) VALUES
(1, 1, 10000.00, 10000.00, 'Active', '2025-12-30', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 2.00, 0.50, 10, 'weekly', 1, 10000.00, NULL, NULL, NULL),
(2, 6, 56000.00, 56000.00, 'Active', '2025-12-30', '2025-12-30 06:43:03', '2025-12-30 06:43:03', 2.00, 0.50, 4, 'weekly', 2, 56000.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_collections`
--

CREATE TABLE `loan_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_installment_id` bigint(20) UNSIGNED NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `collector_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_collections`
--

INSERT INTO `loan_collections` (`id`, `loan_installment_id`, `paid_amount`, `payment_date`, `created_at`, `updated_at`, `collector_id`, `status`, `verified_by`, `transaction_date`, `amount`, `verified_at`, `remarks`) VALUES
(1, 1, 0.00, NULL, '2025-12-30 06:19:55', '2025-12-30 06:19:55', 1, 'pending', NULL, '2025-12-30', 1000.56, NULL, 'good');

-- --------------------------------------------------------

--
-- Table structure for table `loan_guarantors`
--

CREATE TABLE `loan_guarantors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_proposal_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `nid_number` varchar(255) DEFAULT NULL,
  `liabilities` varchar(255) DEFAULT NULL,
  `assets` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `declaration` text DEFAULT NULL,
  `guarantor_signature` varchar(255) DEFAULT NULL,
  `tip_sign` enum('left','right') DEFAULT NULL,
  `employee_signature` varchar(255) DEFAULT NULL,
  `manager_signature` varchar(255) DEFAULT NULL,
  `authorized_person_name` varchar(255) DEFAULT NULL,
  `authorized_person_signature` varchar(255) DEFAULT NULL,
  `investment_amount_words` varchar(255) DEFAULT NULL,
  `investment_received` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_guarantors`
--

INSERT INTO `loan_guarantors` (`id`, `loan_proposal_id`, `name`, `father_name`, `mother_name`, `nationality`, `relationship`, `present_address`, `permanent_address`, `mobile_no`, `email`, `profession`, `nid_number`, `liabilities`, `assets`, `created_at`, `updated_at`, `declaration`, `guarantor_signature`, `tip_sign`, `employee_signature`, `manager_signature`, `authorized_person_name`, `authorized_person_signature`, `investment_amount_words`, `investment_received`) VALUES
(1, 1, 'AB', NULL, NULL, NULL, NULL, '1230', '', '+8801690253986', 'ab2@gmail.com', NULL, '13421435650', NULL, NULL, '2025-12-30 06:08:10', '2025-12-30 06:08:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 6, 'Ayat', NULL, NULL, NULL, NULL, '1230', '', '+8801690253986', 'sumaya0akter45@gmail.com', NULL, '13421435000', NULL, NULL, '2025-12-30 06:42:02', '2025-12-30 06:42:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_installments`
--

CREATE TABLE `loan_installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('Pending','Paid','Overdue') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `installment_no` int(11) NOT NULL,
  `principal_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `interest_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `penalty_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_installments`
--

INSERT INTO `loan_installments` (`id`, `loan_id`, `due_date`, `amount`, `status`, `created_at`, `updated_at`, `installment_no`, `principal_amount`, `interest_amount`, `paid_amount`, `penalty_amount`, `paid_at`) VALUES
(1, 1, '2025-12-30', 1000.56, 'Paid', '2025-12-30 06:13:45', '2025-12-30 06:21:36', 1, 1000.00, 0.56, 0.00, 0.00, NULL),
(2, 1, '2026-01-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 2, 1000.00, 0.56, 0.00, 0.00, NULL),
(3, 1, '2026-03-02', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 3, 1000.00, 0.56, 0.00, 0.00, NULL),
(4, 1, '2026-03-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 4, 1000.00, 0.56, 0.00, 0.00, NULL),
(5, 1, '2026-04-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 5, 1000.00, 0.56, 0.00, 0.00, NULL),
(6, 1, '2026-05-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 6, 1000.00, 0.56, 0.00, 0.00, NULL),
(7, 1, '2026-06-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 7, 1000.00, 0.56, 0.00, 0.00, NULL),
(8, 1, '2026-07-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 8, 1000.00, 0.56, 0.00, 0.00, NULL),
(9, 1, '2026-08-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 9, 1000.00, 0.56, 0.00, 0.00, NULL),
(10, 1, '2026-09-30', 1000.56, 'Pending', '2025-12-30 06:13:45', '2025-12-30 06:13:45', 10, 1000.00, 0.56, 0.00, 0.00, NULL),
(11, 2, '2025-12-30', 14003.11, 'Pending', '2025-12-30 06:43:04', '2025-12-30 06:43:04', 1, 14000.00, 3.11, 0.00, 0.00, NULL),
(12, 2, '2026-01-30', 14003.11, 'Pending', '2025-12-30 06:43:04', '2025-12-30 06:43:04', 2, 14000.00, 3.11, 0.00, 0.00, NULL),
(13, 2, '2026-03-02', 14003.11, 'Pending', '2025-12-30 06:43:04', '2025-12-30 06:43:04', 3, 14000.00, 3.11, 0.00, 0.00, NULL),
(14, 2, '2026-03-30', 14003.11, 'Pending', '2025-12-30 06:43:04', '2025-12-30 06:43:04', 4, 14000.00, 3.11, 0.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_proposals`
--

CREATE TABLE `loan_proposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `proposed_amount` decimal(15,2) NOT NULL,
  `approved_amount` decimal(15,2) DEFAULT NULL,
  `status` enum('pending','under_audit','manager_review','area_manager_approval','approved','rejected') NOT NULL DEFAULT 'pending',
  `business_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `loan_proposal_date` date DEFAULT NULL,
  `savings_balance` decimal(15,2) DEFAULT NULL,
  `dps_balance` decimal(15,2) DEFAULT NULL,
  `approved_amount_audit` decimal(15,2) DEFAULT NULL,
  `approved_amount_manager` decimal(15,2) DEFAULT NULL,
  `approved_amount_area` decimal(15,2) DEFAULT NULL,
  `auditor_signature` varchar(255) DEFAULT NULL,
  `manager_signature` varchar(255) DEFAULT NULL,
  `area_manager_signature` varchar(255) DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `applicant_signature` varchar(255) DEFAULT NULL,
  `employee_signature` varchar(255) DEFAULT NULL,
  `audited_verified` varchar(255) DEFAULT NULL,
  `verified_by_manager` varchar(255) DEFAULT NULL,
  `verified_by_area_manager` varchar(255) DEFAULT NULL,
  `authorized_signatory_signature` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `audited_at` timestamp NULL DEFAULT NULL,
  `manager_approved_at` timestamp NULL DEFAULT NULL,
  `area_manager_approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_proposals`
--

INSERT INTO `loan_proposals` (`id`, `member_id`, `proposed_amount`, `approved_amount`, `status`, `business_type`, `created_at`, `updated_at`, `loan_proposal_date`, `savings_balance`, `dps_balance`, `approved_amount_audit`, `approved_amount_manager`, `approved_amount_area`, `auditor_signature`, `manager_signature`, `area_manager_signature`, `date_approved`, `applicant_signature`, `employee_signature`, `audited_verified`, `verified_by_manager`, `verified_by_area_manager`, `authorized_signatory_signature`, `submitted_at`, `audited_at`, `manager_approved_at`, `area_manager_approved_at`) VALUES
(1, 1, 10000.00, NULL, 'approved', 'Retail Business', '2025-12-30 06:07:06', '2025-12-30 06:13:45', '2025-12-08', 8000000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 06:08:18', '2025-12-30 06:12:50', '2025-12-30 06:12:58', NULL),
(6, 2, 56000.00, NULL, 'approved', 'Farm Business', '2025-12-30 06:41:13', '2025-12-30 06:43:03', '2025-12-30', 12000000.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 06:42:16', '2025-12-30 06:42:25', '2025-12-30 06:42:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_no` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `nid` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text DEFAULT NULL,
  `nominee_name` varchar(100) DEFAULT NULL,
  `nominee_relation` varchar(50) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed') DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `dependents` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_no`, `name`, `guardian_name`, `nid`, `phone`, `email`, `present_address`, `permanent_address`, `nominee_name`, `nominee_relation`, `status`, `gender`, `dob`, `marital_status`, `education`, `dependents`, `created_at`, `updated_at`, `admission_date`, `business_type`) VALUES
(1, 'M00001', 'Abdul Karim', 'Late Abdul Hakim', '1993657821456', '01690253986', 'lammi8776@gmail.com', 'uttara 10', 'CTG', 'Rokaya Bagum', 'wife', 'Active', 'Male', '1995-04-05', 'Married', 'HSC', 2, '2025-12-30 06:02:42', '2025-12-30 06:02:42', NULL, NULL),
(2, 'M00002', 'Mira Khan', 'Kobir Zamman', '1993657821458', '01790253986', 'mira2@gmail.com', 'Mirpur 12', 'Mirpur 12', 'Sharifa Khatun', 'Mother', 'Active', 'Female', '1997-12-15', 'Single', 'MSC', 1, '2025-12-30 06:04:25', '2025-12-30 06:04:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_04_054053_create_permission_tables', 1),
(5, '2025_12_14_102227_create_members_table', 1),
(6, '2025_12_14_103555_create_savings_accounts_table', 1),
(7, '2025_12_14_103632_create_savings_transactions_table', 1),
(8, '2025_12_14_103633_create_savings_withdrawal_requests_table', 1),
(9, '2025_12_14_103715_create_loan_proposals_table', 1),
(10, '2025_12_14_103808_create_loan_guarantors_table', 1),
(11, '2025_12_14_103808_create_loan_table', 1),
(12, '2025_12_14_103834_create_loan_installments_table', 1),
(13, '2025_12_14_110531_create_loan_collections_table', 1),
(14, '2025_12_14_112937_create_partners_table', 1),
(15, '2025_12_14_113001_create_ininvestment_applications_table', 1),
(16, '2025_12_14_113226_create_profit_distributions_table', 1),
(17, '2025_12_15_110506_create_company_funds_table', 1),
(18, '2025_12_17_101010_add_account_no_to_savings_accounts_table', 1),
(19, '2025_12_17_110000_create_loans_table', 1),
(20, '2025_12_17_110100_create_loan_installments_table', 1),
(21, '2025_12_17_110200_create_loan_collections_table', 1),
(22, '2025_12_17_110300_create_cash_assets_table', 1),
(23, '2025_12_17_110400_create_cash_transactions_table', 1),
(24, '2025_12_17_111000_add_penalty_rate_to_loans_table', 1),
(25, '2025_12_17_120000_create_chart_of_accounts_table', 1),
(26, '2025_12_17_120100_create_journals_and_ledger_entries_tables', 1),
(27, '2025_12_17_120200_create_notification_logs_table', 1),
(28, '2025_12_17_120300_create_audit_logs_table', 1),
(29, '2025_12_18_085029_create_withdrawals_table', 1),
(30, '2025_12_22_120953_update_loan_proposals_status_enum', 1),
(31, '2025_12_23_043614_add_admission_date_to_members_table', 1),
(32, '2025_12_23_043646_add_additional_fields_to_loan_proposals_table', 1),
(33, '2025_12_23_054847_add_missing_fields_to_loan_proposals_table', 1),
(34, '2025_12_23_054955_rename_guarantor_fields_in_loan_guarantors_table', 1),
(35, '2025_12_23_055713_add_detailed_fields_to_loan_guarantors_table', 1),
(36, '2025_12_23_055935_create_previous_loans_table', 1),
(37, '2025_12_23_063342_add_member_id_to_loans_table', 1),
(38, '2025_12_23_064533_add_missing_columns_to_loans_table', 1),
(39, '2025_12_23_094709_add_missing_columns_to_loans_table', 1),
(40, '2025_12_23_094824_add_missing_columns_to_loan_collections_table', 1),
(41, '2025_12_23_100235_make_loan_proposal_id_nullable_in_loans_table', 1),
(42, '2025_12_23_102555_add_default_values_to_loans_table', 1),
(43, '2025_12_24_042831_add_workflow_timestamps_to_loan_proposals_table', 1),
(44, '2025_12_24_045646_add_business_type_to_members_table', 1),
(45, '2025_12_24_065737_add_columns_to_previous_loans_table', 1),
(46, '2025_12_24_113316_add_workflow_timestamps_to_loan_proposals_table', 1),
(47, '2025_12_24_121916_change_assets_column_to_text_in_loan_guarantors_table', 1),
(48, '2025_12_28_110528_add_status_and_total_profits_to_partners_table', 1),
(49, '2025_12_28_111650_create_investment_withdrawal_requests_table', 1),
(50, '2025_12_28_111735_create_expenses_table', 1),
(51, '2025_12_28_111747_create_partner_withdrawal_requests_table', 1),
(52, '2025_12_29_111030_change_liabilities_column_to_text_in_loan_guarantors_table', 1),
(53, '2025_12_29_111142_change_liabilities_column_to_varchar_in_loan_guarantors_table', 1),
(54, '2025_12_29_112753_change_investment_received_to_string_in_loan_guarantors_table', 1),
(55, '2025_12_29_123338_add_default_value_to_paid_amount_in_loan_collections_table', 1),
(56, '2025_12_29_123803_add_default_to_paid_amount_in_loan_collections_table', 1),
(57, '2025_12_29_123847_add_paid_amount_to_loan_collections_table', 1),
(58, '2025_12_29_123941_modify_paid_amount_default_in_loan_collections_table', 1),
(59, '2025_12_29_124105_fix_paid_amount_default_in_loan_collections_table', 1),
(60, '2025_12_30_121927_drop_collected_by_from_loan_collections_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `channels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`channels`)),
  `to` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `sent_at` timestamp NULL DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_logs`
--

INSERT INTO `notification_logs` (`id`, `type`, `channels`, `to`, `body`, `status`, `sent_at`, `meta`, `created_at`, `updated_at`) VALUES
(1, 'loan_disbursed', '[\"email\",\"sms\"]', '[\"lammi8776@gmail.com\",\"01690253986\"]', 'Your loan has been disbursed for amount 10,000.00', 'sent', '2025-12-30 06:13:45', '{\"loan_id\":1}', '2025-12-30 06:13:45', '2025-12-30 06:13:45'),
(2, 'loan_disbursed', '[\"email\",\"sms\"]', '[\"mira2@gmail.com\",\"01790253986\"]', 'Your loan has been disbursed for amount 56,000.00', 'sent', '2025-12-30 06:43:04', '{\"loan_id\":2}', '2025-12-30 06:43:04', '2025-12-30 06:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `share_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `invested_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `total_profits` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partner_withdrawal_requests`
--

CREATE TABLE `partner_withdrawal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type` enum('profit','capital') NOT NULL DEFAULT 'profit',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(2, 'role-create', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(3, 'role-edit', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(4, 'role-delete', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(5, 'user-list', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(6, 'user-create', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(7, 'user-edit', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(8, 'user-delete', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(9, 'member-list', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(10, 'member-create', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(11, 'member-edit', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(12, 'member-delete', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(13, 'saving-list', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(14, 'saving-create', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(15, 'saving-approve', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(16, 'saving-edit', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(17, 'saving-delete', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(18, 'saving-post-interest', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(19, 'saving-withdraw', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(20, 'saving-approve-withdraw', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(21, 'saving-voucher', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31'),
(22, 'loan-list', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(23, 'loan-create', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(24, 'loan-edit', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(25, 'loan-delete', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(26, 'partner-list', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(27, 'partner-create', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(28, 'partner-edit', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(29, 'partner-delete', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(30, 'investment-list', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(31, 'investment-create', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(32, 'investment-approve', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(33, 'withdrawal-list', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(34, 'withdrawal-create', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(35, 'withdrawal-approve', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(36, 'cash-asset-list', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(37, 'cash-asset-create', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(38, 'cash-asset-edit', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(39, 'cash-asset-delete', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(40, 'companyfund-view', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(41, 'report-view', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(42, 'notification-view', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(43, 'audit-view', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(44, 'loan-proposal-list', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(45, 'loan-proposal-create', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(46, 'loan-proposal-edit', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(47, 'loan-proposal-delete', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(48, 'loan-proposal-approve', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(49, 'loan-installments', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(50, 'loan-collections', 'web', '2025-12-30 05:59:32', '2025-12-30 05:59:32'),
(51, 'loan-proposal-audit', 'web', '2025-12-30 06:12:22', '2025-12-30 06:12:22'),
(52, 'loan-proposal-manager-review', 'web', '2025-12-30 06:12:22', '2025-12-30 06:12:22'),
(53, 'loan-proposal-area-approve', 'web', '2025-12-30 06:12:22', '2025-12-30 06:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `previous_loans`
--

CREATE TABLE `previous_loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `loan_proposal_id` bigint(20) UNSIGNED NOT NULL,
  `installment_no` int(11) DEFAULT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `disbursement_date` date DEFAULT NULL,
  `repayment_date` date DEFAULT NULL,
  `probable_repayment_date` date DEFAULT NULL,
  `loan_status` enum('active','completed','defaulted') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profit_distributions`
--

CREATE TABLE `profit_distributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `distribution_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-12-30 05:59:31', '2025-12-30 05:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savings_accounts`
--

CREATE TABLE `savings_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `interest_rate` decimal(5,2) NOT NULL DEFAULT 5.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings_accounts`
--

INSERT INTO `savings_accounts` (`id`, `account_no`, `member_id`, `balance`, `interest_rate`, `created_at`, `updated_at`) VALUES
(2, 'SA000002', 2, 12000000.00, 5.00, '2025-12-30 06:05:10', '2025-12-30 06:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `savings_transactions`
--

CREATE TABLE `savings_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `savings_account_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('deposit','withdrawal') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings_transactions`
--

INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `remarks`, `status`, `transaction_date`, `created_at`, `updated_at`) VALUES
(2, 2, 'deposit', 12000000.00, 'Savings Deposit', 'approved', '2025-12-30', '2025-12-30 06:05:10', '2025-12-30 06:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `savings_withdrawal_requests`
--

CREATE TABLE `savings_withdrawal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('len2vNAV6kB8xgcaDOP1Vbag7cNtTTNkK2Tog7ZP', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiajA1eXdNd1FSRW91NVM3M3hvcjhsc1oyQ1k0bGRmZ0JOalNoWkEzciI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9hbnMvMi9lZGl0IjtzOjU6InJvdXRlIjtzOjEwOiJsb2Fucy5lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjcwOTYwNjQ7fX0=', 1767098605);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$nX0alf9Vgr06bwsqjLE27eh4kZq85rD6FD9I9cM9wgX99NcJliYkK', NULL, '2025-12-30 05:59:31', '2025-12-30 05:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `request_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cash_assets`
--
ALTER TABLE `cash_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_transactions_cash_asset_id_foreign` (`cash_asset_id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chart_of_accounts_code_unique` (`code`),
  ADD KEY `chart_of_accounts_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `company_funds`
--
ALTER TABLE `company_funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `investment_applications`
--
ALTER TABLE `investment_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `investment_applications_investment_no_unique` (`investment_no`),
  ADD KEY `investment_applications_member_id_foreign` (`member_id`),
  ADD KEY `investment_applications_partner_id_foreign` (`partner_id`);

--
-- Indexes for table `investment_withdrawal_requests`
--
ALTER TABLE `investment_withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_withdrawal_requests_partner_id_foreign` (`partner_id`),
  ADD KEY `investment_withdrawal_requests_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ledger_entries`
--
ALTER TABLE `ledger_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ledger_entries_journal_id_foreign` (`journal_id`),
  ADD KEY `ledger_entries_account_id_foreign` (`account_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_member_id_foreign` (`member_id`),
  ADD KEY `loans_created_by_foreign` (`created_by`),
  ADD KEY `loans_approved_by_foreign` (`approved_by`),
  ADD KEY `loans_loan_proposal_id_foreign` (`loan_proposal_id`);

--
-- Indexes for table `loan_collections`
--
ALTER TABLE `loan_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_collections_loan_installment_id_foreign` (`loan_installment_id`);

--
-- Indexes for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_guarantors_loan_proposal_id_foreign` (`loan_proposal_id`);

--
-- Indexes for table `loan_installments`
--
ALTER TABLE `loan_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_installments_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `loan_proposals`
--
ALTER TABLE `loan_proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_proposals_member_id_foreign` (`member_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_member_no_unique` (`member_no`),
  ADD UNIQUE KEY `members_nid_unique` (`nid`),
  ADD UNIQUE KEY `members_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_withdrawal_requests`
--
ALTER TABLE `partner_withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_withdrawal_requests_partner_id_foreign` (`partner_id`),
  ADD KEY `partner_withdrawal_requests_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `previous_loans`
--
ALTER TABLE `previous_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `previous_loans_loan_proposal_id_foreign` (`loan_proposal_id`);

--
-- Indexes for table `profit_distributions`
--
ALTER TABLE `profit_distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profit_distributions_partner_id_foreign` (`partner_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `savings_accounts_account_no_unique` (`account_no`),
  ADD KEY `savings_accounts_member_id_foreign` (`member_id`);

--
-- Indexes for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_transactions_savings_account_id_foreign` (`savings_account_id`);

--
-- Indexes for table `savings_withdrawal_requests`
--
ALTER TABLE `savings_withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_withdrawal_requests_member_id_foreign` (`member_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_member_id_foreign` (`member_id`),
  ADD KEY `withdrawals_approved_by_foreign` (`approved_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cash_assets`
--
ALTER TABLE `cash_assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `company_funds`
--
ALTER TABLE `company_funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_applications`
--
ALTER TABLE `investment_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_withdrawal_requests`
--
ALTER TABLE `investment_withdrawal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ledger_entries`
--
ALTER TABLE `ledger_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_collections`
--
ALTER TABLE `loan_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_installments`
--
ALTER TABLE `loan_installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `loan_proposals`
--
ALTER TABLE `loan_proposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partner_withdrawal_requests`
--
ALTER TABLE `partner_withdrawal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `previous_loans`
--
ALTER TABLE `previous_loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profit_distributions`
--
ALTER TABLE `profit_distributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `savings_withdrawal_requests`
--
ALTER TABLE `savings_withdrawal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD CONSTRAINT `cash_transactions_cash_asset_id_foreign` FOREIGN KEY (`cash_asset_id`) REFERENCES `cash_assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD CONSTRAINT `chart_of_accounts_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `investment_applications`
--
ALTER TABLE `investment_applications`
  ADD CONSTRAINT `investment_applications_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investment_applications_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investment_withdrawal_requests`
--
ALTER TABLE `investment_withdrawal_requests`
  ADD CONSTRAINT `investment_withdrawal_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investment_withdrawal_requests_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ledger_entries`
--
ALTER TABLE `ledger_entries`
  ADD CONSTRAINT `ledger_entries_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `chart_of_accounts` (`id`),
  ADD CONSTRAINT `ledger_entries_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_loan_proposal_id_foreign` FOREIGN KEY (`loan_proposal_id`) REFERENCES `loan_proposals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_collections`
--
ALTER TABLE `loan_collections`
  ADD CONSTRAINT `loan_collections_loan_installment_id_foreign` FOREIGN KEY (`loan_installment_id`) REFERENCES `loan_installments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  ADD CONSTRAINT `loan_guarantors_loan_proposal_id_foreign` FOREIGN KEY (`loan_proposal_id`) REFERENCES `loan_proposals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_installments`
--
ALTER TABLE `loan_installments`
  ADD CONSTRAINT `loan_installments_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_proposals`
--
ALTER TABLE `loan_proposals`
  ADD CONSTRAINT `loan_proposals_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `partner_withdrawal_requests`
--
ALTER TABLE `partner_withdrawal_requests`
  ADD CONSTRAINT `partner_withdrawal_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `partner_withdrawal_requests_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `previous_loans`
--
ALTER TABLE `previous_loans`
  ADD CONSTRAINT `previous_loans_loan_proposal_id_foreign` FOREIGN KEY (`loan_proposal_id`) REFERENCES `loan_proposals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profit_distributions`
--
ALTER TABLE `profit_distributions`
  ADD CONSTRAINT `profit_distributions_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD CONSTRAINT `savings_accounts_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  ADD CONSTRAINT `savings_transactions_savings_account_id_foreign` FOREIGN KEY (`savings_account_id`) REFERENCES `savings_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savings_withdrawal_requests`
--
ALTER TABLE `savings_withdrawal_requests`
  ADD CONSTRAINT `savings_withdrawal_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawals_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
