-- ngekos.fasilitas definition

CREATE TABLE `fasilitas` (
  `id_kos` varchar(255) NOT NULL,
  `free_wifi` tinyint(1) DEFAULT NULL,
  `alat_dapur` tinyint(1) DEFAULT NULL,
  `kamar_mandi` tinyint(1) DEFAULT NULL,
  `parkir_motor` tinyint(1) DEFAULT NULL,
  `fasilitas_olahraga` tinyint(1) DEFAULT NULL,
  `cctv` tinyint(1) DEFAULT NULL,
  `tv` tinyint(1) DEFAULT NULL,
  `pembantu` tinyint(1) DEFAULT NULL,
  `ruang_musholla` tinyint(1) DEFAULT NULL,
  `kasur` tinyint(1) DEFAULT NULL,
  `lemari` tinyint(1) DEFAULT NULL,
  `wastafel` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ngekos.images definition

CREATE TABLE `images` (
  `id_images` varchar(255) NOT NULL,
  `id_kos` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_images`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ngekos.kos definition

CREATE TABLE `kos` (
  `id_kos` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `judul` varchar(50) NOT NULL,
  `luas` int(5) NOT NULL,
  `harga` int(11) NOT NULL,
  `pintu` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ngekos.kostersewa definition

CREATE TABLE `kostersewa` (
  `id_kostersewa` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `id_kos` varchar(255) NOT NULL,
  `penghuni` int(2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kostersewa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ngekos.pengajuan definition

CREATE TABLE `pengajuan` (
  `id_pengajuan` varchar(255) NOT NULL,
  `id_user_pemilik` varchar(255) NOT NULL,
  `id_user_pengaju` varchar(255) NOT NULL,
  `id_kos` varchar(255) NOT NULL,
  `penghuni` int(2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ngekos.status_pengajuan definition

CREATE TABLE `status_pengajuan` (
  `id_pengajuan` varchar(255) NOT NULL,
  `id_user_pemilik` varchar(255) NOT NULL,
  `id_user_pengaju` varchar(255) NOT NULL,
  `id_kos` varchar(255) NOT NULL,
  `status_pengajuan` int(1) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ngekos.`user` definition

CREATE TABLE `user` (
  `id_user` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_handphone` varchar(15) NOT NULL,
  `alamat` text DEFAULT NULL,
  `user_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;