-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2025 at 01:58 PM
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
-- Database: `sppd`
--

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status_asn` enum('PNS','PPPK','Honorer') DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `nip` varchar(30) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `pangkat_golongan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `status_asn`, `jenis_kelamin`, `nip`, `jabatan`, `pangkat_golongan`) VALUES
(1, 'Seggaf', 'PNS', 'Laki-laki', '19790803 200502 1 007', 'Pengadministrasi Perkantoran', 'Penata Muda Tk. I III/b'),
(2, 'Hj. Andriana, SH., M.A.P', 'PNS', 'Perempuan', '19730329 199803 2 006', 'Kepala Dinas', 'Pembina Utama Muda IV/c'),
(3, 'Elya, S.Kom., M.A.P', 'PNS', 'Laki-laki', '19790430 200312 1 010', 'Sekretaris', 'Pembina Tk.I IV/b'),
(4, 'Neria Nautha, S.Kom', 'PNS', 'Laki-laki', '19781119 200312 1 005', 'Kabid. Penyelenggaraan e-Government', 'Penata Tk.I IV/b'),
(7, 'Arif Arianto, S.Hut', 'PNS', 'Laki-laki', '19790507 200604 1 015', 'Kabid. Komunikasi dan Informasi Publik', 'Penata Tk.I III/d'),
(8, 'Nur Azmah, A.Md', 'PNS', 'Perempuan', '19711111 199803 2 010', 'Pranata Humas Ahli Muda', 'Penata Tk.I III/d'),
(9, 'Herry Sujana, S.Kom.,M.A.P', 'PNS', 'Laki-laki', '19770827 200604 1 005', 'Sandiman Ahli Muda', 'Penata III/c'),
(10, 'Hatta Nur Rachman, S.Kom', 'PNS', 'Laki-laki', '19890520 201503 1 001', 'Pranata Komputer Ahli Muda', 'Penata III/c'),
(11, 'Arif Machfud Istyanto, SE', 'PNS', 'Laki-laki', '19830923 200502 1 005', 'Penelaah Teknis Kebijakan', 'Penata Muda Tk.I III/c'),
(12, 'Supani', 'PNS', 'Laki-laki', '19720417 200312 1 006', 'Pengadministrasi Perkantoran', 'Penata Muda III/a'),
(13, 'Lidiana L, S.Tr.Kom', 'PNS', 'Perempuan', '19910816 201503 2 007', 'Penata Kelola Sistem dan Teknologi Informasi', 'Penata Muda III/a'),
(14, 'Alirman Boysandi, S.Ip', 'PNS', 'Laki-laki', '19730106 200604 1 014', 'Penelaah Teknis Kebijakan', 'Penata Muda III/a'),
(15, 'Yusuf Fanca', 'PNS', 'Laki-laki', '19821112 200604 1 004', 'Penelaah Teknis Kebijakan', 'Penata Muda III/a'),
(16, 'Deni Mutrofin, A.Md', 'PNS', 'Laki-laki', '19870403 201503 1 001', 'Pengolah Data dan Informasi', 'Penata Muda III/a'),
(17, 'Kurniawati', 'PNS', 'Perempuan', '19800203 200701 2 015', 'Pengadministrasi Perkantoran', 'Penata Muda III/a'),
(18, 'Irwan Yosica', 'PNS', 'Laki-laki', '19820628 201001 1 004', 'Pengadministrasi Perkantoran', 'Pengatur II/c'),
(19, 'Basrin', 'PNS', 'Laki-laki', '19730729 201406 1 002', 'Pengadministrasi Perkantoran', 'Pengatur Muda II/a'),
(20, 'Hongky, S.I.Kom', 'PPPK', 'Laki-laki', '19961130 202421 1 016', 'Pranata Hubungan Masyarakat ahli Pertama', 'IX'),
(21, 'Rizal Kurniawan, ST', 'PPPK', 'Laki-laki', '19860209 202421 1 005', 'Pranata Komputer Ahli Pertama', 'IX'),
(22, 'Ahmad Farobi', 'PPPK', 'Laki-laki', '1111111111111', 'Arsiparis Ahli Pertama', 'IX'),
(25, 'Delya Wana Putri, S.Sos', 'PPPK', 'Perempuan', '-', '-', 'VII'),
(26, 'Purnomo, SE', 'PPPK', 'Laki-laki', '2', '2', 'VII'),
(27, 'Warlina, SE', 'PPPK', 'Perempuan', '3', '3', 'VII'),
(28, 'Ari Wijayanti, SE', 'PPPK', 'Perempuan', '4', '4', 'VII'),
(29, 'Samsul U', 'PPPK', 'Laki-laki', '6', '6', 'V'),
(30, 'Obid Machfud', 'PPPK', 'Laki-laki', '5', '5', 'V');

