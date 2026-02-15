# Fix untuk Error 500 di Vercel

## Masalah yang Ditemukan

Ada file `api/composer.json` yang **tidak seharusnya ada**. File ini membingungkan Vercel karena:
- Vercel mencoba menjalankan `composer install` di folder `api/`
- Padahal `composer.json` yang benar ada di root project
- Ini menyebabkan autoload gagal dan error 500

## Perbaikan yang Dilakukan

### 1. ✅ Hapus `api/composer.json`
File ini sudah dihapus. Yang benar hanya ada `composer.json` di root project.

### 2. ✅ Perbaiki `api/index.php`
- Tambah pengecekan apakah `vendor/autoload.php` ada
- Perbaiki error handling dengan JSON response yang lebih detail
- Tambah `@` di `mkdir` untuk suppress warning

### 3. ✅ Buat `vercel-php.json`
File konfigurasi eksplisit untuk Vercel PHP runtime.

## Cara Deploy Ulang

```bash
git add .
git commit -m "Fix: Remove api/composer.json and improve error handling"
git push
```

## Yang Harus Dicek di Vercel

### 1. Environment Variables
Pastikan sudah diset di Vercel Dashboard → Settings → Environment Variables:

```
APP_KEY=base64:lVyWiTo71gSAh4DCWy8zBOosBUKX49We9rEJCpAmhIk=
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ppcfix-hsu4.vercel.app
```

### 2. Cek Build Logs
Setelah deploy, cek di Vercel Dashboard:
1. Klik deployment terbaru
2. Lihat "Build Logs"
3. Pastikan `composer install` berhasil di **root directory** (bukan di `api/`)

### 3. Cek Function Logs
Jika masih error:
1. Klik "Functions" tab
2. Klik `api/index.php`
3. Lihat error logs
4. Sekarang error akan muncul dalam format JSON yang jelas

## Jika Masih Error

Setelah deploy, coba akses `https://ppcfix-hsu4.vercel.app`

Jika masih error 500, sekarang akan muncul JSON seperti ini:
```json
{
  "error": "Application Error",
  "message": "Detail error message",
  "file": "/path/to/file.php",
  "line": 123,
  "trace": ["stack trace line 1", "line 2", ...]
}
```

**Kirim JSON error tersebut** agar saya bisa bantu debug lebih lanjut.

## Struktur yang Benar

```
ppcfix/
├── api/
│   └── index.php          ← Entry point untuk Vercel
├── app/                   ← Laravel app
├── bootstrap/
├── vendor/                ← Composer dependencies (di root!)
├── composer.json          ← Di root (BUKAN di api/)
├── vercel.json
└── vercel-php.json
```

## File yang Diubah

- ❌ **Dihapus**: `api/composer.json` (file yang salah)
- ✅ **Diperbaiki**: `api/index.php` (error handling lebih baik)
- ✅ **Dibuat**: `vercel-php.json` (konfigurasi PHP runtime)

Silakan deploy ulang dan coba lagi! 🚀
