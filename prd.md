Analisis sistem diusulkan berguna untuk mengetahui sistem apa yang akan dibuat sehingga tidak terjadi penyimpangan dalam merancang sistem yang akan dibangun.

### a) Analisis Rekayasa Ulang-Pengguna
Agar sebuah sistem dapat berjalan dengan baik dan sesuai dengan yang diinginkan maka dibutuhkan sebuah analisa mengenai siapa saja yang dapat mengakses sistem. Adapun yang dapat mengakses sistem ini adalah sebagai berikut. Berikut aktivitas-aktivitas pengguna yang terdapat dalam sistem:

**Tabel 7. Analisis Rekayasa Ulang-Pengguna**

| No | Nama Pengguna | Fungsi | Dokumen Terkait |
| :--- | :--- | :--- | :--- |
| 1 | Admin | Mengelola hak akses sistem dan akun pengguna. | Data User (Username & Password) |
| 2 | Staff Kesiswaan | Mengelola (Input/Edit/Delete) data master profil siswa dan mencetak rekap laporan akhir. | Data Pribadi Siswa |
| 3 | Guru | Menambahkan data/jurnal pelaksanaan kegiatan ekstrakurikuler. | Data Kegiatan Ekstrakurikuler |
| 4 | BK | Mengelola (Input/Edit/Delete) catatan kasus pelanggaran kedisiplinan siswa harian. | Data Kedisiplinan Siswa |
| 5 | Wakil Kepala Kesiswaan | Memvalidasi (approve) data siswa baru dan data kedisiplinan harian yang masuk, serta melihat/mencetak rekap data. | Data Siswa, Data Kedisiplinan |
| 6 | Kepala Sekolah | Melakukan pengesahan (approval akhir) terhadap dokumen laporan. | Dokumen Laporan Rekapitulasi |

---

### b) Analisis Rekayasa-ulang Proses dan Prosedur
Analisis prosedur memberikan gambaran tentang jalannya sistem yang akan dibangun. Tujuannya untuk mengetahui lebih jelas bagaimana cara kerja sistem tersebut. Berikut prosedur yang akan berjalan:

**Tabel 8. Analisis Rekayasa-ulang Proses dan Prosedur**

| No | Aktivitas | Prosedur | Pengguna Terkait | Dokumen Terkait |
| :--- | :--- | :--- | :--- | :--- |
| 1 | Login | 1. User mengakses halaman login.<br>2. User menginputkan username dan password.<br>3. Sistem melakukan verifikasi.<br>4. Sistem menampilkan dashboard sesuai hak akses. | Admin, Kepala Sekolah, Wakil Kepala Kesiswaan, Staff Kesiswaan, Guru BK, Guru | Data Username dan Password |
| 2 | Mengelola Data Master | 1. Admin mengelola akun pengguna.<br>2. Staff Kesiswaan menginput/mengelola data pribadi siswa. | Admin, Staff Kesiswaan | Data User, Data Pribadi Siswa |
| 3 | Mengelola Data Kegiatan & Kasus | 1. Guru menginput jurnal ekstrakurikuler.<br>2. Guru BK menginput kasus kedisiplinan siswa. | Guru, Guru BK | Data Ekstrakurikuler, Data Kedisiplinan |
| 4 | Validasi Data Harian | Wakil Kepala Kesiswaan memvalidasi (Approve 1) data siswa baru dan data kasus kedisiplinan yang baru masuk ke sistem. | Wakil Kepala Kesiswaan | Data Siswa, Data Kedisiplinan |
| 5 | Pengesahan Laporan (Approval Akhir) | Kepala Sekolah meninjau rekapitulasi data bulanan/mingguan dan memberikan pengesahan (Approve 2) secara sistem. | Kepala Sekolah | Dokumen Laporan Rekapitulasi |
| 6 | Cetak Rekap Laporan | User memilih filter tanggal/bulan, lalu sistem menghasilkan dokumen output (PDF/Excel). | Staff Kesiswaan, Wakil Kepala Kesiswaan, Kepala Sekolah | Data Siswa, Data Ekstrakurikuler, Data Kedisiplinan |
| 7 | Log out | 1. User menekan tombol pengaturan.<br>2. User memilih menu log out. | Admin, Kepala Sekolah, Wakil Kepala Kesiswaan, Staff Kesiswaan, Guru BK, Guru | - |

---

### c) Analisis Dokumen

#### 1) Dokumen Input
Dokumen input merupakan dokumen yang dimasukkan oleh pengguna ke dalam sistem. Untuk lebih jelasnya akan dijelaskan oleh tabel berikut:

**Tabel 9. Dokumen Input**

| No | Dokumen | Pengguna Terkait | Keterangan |
| :--- | :--- | :--- | :--- |
| 1 | Data Pengguna (User) | Admin | Data yang berisikan profil akun pengguna, wewenang (role), username, dan password. |
| 2 | Data Pribadi Siswa | Staff Kesiswaan | Data yang berisikan seluruh informasi profil identitas siswa baru atau update data siswa aktif. |
| 3 | Data Kasus Kedisiplinan | Guru BK | Data yang berisikan kategori pelanggaran, waktu kejadian, keterangan, serta foto bukti pelanggaran siswa. |

