# WORKFLOW — Update `DOKUMENTASI.md`

Aturan kerja supaya `DOKUMENTASI.md` selalu mencerminkan isi repo terkini.
**Prinsip: tidak ada perubahan di repo yang tidak dibalas dengan update dokumentasi.**

File ini adalah satu-satunya sumber aturan update. `README.md` tetap ringkas (satu baris), `DOKUMENTASI.md` adalah doc lengkap.

---

## 1. Trigger (kapan wajib update)

| # | Perubahan di repo | Bagian doc yang diupdate |
|---|---|---|
| 1 | Install / hapus / update **plugin** | §4 tabel plugin |
| 2 | Ganti / update **theme** | §1 & §4 |
| 3 | Update **inti WordPress** (`wp-admin/`, `wp-includes/`, `wp-*.php`) | §1 (versi) & §5 (riwayat git) |
| 4 | Ubah `.htaccess`, `.user.ini`, `wordfence-waf.php`, `.cpanel.yml`, `.gitignore` | §3 konfigurasi |
| 5 | Tambah / hapus **file atau folder baru** di root / `wp-content/` | §2 struktur |
| 6 | Ganti isi `robots.txt` atau `llms.txt` | §6 / §7 |
| 7 | Perubahan **deploy / hosting / domain / PHP version** | §1 & §8 |
| 8 | Commit baru apa pun | §5 riwayat git |

> Deteksi cepat: `git status --short` dan `git diff --stat` sebelum & sesudah perubahan.

---

## 2. Checklist update (jalankan berurutan)

```bash
# 1. Lihat apa yang berubah
git status --short
git diff --stat

# 2. Ambil data versi terbaru
grep -m1 "wp_version =" wp-includes/version.php
grep -m1 -E "^(Version|Stable tag)" wp-content/themes/astra/style.css
for d in wp-content/plugins/*/; do
  echo "$(basename $d): $(grep -m1 -oP 'Version:\s*\K[0-9][0-9a-zA-Z.\- ]*' $d*.php 2>/dev/null | head -1)"
done

# 3. Hitung ulang jumlah file (untuk §1 dan §2)
git ls-files | wc -l
git ls-files wp-content | wc -l
git ls-files | grep -c '^wp-admin'
git ls-files | grep -c '^wp-includes'

# 4. Riwayat git terbaru (untuk §5)
git log --format='%h %ad %s' --date=short

# 5. Edit DOKUMENTASI.md sesuai tabel trigger di §1
# 6. Commit doc bersama (atau terpisah dari) perubahannya
```

**Commit message:** `docs: update DOKUMENTASI.md (<hal yang berubah>)`
Contoh: `docs: update DOKUMENTASI.md (elementor 4.2.1 -> 4.3.0)`

---

## 3. Aturan penulisan

- Selalu tambahkan **tanggal & hash commit** di §5 bila riwayat bertambah.
- Versi plugin ditulis persis seperti di header file plugin (jangan dilebih-lebihkan).
- Jangan menyimpan secret, kredensial, atau isi `wp-config.php` di doc mana pun.
- Tabel di §4 wajib diurutkan sesuai urutan yang ada (jangan diacak).
- Bila ada file/folder **baru** yang tidak tercakup §2, tambahkan ke peta struktur.
- Tautan relatif antar doc: `[WORKFLOW.md](WORKFLOW.md)`.

---

## 4. Verifikasi akhir

```bash
# Doc masih valid markdown & tidak ada placeholder
grep -n "TODO\|TBD\|???" DOKUMENTASI.md WORKFLOW.md || echo "OK: bersih"
git status --short   # pastikan DOKUMENTASI.md ikut ter-stage
```

- [ ] Semua trigger di §1 yang terjadi sudah berdampak ke doc
- [ ] Versi plugin/theme/WP cocok dengan isi folder
- [ ] Jumlah file & riwayat git diperbarui
- [ ] Tidak ada secret yang bocor
- [ ] Commit doc sudah dibuat

---

## 5. Struktur file dokumen

```
README.md          → ringkasan 1 baris (sudah cukup)
DOKUMENTASI.md     → doc lengkap project (diupdate mengikuti workflow ini)
WORKFLOW.md         → file ini (aturan update, jarang berubah — hanya bila struktur doc berubah)
```

Bila suatu saat penomoran section di `DOKUMENTASI.md` berubah, **perbarui kolom "Bagian doc" di tabel §1** agar petunjuk tetap akurat.
