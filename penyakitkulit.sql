-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2025 at 04:55 PM
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
-- Database: `penyakitkulit`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aturan`
--

CREATE TABLE `tbl_aturan` (
  `id_aturan` int(100) NOT NULL,
  `kd_penyakit` varchar(100) NOT NULL,
  `kd_gejala` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_aturan`
--

INSERT INTO `tbl_aturan` (`id_aturan`, `kd_penyakit`, `kd_gejala`) VALUES
(1, 'P001', 'G005'),
(2, 'P001', 'G001'),
(3, 'P001', 'G002'),
(4, 'P001', 'G003'),
(5, 'P001', 'G004'),
(6, 'P002', 'G005'),
(7, 'P002', 'G006'),
(8, 'P002', 'G007'),
(9, 'P002', 'G008'),
(10, 'P002', 'G009'),
(11, 'P003', 'G005'),
(12, 'P003', 'G010'),
(13, 'P003', 'G007'),
(14, 'P003', 'G004'),
(15, 'P003', 'G011'),
(16, 'P004', 'G005'),
(17, 'P004', 'G012'),
(18, 'P004', 'G013'),
(19, 'P004', 'G014'),
(20, 'P004', 'G015'),
(21, 'P005', 'G016'),
(22, 'P005', 'G003'),
(23, 'P005', 'G017'),
(24, 'P005', 'G035'),
(25, 'P005', 'G036'),
(26, 'P006', 'G037'),
(27, 'P006', 'G017'),
(28, 'P006', 'G018'),
(29, 'P006', 'G005'),
(30, 'P007', 'G019'),
(31, 'P007', 'G020'),
(32, 'P007', 'G005'),
(33, 'P007', 'G021'),
(34, 'P007', 'G022'),
(35, 'P008', 'G024'),
(36, 'P008', 'G025'),
(37, 'P008', 'G005'),
(38, 'P008', 'G026'),
(39, 'P008', 'G027'),
(40, 'P009', 'G005'),
(41, 'P009', 'G028'),
(42, 'P009', 'G029'),
(43, 'P009', 'G030'),
(44, 'P009', 'G031'),
(45, 'P010', 'G005'),
(46, 'P010', 'G032'),
(47, 'P010', 'G033'),
(48, 'P010', 'G034');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gejala`
--

CREATE TABLE `tbl_gejala` (
  `kd_gejala` varchar(100) NOT NULL,
  `gejala` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gejala`
--

INSERT INTO `tbl_gejala` (`kd_gejala`, `gejala`) VALUES
('G001', 'Alergi'),
('G002', 'Bersisik dan pecah - pecah '),
('G003', 'Kemerah-merahan'),
('G004', 'Terasa panas '),
('G005', ' Terasa gatal'),
('G006', 'Rasa terbakar'),
('G007', 'Nyeri'),
('G008', 'Melepuh'),
('G009', 'Berisi cairan'),
('G010', 'Bengkak'),
('G011', 'Keluar nanah'),
('G012', 'Panas atau demam'),
('G013', 'Ruam merah gatal'),
('G014', 'Batuk pilek'),
('G015', 'Alergi makanan'),
('G016', 'Gatal saat malam hari'),
('G017', 'Bersisik halus'),
('G018', 'Lembab serta berair'),
('G019', 'Bercak putih pada lingkaran'),
('G020', 'Bercak-bercak merah dengan sisik putih tebal'),
('G021', 'Dapat melebar'),
('G022', 'Terdapat di daerah kepala, wajah, siku, genitalia, telapak tangan dan kaki'),
('G023', 'Dikarenakan stress (banyak pikiran)'),
('G024', 'Tahi lalat pada kulit membesar'),
('G025', 'Perubahan warna pada tahi lalat'),
('G026', 'Berdarah'),
('G027', 'Terdapat pada punggung, pantat, kaki, kulit kepala, leher, dan di belakang telinga'),
('G028', 'Melepuh dengan cairan kuning kemerahan'),
('G029', 'Cairan lepuhan membentuk keropang (crusta)'),
('G030', 'Pembengkakan kelenjar getah bening di sekitar luka'),
('G031', 'Jika pecah menyebar di sebelahnya'),
('G032', 'Bau tidak sedap'),
('G033', 'Disela-sela jari kaki maupun tangan'),
('G034', 'Sering berada di tempat yang banyak air'),
('G035', 'Terdapat tungau'),
('G036', 'Terdapat di sela-sela jari kaki, tangan, bawah ketiak, alat kelamin, pinggang dll'),
('G037', 'Kulit menebal dengan lingkaran-lingkaran');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_informasi`
--

CREATE TABLE `tbl_informasi` (
  `id` int(100) NOT NULL,
  `kd_penyakit` varchar(100) NOT NULL,
  `nama_penyakit` varchar(50) NOT NULL,
  `judul` text NOT NULL,
  `deskripsi` text NOT NULL,
  `pencegahan` text NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_informasi`
--