-- --------------------------------------------------------

--
-- Table structure for table `pejabat`
--

CREATE TABLE `pejabat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `pangkat_golongan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pejabat`
--

INSERT INTO `pejabat` (`id`, `nama`, `nip`, `jabatan`, `pangkat_golongan`) VALUES
(1, 'Hj. ANDRIANA, SH., M.AP', '197303291998032006', 'Kepala Dinas', 'Pembina Utama Muda IV/c'),
(2, 'IR. RISDIANTO, S.PI., M.SI', '197205091997031008', 'Sekretaris Daerah', 'Pembina Utama Madya/ IVd');

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int(11) NOT NULL,
  `bidang` varchar(100) NOT NULL,
  `kode_rekening` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `bidang`, `kode_rekening`) VALUES
(1, 'Bidang KIP Luar Daerah Kode 14', '2.16.02.2.01.0014.5.1.02.04.01.0001'),
(2, 'Sekretariat Luar Daerah', '2.16.01.2.06.0009.5.1.02.04.01.0001'),
(4, 'Sekretariat Dalam Daerah', '2.16.01.2.06.0009.5.1.02.04.01.0003'),
(5, 'Bidang KIP Luar Daerah Kode 17', '2.16.02.2.01.0017.5.1.02.04.01.0001'),
(6, 'Bidang KIP Luar Daerah Kode 21', '2.16.02.2.01.0021.5.1.02.04.01.0001 '),
(7, 'Bidang KIP Luar Daerah Kode 24', '2.16.02.2.01.0024.5.1.02.04.01.0001'),
(8, 'Bidang KIP Dalam Daerah Kode 21', '2.16.02.2.01.0021.5.1.02.04.01.0003'),
(9, 'Bidang KIP Dalam Daerah Kode 23', '2.16.02.2.01.0023.5.1.02.04.01.0003'),
(10, 'Bidang KIP Dalam Daerah Kode 24', '2.16.02.2.01.0024.5.1.02.04.01.0003'),
(11, 'Bidang E-Gov Luar Daerah Kode 26', '2.16.03.2.02.0026.5.1.02.04.01.0001'),
(12, 'Bidang E-Gov Luar Daerah Kode 27', '2.16.03.2.02.0027.5.1.02.04.01.0001'),
(13, 'Bidang E-Gov Dalam Daerah', '2.16.03.2.02.0027.5.1.02.04.01.0003'),
(14, 'Bidang Persandian Luar Daerah', '2.21.02.2.01.0004.5.1.02.04.01.0001'),
(15, 'Bidang Persandian Dalam Daerah', '2.21.02.2.01.0004.5.1.02.04.01.0001');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `nama_kantor` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `nama_kantor`, `alamat`, `telepon`, `email`, `website`) VALUES
(1, 'DINAS KOMUNIKASI INFORMATIKA DAN PERSANDIAN', 'Jalan Jelarai Tanjung Selor Hilir Kabupaten Bulungan Kalimantan Utara 77212', '(0552) 2031390', 'diskominfo@bulungan.go.id', 'https://diskominfo.bulungan.go.id');

-- --------------------------------------------------------

--
-- Table structure for table `sppd`
--

CREATE TABLE `sppd` (
  `id` int(11) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `maksud` text DEFAULT NULL,
  `transportasi` enum('Darat','Darat / Laut','Darat / Laut / Udara','Sungai') NOT NULL,
  `tujuan` varchar(200) DEFAULT NULL,
  `tgl_berangkat` date DEFAULT NULL,
  `tgl_pulang` date DEFAULT NULL,
  `lama_hari` int(11) DEFAULT NULL,
  `tgl_input` datetime DEFAULT current_timestamp(),
  `rekening_id` int(11) NOT NULL,
  `pejabat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sppd`
--

INSERT INTO `sppd` (`id`, `no_surat`, `pegawai_id`, `maksud`, `transportasi`, `tujuan`, `tgl_berangkat`, `tgl_pulang`, `lama_hari`, `tgl_input`, `rekening_id`, `pejabat_id`) VALUES
(8, '00.1.2.3/40/SPD/DKIP-TU/VI/2025', 20, 'Konsultasi dan Pencarian Narasumber ke Kementerian KOMDIGI Republik Indonesia', 'Darat / Laut / Udara', 'Jakarta', '2025-06-23', '2025-06-27', 5, '2025-06-21 18:08:32', 5, 1),
(9, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 7, 'Talkshow CNBC', 'Darat / Laut / Udara', 'Jakarta', '2025-06-23', '2025-06-27', 5, '2025-06-21 19:47:05', 5, 1),
(10, '00.1.2.3/40/SPD/DKIP-TU/VI/2025', 2, 'Talkshow Jawa Pos', 'Darat / Laut / Udara', 'Jakarta', '2025-06-24', '2025-06-26', 3, '2025-06-21 19:47:51', 2, 2),
(11, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 1, 'Rakor Pembangunan', 'Darat', 'Desa Tanah Kuning', '2025-06-17', '2025-06-26', 10, '2025-06-21 19:48:55', 8, 1),
(12, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 29, 'Rakor Pembangunan', 'Darat', 'Desa Tanah Kuning', '2025-06-24', '2025-06-26', 3, '2025-06-21 19:51:04', 9, 1),
(13, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 26, 'Pembuatan Film Dokumentasi', 'Darat', 'Desa Long Buang', '2025-06-23', '2025-06-25', 4, '2025-06-21 19:52:30', 10, 1),
(14, '00.1.2.3/40/SPD/DKIP-TU/VI/2025', 8, 'Liputan Acara', 'Darat', 'Desa Salim Batu', '2025-06-25', '2025-06-26', 2, '2025-06-21 19:53:38', 8, 1),
(15, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 4, 'Pemasangan Starlink', 'Sungai', 'Desa Liagu', '2025-06-26', '2025-06-28', 3, '2025-06-21 19:54:21', 13, 1),
(16, '00.1.2.3/40/SPD/DKIP-TU/VI/2025', 13, 'Pemasangan Starlink', 'Sungai', 'Desa Antal', '2025-06-25', '2025-06-27', 3, '2025-06-21 19:55:13', 13, 1),
(17, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 22, 'Rakor BPSDM Banjarmasin', 'Sungai', 'Tarakan', '2025-06-23', '2025-06-25', 3, '2025-06-21 19:56:28', 2, 1),
(18, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 9, 'Pemasangan Telekomunikasi Radio', 'Sungai', 'Desa Long Sam', '2025-06-21', '2025-06-24', 4, '2025-06-21 19:57:45', 15, 1),
(19, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 14, 'Pemasangan Telekomunikasi Radio', 'Sungai', 'Desa Long San', '2025-06-26', '2025-06-28', 3, '2025-06-21 19:58:33', 4, 1),
(20, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 28, 'Mengantar Berkas PPID Bulungan', 'Darat / Laut', 'Tarakan', '2025-06-25', '2025-06-27', 3, '2025-06-21 22:51:58', 6, 1),
(21, '00.1.2.3/40/SPD/DKIP-TU/VI/2024', 30, 'Masang sound di Acara Sound Horeg Festival', 'Sungai', 'Long Peso', '2025-06-21', '2025-06-25', 5, '2025-06-22 15:53:41', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `status`, `created_at`, `updated_at`) VALUES
(5, 'DKIP Bulungan', 'dkipbul', '$2y$10$Ea4lDdJdlu3AhjAaWDr4QejiC3pbfqRM8rWd4YwCOCEIV2huF.5pS', 1, '2025-06-22 19:57:34', '2025-06-22 19:57:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `pejabat`
--
ALTER TABLE `pejabat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sppd`
--
ALTER TABLE `sppd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`),
  ADD KEY `rekening_id` (`rekening_id`),
  ADD KEY `pejabat_id` (`pejabat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pejabat`
--
ALTER TABLE `pejabat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sppd`
--
ALTER TABLE `sppd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sppd`
--
ALTER TABLE `sppd`
  ADD CONSTRAINT `sppd_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `sppd_ibfk_2` FOREIGN KEY (`rekening_id`) REFERENCES `rekening` (`id`),
  ADD CONSTRAINT `sppd_ibfk_3` FOREIGN KEY (`pejabat_id`) REFERENCES `pejabat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