#### 2) Dokumen Output
Dokumen output merupakan dokumen yang dihasilkan oleh sistem setelah melakukan proses. Dokumen output akan menghasilkan informasi yang bermanfaat untuk pengguna. Untuk lebih jelasnya dapat di lihat dalam tabel berikut:

**Tabel 10. Dokumen Output**

| No | Dokumen | Pengguna Terkait | Keterangan |
| :--- | :--- | :--- | :--- |
| 1 | Dokumen Laporan Rekapitulasi Kedisiplinan | Kepala Sekolah, Wakil Kepala Kesiswaan | Data rekap yang berisikan seluruh pelanggaran siswa dalam periode tertentu yang sudah divalidasi dan disahkan. |
| 2 | Dokumen Jurnal Ekstrakurikuler | Kepala Sekolah, Guru | Data cetak/export yang berisi logbook pelaksanaan kegiatan ekskul beserta dokumentasi dan keterangan. |
| 3 | Dokumen Data Master Siswa | Staff Kesiswaan, Wakil Kepala Kesiswaan | Hasil cetak atau export (PDF/Excel) dari keseluruhan data profil siswa aktif yang terdaftar di sekolah. |


### 4. Physical Design (Desain Fisik)

**1) Nama tabel: User**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_user | Int | NO | PRI | Null | Auto Increment |
| nama | Varchar | NO | | Null | |
| level_user | Varchar | NO | | Null | (Admin, Kepsek, Waka, BK, Staff, Guru) |
| email | Varchar | NO | UNI | Null | |
| username | Varchar | NO | UNI | Null | |
| password | Varchar | NO | | Null | |
| jabatan | Varchar | NO | | Null | |
| nip | Varchar | YES | | Null | |
| no_hp | Varchar | YES | | Null | |
| alamat | Varchar | YES | | Null | |

**2) Nama tabel: Wali**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_wali | Int | NO | PRI | Null | Auto Increment |
| nama_ayah | Varchar | YES | | Null | |
| nama_ibu | Varchar | YES | | Null | |
| pekerjaan_ayah | Varchar | YES | | Null | |
| pekerjaan_ibu | Varchar | YES | | Null | |
| no_hp_ayah | Varchar | YES | | Null | |
| no_hp_ibu | Varchar | YES | | Null | |


**3) Nama tabel: Akademik**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_akademik | Int | NO | PRI | Null | Auto Increment |
| id_siswa | Int | NO | MUL | Null | (Foreign Key) |
| asal_paud | Varchar | YES | | Null | |
| asal_tk | Varchar | YES | | Null | |
| asal_sd | Varchar | NO | | Null | |
| beasiswa | Varchar | YES | | Null | |


**4) Nama tabel: Prestasi**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_prestasi | Int | NO | PRI | Null | Auto Increment |
| id_siswa | Int | NO | MUL | Null | (Foreign Key) |
| kegiatan | Varchar | NO | | Null | |
| juara | Varchar | NO | | Null | |


**5) Nama tabel: Kesehatan**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_kesehatan | Int | NO | PRI | Null | Auto Increment |
| id_siswa | Int | NO | MUL | Null | (Foreign Key) |
| tb | Int | YES | | Null | |
| bb | Int | YES | | Null | |
| riwayat_sakit | Varchar | YES | | Null | |


**6) Nama tabel: Siswa**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_siswa | Int | NO | PRI | Null | Auto Increment |
| id_user | Int | NO | MUL | Null | (Foreign Key) |
| id_wali | Int | NO | MUL | Null | (Foreign Key) |
| nisn | Varchar | NO | UNI | Null | (Unique Key) |
| nama | Varchar | NO | | Null | |
| ttl | Varchar | NO | | Null | |
| agama | Varchar | NO | | Null | |
| hobi | Varchar | YES | | Null | |
| thn_msk | Int | NO | | Null | |

**7) Nama tabel: Disiplin**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_disiplin | Int | NO | PRI | Null | Auto Increment |
| id_user | Int | NO | MUL | Null | (Foreign Key) |
| id_siswa | Int | NO | MUL | Null | (Foreign Key) |
| masalah | Varchar | NO | | Null | |
| tanggal | Date | NO | | Null | |
| foto | Varchar | YES | | Null | |
| status_validasi | Varchar | NO | | 'Pending' | |


**8) Nama tabel: Ekstrakurikuler**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_ekskul | Int | NO | PRI | Null | Auto Increment |
| id_user | Int | NO | MUL | Null | (Foreign Key) |
| nama_kegiatan | Varchar | NO | | Null | |
| tanggal | Date | NO | | Null | |
| lokasi | Varchar | NO | | Null | |
| foto | Varchar | YES | | Null | |

**9) Nama tabel: Anggota_Ekskul (Tabel Pivot)**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_anggota | Int | NO | PRI | Null | Auto Increment |
| id_siswa | Int | NO | MUL | Null | (Foreign Key) |
| id_ekskul | Int | NO | MUL | Null | (Foreign Key) |



**10) Nama tabel: Pengesahan_Laporan**

| Field | Type | Null | Key | Default | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- |
| id_pengesahan | Int | NO | PRI | Null | Auto Increment |
| jenis_laporan | Varchar | NO | | Null | |
| periode | Varchar | NO | | Null | |
| tgl_disahkan | Date | YES | | Null | |
| status_kepsek | Varchar | NO | | 'Pending' | |
