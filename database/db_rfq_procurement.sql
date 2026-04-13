-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 07:03 PM
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
-- Database: `db_rfq_procurement`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id_batch` int(10) UNSIGNED NOT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'draft',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id_batch`, `batch_number`, `title`, `description`, `deadline`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'RFQ-20260413-0001', 'Pengadaan Peralatan IT Q2 2026', 'tess', '2026-04-14', 'open', 1, '2026-04-13 10:17:54', '2026-04-12 11:49:04'),
(3, 'RFQ-20260412-0001', 'Pengadaan Peralatan IT Q3 2026', 'testing', '2026-04-15', 'open', 1, '2026-04-12 11:55:03', '2026-04-12 11:56:13'),
(4, 'RFQ-20260413-0002', 'testing batch status', 'testing', '2026-04-15', 'closed', 1, '2026-04-13 09:41:05', '2026-04-13 09:52:07'),
(5, 'RFQ-20260413-0003', 'batch testing 123', 'testing', '2026-04-14', 'closed', 1, '2026-04-13 09:52:44', '2026-04-13 09:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `batch_categories`
--

CREATE TABLE `batch_categories` (
  `id_batch_category` int(10) UNSIGNED NOT NULL,
  `id_batch` int(10) UNSIGNED DEFAULT NULL,
  `id_master_category` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batch_categories`
--

INSERT INTO `batch_categories` (`id_batch_category`, `id_batch`, `id_master_category`) VALUES
(4, 2, 1),
(5, 3, 2),
(6, 4, 2),
(7, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `to_email`, `subject`, `type`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 'ddimasddpprasetiyo@gmail.com', 'Registrasi Supplier Berhasil - E-Quotation System', 'supplier_registered', '2026-04-12 01:14:04', '2026-04-12 01:14:04', '2026-04-12 01:14:04'),
(2, 'ddimasddpprasetiyo@gmail.com', 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System', 'supplier_activated', '2026-04-12 01:23:07', '2026-04-12 01:23:07', '2026-04-12 01:23:07'),
(3, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: Pengadaan Peralatan IT Q1 2026 - E-Quotation System', 'rfq_invitation', '2026-04-12 01:23:41', '2026-04-12 01:23:41', '2026-04-12 01:23:41'),
(4, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru Masuk: PT satnusa - Pengadaan Peralatan IT Q1 2026', 'quotation_submitted', '2026-04-12 01:27:16', '2026-04-12 01:27:16', '2026-04-12 01:27:16'),
(5, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Anda Tidak Diterima - Pengadaan Peralatan IT Q1 2026', 'quotation_rejected', '2026-04-12 08:59:52', '2026-04-12 08:59:52', '2026-04-12 08:59:52'),
(6, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru Masuk: PT Demo Supplier Indonesia - Pengadaan Peralatan IT Q1 2026', 'quotation_submitted', '2026-04-12 09:02:51', '2026-04-12 09:02:51', '2026-04-12 09:02:51'),
(7, 'dimasgantengsejagat@gmail.com', 'Registrasi Supplier Berhasil - E-Quotation System', 'supplier_registered', '2026-04-12 09:10:51', '2026-04-12 09:10:51', '2026-04-12 09:10:51'),
(8, 'dimasgtgsejagat@gmail.com', 'Registrasi Supplier Berhasil - E-Quotation System', 'supplier_registered', '2026-04-12 09:13:58', '2026-04-12 09:13:58', '2026-04-12 09:13:58'),
(9, 'dimasgantengsejagat@gmail.com', 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System', 'supplier_activated', '2026-04-12 09:14:39', '2026-04-12 09:14:39', '2026-04-12 09:14:39'),
(10, 'dimasgtgsejagat@gmail.com', 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System', 'supplier_activated', '2026-04-12 09:14:53', '2026-04-12 09:14:53', '2026-04-12 09:14:53'),
(11, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru Masuk: PT JASA KERJA - Pengadaan Peralatan IT Q1 2026', 'quotation_submitted', '2026-04-12 09:22:51', '2026-04-12 09:22:51', '2026-04-12 09:22:51'),
(12, 'dimasgantengsejagat@gmail.com', 'Undangan RFQ: Pengadaan Peralatan IT Q1 2026 - E-Quotation System', 'rfq_invitation', '2026-04-12 09:32:44', '2026-04-12 09:32:44', '2026-04-12 09:32:44'),
(13, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru Masuk: CV - Pengadaan Peralatan IT Q1 2026', 'quotation_submitted', '2026-04-12 09:54:27', '2026-04-12 09:54:27', '2026-04-12 09:54:27'),
(14, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: Pengadaan Peralatan IT Q2 2026 - E-Quotation System', 'rfq_invitation', '2026-04-12 10:54:39', '2026-04-12 10:54:39', '2026-04-12 10:54:39'),
(15, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: Pengadaan Peralatan IT Q2 2026 - E-Quotation System', 'rfq_invitation', '2026-04-12 10:55:15', '2026-04-12 10:55:15', '2026-04-12 10:55:15'),
(16, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - Pengadaan Peralatan IT Q2 2026', 'quotation_submitted', '2026-04-12 10:59:57', '2026-04-12 10:59:57', '2026-04-12 10:59:57'),
(17, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - Pengadaan Peralatan IT Q2 2026', 'quotation_submitted', '2026-04-12 11:42:23', '2026-04-12 11:42:23', '2026-04-12 11:42:23'),
(18, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - Pengadaan Peralatan IT Q2 2026', 'quotation_approved', '2026-04-12 11:44:54', '2026-04-12 11:44:54', '2026-04-12 11:44:54'),
(19, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: Pengadaan Peralatan IT Q2 2026 - E-Quotation System', 'winner_reminder', '2026-04-12 11:47:22', '2026-04-12 11:47:22', '2026-04-12 11:47:22'),
(20, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: Pengadaan Peralatan IT Q2 2026 - E-Quotation System', 'winner_reminder', '2026-04-12 11:47:52', '2026-04-12 11:47:52', '2026-04-12 11:47:52'),
(21, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: Pengadaan Peralatan IT Q2 2026 - E-Quotation System', 'winner_reminder', '2026-04-12 11:49:10', '2026-04-12 11:49:10', '2026-04-12 11:49:10'),
(22, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: Pengadaan Peralatan IT Q3 2026 - E-Quotation System', 'rfq_invitation', '2026-04-12 11:56:13', '2026-04-12 11:56:13', '2026-04-12 11:56:13'),
(23, 'supplier@demo.com', 'Undangan RFQ: Pengadaan Peralatan IT Q2 2026 - E-Quotation System', 'rfq_invitation', '2026-04-13 00:26:18', '2026-04-13 00:26:18', '2026-04-13 00:26:18'),
(24, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT Demo Supplier Indonesia - Pengadaan Peralatan IT Q2 2026', 'quotation_submitted', '2026-04-13 00:27:17', '2026-04-13 00:27:17', '2026-04-13 00:27:17'),
(25, 'supplier@demo.com', 'Penawaran Tidak Diterima - Pengadaan Peralatan IT Q2 2026', 'quotation_rejected', '2026-04-13 09:26:48', '2026-04-13 09:26:48', '2026-04-13 09:26:48'),
(26, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing batch status - E-Quotation System', 'rfq_invitation', '2026-04-13 09:41:54', '2026-04-13 09:41:54', '2026-04-13 09:41:54'),
(27, 'supplier@demo.com', 'Undangan RFQ: testing batch status - E-Quotation System', 'rfq_invitation', '2026-04-13 09:42:12', '2026-04-13 09:42:12', '2026-04-13 09:42:12'),
(28, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing batch status', 'quotation_submitted', '2026-04-13 09:43:04', '2026-04-13 09:43:04', '2026-04-13 09:43:04'),
(29, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT Demo Supplier Indonesia - testing batch status', 'quotation_submitted', '2026-04-13 09:44:03', '2026-04-13 09:44:03', '2026-04-13 09:44:03'),
(30, 'supplier@demo.com', '🎉 Penawaran Anda Diterima - testing batch status', 'quotation_approved', '2026-04-13 09:44:57', '2026-04-13 09:44:57', '2026-04-13 09:44:57'),
(31, 'supplier@demo.com', 'Informasi Pengadaan: testing batch status - E-Quotation System', 'winner_reminder', '2026-04-13 09:49:44', '2026-04-13 09:49:44', '2026-04-13 09:49:44'),
(32, 'supplier@demo.com', 'Informasi Pengadaan: testing batch status - E-Quotation System', 'winner_reminder', '2026-04-13 09:51:41', '2026-04-13 09:51:41', '2026-04-13 09:51:41'),
(33, 'supplier@demo.com', 'Informasi Pengadaan: testing batch status - E-Quotation System', 'winner_reminder', '2026-04-13 09:51:56', '2026-04-13 09:51:56', '2026-04-13 09:51:56'),
(34, 'supplier@demo.com', 'Informasi Pengadaan: testing batch status - E-Quotation System', 'winner_reminder', '2026-04-13 09:52:12', '2026-04-13 09:52:12', '2026-04-13 09:52:12'),
(35, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: batch testing 123 - E-Quotation System', 'rfq_invitation', '2026-04-13 09:53:26', '2026-04-13 09:53:26', '2026-04-13 09:53:26'),
(36, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: batch testing 123 - E-Quotation System', 'rfq_invitation', '2026-04-13 09:53:43', '2026-04-13 09:53:43', '2026-04-13 09:53:43'),
(37, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - batch testing 123', 'quotation_submitted', '2026-04-13 09:56:31', '2026-04-13 09:56:31', '2026-04-13 09:56:31'),
(38, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - batch testing 123', 'quotation_submitted', '2026-04-13 09:57:37', '2026-04-13 09:57:37', '2026-04-13 09:57:37'),
(39, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - batch testing 123', 'quotation_approved', '2026-04-13 09:58:43', '2026-04-13 09:58:43', '2026-04-13 09:58:43'),
(40, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - Pengadaan Peralatan IT Q3 2026', 'quotation_submitted', '2026-04-13 10:00:39', '2026-04-13 10:00:39', '2026-04-13 10:00:39'),
(41, 'dimasgtgsejagat@gmail.com', 'Penawaran Tidak Diterima - Pengadaan Peralatan IT Q3 2026', 'quotation_rejected', '2026-04-13 10:01:02', '2026-04-13 10:01:02', '2026-04-13 10:01:02');

-- --------------------------------------------------------

--
-- Table structure for table `invited_supplier_categories`
--

CREATE TABLE `invited_supplier_categories` (
  `id_invited_supplier` int(10) UNSIGNED NOT NULL,
  `id_supplier` int(10) UNSIGNED DEFAULT NULL,
  `id_batch_category` int(10) UNSIGNED DEFAULT NULL,
  `invited_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'invited',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invited_supplier_categories`
--

INSERT INTO `invited_supplier_categories` (`id_invited_supplier`, `id_supplier`, `id_batch_category`, `invited_at`, `status`, `created_at`, `updated_at`) VALUES
(5, 2, 4, '2026-04-12 10:54:33', 'submitted', '2026-04-12 10:54:33', '2026-04-12 10:59:52'),
(6, 4, 4, '2026-04-12 10:55:10', 'submitted', '2026-04-12 10:55:10', '2026-04-12 11:42:18'),
(7, 4, 5, '2026-04-12 11:56:07', 'submitted', '2026-04-12 11:56:07', '2026-04-13 10:00:34'),
(8, 1, 4, '2026-04-13 00:26:11', 'submitted', '2026-04-13 00:26:11', '2026-04-13 00:27:11'),
(9, 2, 6, '2026-04-13 09:41:50', 'submitted', '2026-04-13 09:41:50', '2026-04-13 09:42:59'),
(10, 1, 6, '2026-04-13 09:42:08', 'invited', '2026-04-13 09:42:08', '2026-04-13 09:51:51'),
(11, 4, 7, '2026-04-13 09:53:21', 'submitted', '2026-04-13 09:53:21', '2026-04-13 09:57:31'),
(12, 2, 7, '2026-04-13 09:53:39', 'submitted', '2026-04-13 09:53:39', '2026-04-13 09:56:26');

-- --------------------------------------------------------

--
-- Table structure for table `items_batch_categories`
--

CREATE TABLE `items_batch_categories` (
  `id_item_batch_category` int(10) UNSIGNED NOT NULL,
  `id_item` int(10) UNSIGNED DEFAULT NULL,
  `id_batch_category` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items_batch_categories`
--

INSERT INTO `items_batch_categories` (`id_item_batch_category`, `id_item`, `id_batch_category`, `quantity`) VALUES
(3, 1, 4, 10),
(4, 2, 4, 12),
(5, 3, 4, 8),
(6, 3, 5, 10),
(7, 3, 6, 10),
(8, 1, 7, 12);

-- --------------------------------------------------------

--
-- Table structure for table `master_category`
--

CREATE TABLE `master_category` (
  `id_master_category` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_category`
--

INSERT INTO `master_category` (`id_master_category`, `name`, `description`) VALUES
(1, 'IT Equipment', 'Peralatan teknologi informasi'),
(2, 'Office Supplies', 'Perlengkapan kantor');

-- --------------------------------------------------------

--
-- Table structure for table `master_items`
--

CREATE TABLE `master_items` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_category` int(10) UNSIGNED DEFAULT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `item_name` varchar(150) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_items`
--

INSERT INTO `master_items` (`id_item`, `id_category`, `item_code`, `item_name`, `unit`, `description`) VALUES
(1, 1, 'IT-001', 'Laptop Core i7 Gen 13', 'Unit', 'Laptop untuk kebutuhan kantor'),
(2, 1, 'IT-002', 'Monitor 24 inch FHD', 'Unit', 'Monitor LCD 24 inch'),
(3, 2, 'OS-001', 'Kertas A4 80gsm', 'Rim', 'Kertas fotokopi A4');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id_quotation` int(10) UNSIGNED NOT NULL,
  `id_invited_supplier` int(10) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'submitted',
  `note` text DEFAULT NULL,
  `po_file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id_quotation`, `id_invited_supplier`, `file_name`, `file_path`, `submitted_at`, `total_price`, `status`, `note`, `po_file_path`, `created_at`, `updated_at`) VALUES
(5, 5, '1775981185_Untitled (1).xlsx', 'quotations/tET0FOwGLuxH3HlxBas7SiUcpgB33GhrGOsz9rFN.xlsx', '2026-04-12 10:59:48', 2500000.00, 'approved', NULL, 'po/po_5_1776019487.pdf', '2026-04-12 10:59:48', '2026-04-12 11:44:49'),
(6, 6, '1775981185_Untitled (1).xlsx', 'quotations/0IUeHAtVEMzTIJYcijTAJQkBo8ZXP2gYjU5ykbNq.xlsx', '2026-04-12 11:42:17', 6000000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-12 11:42:17', '2026-04-12 11:44:49'),
(7, 8, 'quotation_items_filled.xlsx', 'quotations/cWBo81a92B8xK3oeD0DlpKCB0WHw6Lr6pyYB8M61.xlsx', '2026-04-13 00:27:10', 3500000.00, 'rejected', 'apakek', NULL, '2026-04-13 00:27:10', '2026-04-13 09:26:41'),
(8, 9, 'Untitled.xlsx', 'quotations/oAOUXXge2AbtL511xY0McCDAHXhvCRLoT2kwP7kl.xlsx', '2026-04-13 09:42:49', 100000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-13 09:42:49', '2026-04-13 09:44:53'),
(9, 10, 'Untitled.xlsx', 'quotations/lXMWOhfCIX8NXIwNsC6JDjFst6AMdAmDGGYcgp7D.xlsx', '2026-04-13 09:43:59', 150000.00, 'approved', NULL, 'po/po_9_1776098689.pdf', '2026-04-13 09:43:59', '2026-04-13 09:44:53'),
(10, 12, 'quotation_items_filled.xlsx', 'quotations/xNCSJpurgeTD578dVVEsPrwzIsJo8G3XzWYL6spP.xlsx', '2026-04-13 09:56:26', 120000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-13 09:56:26', '2026-04-13 09:58:38'),
(11, 11, 'quotation_items_filled.xlsx', 'quotations/cIb8UNik3Tu7OnBQf69eqWfZrFvz3JiyGIPXxSeE.xlsx', '2026-04-13 09:57:31', 100000.00, 'approved', NULL, 'po/po_11_1776099517.pdf', '2026-04-13 09:57:31', '2026-04-13 09:58:38'),
(12, 7, 'quotation_items_filled.xlsx', 'quotations/XNbXhfbc9aCiFglj5QvUJWgBozF89SAciiGqfxET.xlsx', '2026-04-13 10:00:34', 350000.00, 'rejected', 'testing tolak', NULL, '2026-04-13 10:00:34', '2026-04-13 10:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_quotation` int(10) UNSIGNED NOT NULL,
  `coll_no` varchar(255) DEFAULT NULL,
  `rfq_no` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `no_item` varchar(255) DEFAULT NULL,
  `material_no` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `qty` decimal(15,2) DEFAULT NULL,
  `uom` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `net_price` decimal(15,2) DEFAULT NULL,
  `incoterm` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `remark_1` text DEFAULT NULL,
  `remark_2` text DEFAULT NULL,
  `lead_time_weeks` varchar(255) DEFAULT NULL,
  `payment_term` varchar(255) DEFAULT NULL,
  `quotation_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `id_quotation`, `coll_no`, `rfq_no`, `vendor`, `no_item`, `material_no`, `description`, `qty`, `uom`, `currency`, `net_price`, `incoterm`, `destination`, `remark_1`, `remark_2`, `lead_time_weeks`, `payment_term`, `quotation_date`, `created_at`, `updated_at`) VALUES
(5, 5, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-04-12 10:59:52', '2026-04-12 10:59:52'),
(6, 7, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', NULL, '30 Days', '2026-04-12', '2026-04-13 00:27:11', '2026-04-13 00:27:11'),
(7, 7, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', NULL, '30 Days', '2026-04-12', '2026-04-13 00:27:11', '2026-04-13 00:27:11'),
(8, 7, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', NULL, '45 Days', '2026-04-12', '2026-04-13 00:27:11', '2026-04-13 00:27:11'),
(9, 7, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', NULL, '45 Days', '2026-04-12', '2026-04-13 00:27:11', '2026-04-13 00:27:11'),
(10, 8, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-04-13 09:42:59', '2026-04-13 09:42:59'),
(11, 9, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-04-13 09:43:59', '2026-04-13 09:43:59'),
(12, 10, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-13 09:56:26', '2026-04-13 09:56:26'),
(13, 10, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-13 09:56:26', '2026-04-13 09:56:26'),
(14, 10, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-13 09:56:26', '2026-04-13 09:56:26'),
(15, 10, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-13 09:56:26', '2026-04-13 09:56:26'),
(16, 11, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-13 09:57:31', '2026-04-13 09:57:31'),
(17, 11, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-13 09:57:31', '2026-04-13 09:57:31'),
(18, 11, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-13 09:57:31', '2026-04-13 09:57:31'),
(19, 11, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-13 09:57:31', '2026-04-13 09:57:31'),
(20, 12, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-13 10:00:34', '2026-04-13 10:00:34'),
(21, 12, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-13 10:00:34', '2026-04-13 10:00:34'),
(22, 12, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-13 10:00:34', '2026-04-13 10:00:34'),
(23, 12, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-13 10:00:34', '2026-04-13 10:00:34');

-- --------------------------------------------------------

--
-- Table structure for table `rfq_templates`
--

CREATE TABLE `rfq_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `uploaded_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rfq_templates`
--

INSERT INTO `rfq_templates` (`id`, `title`, `description`, `file_name`, `file_path`, `is_active`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 'untuk batch 1', 'testing', 'Untitled.xlsx', 'rfq-templates/1775981185_Untitled.xlsx', 1, 1, '2026-04-12 01:06:28', '2026-04-12 01:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `company_name`, `phone`, `address`, `npwp`, `created_at`, `updated_at`) VALUES
(1, 2, 'PT Demo Supplier Indonesia', '+62 21 5555 1234', 'Jl. Sudirman No. 88, Jakarta Pusat', '12.345.678.9-012.345', '2026-04-12 01:05:21', '2026-04-12 01:05:21'),
(2, 3, 'PT satnusa', '0812792392938', 'Batam', '12.345.678.9-012.000', '2026-04-12 01:13:59', '2026-04-12 01:13:59'),
(3, 4, 'CV', '086377139952', 'Jakarta Selatan', '432424242342343242', '2026-04-12 09:10:45', '2026-04-12 09:10:45'),
(4, 5, 'PT JASA KERJA', '081264820238', 'Kalimantan Tengah', '2489248924292489824', '2026-04-12 09:13:51', '2026-04-12 09:13:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','supplier') DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@rfqsystem.com', '$2y$12$nEj6xXyZl2S472wivCD9QOo9.mMbqBtHrqRk9/n9aDjQnX.YZxMEm', 'admin', 1, '2026-04-12 01:05:20', '2026-04-12 01:05:20'),
(2, 'Budi Santoso', 'supplier@demo.com', '$2y$12$fvHQuOSAu7qH6wGaHYd3.OE1yz9xtk9/U0Z5ijyFPSZV/pnt8Yu/2', 'supplier', 1, '2026-04-12 01:05:21', '2026-04-12 01:05:21'),
(3, 'Dimas Dwi Prasetiyo', 'ddimasddpprasetiyo@gmail.com', '$2y$12$oDgPqavOeF19RNJ.DkMbe.zPI7K/5Dqf8loxuF3iJGvd.TFwSNmVm', 'supplier', 1, '2026-04-12 01:13:59', '2026-04-12 01:13:59'),
(4, 'Bambang setyanto', 'dimasgantengsejagat@gmail.com', '$2y$12$7L5jO8Q1KFpgpZK8Wp3IqOKFK5C6Ln19c.K7EikY4up4qJuZXAaka', 'supplier', 1, '2026-04-12 09:10:45', '2026-04-12 09:10:45'),
(5, 'eka', 'dimasgtgsejagat@gmail.com', '$2y$12$3oglmyUvDxlKTImvlzPcFu8JUVAR4BfratNHkfoEwcxOGgXojO8o.', 'supplier', 1, '2026-04-12 09:13:51', '2026-04-12 09:13:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id_batch`),
  ADD KEY `batches_created_by_foreign` (`created_by`);

--
-- Indexes for table `batch_categories`
--
ALTER TABLE `batch_categories`
  ADD PRIMARY KEY (`id_batch_category`),
  ADD KEY `batch_categories_id_batch_foreign` (`id_batch`),
  ADD KEY `batch_categories_id_master_category_foreign` (`id_master_category`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invited_supplier_categories`
--
ALTER TABLE `invited_supplier_categories`
  ADD PRIMARY KEY (`id_invited_supplier`),
  ADD KEY `invited_supplier_categories_id_supplier_foreign` (`id_supplier`),
  ADD KEY `invited_supplier_categories_id_batch_category_foreign` (`id_batch_category`);

--
-- Indexes for table `items_batch_categories`
--
ALTER TABLE `items_batch_categories`
  ADD PRIMARY KEY (`id_item_batch_category`),
  ADD KEY `items_batch_categories_id_item_foreign` (`id_item`),
  ADD KEY `items_batch_categories_id_batch_category_foreign` (`id_batch_category`);

--
-- Indexes for table `master_category`
--
ALTER TABLE `master_category`
  ADD PRIMARY KEY (`id_master_category`);

--
-- Indexes for table `master_items`
--
ALTER TABLE `master_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `master_items_id_category_foreign` (`id_category`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id_quotation`),
  ADD KEY `quotations_id_invited_supplier_foreign` (`id_invited_supplier`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_items_id_quotation_foreign` (`id_quotation`);

--
-- Indexes for table `rfq_templates`
--
ALTER TABLE `rfq_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfq_templates_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id_batch` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batch_categories`
--
ALTER TABLE `batch_categories`
  MODIFY `id_batch_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `invited_supplier_categories`
--
ALTER TABLE `invited_supplier_categories`
  MODIFY `id_invited_supplier` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `items_batch_categories`
--
ALTER TABLE `items_batch_categories`
  MODIFY `id_item_batch_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_category`
--
ALTER TABLE `master_category`
  MODIFY `id_master_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_items`
--
ALTER TABLE `master_items`
  MODIFY `id_item` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id_quotation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `rfq_templates`
--
ALTER TABLE `rfq_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `batch_categories`
--
ALTER TABLE `batch_categories`
  ADD CONSTRAINT `batch_categories_id_batch_foreign` FOREIGN KEY (`id_batch`) REFERENCES `batches` (`id_batch`) ON DELETE CASCADE,
  ADD CONSTRAINT `batch_categories_id_master_category_foreign` FOREIGN KEY (`id_master_category`) REFERENCES `master_category` (`id_master_category`) ON DELETE CASCADE;

--
-- Constraints for table `invited_supplier_categories`
--
ALTER TABLE `invited_supplier_categories`
  ADD CONSTRAINT `invited_supplier_categories_id_batch_category_foreign` FOREIGN KEY (`id_batch_category`) REFERENCES `batch_categories` (`id_batch_category`) ON DELETE CASCADE,
  ADD CONSTRAINT `invited_supplier_categories_id_supplier_foreign` FOREIGN KEY (`id_supplier`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items_batch_categories`
--
ALTER TABLE `items_batch_categories`
  ADD CONSTRAINT `items_batch_categories_id_batch_category_foreign` FOREIGN KEY (`id_batch_category`) REFERENCES `batch_categories` (`id_batch_category`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_batch_categories_id_item_foreign` FOREIGN KEY (`id_item`) REFERENCES `master_items` (`id_item`) ON DELETE CASCADE;

--
-- Constraints for table `master_items`
--
ALTER TABLE `master_items`
  ADD CONSTRAINT `master_items_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `master_category` (`id_master_category`) ON DELETE SET NULL;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_id_invited_supplier_foreign` FOREIGN KEY (`id_invited_supplier`) REFERENCES `invited_supplier_categories` (`id_invited_supplier`) ON DELETE CASCADE;

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_id_quotation_foreign` FOREIGN KEY (`id_quotation`) REFERENCES `quotations` (`id_quotation`) ON DELETE CASCADE;

--
-- Constraints for table `rfq_templates`
--
ALTER TABLE `rfq_templates`
  ADD CONSTRAINT `rfq_templates_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
