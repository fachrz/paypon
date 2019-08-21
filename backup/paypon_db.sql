-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Agu 2019 pada 14.28
-- Versi server: 10.3.15-MariaDB
-- Versi PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paypon_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account`
--

CREATE TABLE `account` (
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `account`
--

INSERT INTO `account` (`email`, `password`, `nama`, `no_telp`, `alamat`, `saldo`) VALUES
('geldy@gmail.com', 'test1234', 'Geldy', '0895610355705', 'Jl. Chairil Anwar', 111000),
('rfachru4@gmail.com', 'test1234', 'Fachrurozi', '0895610355705', 'Jl. Chairil Anwar', 230000),
('rifqifadhli@gmail.com', 'test1234', 'Rifqi', '087881108626', 'jl.jalak bali', 60000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `username` varchar(30) NOT NULL,
  `password` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`username`, `password`) VALUES
('ppa_admin', 'test1234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_aktivitas`
--

CREATE TABLE `tb_aktivitas` (
  `id_aktivitas` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tipe_aktivitas` varchar(20) NOT NULL,
  `saldo_aktivitas` int(11) NOT NULL,
  `tgl_aktivitas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_aktivitas`
--

INSERT INTO `tb_aktivitas` (`id_aktivitas`, `email`, `tipe_aktivitas`, `saldo_aktivitas`, `tgl_aktivitas`) VALUES
(2, 'rfachru4@gmail.com', 'transfer', 1000, '2019-08-21 04:11:33'),
(5, 'rfachru4@gmail.com', 'top-up', 100000, '2019-08-21 05:29:38'),
(6, 'rfachru4@gmail.com', 'transfer', 100000, '2019-08-21 05:41:16'),
(7, 'rifqifadhli@gmail.com', 'top-up', 100000, '2019-08-21 08:10:38'),
(8, 'rifqifadhli@gmail.com', 'transfer', 20000, '2019-08-21 08:12:01'),
(9, 'rifqifadhli@gmail.com', 'transfer', 20000, '2019-08-21 08:23:11'),
(10, 'rfachru4@gmail.com', 'terima transfer', 20000, '2019-08-21 08:23:11'),
(11, 'rfachru4@gmail.com', 'transfer bank', 100000, '2019-08-21 08:49:17'),
(12, 'rfachru4@gmail.com', 'transfer bank', 10000, '2019-08-21 09:00:30'),
(13, 'rfachru4@gmail.com', 'top-up', 100000, '2019-08-21 09:32:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bank`
--

CREATE TABLE `tb_bank` (
  `kode_bank` varchar(5) NOT NULL,
  `nama_bank` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_bank`
--

INSERT INTO `tb_bank` (`kode_bank`, `nama_bank`) VALUES
('011', 'Bank Danamon');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rekening`
--

CREATE TABLE `tb_rekening` (
  `email` varchar(50) NOT NULL,
  `kode_bank` varchar(4) NOT NULL,
  `no_rek` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_rekening`
--

INSERT INTO `tb_rekening` (`email`, `kode_bank`, `no_rek`) VALUES
('rfachru4@gmail.com', '011', '183741234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transfer`
--

CREATE TABLE `tb_transfer` (
  `email` varchar(50) NOT NULL,
  `tgl_transfer` datetime NOT NULL,
  `jumlah_transfer` int(11) NOT NULL,
  `email_tujuan` varchar(50) NOT NULL,
  `deskripsi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_transfer`
--

INSERT INTO `tb_transfer` (`email`, `tgl_transfer`, `jumlah_transfer`, `email_tujuan`, `deskripsi`) VALUES
('rfachru4@gmail.com', '2019-08-21 03:25:04', 10000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 03:26:25', 10000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 04:08:38', 1000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 04:09:20', 1000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 04:09:36', 1000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 04:10:17', 1000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 04:11:14', 1000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 04:11:33', 1000, 'geldy@gmail.com', 'test'),
('rfachru4@gmail.com', '2019-08-21 05:41:16', 100000, 'geldy@gmail.com', 'test'),
('rifqifadhli@gmail.com', '2019-08-21 08:12:01', 20000, 'rfachru4@gmail.com', 'buat jajan'),
('rifqifadhli@gmail.com', '2019-08-21 08:23:11', 20000, 'rfachru4@gmail.com', 'test');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_withdraw`
--

CREATE TABLE `tb_withdraw` (
  `email` varchar(50) NOT NULL,
  `no_rek` varchar(16) NOT NULL,
  `jumlah_transfer` int(11) NOT NULL,
  `tgl_transfer` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_withdraw`
--

INSERT INTO `tb_withdraw` (`email`, `no_rek`, `jumlah_transfer`, `tgl_transfer`) VALUES
('rfachru4@gmail.com', '183741234', 10000, '2019-08-21 09:00:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `top_up`
--

CREATE TABLE `top_up` (
  `id_topup` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `jumlah_topup` int(11) NOT NULL,
  `tgl_topup` datetime NOT NULL,
  `status` varchar(5) NOT NULL,
  `kode_transaksi` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `top_up`
--

INSERT INTO `top_up` (`id_topup`, `email`, `jumlah_topup`, `tgl_topup`, `status`, `kode_transaksi`) VALUES
(6, 'rfachru4@gmail.com', 100000, '2019-08-21 05:19:11', 'green', 'PP952778939'),
(7, 'rfachru4@gmail.com', 100000, '2019-08-21 05:27:04', 'green', 'PP225301115'),
(9, 'rfachru4@gmail.com', 100000, '2019-08-21 05:29:32', 'green', 'PP742456225'),
(10, 'geldy@gmail.com', 100000, '2019-08-21 05:36:55', 'red', 'PP573597626'),
(12, 'rifqifadhli@gmail.com', 100000, '2019-08-21 08:10:15', 'green', 'PP948314052'),
(13, 'rfachru4@gmail.com', 100000, '2019-08-21 09:31:51', 'green', 'PP260334638');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_rekening`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_rekening` (
`email` varchar(50)
,`no_rek` varchar(16)
,`nama_bank` varchar(20)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_rekening`
--
DROP TABLE IF EXISTS `v_rekening`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekening`  AS  select `tb_rekening`.`email` AS `email`,`tb_rekening`.`no_rek` AS `no_rek`,`tb_bank`.`nama_bank` AS `nama_bank` from (`tb_rekening` join `tb_bank` on(`tb_rekening`.`kode_bank` = `tb_bank`.`kode_bank`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
  ADD PRIMARY KEY (`id_aktivitas`),
  ADD KEY `email` (`email`);

--
-- Indeks untuk tabel `tb_bank`
--
ALTER TABLE `tb_bank`
  ADD PRIMARY KEY (`kode_bank`);

--
-- Indeks untuk tabel `tb_rekening`
--
ALTER TABLE `tb_rekening`
  ADD UNIQUE KEY `nomor_rekening` (`no_rek`),
  ADD KEY `email` (`email`),
  ADD KEY `kode_bank` (`kode_bank`);

--
-- Indeks untuk tabel `tb_transfer`
--
ALTER TABLE `tb_transfer`
  ADD KEY `email` (`email`),
  ADD KEY `email_tujuan` (`email_tujuan`);

--
-- Indeks untuk tabel `tb_withdraw`
--
ALTER TABLE `tb_withdraw`
  ADD KEY `email` (`email`),
  ADD KEY `no_rek` (`no_rek`);

--
-- Indeks untuk tabel `top_up`
--
ALTER TABLE `top_up`
  ADD PRIMARY KEY (`id_topup`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
  MODIFY `id_aktivitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `top_up`
--
ALTER TABLE `top_up`
  MODIFY `id_topup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
  ADD CONSTRAINT `tb_aktivitas_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`);

--
-- Ketidakleluasaan untuk tabel `tb_rekening`
--
ALTER TABLE `tb_rekening`
  ADD CONSTRAINT `tb_rekening_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`),
  ADD CONSTRAINT `tb_rekening_ibfk_2` FOREIGN KEY (`kode_bank`) REFERENCES `tb_bank` (`kode_bank`);

--
-- Ketidakleluasaan untuk tabel `tb_transfer`
--
ALTER TABLE `tb_transfer`
  ADD CONSTRAINT `tb_transfer_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`),
  ADD CONSTRAINT `tb_transfer_ibfk_2` FOREIGN KEY (`email_tujuan`) REFERENCES `account` (`email`);

--
-- Ketidakleluasaan untuk tabel `tb_withdraw`
--
ALTER TABLE `tb_withdraw`
  ADD CONSTRAINT `tb_withdraw_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`),
  ADD CONSTRAINT `tb_withdraw_ibfk_2` FOREIGN KEY (`no_rek`) REFERENCES `tb_rekening` (`no_rek`);

--
-- Ketidakleluasaan untuk tabel `top_up`
--
ALTER TABLE `top_up`
  ADD CONSTRAINT `top_up_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
