# Fix: Composer Dependencies Not Installed

## Masalah
Error: `Composer dependencies not installed. Please run: composer install`

Ini terjadi karena Vercel tidak menjalankan `composer install` saat deployment.

## Penyebab
1. ❌ File `vendor` ada di `.vercelignore` 
2. ❌ File `composer.json` ada di `.vercelignore`
3. ❌ Tidak ada `buildCommand` di `vercel.json`

## Solusi yang Diterapkan

### 1. ✅ Update `.vercelignore`
**Dihapus:**
- `vendor` (biarkan Vercel install sendiri)
- `composer.json` (Vercel perlu file ini!)
- `storage` (Vercel perlu folder ini)

**Tetap di-ignore:**
- `.git`, `.env`, `node_modules`, `tests`, dll

### 2. ✅ Update `vercel.json`
Ditambahkan `buildCommand`:
```json
{
  "buildCommand": "composer install --no-dev --optimize-autoloader"
}
```

Ini memastikan Vercel menjalankan composer install sebelum deployment.

### 3. ✅ Buat `build.sh`
Script cadangan jika `buildCommand` tidak bekerja.

## Deploy Ulang

```bash
git add .
git commit -m "Fix: Enable composer install on Vercel"
git push
```

## Cek Build Logs

Setelah deploy, cek di Vercel Dashboard:
1. Klik deployment terbaru
2. Lihat "Build Logs"
3. Pastikan ada output: `Installing Composer dependencies...`
4. Pastikan `composer install` berhasil

## Yang Harus Terlihat di Logs

```
Installing Composer dependencies...
Loading composer repositories with package information
Installing dependencies from lock file
...
Generating optimized autoload files
```

## Jika Masih Error

Jika masih muncul error yang sama:
1. Cek apakah `composer.json` ada di root project
2. Cek apakah `composer.lock` ada di root project
3. Pastikan kedua file tidak di-ignore di `.gitignore`
4. Kirim screenshot build logs dari Vercel

## File yang Diubah

- ✅ `.vercelignore` - Dihapus `vendor`, `composer.json`, `storage`
- ✅ `vercel.json` - Ditambah `buildCommand`
- ✅ `build.sh` - Script build cadangan

Silakan deploy ulang! 🚀