INSERT INTO `tbl_informasi` (`id`, `kd_penyakit`, `nama_penyakit`, `judul`, `deskripsi`, `pencegahan`, `img`) VALUES
(1, 'P001', 'Eksim', 'Mengenal Penyakit Eksim: Gejala, Penyebab, dan Langkah Pencegahan', '• Apa Itu Eksim?\r\nEksim atau dermatitis adalah kondisi peradangan kronis pada kulit yang ditandai dengan rasa gatal, kemerahan, kering, bersisik, bahkan bisa melepuh. Penyakit ini bukanlah penyakit menular, tetapi dapat berdampak serius pada kualitas hidup penderitanya. Eksim bisa muncul pada siapa saja, mulai dari bayi hingga orang dewasa, dan umumnya bersifat kambuhan.\r\n\r\n• Jenis-Jenis Eksim\r\nBerdasarkan studi dermatologi, eksim terdiri dari beberapa jenis, di antaranya:\r\n1. Dermatitis Atopik\r\nJenis eksim paling umum, sering terjadi pada anak-anak dan berkaitan dengan riwayat alergi atau asma.\r\n2. Dermatitis Kontak\r\nTerjadi akibat kontak langsung kulit dengan zat iritan atau alergen, seperti deterjen atau bahan kimia tertentu.\r\n3. Eksim Numularis\r\nDitandai dengan bercak bulat seperti koin pada kulit yang sangat gatal dan kering.\r\n4. Dishidrotik\r\nEksim yang menyebabkan lepuhan kecil berisi cairan, sering muncul di tangan dan kaki.\r\n5. Seboroik\r\nBiasanya terjadi di area kulit yang berminyak seperti wajah dan kulit kepala.\r\n\r\n• Penyebab Eksim\r\nEksim disebabkan oleh kombinasi faktor genetik dan lingkungan. Faktor penyebab utama meliputi:\r\n1. Gangguan sistem imun\r\nSistem imun yang terlalu aktif dapat menyebabkan reaksi inflamasi yang memicu eksim.\r\n2. Faktor genetik\r\nRiwayat keluarga dengan penyakit alergi, asma, atau rinitis alergi meningkatkan risiko eksim.\r\n3. Iritan lingkungan\r\nSeperti sabun keras, detergen, polusi udara, atau suhu ekstrem.\r\n4. Stres psikologis\r\nStres dapat memperparah gejala eksim atau memicu kekambuhan.\r\n\r\n• Gejala Eksim\r\nGejala eksim dapat bervariasi, tergantung jenis dan tingkat keparahannya, namun umumnya meliputi:\r\n1. Kulit kering dan menebal\r\n2. Rasa gatal yang intens, terutama pada malam hari\r\n3. Kemerahan atau bercak kulit yang meradang\r\n4. Luka terbuka akibat garukan\r\n5. Kulit bersisik atau mengelupas', '• Langkah-Langkah Pencegahan Eksim\r\nMeski tidak dapat disembuhkan sepenuhnya, eksim bisa dikendalikan dengan langkah-langkah pencegahan berikut:\r\n1. Hindari Pemicu\r\nIdentifikasi dan hindari bahan yang menyebabkan iritasi, seperti deterjen, parfum, dan logam tertentu.\r\n2. Gunakan Pelembap Secara Rutin\r\nMelembapkan kulit setidaknya dua kali sehari dapat membantu menjaga pelindung kulit alami dan mencegah kekeringan.\r\n3. Pilih Produk Perawatan Kulit yang Lembut\r\nGunakan sabun tanpa pewangi dan produk dengan pH seimbang untuk mengurangi risiko iritasi.\r\n4. Kenakan Pakaian yang Nyaman\r\nPilih bahan katun yang tidak menyebabkan gesekan berlebih. Hindari wol atau sintetis yang bisa memperparah gatal.\r\n5. Kelola Stres\r\nPraktik relaksasi seperti meditasi, yoga, atau olahraga ringan dapat membantu mengurangi stres sebagai pemicu eksim.\r\n6. Jaga Suhu dan Kelembapan Lingkungan\r\nGunakan humidifier saat udara kering dan hindari suhu ekstrem.\r\n7. Konsultasi dengan Dokter Spesialis Kulit\r\nPerawatan medis seperti kortikosteroid topikal atau imunomodulator mungkin diperlukan untuk kasus yang parah.', 'eksim.png'),
(2, 'P002', 'Herpes', 'Mengenal Penyakit Herpes: Jenis, Gejala, dan Langkah Pencegahan', '• Apa Itu Penyakit Herpes?\r\nHerpes adalah infeksi virus yang disebabkan oleh Herpes Simplex Virus (HSV), yang terbagi menjadi dua tipe utama:\r\n1. HSV-1: Umumnya menyebabkan herpes oral, yaitu luka di sekitar mulut atau wajah.\r\n2. HSV-2: Umumnya menyebabkan herpes genital, yaitu luka atau lecet di area kelamin.\r\nVirus ini sangat menular dan menyebar melalui kontak langsung dengan luka, air liur, atau cairan tubuh, bahkan saat gejala tidak terlihat (asimptomatik).\r\n\r\n• Jenis-Jenis Herpes\r\n1. Herpes Oral (HSV-1)\r\nMenyebabkan luka melepuh di bibir, gusi, dan sekitar mulut. Umumnya ditularkan melalui ciuman, berbagi alat makan, atau kontak langsung dengan luka aktif.\r\n2. Herpes Genital (HSV-2)\r\nMenyebabkan luka melepuh atau nyeri di area genital, anus, dan paha bagian dalam. Penularan utamanya melalui hubungan seksual, baik vaginal, anal, maupun oral.\r\n3. Herpes Neonatal\r\nJenis herpes langka namun serius yang ditularkan dari ibu ke bayi saat proses persalinan, bila sang ibu mengalami infeksi aktif.\r\n4. Herpes Zoster (Cacar Api)\r\nBerbeda dengan HSV, ini disebabkan oleh virus Varicella-Zoster (penyebab cacar air) yang kembali aktif di dalam tubuh.\r\n\r\n• Gejala Umum Herpes\r\nGejala bisa berbeda tergantung tipe virus dan lokasi infeksi. Namun, beberapa gejala umum meliputi:\r\n1. Luka kecil berisi cairan yang melepuh, kemudian pecah dan mengering\r\n2. Rasa nyeri atau terbakar di sekitar luka\r\n3. Gatal atau kesemutan sebelum munculnya luka\r\n4. Demam ringan dan nyeri otot\r\n5. Pembengkakan kelenjar getah bening\r\n6. Sulit buang air kecil (pada herpes genital)\r\nPada beberapa kasus, penderita tidak mengalami gejala sama sekali, tetapi tetap bisa menularkan virus.\r\n\r\n• Bagaimana Herpes Menular?\r\nPenularan herpes terjadi melalui:\r\n1. Kontak langsung dengan luka atau kulit yang terinfeksi\r\n2. Hubungan seksual tanpa pengaman\r\n3. Berbagi barang pribadi seperti alat makan, lip balm, atau handuk\r\n4. Dari ibu ke bayi saat melahirkan (herpes neonatal)', '• Langkah-Langkah Pencegahan Herpes\r\nMeski tidak ada obat yang dapat menyembuhkan herpes secara permanen, pencegahan dapat dilakukan melalui langkah-langkah berikut:\r\n1. Gunakan Kondom Saat Berhubungan Seksual\r\nPenggunaan kondom secara konsisten dapat mengurangi risiko penularan, meski tidak 100% efektif karena herpes bisa menular melalui kulit yang tidak tertutup.\r\n2. Hindari Kontak dengan Luka Herpes Aktif\r\nJangan menyentuh luka aktif dan hindari ciuman atau seks oral jika pasangan memiliki luka di mulut atau genital.\r\n3. Jangan Berbagi Barang Pribadi\r\nHindari penggunaan bersama peralatan makan, kosmetik, atau handuk.\r\n4. Cuci Tangan Secara Rutin\r\nSelalu cuci tangan setelah menyentuh wajah atau area genital, terutama jika sedang mengalami gejala herpes.\r\n5. Kelola Stres dan Jaga Imunitas Tubuh\r\nSistem imun yang lemah dan stres tinggi dapat memicu kekambuhan herpes. Tidur cukup, makan bergizi, dan olahraga teratur adalah kunci.\r\n6. Pemeriksaan dan Konseling Seksual Teratur\r\nBagi pasangan seksual aktif, konsultasi rutin ke dokter dan pemeriksaan laboratorium sangat dianjurkan.\r\n7. Pengobatan Pencegahan (Profilaksis)\r\nBagi penderita herpes berulang, dokter dapat meresepkan antivirus harian untuk menekan frekuensi kekambuhan dan risiko penularan.', 'herpes.png'),
(3, 'P003', 'Bisul', 'Mengenal Penyakit Bisul: Penyebab, Gejala, dan Cara Pencegahan', '• Apa Itu Bisul?\r\nBisul (dalam istilah medis disebut furunkel) adalah infeksi kulit yang disebabkan oleh bakteri, umumnya Staphylococcus aureus, yang masuk ke dalam folikel rambut atau kelenjar minyak. Infeksi ini menyebabkan peradangan yang membentuk benjolan merah berisi nanah di bawah permukaan kulit. Bisul biasanya terasa nyeri, membesar secara bertahap, dan dapat pecah serta mengeluarkan nanah.\r\nMeski tergolong ringan, bisul bisa menjadi serius jika menyebar atau terjadi berulang kali, yang disebut furunkulosis.\r\n\r\n• Penyebab Bisul\r\nPenyebab utama bisul adalah infeksi bakteri, terutama:\r\n1. Staphylococcus aureus\r\nBakteri ini hidup di permukaan kulit, dan masuk ke dalam tubuh melalui luka kecil, goresan, atau pori-pori terbuka.\r\nFaktor risiko yang mempermudah infeksi antara lain:\r\n1. Kurangnya kebersihan kulit\r\n2. Luka kecil atau lecet yang tidak dibersihkan\r\n3. Sistem imun tubuh yang lemah\r\n4. Diabetes mellitus\r\n5. Gesekan kulit akibat pakaian ketat atau bercukur\r\n6. Keringat berlebih\r\n\r\n• Gejala Bisul\r\nBisul biasanya berkembang secara bertahap dan dapat dikenali melalui beberapa tahapan gejala berikut:\r\n1. Benjolan merah dan nyeri di bawah kulit\r\n2. Pembengkakan di sekitar benjolan\r\n3. Benjolan bertambah besar dan lunak di tengahnya\r\n4. Munculnya titik putih (nanah) di puncak benjolan\r\n5. Demam (pada kasus infeksi berat)\r\n6. Nyeri saat disentuh atau bergerak\r\nBisul paling sering muncul di area yang sering berkeringat dan mengalami gesekan, seperti leher, ketiak, bokong, paha, dan wajah.', '• Langkah-Langkah Pencegahan Bisul\r\nMencegah bisul memerlukan kebiasaan hidup bersih dan sehat. Berikut beberapa langkah efektif:\r\n1. Jaga Kebersihan Kulit\r\nMandi secara teratur dan gunakan sabun antibakteri untuk mengurangi pertumbuhan bakteri pada kulit.\r\n2. Hindari Memencet Bisul\r\nMemencet atau memecahkan bisul bisa menyebabkan infeksi menyebar ke area lain.\r\n3. Cuci Tangan Secara Teratur\r\nTerutama setelah menyentuh area yang terinfeksi atau berisiko.\r\n4. Gunakan Pakaian yang Longgar dan Bersih\r\nHindari pakaian ketat yang menyebabkan gesekan pada kulit.\r\n5.Rawat Luka Kecil dengan Benar\r\nBersihkan luka dengan antiseptik dan tutup dengan perban bersih untuk mencegah infeksi.\r\n6.Kelola Gula Darah (Bagi Penderita Diabetes)\r\nGula darah tinggi dapat melemahkan sistem imun dan memperparah infeksi.\r\n7, Tingkatkan Daya Tahan Tubuh\r\nPola makan seimbang, olahraga, tidur cukup, dan manajemen stres membantu sistem imun melawan infeksi.\r\n8. Hindari Berbagi Barang Pribadi\r\nSeperti handuk, pisau cukur, atau pakaian, yang dapat menjadi media penyebaran bakteri.\r\n\r\n• Kapan Harus ke Dokter?\r\nSegera konsultasikan dengan dokter jika:\r\n1. Bisul tidak membaik dalam seminggu\r\n2.Disertai demam tinggi\r\n3. Muncul di wajah atau tulang belakang\r\n4. Ukurannya sangat besar atau muncul berulang\r\n5. Terjadi penyebaran nanah atau infeksi ke jaringan sekitarnya', 'bisul.png'),
(4, 'P004', 'Campak', 'Mengenal Penyakit Campak: Gejala, Penularan, dan Pencegahan', '• Apa Itu Penyakit Campak?\r\nCampak adalah penyakit infeksi akut yang sangat menular, disebabkan oleh virus Measles virus dari famili Paramyxoviridae. Campak terutama menyerang anak-anak, tetapi juga dapat terjadi pada orang dewasa yang belum memiliki kekebalan.\r\nCampak ditandai dengan gejala awal seperti demam tinggi, batuk, pilek, mata merah (konjungtivitis), dan munculnya ruam merah di kulit. Penyakit ini menyebar sangat cepat melalui udara saat penderita batuk atau bersin.\r\nCampak bukan hanya penyakit kulit biasa; bila tidak ditangani dengan baik, campak dapat menyebabkan komplikasi serius, bahkan kematian—terutama pada anak-anak dengan sistem imun yang lemah atau yang kekurangan gizi.\r\n\r\n• Penyebab Campak\r\nCampak disebabkan oleh:\r\n1. Virus campak (Measles virus) yang menyebar melalui droplet dari hidung, mulut, atau tenggorokan penderita yang terinfeksi.\r\nMasa inkubasi virus biasanya sekitar 10–14 hari sebelum gejala mulai muncul.\r\n\r\n• Gejala Campak\r\nGejala campak muncul secara bertahap, dan meliputi:\r\n1. Fase Prodromal (1–4 hari):\r\n   a. Demam tinggi (>38.5°C)\r\n   b. Batuk kering\r\n   c. Pilek (rinitis)\r\n   d. Mata merah dan sensitif terhadap cahaya\r\n   e. Nyeri tenggorokan\r\n   f. Bercak Koplik (bintik putih di dalam mulut)\r\n2. Fase Eksantem (Hari ke-4 hingga ke-7):\r\n   a. Ruam merah (makulopapular) yang menyebar dari wajah ke seluruh tubuh\r\n   b. Ruam berlangsung 5–6 hari dan kemudian menghilang secara bertahap\r\n3. Fase Pemulihan:\r\n   a. Gejala membaik\r\n   b. Ruam menghilang dengan sisik halus\r\n\r\n• Komplikasi Campak\r\nCampak bisa berkembang menjadi komplikasi serius, terutama pada anak kecil dan individu dengan sistem kekebalan lemah:\r\n1. Radang paru-paru (pneumonia)\r\n2. Diare berat\r\n3. Otitis media (infeksi telinga tengah)\r\n4. Ensefalitis (radang otak)\r\n5. Kebutaan\r\n6. Malnutrisi akut\r\n7. Kematian\r\n\r\n• Penularan Campak\r\nVirus campak sangat mudah menular. Penularan terjadi melalui:\r\n1. Udara (droplet) saat penderita batuk atau bersin\r\n2. Kontak langsung dengan cairan hidung atau mulut penderita\r\n3. Permukaan atau benda yang terkontaminasi virus\r\nPenderita bisa menularkan virus 4 hari sebelum hingga 4 hari setelah ruam muncul.', '• Langkah Pencegahan Campak\r\n1. Imunisasi Campak (MR/MMR)\r\n    a. Vaksin campak sangat efektif dan merupakan cara utama mencegah infeksi.\r\n    b. Jadwal imunisasi:\r\n       1) Dosis pertama: usia 9 bulan\r\n       2) Dosis kedua: usia 18 bulan atau sesuai program imunisasi nasional\r\n2. Isolasi Penderita\r\n   a. Hindari kontak dengan orang yang sedang terinfeksi\r\n   b. Isolasi selama minimal 4 hari setelah ruam muncul\r\n3. Tingkatkan Kekebalan Tubuh\r\n   a. Konsumsi makanan bergizi\r\n   b. Istirahat cukup dan hindari stres berlebihan\r\n4. Edukasi Masyarakat\r\n   a. Sosialisasi pentingnya vaksinasi dan gejala awal campak\r\n   b. Hindari menyebarkan hoaks tentang bahaya vaksin\r\n5. Penerapan Perilaku Hidup Bersih dan Sehat (PHBS)\r\n   a. Cuci tangan dengan sabun\r\n   b. Gunakan masker saat flu/batuk\r\n   c. Etika batuk yang benar (menutup mulut dengan lengan)', 'campak.png'),
(5, 'P005', 'Kudis', 'Mengenal Penyakit Kudis: Penyebab, Gejala, dan Cara Pencegahan', '• Apa Itu Kudis?\r\nKudis (dalam istilah medis disebut skabies) adalah penyakit kulit menular yang disebabkan oleh infestasi kutu kecil bernama Sarcoptes scabiei var. hominis. Tungau ini masuk ke dalam lapisan atas kulit dan membuat terowongan untuk bertelur, yang memicu reaksi alergi berupa gatal hebat dan ruam kulit.\r\nPenyakit ini dapat menyerang siapa saja, tetapi paling sering terjadi di lingkungan padat penduduk, tempat tinggal yang tidak higienis, serta institusi seperti asrama, panti, dan penjara.\r\n\r\n• Penyebab Kudis\r\nKudis disebabkan oleh:\r\n1. Tungau Sarcoptes scabiei\r\nParasit mikroskopis ini hidup dan berkembang biak di kulit manusia. Infeksi terjadi melalui kontak kulit langsung yang lama dengan penderita.\r\n\r\n• Cara Penularan Kudis\r\nPenyakit kudis sangat menular dan menyebar melalui:\r\n1. Kontak kulit langsung yang berkepanjangan, seperti tidur satu ranjang atau berpelukan\r\n2. Berbagi barang pribadi, seperti handuk, seprai, atau pakaian\r\n3. Lingkungan padat dan sanitasi buruk meningkatkan risiko penularan\r\nKudis tidak menyebar melalui kontak singkat seperti berjabat tangan cepat.\r\n\r\n• Gejala Kudis\r\nGejala kudis biasanya muncul 2–6 minggu setelah infestasi pertama, atau lebih cepat pada reinfeksi. Tanda-tanda khasnya meliputi:\r\n1. Gatal hebat, terutama pada malam hari\r\n2. Ruam kemerahan berbentuk bintik kecil atau lenting\r\n3. Garis-garis kecil di kulit tempat tungau menggali terowongan\r\n4. Luka akibat garukan, yang bisa menyebabkan infeksi sekunder\r\nLokasi umum munculnya gejala:\r\n1. Jari tangan dan sela-sela jari\r\n2. Pergelangan tangan\r\n3. Ketiak\r\n4. Pinggang\r\n5. Paha bagian dalam\r\n6. Alat kelamin\r\n7. Bokong\r\nPada anak-anak dan bayi, lesi juga bisa muncul di wajah, kepala, dan telapak tangan atau kaki.\r\n\r\n• Komplikasi Kudis\r\nJika tidak diobati, kudis bisa menyebabkan:\r\n1. Infeksi kulit sekunder (impetigo) akibat garukan\r\n2. Eksim atau dermatitis yang berkepanjangan\r\n3. Kudis Norwegia (kudis krustosa) – bentuk berat kudis yang sangat menular dan sulit diobati, biasanya pada pasien dengan imunitas lemah', '• Langkah Pencegahan Kudis\r\n1. Hindari Kontak Langsung dengan Penderita\r\nJangan berbagi tempat tidur, pakaian, atau handuk dengan orang yang terinfeksi.\r\n2. Cuci Semua Barang yang Terinfeksi\r\nCuci pakaian, seprai, dan handuk dengan air panas dan keringkan dengan suhu tinggi.\r\n3. Jaga Kebersihan Diri dan Lingkungan\r\nMandi teratur, bersihkan kamar tidur, dan rutin mengganti pakaian dalam serta seprai.\r\n4. Isolasi Penderita Selama Pengobatan\r\nSeluruh anggota keluarga/rumah tangga sebaiknya ikut diobati, bahkan jika belum muncul gejala.\r\n5. Obati Secara Medis dengan Krim atau Salep Anti-Tungau\r\nKonsultasikan dengan dokter untuk pengobatan menggunakan permetrin, benzil benzoat, atau ivermectin (oral).', 'kudis.png'),
(6, 'P006', 'Kurap', 'Mengenal Penyakit Kurap: Penyebab, Gejala, dan Cara Pencegahan', '• Apa Itu Kurap?\r\nKurap (dalam istilah medis dikenal sebagai tinea atau dermatofitosis) adalah infeksi kulit yang disebabkan oleh jamur dermatofit. Infeksi ini menyerang lapisan luar kulit, rambut, atau kuku, dan ditandai dengan bercak merah berbentuk cincin yang sering terasa gatal.\r\nPenyakit ini sangat menular dan bisa menyebar melalui kontak langsung dengan penderita atau benda-benda yang terkontaminasi seperti handuk, pakaian, atau alat cukur. Kurap dapat menyerang siapa saja, tetapi lebih umum terjadi di daerah beriklim tropis dan lembap.\r\n\r\n• Penyebab Kurap\r\nKurap disebabkan oleh infeksi jamur dari kelompok dermatofita seperti:\r\n1. Trichophyton\r\n2. Microsporum\r\n3. Epidermophyton\r\nJamur ini tumbuh subur di lingkungan hangat dan lembap.\r\n\r\n• Jenis dan Lokasi Kurap\r\n1. Tinea corporis – kurap di badan\r\n2. Tinea capitis – kurap di kulit kepala\r\n3. Tinea cruris – kurap di lipat paha (sering disebut “jock itch”)\r\n4. Tinea pedis – kurap di kaki (“athlete’s foot”)\r\n5. Tinea unguium – kurap pada kuku\r\n\r\n• Gejala Kurap\r\nGejala kurap dapat bervariasi tergantung lokasi infeksi, namun secara umum meliputi:\r\n1. Bercak merah berbentuk cincin\r\n2. Pinggiran lesi lebih menonjol daripada tengahnya\r\n3. Kulit bersisik, gatal, dan kadang melepuh\r\n4. Rambut rontok pada infeksi kulit kepala\r\n5. Penebalan atau perubahan warna pada kuku\r\n\r\n• Cara Penularan Kurap\r\nKurap sangat menular dan dapat menyebar melalui:\r\n1. Kontak langsung dengan penderita\r\n2. Berbagi pakaian atau handuk\r\n3. Kontak dengan hewan terinfeksi, terutama kucing atau anjing\r\nPermukaan terkontaminasi seperti lantai kamar mandi, peralatan olahraga, dll.', '• Langkah Pencegahan Kurap\r\n1. Jaga Kebersihan Diri dan Lingkungan\r\na. Mandi secara rutin dan keringkan tubuh dengan baik, terutama area lipatan\r\nb. Ganti pakaian dan pakaian dalam setiap hari\r\nc. Gunakan alas kaki di kamar mandi umum atau kolam renang\r\n2. Hindari Berbagi Barang Pribadi\r\na. Jangan berbagi handuk, sisir, topi, atau pakaian\r\n3. Cuci Pakaian dengan Air Panas\r\na. Untuk membunuh spora jamur, cuci pakaian dan seprai secara rutin dengan suhu tinggi\r\n4. Rawat Hewan Peliharaan\r\na. Periksa dan obati hewan peliharaan yang menunjukkan tanda-tanda kurap\r\n5. Kenakan Pakaian yang Menyerap Keringat\r\na. Hindari pakaian ketat dan tidak menyerap keringat, terutama saat cuaca panas\r\n6. Obati Segera Jika Terinfeksi\r\na. Gunakan krim antijamur sesuai anjuran dokter\r\nb. Bila infeksi berat atau menyebar, bisa diperlukan obat antijamur oral', 'kurap.png'),
(7, 'P007', 'Psoriasis', 'Mengenal Penyakit Psoriasis: Gejala, Penyebab, dan Cara Pencegahan', '• Apa Itu Psoriasis?\r\nPsoriasis adalah penyakit kulit kronis yang bersifat autoimun, ditandai dengan peradangan serta pertumbuhan sel kulit yang terlalu cepat, sehingga membentuk sisik tebal berwarna putih keperakan di atas kulit yang kemerahan dan menebal. Psoriasis tidak menular, namun dapat mengganggu kualitas hidup penderitanya secara fisik dan emosional.\r\nPsoriasis dapat kambuh dalam jangka waktu lama dan berulang. Meskipun belum ada obat yang menyembuhkan total, kondisi ini dapat dikendalikan dengan pengobatan dan gaya hidup sehat.\r\n\r\n• Penyebab Psoriasis\r\nPsoriasis disebabkan oleh gangguan sistem imun, di mana sel T (sejenis sel darah putih) secara keliru menyerang sel kulit sehat, sehingga mempercepat regenerasi kulit. Akibatnya, sel kulit menumpuk di permukaan dalam beberapa hari (bukan minggu).\r\nFaktor pemicu lainnya meliputi:\r\n1. Faktor genetik/keturunan\r\n2. Stres fisik maupun emosional\r\n3. Infeksi (seperti radang tenggorokan)\r\n4. Cedera pada kulit (goresan, luka bakar, atau sengatan matahari)\r\n5. Penggunaan obat tertentu (seperti lithium, beta-blocker)\r\n6. Konsumsi alkohol berlebihan dan merokok\r\n\r\n• Jenis-Jenis Psoriasis\r\n1. Psoriasis plak (plaque psoriasis) – bentuk paling umum, bercak tebal, merah, bersisik putih-perak\r\n2. Psoriasis gutata – bintik kecil di tubuh, sering pada anak-anak\r\n3. Psoriasis inversa – muncul di lipatan tubuh (ketiak, selangkangan)\r\n4. Psoriasis pustular – lepuh berisi nanah, dapat menyebar luas\r\n5. Psoriasis eritroderma – bentuk paling parah, seluruh tubuh memerah dan bersisik\r\n\r\n• Gejala Psoriasis\r\n1. Bercak merah pada kulit dengan sisik tebal keperakan\r\n2. Kulit kering dan pecah-pecah, kadang berdarah\r\n3. Rasa gatal, perih, atau nyeri\r\n4. Kuku menebal atau berlubang\r\n5. Nyeri sendi (pada psoriasis artritis)\r\nGejala dapat memburuk dalam waktu tertentu (flare-up) dan reda pada waktu lain (remisi).', '• Langkah Pencegahan dan Pengelolaan Psoriasis\r\nMeskipun tidak dapat dicegah sepenuhnya, ada langkah-langkah yang dapat membantu mengontrol kambuhnya psoriasis:\r\n1. Hindari Pemicu\r\nKetahui dan hindari hal-hal yang memicu flare-up, seperti stres, infeksi, atau cuaca ekstrem.\r\n2. Kelola Stres\r\nTeknik relaksasi seperti yoga, meditasi, dan olahraga ringan sangat dianjurkan.\r\n3. Gunakan Pelembap Secara Teratur\r\nMenjaga kelembapan kulit penting untuk mencegah kulit kering dan pecah-pecah.\r\n4. Hindari Alkohol dan Rokok\r\nKedua faktor ini terbukti memperburuk gejala psoriasis.\r\n5. Hindari Luka pada Kulit\r\nGoresan, luka bakar, atau luka lain bisa memicu munculnya psoriasis baru (fenomena Koebner).\r\n6. Makan Sehat dan Seimbang\r\nDiet anti-inflamasi (sayur, buah, ikan berlemak) bisa membantu mengurangi keparahan gejala.\r\n7. Konsultasi Rutin ke Dokter\r\nUntuk pemantauan dan penyesuaian pengobatan. Terapi bisa berupa salep kortikosteroid, fototerapi, atau obat sistemik (biologis).', 'psoriasis.png'),
(8, 'P008', 'Melanoma', 'Mengenal Penyakit Melanoma: Kanker Kulit yang Mematikan', '• Apa Itu Melanoma?\r\nMelanoma adalah jenis kanker kulit yang berasal dari sel penghasil pigmen kulit yang disebut melanosit. Melanoma merupakan bentuk kanker kulit yang paling agresif dan berpotensi menyebar ke organ tubuh lainnya jika tidak terdeteksi dan ditangani sejak dini. Meskipun lebih jarang dibandingkan jenis kanker kulit lainnya seperti karsinoma sel basal atau skuamosa, melanoma menyumbang sebagian besar kematian akibat kanker kulit.\r\n\r\n• Penyebab dan Faktor Risiko Melanoma\r\nMelanoma disebabkan oleh kerusakan DNA pada sel melanosit, yang sebagian besar disebabkan oleh paparan sinar ultraviolet (UV) dari sinar matahari atau tanning bed. Mutasi ini menyebabkan pertumbuhan sel yang tidak terkendali dan membentuk tumor ganas.\r\nFaktor risiko utama meliputi:\r\n1. Paparan sinar UV berlebihan\r\n2. Kulit putih atau terang\r\n3. Riwayat sengatan matahari parah di masa kecil\r\n4. Banyak tahi lalat atau tahi lalat atipikal\r\n5. Riwayat keluarga dengan melanoma\r\n6. Sistem imun lemah\r\n7. Usia lanjut\r\n\r\n• Gejala dan Ciri-Ciri Melanoma\r\nMelanoma dapat muncul di kulit yang tampak sehat atau berkembang dari tahi lalat yang sudah ada. Tanda-tanda utama melanoma sering diringkas dalam aturan ABCDE:\r\n1. A (Asymmetry): Bentuk tidak simetris\r\n2. B (Border): Batas tidak teratur atau kabur\r\n3. C (Color): Warna tidak merata (hitam, coklat, merah, biru)\r\n4. D (Diameter): Lebih dari 6 mm\r\n5. E (Evolving): Perubahan ukuran, bentuk, atau warna\r\nGejala tambahan bisa meliputi gatal, berdarah, atau luka yang tidak sembuh.\r\n\r\nDiagnosa dan Pengobatan Melanoma\r\nMelanoma didiagnosis melalui:\r\n1. Pemeriksaan fisik kulit\r\n2. Dermatoskopi\r\n3. Biopsi jaringan kulit\r\nPengobatan tergantung pada stadium kanker dan bisa mencakup:\r\n1. Pembedahan eksisi\r\n2. Imunoterapi\r\n3. Terapi target\r\n4. Kemoterapi\r\n5. Radioterapi\r\nPrognosis sangat bergantung pada deteksi dini. Jika melanoma belum menyebar, tingkat kelangsungan hidup lima tahun bisa mencapai >90%.', '• Langkah Pencegahan Melanoma\r\n1. Lindungi Kulit dari Paparan UV\r\na. Gunakan tabir surya minimal SPF 30, bahkan saat cuaca mendung\r\nb. Gunakan topi, pakaian pelindung, dan kacamata hitam saat di luar rumah\r\nc. Hindari paparan sinar matahari langsung antara pukul 10 pagi – 4 sore\r\n2. Hindari Tanning Bed\r\na. Alat penggelap kulit buatan juga memancarkan sinar UV berbahaya\r\n3. Lakukan Pemeriksaan Kulit Rutin\r\na. Periksa seluruh tubuh sendiri sebulan sekali\r\nb. Lihat perubahan tahi lalat atau munculnya bintik baru\r\nc. Konsultasikan ke dokter kulit setiap tahun, terutama jika Anda berisiko tinggi\r\n4. Waspadai Perubahan pada Kulit\r\na. Gunakan panduan ABCDE untuk memantau tahi lalat atau lesi kulit\r\n5. Pendidikan dan Kesadaran\r\na. Edukasi masyarakat tentang bahaya sinar UV dan pentingnya deteksi dini', 'melanoma.png'),
(9, 'P009', 'Impetigo', 'Impetigo: Infeksi Kulit Menular yang Umum Terjadi pada Anak', '• Apa Itu Impetigo?\r\nImpetigo adalah infeksi kulit superfisial yang sangat menular, umumnya disebabkan oleh bakteri Staphylococcus aureus atau Streptococcus pyogenes. Penyakit ini paling sering terjadi pada anak-anak usia 2 hingga 5 tahun, tetapi juga bisa menyerang orang dewasa. Impetigo ditandai oleh luka lepuh berisi cairan atau nanah yang mudah pecah dan membentuk kerak kekuningan seperti madu.\r\nMeskipun tergolong ringan dan jarang menyebabkan komplikasi serius, impetigo perlu segera diobati untuk mencegah penyebaran ke orang lain atau ke bagian tubuh lainnya.\r\n\r\n• Penyebab dan Cara Penularan\r\nImpetigo disebabkan oleh infeksi bakteri yang masuk ke dalam kulit melalui luka kecil, goresan, gigitan serangga, atau iritasi kulit lainnya seperti eksim. Penularan terjadi melalui:\r\n1. Kontak langsung dengan luka atau cairan dari penderita\r\n2. Menyentuh barang-barang yang terkontaminasi (handuk, pakaian, mainan)\r\n3. Kebersihan tangan yang buruk\r\nImpetigo lebih mudah menyebar di lingkungan yang padat seperti sekolah, penitipan anak, atau asrama.\r\n\r\n• Gejala Impetigo\r\nGejala impetigo bervariasi tergantung pada jenisnya, yaitu:\r\n1. Impetigo Krustosa (non-bulosa)\r\na. Luka kecil yang cepat pecah dan meninggalkan kerak berwarna kuning keemasan\r\nb. Umumnya tidak terasa sakit, tetapi bisa terasa gatal\r\nc. Sering muncul di sekitar hidung, mulut, tangan, atau lengan\r\n2. Impetigo Bulosa\r\na. Lepuh besar berisi cairan yang tidak mudah pecah\r\nb. Umumnya disebabkan oleh Staphylococcus aureus\r\nc. Bisa menyebabkan demam ringan dan pembengkakan kelenjar getah bening\r\n\r\n• Diagnosis dan Pengobatan\r\nDiagnosis dilakukan berdasarkan penampilan klinis kulit. Dalam beberapa kasus, kultur cairan dari luka dapat diambil untuk memastikan jenis bakteri penyebab.\r\nPengobatan impetigo meliputi:\r\n1. Salep antibiotik topikal (misalnya mupirocin atau fusidic acid)\r\n2. Antibiotik oral untuk kasus yang lebih luas atau parah\r\n3. Menjaga kebersihan luka dengan sabun antiseptik dan air hangat\r\nPengobatan biasanya efektif dalam beberapa hari, namun penting untuk menyelesaikan seluruh siklus antibiotik agar infeksi tidak kambuh.', '• Langkah Pencegahan Impetigo\r\n1. Menjaga Kebersihan Pribadi\r\na. Cuci tangan secara teratur dengan sabun\r\nb. Potong kuku secara rutin dan hindari menggaruk kulit\r\n2. Menutup Luka dengan Rapi\r\na. Luka kecil harus segera dibersihkan dan ditutup untuk mencegah infeksi\r\n3. Hindari Berbagi Barang Pribadi\r\na. Handuk, pakaian, atau alat mandi tidak boleh digunakan bersama\r\n4. Isolasi Sementara Penderita\r\na. Anak yang terkena impetigo sebaiknya tidak masuk sekolah sampai 24 jam setelah pengobatan dimulai\r\n5. Bersihkan Permukaan yang Sering Disentuh\r\na. Gunakan disinfektan untuk membersihkan mainan, meja, gagang pintu, dan barang lain di sekitar penderita', 'impetigo.png'),
(10, 'P010', 'Kutu Air', 'Mengenal Kutu Air: Infeksi Jamur pada Kulit Kaki', '• Apa Itu Kutu Air?\r\nKutu air (dalam istilah medis disebut Tinea pedis) adalah infeksi jamur yang menyerang kulit kaki, terutama di sela-sela jari. Penyakit ini disebabkan oleh kelompok jamur dermatofita yang tumbuh subur di lingkungan yang lembap dan hangat. Kutu air merupakan salah satu bentuk infeksi jamur kulit yang paling umum dan sangat menular.\r\nPenyakit ini tidak hanya menyebabkan rasa tidak nyaman dan gatal, tetapi juga bisa menyebar ke bagian tubuh lain seperti tangan (tinea manuum) atau kuku (tinea unguium) bila tidak segera ditangani.\r\n\r\n• Penyebab dan Penularan Kutu Air\r\nKutu air disebabkan oleh jamur seperti Trichophyton rubrum atau Trichophyton mentagrophytes, yang berkembang di area yang lembap, seperti kaki yang tertutup sepatu sepanjang hari.\r\nFaktor-faktor pemicu dan cara penularan:\r\n1. Kebiasaan menggunakan sepatu tertutup dan berkeringat\r\n2. Sering berjalan tanpa alas kaki di tempat umum (kolam renang, kamar mandi umum, gym)\r\n3. Berbagi handuk, kaus kaki, atau sepatu dengan penderita\r\n4. Kebersihan kaki yang buruk\r\n5. Sistem imun yang lemah\r\n\r\n• Gejala Kutu Air\r\nTanda dan gejala kutu air bisa bervariasi tergantung pada tingkat infeksinya, namun gejala umum meliputi:\r\n1. Kulit kering, pecah-pecah, dan mengelupas, terutama di sela jari kaki\r\n2. Gatal dan rasa terbakar pada area yang terinfeksi\r\n3. Kemerahan dan pembengkakan\r\n4. Luka lecet berisi cairan\r\n5. Bau kaki yang tidak sedap\r\n\r\n• Diagnosis dan Pengobatan\r\nDiagnosis kutu air biasanya dapat ditegakkan melalui pemeriksaan fisik oleh dokter. Dalam beberapa kasus, pengambilan sampel kulit (kerokan) dilakukan untuk diperiksa di bawah mikroskop.\r\nPilihan pengobatan:\r\n1. Antijamur topikal seperti clotrimazole, terbinafine, atau miconazole\r\n2. Antijamur oral untuk infeksi berat atau kronis\r\n3. Menjaga kaki tetap bersih dan kering\r\n4. Mengganti kaus kaki dan sepatu secara rutin\r\nPengobatan harus diteruskan sampai tuntas meskipun gejala membaik, guna mencegah kekambuhan.', '• Langkah Pencegahan Kutu Air\r\n1. Jaga kebersihan kaki\r\na. Cuci kaki setiap hari dan keringkan dengan baik, terutama sela jari\r\n2. Gunakan alas kaki di tempat umum\r\na. Jangan berjalan tanpa sandal di kolam renang, gym, atau kamar mandi umum\r\n3. Ganti kaus kaki setiap hari\r\na. Pilih kaus kaki berbahan katun yang menyerap keringat\r\n4. Gunakan bedak antijamur jika perlu\r\na. Untuk kaki yang mudah berkeringat\r\n5. Hindari berbagi barang pribadi\r\na. Jangan gunakan handuk, sepatu, atau kaus kaki orang lain\r\n6. Pastikan sepatu kering dan bersih\r\na. Jemur sepatu secara berkala di bawah sinar matahari', 'kutu air.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(255) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_hp` text NOT NULL,
  `title` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `nama_lengkap`, `email`, `username`, `password`, `alamat`, `no_hp`, `title`) VALUES
(1, 'Muh Fachri', 'muhfachri@gmail.com', 'fachri', 'fachri', 'Palopo', '085123456789', 'admin'),
(2, 'Archiii', 'archiii@gmail.com', 'archiii', 'archiii', 'Palopo', '085111222333', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_aturan`
--
ALTER TABLE `tbl_aturan`
  ADD PRIMARY KEY (`id_aturan`);

--
-- Indexes for table `tbl_gejala`
--
ALTER TABLE `tbl_gejala`
  ADD PRIMARY KEY (`kd_gejala`);

--
-- Indexes for table `tbl_informasi`
--
ALTER TABLE `tbl_informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_aturan`
--
ALTER TABLE `tbl_aturan`
  MODIFY `id_aturan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_informasi`
--
ALTER TABLE `tbl_informasi`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
