-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 01:41 PM
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
(4, 'RFQ-20260413-0002', 'testing batch status', 'testing', '2026-04-15', 'closed', 1, '2026-04-13 09:41:05', '2026-04-13 09:52:07'),
(5, 'RFQ-20260413-0003', 'batch testing 123', 'testing', '2026-04-14', 'closed', 1, '2026-04-13 09:52:44', '2026-04-13 09:58:38'),
(7, 'RFQ-20260416-0001', 'TENDER Q4/2026 TESTING', 'tes', '2026-04-18', 'closed', 1, '2026-04-16 11:58:14', '2026-04-16 12:11:43'),
(8, 'RFQ-20260416-0002', 'testing email rejected', 'testing email rejected', '2026-04-25', 'closed', 1, '2026-04-16 12:30:48', '2026-04-24 11:47:34'),
(9, 'RFQ-20260417-0001', 'testing2', 'o', '2026-05-05', 'closed', 1, '2026-04-17 05:10:44', '2026-05-04 06:10:54'),
(10, 'RFQ-20260418-0001', 'testing all', 'testing all', '2026-04-24', 'closed', 1, '2026-04-18 03:40:09', '2026-04-24 11:46:37'),
(11, 'RFQ-20260421-0001', 'Pengadaan Peralatan Chemicals Q1 2026', 'Pengadaan Peralatan Chemicals Q1 2026', '2026-04-22', 'closed', 1, '2026-04-21 08:14:52', '2026-04-21 08:19:44'),
(12, 'RFQ-20260423-0001', 'tes', 'ts', '2026-04-29', 'closed', 1, '2026-04-23 06:13:15', '2026-04-24 11:55:06'),
(13, 'RFQ-20260503-0001', 'PENGADAAN BARANG UNTUK MBG 2026', 'TESTING', '2026-05-05', 'closed', 1, '2026-05-03 07:37:30', '2026-05-03 07:55:42'),
(14, 'RFQ-20260504-0001', 'testing 04/05/26', 'testing', '2026-05-20', 'closed', 1, '2026-05-04 06:11:28', '2026-05-19 09:24:17'),
(15, 'RFQ-20260504-0002', 'eee', 'ee', '2026-05-06', 'closed', 1, '2026-05-04 06:21:28', '2026-05-04 06:52:15'),
(16, 'RFQ-20260504-0003', 'ee', 'e', '2026-05-27', 'closed', 1, '2026-05-04 06:38:03', '2026-05-04 11:53:18'),
(17, 'RFQ-20260505-0001', 'testing demo', 'testing demo', '2026-05-20', 'closed', 1, '2026-05-05 05:52:38', '2026-05-19 11:24:29'),
(18, 'RFQ-20260519-0001', 'testing reminder', 'testing reminder', '2026-05-21', 'closed', 1, '2026-05-19 09:15:06', '2026-05-19 11:24:04'),
(19, 'RFQ-20260519-0002', 'testing reminder v2', 'testing reminder v2', '2026-05-22', 'closed', 1, '2026-05-19 09:46:00', '2026-05-19 11:23:46'),
(20, 'RFQ-20260519-0003', 'testing deadline', 'testing deadline', '2026-05-20', 'closed', 1, '2026-05-19 10:27:15', '2026-05-19 11:23:33'),
(24, 'RFQ-20260519-0004', 'testing reminder final v4', 'testing reminder final v4', '2026-05-21', 'closed', 1, '2026-05-19 12:26:15', '2026-06-05 13:35:33'),
(25, 'RFQ-20260520-0001', 'tessss', NULL, '2026-05-20', 'open', 1, '2026-05-19 19:39:59', '2026-05-19 19:40:48'),
(26, 'RFQ-20260605-0001', 'coba po', 'coba po', '2026-06-05', 'closed', 1, '2026-06-05 14:00:29', '2026-06-05 14:09:52');

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
(6, 4, 2),
(7, 5, 1),
(9, 7, 1),
(11, 8, 1),
(12, 9, 1),
(13, 10, 4),
(14, 11, 6),
(15, 12, 6),
(16, 13, 7),
(17, 14, 1),
(18, 15, 6),
(19, 16, 2),
(20, 17, 8),
(21, 18, 6),
(22, 19, 8),
(23, 20, 6),
(27, 24, 6),
(28, 24, 1),
(29, 25, 1),
(30, 26, 1);

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
(41, 'dimasgtgsejagat@gmail.com', 'Penawaran Tidak Diterima - Pengadaan Peralatan IT Q3 2026', 'quotation_rejected', '2026-04-13 10:01:02', '2026-04-13 10:01:02', '2026-04-13 10:01:02'),
(42, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: TENDER QE/2026 TESTING - E-Quotation System', 'rfq_invitation', '2026-04-14 07:33:19', '2026-04-14 07:33:19', '2026-04-14 07:33:19'),
(43, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: TENDER QE/2026 TESTING - E-Quotation System', 'rfq_invitation', '2026-04-14 07:33:52', '2026-04-14 07:33:52', '2026-04-14 07:33:52'),
(44, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - TENDER QE/2026 TESTING', 'quotation_submitted', '2026-04-14 07:35:50', '2026-04-14 07:35:50', '2026-04-14 07:35:50'),
(45, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - TENDER QE/2026 TESTING', 'quotation_submitted', '2026-04-14 07:36:55', '2026-04-14 07:36:55', '2026-04-14 07:36:55'),
(46, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - TENDER QE/2026 TESTING', 'quotation_approved', '2026-04-14 07:38:04', '2026-04-14 07:38:04', '2026-04-14 07:38:04'),
(47, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: TENDER QE/2026 TESTING - E-Quotation System', 'winner_reminder', '2026-04-14 07:40:45', '2026-04-14 07:40:45', '2026-04-14 07:40:45'),
(48, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: TENDER QE/2026 TESTING - E-Quotation System', 'winner_reminder', '2026-04-14 07:41:32', '2026-04-14 07:41:32', '2026-04-14 07:41:32'),
(49, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: TENDER Q4/2026 TESTING - E-Quotation System', 'rfq_invitation', '2026-04-16 11:59:54', '2026-04-16 11:59:54', '2026-04-16 11:59:54'),
(50, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: TENDER Q4/2026 TESTING - E-Quotation System', 'rfq_invitation', '2026-04-16 12:00:19', '2026-04-16 12:00:19', '2026-04-16 12:00:19'),
(51, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - TENDER Q4/2026 TESTING', 'quotation_submitted', '2026-04-16 12:05:57', '2026-04-16 12:05:57', '2026-04-16 12:05:57'),
(52, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - TENDER Q4/2026 TESTING', 'quotation_submitted', '2026-04-16 12:07:18', '2026-04-16 12:07:18', '2026-04-16 12:07:18'),
(53, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - TENDER Q4/2026 TESTING', 'quotation_approved', '2026-04-16 12:11:48', '2026-04-16 12:11:48', '2026-04-16 12:11:48'),
(54, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing email rejected - E-Quotation System', 'rfq_invitation', '2026-04-16 12:31:24', '2026-04-16 12:31:24', '2026-04-16 12:31:24'),
(55, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing email rejected', 'quotation_submitted', '2026-04-16 12:34:21', '2026-04-16 12:34:21', '2026-04-16 12:34:21'),
(56, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Tidak Diterima - testing email rejected', 'quotation_rejected', '2026-04-16 12:35:05', '2026-04-16 12:35:05', '2026-04-16 12:35:05'),
(57, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing2 - E-Quotation System', 'rfq_invitation', '2026-04-17 05:11:54', '2026-04-17 05:11:54', '2026-04-17 05:11:54'),
(58, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing2', 'quotation_submitted', '2026-04-17 05:35:09', '2026-04-17 05:35:09', '2026-04-17 05:35:09'),
(59, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - testing2', 'quotation_approved', '2026-04-17 05:37:51', '2026-04-17 05:37:51', '2026-04-17 05:37:51'),
(60, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing2 - E-Quotation System', 'rfq_invitation', '2026-04-17 06:06:02', '2026-04-17 06:06:02', '2026-04-17 06:06:02'),
(61, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing all - E-Quotation System', 'rfq_invitation', '2026-04-18 03:43:48', '2026-04-18 03:43:48', '2026-04-18 03:43:48'),
(62, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing all - E-Quotation System', 'rfq_invitation', '2026-04-18 03:43:54', '2026-04-18 03:43:54', '2026-04-18 03:43:54'),
(63, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing all', 'quotation_submitted', '2026-04-18 03:56:05', '2026-04-18 03:56:05', '2026-04-18 03:56:05'),
(64, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - testing all', 'quotation_submitted', '2026-04-18 04:06:02', '2026-04-18 04:06:02', '2026-04-18 04:06:02'),
(65, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - testing all', 'quotation_approved', '2026-04-18 04:07:09', '2026-04-18 04:07:09', '2026-04-18 04:07:09'),
(66, 'dimasgtgsejagat@gmail.com', 'Penawaran Tidak Diterima - testing all', 'quotation_rejected', '2026-04-18 04:07:14', '2026-04-18 04:07:14', '2026-04-18 04:07:14'),
(67, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing all - E-Quotation System', 'winner_reminder', '2026-04-18 07:53:18', '2026-04-18 07:53:18', '2026-04-18 07:53:18'),
(68, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing all - E-Quotation System', 'winner_reminder', '2026-04-18 07:53:35', '2026-04-18 07:53:35', '2026-04-18 07:53:35'),
(69, 'dimasgtgsejagat@gmail.com', 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System', 'supplier_activated', '2026-04-18 08:40:43', '2026-04-18 08:40:43', '2026-04-18 08:40:43'),
(70, 'dimasgtgsejagat@gmail.com', 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System', 'supplier_activated', '2026-04-18 08:43:20', '2026-04-18 08:43:20', '2026-04-18 08:43:20'),
(71, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: Pengadaan Peralatan Chemicals Q1 2026 - E-Quotation System', 'rfq_invitation', '2026-04-21 08:16:12', '2026-04-21 08:16:12', '2026-04-21 08:16:12'),
(72, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - Pengadaan Peralatan Chemicals Q1 2026', 'quotation_submitted', '2026-04-21 08:18:12', '2026-04-21 08:18:12', '2026-04-21 08:18:12'),
(73, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - Pengadaan Peralatan Chemicals Q1 2026', 'quotation_approved', '2026-04-21 08:19:48', '2026-04-21 08:19:48', '2026-04-21 08:19:48'),
(74, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: tes - E-Quotation System', 'rfq_invitation', '2026-04-23 06:14:25', '2026-04-23 06:14:25', '2026-04-23 06:14:25'),
(75, 'bpbatam@gmail.com', 'Registrasi Supplier Berhasil - E-Quotation System', 'supplier_registered', '2026-04-24 06:44:37', '2026-04-24 06:44:37', '2026-04-24 06:44:37'),
(76, 'quotation2611@gmail.com', 'Penawaran Baru: PT satnusa - tes', 'quotation_submitted', '2026-04-24 11:06:47', '2026-04-24 11:06:47', '2026-04-24 11:06:47'),
(77, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - tes', 'quotation_approved', '2026-04-24 11:10:22', '2026-04-24 11:10:22', '2026-04-24 11:10:22'),
(78, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:14:10', '2026-04-24 11:14:10', '2026-04-24 11:14:10'),
(79, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:14:40', '2026-04-24 11:14:40', '2026-04-24 11:14:40'),
(80, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:14:46', '2026-04-24 11:14:46', '2026-04-24 11:14:46'),
(81, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:15:00', '2026-04-24 11:15:00', '2026-04-24 11:15:00'),
(82, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:15:11', '2026-04-24 11:15:11', '2026-04-24 11:15:11'),
(83, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:18:53', '2026-04-24 11:18:53', '2026-04-24 11:18:53'),
(84, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:32:27', '2026-04-24 11:32:27', '2026-04-24 11:32:27'),
(85, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: tes - E-Quotation System', 'winner_reminder', '2026-04-24 11:34:13', '2026-04-24 11:34:13', '2026-04-24 11:34:13'),
(86, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing all - E-Quotation System', 'winner_reminder', '2026-04-24 11:38:10', '2026-04-24 11:38:10', '2026-04-24 11:38:10'),
(87, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing all - E-Quotation System', 'winner_reminder', '2026-04-24 11:46:10', '2026-04-24 11:46:10', '2026-04-24 11:46:10'),
(88, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing all - E-Quotation System', 'winner_reminder', '2026-04-24 11:46:43', '2026-04-24 11:46:43', '2026-04-24 11:46:43'),
(89, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing2 - E-Quotation System', 'winner_reminder', '2026-04-24 11:51:02', '2026-04-24 11:51:02', '2026-04-24 11:51:02'),
(90, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing2 - E-Quotation System', 'winner_reminder', '2026-04-24 11:51:12', '2026-04-24 11:51:12', '2026-04-24 11:51:12'),
(91, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing2 - E-Quotation System', 'winner_reminder', '2026-04-24 11:52:13', '2026-04-24 11:52:13', '2026-04-24 11:52:13'),
(92, 'quotation2611@gmail.com', 'Penawaran Baru: PT satnusa - tes', 'quotation_submitted', '2026-04-24 11:53:21', '2026-04-24 11:53:21', '2026-04-24 11:53:21'),
(93, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - tes', 'quotation_approved', '2026-04-24 11:55:13', '2026-04-24 11:55:13', '2026-04-24 11:55:13'),
(94, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - eee', 'quotation_submitted', '2026-05-04 06:46:45', '2026-05-04 06:46:45', '2026-05-04 06:46:45'),
(95, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - eee', 'quotation_approved', '2026-05-04 06:49:12', '2026-05-04 06:49:12', '2026-05-04 06:49:12'),
(96, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: eee - E-Quotation System', 'winner_reminder', '2026-05-04 06:50:43', '2026-05-04 06:50:43', '2026-05-04 06:50:43'),
(97, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: eee - E-Quotation System', 'winner_reminder', '2026-05-04 06:50:49', '2026-05-04 06:50:49', '2026-05-04 06:50:49'),
(98, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: eee - E-Quotation System', 'winner_reminder', '2026-05-04 06:52:20', '2026-05-04 06:52:20', '2026-05-04 06:52:20'),
(99, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - ee', 'quotation_submitted', '2026-05-04 11:50:33', '2026-05-04 11:50:33', '2026-05-04 11:50:33'),
(100, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - ee', 'quotation_submitted', '2026-05-04 11:51:56', '2026-05-04 11:51:56', '2026-05-04 11:51:56'),
(101, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - ee', 'quotation_approved', '2026-05-04 11:53:22', '2026-05-04 11:53:22', '2026-05-04 11:53:22'),
(102, 'dimasgtgsejagat@gmail.com', 'Penawaran Tidak Diterima - ee', 'quotation_rejected', '2026-05-04 11:53:27', '2026-05-04 11:53:27', '2026-05-04 11:53:27'),
(103, 'majujaya@gmail.com', 'Undangan RFQ: testing demo - E-Quotation System', 'rfq_invitation', '2026-05-05 05:54:06', '2026-05-05 05:54:06', '2026-05-05 05:54:06'),
(104, 'batam@gmail.com', 'Registrasi Supplier Berhasil - E-Quotation System', 'supplier_registered', '2026-05-05 07:26:22', '2026-05-05 07:26:22', '2026-05-05 07:26:22'),
(105, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing reminder - E-Quotation System', 'rfq_invitation', '2026-05-19 09:17:52', '2026-05-19 09:17:52', '2026-05-19 09:17:52'),
(106, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing reminder', 'quotation_submitted', '2026-05-19 09:20:46', '2026-05-19 09:20:46', '2026-05-19 09:20:46'),
(107, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - testing reminder', 'quotation_approved', '2026-05-19 09:22:00', '2026-05-19 09:22:00', '2026-05-19 09:22:00'),
(108, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing 04/05/26 - E-Quotation System', 'winner_reminder', '2026-05-19 09:24:22', '2026-05-19 09:24:22', '2026-05-19 09:24:22'),
(109, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder - E-Quotation System', 'winner_reminder', '2026-05-19 09:25:41', '2026-05-19 09:25:41', '2026-05-19 09:25:41'),
(110, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder - E-Quotation System', 'winner_reminder', '2026-05-19 09:26:26', '2026-05-19 09:26:26', '2026-05-19 09:26:26'),
(111, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder - E-Quotation System', 'winner_reminder', '2026-05-19 09:29:01', '2026-05-19 09:29:01', '2026-05-19 09:29:01'),
(112, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder - E-Quotation System', 'winner_reminder', '2026-05-19 09:44:48', '2026-05-19 09:44:48', '2026-05-19 09:44:48'),
(113, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing reminder v2 - E-Quotation System', 'rfq_invitation', '2026-05-19 09:46:59', '2026-05-19 09:46:59', '2026-05-19 09:46:59'),
(114, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - testing reminder v2', 'quotation_submitted', '2026-05-19 09:48:23', '2026-05-19 09:48:23', '2026-05-19 09:48:23'),
(115, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - testing reminder v2', 'quotation_approved', '2026-05-19 09:48:58', '2026-05-19 09:48:58', '2026-05-19 09:48:58'),
(116, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing reminder v2 - E-Quotation System', 'winner_reminder', '2026-05-19 09:51:28', '2026-05-19 09:51:28', '2026-05-19 09:51:28'),
(117, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder v2', 'deadline_reminder', '2026-05-19 10:02:14', '2026-05-19 10:02:14', '2026-05-19 10:02:14'),
(118, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing deadline - E-Quotation System', 'rfq_invitation', '2026-05-19 10:28:06', '2026-05-19 10:28:06', '2026-05-19 10:28:06'),
(119, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing deadline - E-Quotation System', 'rfq_invitation', '2026-05-19 10:28:36', '2026-05-19 10:28:36', '2026-05-19 10:28:36'),
(120, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing last all reminder - E-Quotation System', 'rfq_invitation', '2026-05-19 11:04:13', '2026-05-19 11:04:13', '2026-05-19 11:04:13'),
(121, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - testing last all reminder', 'quotation_submitted', '2026-05-19 11:04:59', '2026-05-19 11:04:59', '2026-05-19 11:04:59'),
(122, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing last all reminder - E-Quotation System', 'rfq_invitation', '2026-05-19 11:06:49', '2026-05-19 11:06:49', '2026-05-19 11:06:49'),
(123, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder v2', 'deadline_reminder', '2026-05-19 11:07:51', '2026-05-19 11:07:51', '2026-05-19 11:07:51'),
(124, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:07:56', '2026-05-19 11:07:56', '2026-05-19 11:07:56'),
(125, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:08:00', '2026-05-19 11:08:00', '2026-05-19 11:08:00'),
(126, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:08:04', '2026-05-19 11:08:04', '2026-05-19 11:08:04'),
(127, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:08:09', '2026-05-19 11:08:09', '2026-05-19 11:08:09'),
(128, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing last all reminder', 'quotation_submitted', '2026-05-19 11:11:01', '2026-05-19 11:11:01', '2026-05-19 11:11:01'),
(129, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - testing last all reminder', 'quotation_approved', '2026-05-19 11:11:40', '2026-05-19 11:11:40', '2026-05-19 11:11:40'),
(130, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Tidak Diterima - testing last all reminder', 'quotation_rejected', '2026-05-19 11:11:45', '2026-05-19 11:11:45', '2026-05-19 11:11:45'),
(131, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:16:02', '2026-05-19 11:16:02', '2026-05-19 11:16:02'),
(132, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:16:31', '2026-05-19 11:16:31', '2026-05-19 11:16:31'),
(133, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder v2', 'deadline_reminder', '2026-05-19 11:16:39', '2026-05-19 11:16:39', '2026-05-19 11:16:39'),
(134, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:16:43', '2026-05-19 11:16:43', '2026-05-19 11:16:43'),
(135, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:16:47', '2026-05-19 11:16:47', '2026-05-19 11:16:47'),
(136, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:18:38', '2026-05-19 11:18:38', '2026-05-19 11:18:38'),
(137, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder v2', 'deadline_reminder', '2026-05-19 11:18:47', '2026-05-19 11:18:47', '2026-05-19 11:18:47'),
(138, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:18:51', '2026-05-19 11:18:51', '2026-05-19 11:18:51'),
(139, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:18:56', '2026-05-19 11:18:56', '2026-05-19 11:18:56'),
(140, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:20:28', '2026-05-19 11:20:28', '2026-05-19 11:20:28'),
(141, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder v2', 'deadline_reminder', '2026-05-19 11:20:35', '2026-05-19 11:20:35', '2026-05-19 11:20:35'),
(142, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:20:39', '2026-05-19 11:20:39', '2026-05-19 11:20:39'),
(143, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:20:44', '2026-05-19 11:20:44', '2026-05-19 11:20:44'),
(144, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:21:31', '2026-05-19 11:21:31', '2026-05-19 11:21:31'),
(145, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:21:39', '2026-05-19 11:21:39', '2026-05-19 11:21:39'),
(146, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder v2', 'deadline_reminder', '2026-05-19 11:22:27', '2026-05-19 11:22:27', '2026-05-19 11:22:27'),
(147, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:22:31', '2026-05-19 11:22:31', '2026-05-19 11:22:31'),
(148, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing deadline', 'deadline_reminder', '2026-05-19 11:22:35', '2026-05-19 11:22:35', '2026-05-19 11:22:35'),
(149, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing reminder v2 - E-Quotation System', 'winner_reminder', '2026-05-19 11:23:51', '2026-05-19 11:23:51', '2026-05-19 11:23:51'),
(150, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing reminder v2 - E-Quotation System', 'winner_reminder', '2026-05-19 11:23:55', '2026-05-19 11:23:55', '2026-05-19 11:23:55'),
(151, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:24:08', '2026-05-19 11:24:08', '2026-05-19 11:24:08'),
(152, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:25:42', '2026-05-19 11:25:42', '2026-05-19 11:25:42'),
(153, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:25:51', '2026-05-19 11:25:51', '2026-05-19 11:25:51'),
(154, 'ddimasddpprasetiyo@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:25:55', '2026-05-19 11:25:55', '2026-05-19 11:25:55'),
(155, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:32:48', '2026-05-19 11:32:48', '2026-05-19 11:32:48'),
(156, 'ddimasddpprasetiyo@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:32:53', '2026-05-19 11:32:53', '2026-05-19 11:32:53'),
(157, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:39:30', '2026-05-19 11:39:30', '2026-05-19 11:39:30'),
(158, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:40:14', '2026-05-19 11:40:14', '2026-05-19 11:40:14'),
(159, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:44:56', '2026-05-19 11:44:56', '2026-05-19 11:44:56'),
(160, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:45:52', '2026-05-19 11:45:52', '2026-05-19 11:45:52'),
(161, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing last all reminder - E-Quotation System', 'winner_reminder', '2026-05-19 11:46:01', '2026-05-19 11:46:01', '2026-05-19 11:46:01'),
(162, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:51:08', '2026-05-19 11:51:08', '2026-05-19 11:51:08'),
(163, 'ddimasddpprasetiyo@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:51:12', '2026-05-19 11:51:12', '2026-05-19 11:51:12'),
(164, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:54:37', '2026-05-19 11:54:37', '2026-05-19 11:54:37'),
(165, 'ddimasddpprasetiyo@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 11:54:41', '2026-05-19 11:54:41', '2026-05-19 11:54:41'),
(166, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing last all reminder', 'deadline_reminder', '2026-05-19 12:00:38', '2026-05-19 12:00:38', '2026-05-19 12:00:38'),
(167, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing reminder final v3 - E-Quotation System', 'rfq_invitation', '2026-05-19 12:03:06', '2026-05-19 12:03:06', '2026-05-19 12:03:06'),
(168, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing reminder final v3 - E-Quotation System', 'rfq_invitation', '2026-05-19 12:03:13', '2026-05-19 12:03:13', '2026-05-19 12:03:13'),
(169, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing reminder final v3', 'quotation_submitted', '2026-05-19 12:04:44', '2026-05-19 12:04:44', '2026-05-19 12:04:44'),
(170, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - testing reminder final v3', 'quotation_approved', '2026-05-19 12:05:29', '2026-05-19 12:05:29', '2026-05-19 12:05:29'),
(171, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing reminder final v3 - E-Quotation System', 'rfq_invitation', '2026-05-19 12:07:19', '2026-05-19 12:07:19', '2026-05-19 12:07:19'),
(172, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing reminder final v3 - E-Quotation System', 'rfq_invitation', '2026-05-19 12:07:26', '2026-05-19 12:07:26', '2026-05-19 12:07:26'),
(173, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing reminder final v3', 'quotation_submitted', '2026-05-19 12:08:23', '2026-05-19 12:08:23', '2026-05-19 12:08:23'),
(174, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - testing reminder final v3', 'quotation_submitted', '2026-05-19 12:09:28', '2026-05-19 12:09:28', '2026-05-19 12:09:28'),
(175, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - testing reminder final v3', 'quotation_approved', '2026-05-19 12:10:08', '2026-05-19 12:10:08', '2026-05-19 12:10:08'),
(176, 'dimasgtgsejagat@gmail.com', 'Penawaran Tidak Diterima - testing reminder final v3', 'quotation_rejected', '2026-05-19 12:10:13', '2026-05-19 12:10:13', '2026-05-19 12:10:13'),
(177, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:11:13', '2026-05-19 12:11:13', '2026-05-19 12:11:13'),
(178, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:11:46', '2026-05-19 12:11:46', '2026-05-19 12:11:46'),
(179, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:12:39', '2026-05-19 12:12:39', '2026-05-19 12:12:39'),
(180, 'ddimasddpprasetiyo@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder final v3', 'deadline_reminder', '2026-05-19 12:13:06', '2026-05-19 12:13:06', '2026-05-19 12:13:06'),
(181, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:13:45', '2026-05-19 12:13:45', '2026-05-19 12:13:45'),
(182, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:14:01', '2026-05-19 12:14:01', '2026-05-19 12:14:01'),
(183, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:14:17', '2026-05-19 12:14:17', '2026-05-19 12:14:17'),
(184, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing reminder final v3', 'deadline_reminder', '2026-05-19 12:14:35', '2026-05-19 12:14:35', '2026-05-19 12:14:35'),
(185, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:22:30', '2026-05-19 12:22:30', '2026-05-19 12:22:30'),
(186, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:22:38', '2026-05-19 12:22:38', '2026-05-19 12:22:38'),
(187, 'ddimasddpprasetiyo@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder final v3', 'deadline_reminder', '2026-05-19 12:22:53', '2026-05-19 12:22:53', '2026-05-19 12:22:53'),
(188, 'ddimasddpprasetiyo@gmail.com', 'Informasi Pengadaan: testing reminder final v3 - E-Quotation System', 'winner_reminder', '2026-05-19 12:23:45', '2026-05-19 12:23:45', '2026-05-19 12:23:45'),
(189, 'ddimasddpprasetiyo@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing reminder final v3', 'deadline_reminder', '2026-05-19 12:23:56', '2026-05-19 12:23:56', '2026-05-19 12:23:56'),
(190, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing reminder final v4 - E-Quotation System', 'rfq_invitation', '2026-05-19 12:26:51', '2026-05-19 12:26:51', '2026-05-19 12:26:51'),
(191, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing reminder final v4 - E-Quotation System', 'rfq_invitation', '2026-05-19 12:26:59', '2026-05-19 12:26:59', '2026-05-19 12:26:59'),
(192, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT satnusa - testing reminder final v4', 'quotation_submitted', '2026-05-19 12:27:50', '2026-05-19 12:27:50', '2026-05-19 12:27:50'),
(193, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - testing reminder final v4', 'quotation_submitted', '2026-05-19 12:28:30', '2026-05-19 12:28:30', '2026-05-19 12:28:30'),
(194, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: testing reminder final v4 - E-Quotation System', 'rfq_invitation', '2026-05-19 19:35:46', '2026-05-19 19:35:46', '2026-05-19 19:35:46'),
(195, 'ddimasddpprasetiyo@gmail.com', 'Undangan RFQ: testing reminder final v4 - E-Quotation System', 'rfq_invitation', '2026-05-19 19:35:52', '2026-05-19 19:35:52', '2026-05-19 19:35:52'),
(196, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: tessss - E-Quotation System', 'rfq_invitation', '2026-05-19 19:40:48', '2026-05-19 19:40:48', '2026-05-19 19:40:48'),
(197, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - tessss', 'quotation_submitted', '2026-05-19 19:49:12', '2026-05-19 19:49:12', '2026-05-19 19:49:12'),
(198, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - testing reminder final v4', 'quotation_submitted', '2026-05-19 19:52:04', '2026-05-19 19:52:04', '2026-05-19 19:52:04'),
(199, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - testing reminder final v4', 'quotation_approved', '2026-05-19 19:53:12', '2026-05-19 19:53:12', '2026-05-19 19:53:12'),
(200, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing reminder final v4 - E-Quotation System', 'winner_reminder', '2026-05-19 19:54:45', '2026-05-19 19:54:45', '2026-05-19 19:54:45'),
(201, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder final v4', 'deadline_reminder', '2026-05-19 19:55:46', '2026-05-19 19:55:46', '2026-05-19 19:55:46'),
(202, 'dimasgtgsejagat@gmail.com', '⏰ 3 Hari Lagi — Deadline RFQ: testing reminder final v4', 'deadline_reminder', '2026-05-19 19:55:52', '2026-05-19 19:55:52', '2026-05-19 19:55:52'),
(203, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: testing reminder final v4 - E-Quotation System', 'winner_reminder', '2026-05-19 19:56:30', '2026-05-19 19:56:30', '2026-05-19 19:56:30'),
(204, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing reminder final v4', 'deadline_reminder', '2026-05-19 19:56:41', '2026-05-19 19:56:41', '2026-05-19 19:56:41'),
(205, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing reminder final v4', 'deadline_reminder', '2026-05-19 19:56:46', '2026-05-19 19:56:46', '2026-05-19 19:56:46'),
(206, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing reminder final v4', 'deadline_reminder', '2026-05-20 13:58:25', '2026-05-20 13:58:25', '2026-05-20 13:58:25'),
(207, 'dimasgtgsejagat@gmail.com', '🚨 BESOK DEADLINE! — Deadline RFQ: testing reminder final v4', 'deadline_reminder', '2026-05-20 13:58:31', '2026-05-20 13:58:31', '2026-05-20 13:58:31'),
(208, 'Tigernix@gmail.com', 'Registrasi Supplier Berhasil - E-Quotation System', 'supplier_registered', '2026-05-24 13:29:18', '2026-05-24 13:29:18', '2026-05-24 13:29:18'),
(209, 'Tigernix@gmail.com', 'Akun Supplier Anda Telah Diaktifkan - E-Quotation System', 'supplier_activated', '2026-05-24 13:30:25', '2026-05-24 13:30:25', '2026-05-24 13:30:25'),
(210, 'ddimasddpprasetiyo@gmail.com', '🎉 Penawaran Anda Diterima - testing reminder final v4', 'quotation_approved', '2026-06-05 13:35:38', '2026-06-05 13:35:38', '2026-06-05 13:35:38'),
(211, 'dimasgtgsejagat@gmail.com', 'Penawaran Tidak Diterima - testing reminder final v4', 'quotation_rejected', '2026-06-05 13:35:42', '2026-06-05 13:35:42', '2026-06-05 13:35:42'),
(212, 'dimasgtgsejagat@gmail.com', 'Undangan RFQ: coba po - E-Quotation System', 'rfq_invitation', '2026-06-05 14:01:51', '2026-06-05 14:01:51', '2026-06-05 14:01:51'),
(213, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - coba po', 'quotation_submitted', '2026-06-05 14:03:23', '2026-06-05 14:03:23', '2026-06-05 14:03:23'),
(214, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - coba po', 'quotation_approved', '2026-06-05 14:04:00', '2026-06-05 14:04:00', '2026-06-05 14:04:00'),
(215, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: coba po - E-Quotation System', 'winner_reminder', '2026-06-05 14:07:47', '2026-06-05 14:07:47', '2026-06-05 14:07:47'),
(216, 'dimasgtgsejagat@gmail.com', 'Informasi Pengadaan: coba po - E-Quotation System', 'winner_reminder', '2026-06-05 14:08:10', '2026-06-05 14:08:10', '2026-06-05 14:08:10'),
(217, 'ddimasddpprasetiyo@gmail.com', 'Penawaran Baru: PT JASA KERJA - coba po', 'quotation_submitted', '2026-06-05 14:09:26', '2026-06-05 14:09:26', '2026-06-05 14:09:26'),
(218, 'dimasgtgsejagat@gmail.com', '🎉 Penawaran Anda Diterima - coba po', 'quotation_approved', '2026-06-05 14:10:01', '2026-06-05 14:10:01', '2026-06-05 14:10:01');

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
(9, 2, 6, '2026-04-13 09:41:50', 'submitted', '2026-04-13 09:41:50', '2026-04-13 09:42:59'),
(10, 1, 6, '2026-04-13 09:42:08', 'invited', '2026-04-13 09:42:08', '2026-04-13 09:51:51'),
(11, 4, 7, '2026-04-13 09:53:21', 'submitted', '2026-04-13 09:53:21', '2026-04-13 09:57:31'),
(12, 2, 7, '2026-04-13 09:53:39', 'submitted', '2026-04-13 09:53:39', '2026-04-13 09:56:26'),
(15, 4, 9, '2026-04-16 11:59:48', 'submitted', '2026-04-16 11:59:48', '2026-04-16 12:07:13'),
(16, 2, 9, '2026-04-16 12:00:14', 'submitted', '2026-04-16 12:00:14', '2026-04-16 12:05:52'),
(17, 2, 11, '2026-04-16 12:31:20', 'submitted', '2026-04-16 12:31:20', '2026-04-16 12:34:16'),
(18, 2, 12, '2026-04-17 05:11:48', 'invited', '2026-04-17 05:11:48', '2026-05-04 06:08:33'),
(19, 4, 12, '2026-04-17 06:05:56', 'invited', '2026-04-17 06:05:56', '2026-04-17 06:05:56'),
(20, 4, 13, '2026-04-18 03:43:38', 'submitted', '2026-04-18 03:43:38', '2026-04-18 04:05:57'),
(21, 2, 13, '2026-04-18 03:43:48', 'invited', '2026-04-18 03:43:48', '2026-04-18 07:53:30'),
(22, 4, 14, '2026-04-21 08:16:04', 'winner', '2026-04-21 08:16:04', '2026-04-21 08:19:44'),
(23, 2, 15, '2026-04-23 06:14:18', 'winner', '2026-04-23 06:14:18', '2026-04-24 11:55:06'),
(24, 6, 16, '2026-05-03 07:44:43', 'winner', '2026-05-03 07:44:43', '2026-05-03 07:55:42'),
(25, 4, 17, '2026-05-04 06:12:31', 'submitted', '2026-05-04 06:12:31', '2026-05-04 06:29:35'),
(26, 2, 17, '2026-05-04 06:12:33', 'submitted', '2026-05-04 06:12:33', '2026-05-04 06:25:10'),
(27, 4, 18, '2026-05-04 06:21:54', 'invited', '2026-05-04 06:21:54', '2026-05-04 06:21:54'),
(28, 2, 18, '2026-05-04 06:21:57', 'invited', '2026-05-04 06:21:57', '2026-05-04 06:50:29'),
(29, 4, 19, '2026-05-04 06:38:41', 'submitted', '2026-05-04 06:38:41', '2026-05-04 11:51:52'),
(30, 2, 19, '2026-05-04 06:38:45', 'winner', '2026-05-04 06:38:45', '2026-05-04 11:53:18'),
(31, 6, 20, '2026-05-05 05:54:00', 'invited', '2026-05-05 05:54:00', '2026-05-05 05:54:00'),
(32, 2, 21, '2026-05-19 09:17:45', 'invited', '2026-05-19 09:17:45', '2026-05-19 09:26:21'),
(33, 4, 22, '2026-05-19 09:46:53', 'invited', '2026-05-19 09:46:53', '2026-05-19 09:51:22'),
(34, 4, 23, '2026-05-19 10:28:01', 'invited', '2026-05-19 10:28:01', '2026-05-19 10:28:01'),
(35, 2, 23, '2026-05-19 10:28:31', 'invited', '2026-05-19 10:28:31', '2026-05-19 10:28:31'),
(42, 4, 27, '2026-05-19 12:26:45', 'submitted', '2026-05-19 12:26:45', '2026-05-19 12:28:26'),
(43, 2, 27, '2026-05-19 12:26:52', 'winner', '2026-05-19 12:26:52', '2026-06-05 13:35:33'),
(44, 4, 28, '2026-05-19 19:35:41', 'invited', '2026-05-19 19:35:41', '2026-05-19 19:54:40'),
(45, 2, 28, '2026-05-19 19:35:47', 'invited', '2026-05-19 19:35:47', '2026-05-19 19:35:47'),
(46, 4, 29, '2026-05-19 19:40:42', 'submitted', '2026-05-19 19:40:42', '2026-05-19 19:49:06'),
(47, 4, 30, '2026-06-05 14:01:43', 'winner', '2026-06-05 14:01:43', '2026-06-05 14:09:52');

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
(7, 3, 6, 10),
(8, 1, 7, 12),
(10, 1, 9, 90),
(11, 2, 9, 90),
(12, 4, 9, 76),
(14, 1, 11, 7),
(15, 1, 12, 89),
(16, 3, 12, 90),
(17, 3, 13, 7),
(18, 5, 13, 56),
(19, 4, 13, 54),
(20, 7, 14, 12),
(21, 6, 14, 23),
(22, 8, 14, 90),
(23, 2, 15, 9),
(24, 3, 15, 12),
(25, 9, 16, 20),
(26, 10, 16, 90),
(27, 1, 17, 2),
(28, 2, 17, 23),
(29, 3, 18, 2),
(30, 3, 20, 90),
(31, 7, 21, 12),
(32, 9, 21, 32),
(33, 5, 22, 12),
(34, 9, 23, 12),
(37, 7, 30, 12);

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
(2, 'Office Supplies', 'Perlengkapan kantor'),
(4, 'testing baru2', 'testing baru'),
(6, 'Chemicals Equipment', 'Chemicals Equipment'),
(7, 'MBG 2026', 'MBG 2026'),
(8, 'testing demo', NULL);

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
(1, 4, 'IT-001', 'Laptop Core i7 Gen 13', 'Unit', 'Laptop untuk kebutuhan kantor'),
(2, 1, 'IT-002', 'Monitor 24 inch FHD', 'Unit', 'Monitor LCD 24 inch'),
(3, 4, 'OS-001', 'Kertas A4 80gsm', 'Rim', 'Kertas fotokopi A4'),
(4, 1, 'ITM-003', 'printer', 'kg', 'testing'),
(5, 4, 'ITM-004', 'meja kerja', 'kg', 'testing'),
(6, 6, 'ITM-005', 'zat kimia', 'pcs', NULL),
(7, 6, 'ITM-006', 'gelas ukur', 'pcs', NULL),
(8, 6, 'ITM-007', 'tabung reaksi', 'pcs', NULL),
(9, 7, 'ITM-008', 'Galon Air', 'kg', 'testing'),
(10, 7, 'ITM-009', 'renteng bekal', 'kg', 'testing');

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
(1, '2026_05_24_195134_add_business_field_to_suppliers_table', 1);

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
(8, 9, 'Untitled.xlsx', 'quotations/oAOUXXge2AbtL511xY0McCDAHXhvCRLoT2kwP7kl.xlsx', '2026-04-13 09:42:49', 100000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-13 09:42:49', '2026-04-13 09:44:53'),
(9, 10, 'Untitled.xlsx', 'quotations/lXMWOhfCIX8NXIwNsC6JDjFst6AMdAmDGGYcgp7D.xlsx', '2026-04-13 09:43:59', 150000.00, 'approved', NULL, 'po/po_9_1776098689.pdf', '2026-04-13 09:43:59', '2026-04-13 09:44:53'),
(10, 12, 'quotation_items_filled.xlsx', 'quotations/xNCSJpurgeTD578dVVEsPrwzIsJo8G3XzWYL6spP.xlsx', '2026-04-13 09:56:26', 120000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-13 09:56:26', '2026-04-13 09:58:38'),
(11, 11, 'quotation_items_filled.xlsx', 'quotations/cIb8UNik3Tu7OnBQf69eqWfZrFvz3JiyGIPXxSeE.xlsx', '2026-04-13 09:57:31', 100000.00, 'approved', NULL, 'po/po_11_1776099517.pdf', '2026-04-13 09:57:31', '2026-04-13 09:58:38'),
(15, 16, 'Untitled.xlsx', 'quotations/VbTEXrMXYX90lOPzWlAw4Gw7aPp7hNTZ6E1mZ4vp.xlsx', '2026-04-16 12:05:45', 90000000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-16 12:05:45', '2026-04-16 12:11:43'),
(16, 15, '1775981185_Untitled.xlsx', 'quotations/HEr9cCCKCwrV2l9nwpWnae4VB0oUl3qT71El8TOo.xlsx', '2026-04-16 12:07:13', 70000000.00, 'approved', NULL, 'po/po_16_1776366701.pdf', '2026-04-16 12:07:13', '2026-04-16 12:11:43'),
(17, 17, 'quotation_items_filled.xlsx', 'quotations/kJbxUaSNRPkZWCCDrwO5HRdSNBseK9OCjVNqMfVP.xlsx', '2026-04-16 12:34:16', 700000.00, 'rejected', 'ga sesuai', NULL, '2026-04-16 12:34:16', '2026-04-16 12:35:01'),
(18, 18, 'quotation_items_filled.xlsx', 'quotations/je4DwRrByp8UZrRfcKMnGiCZQ9LCldTiVziv6BEU.xlsx', '2026-04-17 05:34:53', 900000.00, 'approved', NULL, 'po/po_18_1776429462.pdf', '2026-04-17 05:34:53', '2026-04-17 05:37:45'),
(19, 21, 'quotation_items_filled.xlsx', 'quotations/L2YA0MTAeQABUegciBv0iCuN7yR1PNwiZkZWv2sR.xlsx', '2026-04-18 03:55:52', 700000.00, 'approved', NULL, 'po/po_19_1776510422.pdf', '2026-04-18 03:55:52', '2026-04-18 04:07:04'),
(20, 20, 'quotation_items_filled.xlsx', 'quotations/9ptJf6j8t3osSj6BNYQR9LpFNhpzdIezUmqj3Bec.xlsx', '2026-04-18 04:05:57', 900000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-04-18 04:05:57', '2026-04-18 04:07:04'),
(21, 22, 'quotation_items_filled.xlsx', 'quotations/tCLGM06G7SUyP5NhtFZWjNAklkdR8ei0hjJDyQER.xlsx', '2026-04-21 08:18:00', 8000000.00, 'approved', NULL, 'po/po_21_1776784781.pdf', '2026-04-21 08:18:00', '2026-04-21 08:19:44'),
(22, 23, 'quotation_items_filled.xlsx', 'quotations/8IKxMMfXeu3IJYrlIxFUwFUqZO3jioJUW2p61V2d.xlsx', '2026-04-24 11:06:33', 11999999.00, 'approved', NULL, 'po/po_22_1777054214.pdf', '2026-04-24 11:06:33', '2026-04-24 11:10:16'),
(23, 23, 'quotation_items_filled.xlsx', 'quotations/53cBf0645X1rJlVHMMAyaS6H2GddRTPqRO2QlAr9.xlsx', '2026-04-24 11:53:08', 200000.00, 'approved', NULL, 'po/po_23_1777056903.pdf', '2026-04-24 11:53:08', '2026-04-24 11:55:06'),
(24, 24, 'quotation_items_filled.xlsx', 'quotations/gvHJQh043m4CIG9G7OrvvE3cmGIMQ6TCS6IN1UDA.xlsx', '2026-05-03 07:49:21', 50000000.00, 'approved', NULL, 'po/po_24_1777819873.pdf', '2026-05-03 07:49:21', '2026-05-03 07:51:15'),
(25, 24, 'quotation_items_filled.xlsx', 'quotations/fjVx4i5xWQGXj5vpmbaHPTFUsmNWH4ZExlvNUUj9.xlsx', '2026-05-03 07:54:45', 120000000.00, 'approved', NULL, 'po/po_25_1777820142.pdf', '2026-05-03 07:54:45', '2026-05-03 07:55:42'),
(26, 18, '1775981185_Untitled.xlsx', 'quotations/PmTULDAZl6n2ncX5yMAwcFCGQfC2tmU4OXHFjhMK.xlsx', '2026-05-04 05:53:25', 900000.00, 'rejected', 'testing', NULL, '2026-05-04 05:53:25', '2026-05-04 06:09:12'),
(27, 26, 'gvHJQh043m4CIG9G7OrvvE3cmGIMQ6TCS6IN1UDA.xlsx', 'quotations/zlzX2Z42iF7eWoeNSB1mN4u9R7Gy3ajDVd5rs1Bj.xlsx', '2026-05-04 06:25:10', 200000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-05-04 06:25:10', '2026-05-04 06:26:43'),
(28, 25, '1775981185_Untitled (1).xlsx', 'quotations/ye1Kf0Q3nOrzkMz36y41Elfs8KhEaVgAi9dM53X0.xlsx', '2026-05-04 06:25:51', 100000.00, 'approved', NULL, 'po/po_28_1777901202.pdf', '2026-05-04 06:25:51', '2026-05-04 06:26:43'),
(29, 25, 'quotation_items_filled.xlsx', 'quotations/Uj9UwMMKnJxKSCSXwWfeJeNttJc5wa3tu9LMQO4z.xlsx', '2026-05-04 06:29:35', 900000.00, 'rejected', '-', NULL, '2026-05-04 06:29:35', '2026-05-04 06:30:01'),
(30, 28, 'gvHJQh043m4CIG9G7OrvvE3cmGIMQ6TCS6IN1UDA.xlsx', 'quotations/lbDR6tq8ej1qnjhdAILdSVA1H6OamJHZv6VhK0fP.xlsx', '2026-05-04 06:46:41', 900000.00, 'approved', NULL, 'po/po_30_1777902547.pdf', '2026-05-04 06:46:41', '2026-05-04 06:49:08'),
(31, 30, 'quotation_items_filled.xlsx', 'quotations/EteKokM47vsn79OTSnBGUl1BrkY33LuzcQJEmRb7.xlsx', '2026-05-04 11:50:20', 120000.00, 'approved', NULL, 'po/po_31_1777920796.pdf', '2026-05-04 11:50:20', '2026-05-04 11:53:18'),
(32, 29, 'quotation_items_filled.xlsx', 'quotations/8mSMKJb6vHqcsLRUfsPFyqeGxF3L3dLPk3XTK9Si.xlsx', '2026-05-04 11:51:52', 500000.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-05-04 11:51:52', '2026-05-04 11:53:18'),
(33, 32, '1775981185_Untitled (1).xlsx', 'quotations/NrNU9F85EKrK5QWUpiKZhTd7yERHh6YLEinc2V0T.xlsx', '2026-05-19 09:20:32', 900000.00, 'approved', NULL, 'po/po_33_1779207712.pdf', '2026-05-19 09:20:32', '2026-05-19 09:21:55'),
(34, 33, 'gvHJQh043m4CIG9G7OrvvE3cmGIMQ6TCS6IN1UDA.xlsx', 'quotations/Ug729vb9sTNCT702yJeFnhaAmo4jDhDm9daPXsqN.xlsx', '2026-05-19 09:48:17', 120000.00, 'approved', NULL, 'po/po_34_1779209332.pdf', '2026-05-19 09:48:17', '2026-05-19 09:48:53'),
(40, 43, 'quotation_items_filled.xlsx', 'quotations/Ft5C06xk8ae5080oOEGWhkCT2Zwnd2mdTCfRUl04.xlsx', '2026-05-19 12:27:45', 1111.00, 'approved', NULL, 'po/po_40_1780666532.pdf', '2026-05-19 12:27:45', '2026-06-05 13:35:33'),
(41, 42, '1775981185_Untitled (1).xlsx', 'quotations/Jg4iZP0kFrl2clpnCCYBNi6otCywaBPmQJT8LdsA.xlsx', '2026-05-19 12:28:25', 111.00, 'rejected', 'Penawaran lain telah dipilih.', NULL, '2026-05-19 12:28:25', '2026-06-05 13:35:33'),
(42, 46, '1776504999_Untitled.xlsx', 'quotations/iRLSsmZug4VmCkAP01VAbL8lnGsMKni5XrbIguLe.xlsx', '2026-05-19 19:49:06', 1.00, 'pending', NULL, NULL, '2026-05-19 19:49:06', '2026-05-19 19:49:06'),
(43, 44, '1776504999_Untitled.xlsx', 'quotations/Nlqt9fQXC8wJMet6EQ4FDx5xUsVWKrOOpADbnOlu.xlsx', '2026-05-19 19:51:59', 20.00, 'approved', NULL, 'po/po_43_1779220387.pdf', '2026-05-19 19:51:59', '2026-05-19 19:53:08'),
(44, 47, 'gvHJQh043m4CIG9G7OrvvE3cmGIMQ6TCS6IN1UDA.xlsx', 'quotations/j5waXPS4vuOd6rUTzZu1tIVb93iNH6pjLqfwmTSr.xlsx', '2026-06-05 14:03:06', 200000.00, 'approved', NULL, 'po/po_44_1780668234.pdf', '2026-06-05 14:03:06', '2026-06-05 14:03:54'),
(45, 47, '1775981185_Untitled (1).xlsx', 'quotations/lbWcBNJ94DhSQWUUBaz6QZOt4VPDEpOqGM6VYJWB.xlsx', '2026-06-05 14:09:19', 1222.00, 'approved', NULL, 'po/po_45_1780668591.pdf', '2026-06-05 14:09:19', '2026-06-05 14:09:51');

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
(32, 15, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-04-16 12:05:52', '2026-04-16 12:05:52'),
(33, 16, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-04-16 12:07:13', '2026-04-16 12:07:13'),
(34, 17, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-16 12:34:16', '2026-04-16 12:34:16'),
(35, 17, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-16 12:34:16', '2026-04-16 12:34:16'),
(36, 17, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-16 12:34:16', '2026-04-16 12:34:16'),
(37, 17, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-16 12:34:16', '2026-04-16 12:34:16'),
(38, 18, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-17 05:35:02', '2026-04-17 05:35:02'),
(39, 18, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-17 05:35:02', '2026-04-17 05:35:02'),
(40, 18, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-17 05:35:02', '2026-04-17 05:35:02'),
(41, 18, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-17 05:35:02', '2026-04-17 05:35:02'),
(42, 19, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-18 03:55:59', '2026-04-18 03:55:59'),
(43, 19, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-18 03:55:59', '2026-04-18 03:55:59'),
(44, 19, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-18 03:55:59', '2026-04-18 03:55:59'),
(45, 19, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-18 03:55:59', '2026-04-18 03:55:59'),
(46, 20, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-18 04:05:57', '2026-04-18 04:05:57'),
(47, 20, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-18 04:05:57', '2026-04-18 04:05:57'),
(48, 20, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-18 04:05:57', '2026-04-18 04:05:57'),
(49, 20, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-18 04:05:57', '2026-04-18 04:05:57'),
(50, 21, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-21 08:18:08', '2026-04-21 08:18:08'),
(51, 21, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-21 08:18:08', '2026-04-21 08:18:08'),
(52, 21, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-21 08:18:08', '2026-04-21 08:18:08'),
(53, 21, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-21 08:18:08', '2026-04-21 08:18:08'),
(54, 22, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-24 11:06:41', '2026-04-24 11:06:41'),
(55, 22, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-24 11:06:41', '2026-04-24 11:06:41'),
(56, 22, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-24 11:06:41', '2026-04-24 11:06:41'),
(57, 22, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-24 11:06:41', '2026-04-24 11:06:41'),
(58, 23, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-04-24 11:53:15', '2026-04-24 11:53:15'),
(59, 23, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-04-24 11:53:15', '2026-04-24 11:53:15'),
(60, 23, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-04-24 11:53:15', '2026-04-24 11:53:15'),
(61, 23, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-04-24 11:53:15', '2026-04-24 11:53:15'),
(62, 24, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-03 07:49:25', '2026-05-03 07:49:25'),
(63, 24, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-03 07:49:25', '2026-05-03 07:49:25'),
(64, 24, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-03 07:49:25', '2026-05-03 07:49:25'),
(65, 24, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-03 07:49:25', '2026-05-03 07:49:25'),
(66, 25, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-03 07:54:45', '2026-05-03 07:54:45'),
(67, 25, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-03 07:54:45', '2026-05-03 07:54:45'),
(68, 25, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-03 07:54:45', '2026-05-03 07:54:45'),
(69, 25, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-03 07:54:45', '2026-05-03 07:54:45'),
(70, 26, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-05-04 05:53:34', '2026-05-04 05:53:34'),
(71, 27, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-04 06:25:10', '2026-05-04 06:25:10'),
(72, 27, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-04 06:25:10', '2026-05-04 06:25:10'),
(73, 27, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-04 06:25:10', '2026-05-04 06:25:10'),
(74, 27, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-04 06:25:10', '2026-05-04 06:25:10'),
(75, 28, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-05-04 06:25:51', '2026-05-04 06:25:51'),
(76, 29, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-04 06:29:35', '2026-05-04 06:29:35'),
(77, 29, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-04 06:29:35', '2026-05-04 06:29:35'),
(78, 29, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-04 06:29:35', '2026-05-04 06:29:35'),
(79, 29, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-04 06:29:35', '2026-05-04 06:29:35'),
(80, 30, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-04 06:46:41', '2026-05-04 06:46:41'),
(81, 30, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-04 06:46:41', '2026-05-04 06:46:41'),
(82, 30, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-04 06:46:41', '2026-05-04 06:46:41'),
(83, 30, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-04 06:46:41', '2026-05-04 06:46:41'),
(84, 31, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-04 11:50:27', '2026-05-04 11:50:27'),
(85, 31, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-04 11:50:27', '2026-05-04 11:50:27'),
(86, 31, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-04 11:50:27', '2026-05-04 11:50:27'),
(87, 31, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-04 11:50:27', '2026-05-04 11:50:27'),
(88, 32, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-04 11:51:52', '2026-05-04 11:51:52'),
(89, 32, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-04 11:51:52', '2026-05-04 11:51:52'),
(90, 32, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-04 11:51:52', '2026-05-04 11:51:52'),
(91, 32, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-04 11:51:52', '2026-05-04 11:51:52'),
(92, 33, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-05-19 09:20:40', '2026-05-19 09:20:40'),
(93, 34, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-19 09:48:17', '2026-05-19 09:48:17'),
(94, 34, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-19 09:48:17', '2026-05-19 09:48:17'),
(95, 34, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-19 09:48:17', '2026-05-19 09:48:17'),
(96, 34, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-19 09:48:17', '2026-05-19 09:48:17'),
(111, 40, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-05-19 12:27:45', '2026-05-19 12:27:45'),
(112, 40, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-05-19 12:27:45', '2026-05-19 12:27:45'),
(113, 40, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-05-19 12:27:45', '2026-05-19 12:27:45'),
(114, 40, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-05-19 12:27:45', '2026-05-19 12:27:45'),
(115, 41, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-05-19 12:28:26', '2026-05-19 12:28:26'),
(116, 42, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-05-19 19:49:06', '2026-05-19 19:49:06'),
(117, 43, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-05-19 19:51:59', '2026-05-19 19:51:59'),
(118, 44, 'EMS11', '6000010111', 'PT Supplier A', '1', 'MAT-001', 'Laptop ASUS', 5.00, 'PCS', 'IDR', 3000000.00, 'FOB', 'Jakarta', '', '', '2', '30 Days', '2026-04-12', '2026-06-05 14:03:14', '2026-06-05 14:03:14'),
(119, 44, 'EMS11', '6000010111', 'PT Supplier A', '2', 'MAT-002', 'Mouse Wireless', 10.00, 'PCS', 'IDR', 150000.00, 'FOB', 'Jakarta', '', '', '1', '30 Days', '2026-04-12', '2026-06-05 14:03:14', '2026-06-05 14:03:14'),
(120, 44, 'EMS11', '6000010111', 'PT Supplier B', '1', 'MAT-003', 'Laptop Lenovo', 3.00, 'PCS', 'IDR', 3500000.00, 'CIF', 'Batam', '', '', '3', '45 Days', '2026-04-12', '2026-06-05 14:03:14', '2026-06-05 14:03:14'),
(121, 44, 'EMS11', '6000010111', 'PT Supplier B', '2', 'MAT-004', 'Keyboard Mechanical', 7.00, 'PCS', 'IDR', 500000.00, 'CIF', 'Batam', '', '', '2', '45 Days', '2026-04-12', '2026-06-05 14:03:14', '2026-06-05 14:03:14'),
(122, 45, 'EMS11', '6000010111', '16000501', '10', '13005620', 'MONITOR, COLOR, LCD 20\"/21\", WIDESCREEN, AC100-240V, 50/60 Hz', 2.00, 'UNT', '', 0.00, '', '', '', '', '', '', NULL, '2026-06-05 14:09:21', '2026-06-05 14:09:21');

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
(2, 'untuk  all batch', 'testing', 'Untitled.xlsx', 'rfq-templates/1776504999_Untitled.xlsx', 1, 1, '2026-04-18 02:36:39', '2026-04-18 02:36:39');

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
  `business_field` varchar(150) DEFAULT NULL COMMENT 'Bidang usaha perusahaan supplier',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `company_name`, `phone`, `address`, `npwp`, `business_field`, `created_at`, `updated_at`) VALUES
(1, 2, 'PT Demo Supplier Indonesia', '+62 21 5555 1234', 'Jl. Sudirman No. 88, Jakarta Pusat', '12.345.678.9-012.345', NULL, '2026-04-12 01:05:21', '2026-04-12 01:05:21'),
(2, 3, 'PT satnusa', '0812792392938', 'Batam', '12.345.678.9-012.000', 'Teknologi', '2026-04-12 01:13:59', '2026-05-24 13:09:26'),
(3, 4, 'CV', '086377139952', 'Jakarta Selatan', '432424242342343242', NULL, '2026-04-12 09:10:45', '2026-04-12 09:10:45'),
(4, 5, 'PT JASA KERJA', '081264820238', 'Kalimantan Tengah', '2489248924292489824', NULL, '2026-04-12 09:13:51', '2026-04-12 09:13:51'),
(5, 6, 'PT', '0821786693733', 'Batam, Batam Cenre', '12.345.698.9-012.111', NULL, '2026-04-24 06:44:30', '2026-04-24 06:44:30'),
(6, 7, 'PT MAJU JAYA', '081266578976', 'jl. Merpati raya no 12', '12.345.698.9-012.987', NULL, '2026-05-03 07:32:52', '2026-05-03 07:32:52'),
(7, 8, 'batam', '081266578976', 'batam centre', '12.345.698.9-012.987', NULL, '2026-05-05 07:26:17', '2026-05-05 07:26:17'),
(8, 9, 'PT Tigernix', '082389709976', 'batam centre', '12.345.678.9-032.000', 'Kontruksi', '2026-05-24 13:29:10', '2026-05-24 13:32:20');

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
(1, 'Admin', 'admin@rfqsystem.com', '$2y$12$F.NbKCRANxyJzyaPo5lIyOPdeCOK3hSs93gOqTnSxj/ixdg/owXz.', 'admin', 1, '2026-04-12 01:05:20', '2026-04-12 01:05:20'),
(2, 'Budi Santoso', 'supplier@demo.com', '$2y$12$fvHQuOSAu7qH6wGaHYd3.OE1yz9xtk9/U0Z5ijyFPSZV/pnt8Yu/2', 'supplier', 1, '2026-04-12 01:05:21', '2026-04-12 01:05:21'),
(3, 'Dimas Dwi Prasetiyo', 'ddimasddpprasetiyo@gmail.com', '$2y$12$oDgPqavOeF19RNJ.DkMbe.zPI7K/5Dqf8loxuF3iJGvd.TFwSNmVm', 'supplier', 1, '2026-04-12 01:13:59', '2026-04-12 01:13:59'),
(4, 'Bambang setyanto', 'dimasgantengsejagat@gmail.com', '$2y$12$7L5jO8Q1KFpgpZK8Wp3IqOKFK5C6Ln19c.K7EikY4up4qJuZXAaka', 'supplier', 1, '2026-04-12 09:10:45', '2026-04-12 09:10:45'),
(5, 'eka', 'dimasgtgsejagat@gmail.com', '$2y$12$3oglmyUvDxlKTImvlzPcFu8JUVAR4BfratNHkfoEwcxOGgXojO8o.', 'supplier', 1, '2026-04-12 09:13:51', '2026-04-12 09:13:51'),
(6, 'BP BATAM', 'bpbatam@gmail.com', '$2y$12$1ocF3TfBb3JJ73sVE/6HYeLqTJp12rn9Jz6NMGooJs6AyWUX4D0Fa', 'supplier', 0, '2026-04-24 06:44:29', '2026-04-24 06:44:29'),
(7, 'prabowo subianto', 'majujaya@gmail.com', '$2y$12$nMMkwuY32mj9QsDMW1zF4uqu7T7dee4zJCwDc5aCYtD8lbkTJFyhe', 'supplier', 1, '2026-05-03 07:32:52', '2026-05-03 07:32:52'),
(8, 'raisya', 'batam@gmail.com', '$2y$12$Wba8tEzfyhgukDiwz3VUIeZ0tncuUssTefQcOmOKi2tnTKSLheXs2', 'supplier', 0, '2026-05-05 07:26:17', '2026-05-05 07:26:17'),
(9, 'eko', 'Tigernix@gmail.com', '$2y$12$wP2o4hj465GzEepYvX6GLOX/jgWmDRvpdIUxPrgHRe6uvT73aDqk.', 'supplier', 1, '2026-05-24 13:29:10', '2026-05-24 13:29:10');

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_batch` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `batch_categories`
--
ALTER TABLE `batch_categories`
  MODIFY `id_batch_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `invited_supplier_categories`
--
ALTER TABLE `invited_supplier_categories`
  MODIFY `id_invited_supplier` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `items_batch_categories`
--
ALTER TABLE `items_batch_categories`
  MODIFY `id_item_batch_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `master_category`
--
ALTER TABLE `master_category`
  MODIFY `id_master_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_items`
--
ALTER TABLE `master_items`
  MODIFY `id_item` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id_quotation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `rfq_templates`
--
ALTER TABLE `rfq_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
