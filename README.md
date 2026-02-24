# 🌡️ Aplikasi Pemantauan Sensor Gas Metana Berbasis Web

Sistem monitoring real-time untuk pemantauan gas metana berbasis web, dikembangkan saat **Program Magang di PT Pupuk Sriwidjaja Palembang**.

---

## 📋 Tentang Aplikasi

Aplikasi ini dibangun untuk memantau kadar gas metana secara **real-time** melalui antarmuka web yang mudah digunakan. Data sensor ditampilkan dalam bentuk dashboard interaktif dengan peta lokasi dan grafik monitoring harian.

### Manfaat
1. **Pemantauan Real-Time** — Mempermudah pemantauan gas metana yang lebih cepat, sehingga potensi bahaya dapat diidentifikasi lebih awal.
2. **Pengambilan Keputusan** — Memastikan data sensor gas metana dapat dipantau secara real-time untuk mendukung pengambilan keputusan yang cepat berdasarkan kondisi.
3. **Data Historis** — Menyimpan data historis secara terstruktur, mendukung proses dokumentasi dan analisis untuk pengelolaan gas metana secara berkelanjutan.

> ⚠️ **Catatan:** Aplikasi ini merupakan **antarmuka web (frontend & backend)** untuk pemantauan data sensor gas metana. Untuk implementasi ke perangkat IoT secara langsung (seperti ESP32, Arduino, atau sensor MQ-4), diperlukan pengembangan lebih lanjut pada sisi hardware dan koneksi API ke database.

---

## 🛠️ Tech Stack

| Teknologi | Keterangan |
|-----------|------------|
| PHP       | Backend & Logic |
| MySQL     | Database |
| HTML/CSS/JS | Frontend |
| Laragon   | Local Server |

---

## 🚀 Cara Menjalankan

### Prasyarat
Pastikan sudah menginstall **[Laragon](https://laragon.org/download/)** (sudah termasuk Apache, PHP, dan MySQL).

### Langkah-Langkah

**1. Clone Repository**
```bash
git clone https://github.com/AniffXP/Website-monitoring-sensor-metan.git
```

**2. Pindahkan ke Folder Laragon**

Pindahkan folder hasil clone ke dalam folder `www` milik Laragon:
```
C:\laragon\www\Website-monitoring-sensor-metan
```

**3. Start Laragon**

Buka aplikasi Laragon → klik tombol **"Start All"** untuk menyalakan Apache dan MySQL.

**4. Buat Database**

- Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
- Klik **"New"** di sidebar kiri
- Buat database baru dengan nama: **`dbsensor`**
- Klik **Create**

**5. Import Database**

- Pilih database `dbsensor` yang baru dibuat
- Klik tab **"Import"**
- Klik **"Choose File"**, pilih file: `database/dbsensor.sql`
- Klik **"Go"** / **"Import"**

**6. Buka di Browser**

Akses website di browser:
```
http://localhost/Website-monitoring-sensor-metan/
```

**7. Login**

Gunakan kredensial berikut:
| Username | Password |
|----------|----------|
| `admin`  | `admin`  |

---

## 📁 Struktur Folder

```
├── assets/
│   ├── css/          # File styling
│   ├── js/           # File JavaScript
│   └── img/          # Gambar & logo
├── database/
│   └── dbsensor.sql  # File SQL database
├── includes/
│   └── db.php        # Koneksi database
├── pages/
│   ├── dashboard.php         # Halaman dashboard utama
│   ├── daily_monitoring.php  # Monitoring harian & peta
│   ├── operasi.php           # Data operasi sensor
│   ├── add_data.php          # Tambah data sensor
│   ├── edit_data.php         # Edit data sensor
│   └── delete_data.php       # Hapus data sensor
├── index.php          # Halaman utama (redirect)
├── login.php          # Halaman login
└── logout.php         # Proses logout
```

---

## 👤 Developer

**Abdurrahman Hanif**
- D3 Teknik Komputer — Politeknik Negeri Sriwijaya
- 📧 ahanif562@gmail.com
- 🔗 [GitHub](https://github.com/AniffXP)

---

## 📄 Lisensi

Project ini dibuat untuk keperluan **Laporan Akhir / Magang** di PT Pupuk Sriwidjaja Palembang.
