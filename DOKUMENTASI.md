# babada-corp — DOKUMENTASI

Dokumentasi lengkap isi repo ini — dibaca dari awal, tanpa perlu tracing ke file satu-satu.
Aturan update dokumen ini setiap ada perubahan: lihat [`WORKFLOW.md`](WORKFLOW.md).

---

## 1. Ringkasan Proyek

Repo ini adalah **source code production website [babada.co.id](https://www.babada.co.id/)** — situs resmi **PT Babada Wasaka Indonesia (Babada Corporation)**, holding company di bidang industri kuliner / F&B di Riau.

Isinya adalah **installasi WordPress full (core + theme + plugins)** yang di-track ke Git, dipakai sebagai basis deploy ke hosting cPanel. Tidak ada custom plugin/theme buatan sendiri di repo ini — semuanya adalah komponen pihak ketiga + konfigurasi hosting.

| Item | Nilai |
|---|---|
| Situs | https://www.babada.co.id/ |
| Staging | https://staging.babada.co.id/ (child theme `babada-child`, auto-deploy) |
| CMS | WordPress `7.1.2` (repo = server, sinkron 2026-09-25) |
| Theme | Astra `4.13.9` (repo = server) + child `babada-child` |
| PHP | `ea-php83` (PHP 8.3, via handler cPanel) |
| Hosting | cPanel, docroot `/home/babadaco/public_html/` |
| Total file ter-track | ± 18.262 file (± 14.913 di `wp-content/`) |
| Bahasa konten | Indonesia (`llms.txt` → Yoast SEO v28.2) |
| Cabang | `main` (basis production, semua lewat PR) & `develop` (auto-deploy staging) |

> **Versi di tabel ini = versi repo (`main`) = versi server staging** — sudah disinkronkan pada 2026-09-25 (cara & sisa selisih: §9.1).

---

## 2. Struktur Repo

```
babada-corp/
├── README.md            ← ringkasan 1 baris
├── DOKUMENTASI.md       ← file ini (doc lengkap, aturan update: WORKFLOW.md)
├── WORKFLOW.md          ← aturan update dokumentasi + alur PR
├── llms.txt             ← ringkasan situs untuk LLM (dari Yoast SEO)
├── readme.html          ← readme bawaan WordPress
├── license.txt          ← lisensi GPL WordPress (baru sejak WP 7.1.2)
├── robots.txt           ← kebijakan crawler (lihat §6)
├── .cpanel.yml          ← definisi deployment cPanel
├── .htaccess            ← rewrite WordPress + WAF Wordfence + PHP handler
├── .user.ini            ← auto_prepend_file → Wordfence WAF
├── .gitignore           ← file yang TIDAK boleh masuk Git
│
├── index.php, wp-*.php  ← entry point WordPress core
│   (wp-load, wp-settings, wp-login, wp-cron, xmlrpc, dll.)
├── wordfence-waf.php    ← bootstrap WAF (dirujuk .htaccess/.user.ini)
│
├── wp-admin/            ← 593 file ter-track (dashboard)
├── wp-includes/         ← 2.729 file ter-track (library inti)
└── wp-content/          ← 14.913 file ter-track
    ├── plugins/         ← 19 plugin (lihat §4)
    ├── themes/astra/    ← theme utama
    ├── advanced-cache.php   ← dibuat WP-Optimize (page cache)
    ├── maintenance.php      ← dibuat otomatis saat mode maintenance
    ├── uploads/         ← TIDAK di-track (konten media)
    └── cache/, wflogs/, languages/, fonts/  ← TIDAK di-track
```

---

## 3. File Konfigurasi Kunci

### `.htaccess`
- **WordPress rewrite** — blok `BEGIN WordPress` (jangan diedit manual, ditulis ulang oleh WP).
- **Wordfence WAF** — `php_value auto_prepend_file` ke `wordfence-waf.php` untuk LiteSpeed/lsapi, plus proteksi file `.user.ini`.
- **Hotlinking** — blok kosong, aktif/diatur dari plugin.
- **PHP handler cPanel** — `AddHandler application/x-httpd-ea-php83 .php .php8 .phtml`.

### `.user.ini`
```
auto_prepend_file = '/home/babadaco/public_html/wordfence-waf.php'
```
WAF dijalankan sebelum script PHP lain (fallback bila modul LiteSpeed tidak aktif).

### `wordfence-waf.php`
Bootstrap WAF → memuat `wp-content/plugins/wordfence/waf/bootstrap.php`, log ke `wp-content/wflogs/`. Jangan dihapus selama `auto_prepend_file` masih menunjuk ke file ini.

### `.cpanel.yml` (deployment)
```yaml
deployment:
  tasks:
    - export DEPLOYPATH=/home/babadaco/public_html/
    - /bin/cp README.md $DEPLOYPATH
```
Saat ini hanya menyalin `README.md` ke docroot. **Belum melakukan sync WP core/plugin** — deploy penuh masih manual (upload via git push ke cPanel / File Manager).

### `.gitignore`
| Kategori | Pola |
|---|---|
| Secrets | `wp-config.php`, `.env`, `.env.*` |
| Konten user | `wp-content/uploads/` |
| Cache/runtime | `wp-content/cache/`, `litespeed/`, `wpo-cache/`, `wflogs/`, `upgrade*/`, `maintenance/` |
| Artefak generate | `wp-content/fonts/`, `wp-content/languages/` |
| Log | `error_log`, `*.log` |
| OS/IDE | `.DS_Store`, `.idea/`, `.vscode/`, `*.swp` |

> **Penting:** `wp-config.php` berisi kredensial database dan **tidak pernah** ada di Git. Konfigurasi hidup hanya di server.

---

## 4. Theme & Plugin (tertrack di repo, versi saat commit terakhir)

> Angka di bawah = versi **repo `main`** = versi **server staging** (sinkron 2026-09-25, lihat §9.1).

**Theme**
| Theme | Versi |
|---|---|
| Astra | 4.13.9 |

**Plugins (19)**
| Plugin | Versi | Fungsi |
|---|---|---|
| Wordfence Security | 9.0.0 | Security + WAF |
| Yoast SEO (`wordpress-seo`) | 28.2 | SEO + `llms.txt` |
| Elementor | 4.2.2 | Page builder |
| WPZOOM Elementor Addons | 1.4.11 | Addon Elementor |
| WPZOOM Portfolio | 1.4.31 | Portfolio |
| Header Footer Elementor | 2.9.3 | Header/footer via Elementor |
| Astra Widgets | 1.2.17 | Widget tambahan |
| WPForms Lite | 2.0.0.3 | Formulir |
| Polylang | 3.8.6 | Multibahasa |
| WP-Optimize | 4.6.1 | Cache + optimasi DB |
| OneSignal Free Web Push | 3.9.2 | Push notification |
| Quick Adsense | 2.9.4 | Slot iklan |
| Sassy Social Share | 3.3.79 | Tombol share |
| Social Icons Widget (WPZoom) | 4.6.1 | Ikon sosial |
| 3D Flipbook (dFlip Lite) | 2.4.37 | Buku flip |
| Classic Editor | 1.7.0 | Editor lama |
| Classic Widgets | 0.3 | Widget lama |
| Duplicate Page | 4.5.9 | Duplikat halaman |
| Insert Headers and Footers | 2.3.9 | Skrip head/body |

Ada juga `wp-content/plugins/justshoppe-features.zip` — paket zip yang di-commit apa adanya (bukan folder plugin ter-install).

---

## 5. Riwayat Git

Baseline (impor eksisting production):

```
973197c5 2026-09-07 chore: add WordPress core          ← import WP core + wp-content
6f5999c5 2026-09-07 chore: initial production baseline  ← baseline production
b3572960 2026-08-24 Add cPanel deployment               ← .cpanel.yml
df0ac28e 2026-08-24 Update README.md
87312c94 2026-08-24 first commit
```

- Author: `Abdullah Fikri Harahap <fharahap85@gmail.com>` (set lokal: `git config user.name/user.email`).
- **Riwayat setelah baseline** (perubahan kode/doc) selalu masuk lewat **PR → merge ke `main`** — lihat [`WORKFLOW.md`](WORKFLOW.md) §5.

```
26bfc983 2026-09-25 ci: tambah workflow server snapshot (probe/pack)   (PR #3)
bc8d7545 2026-09-25 docs: sinkron status server staging, CI/CD, known issue  (PR #2)
9a25419c 2026-09-25 docs: dokumentasi proyek + workflow update via PR  (PR #1)
```

- Riwayat paling mutakhir: `git log --oneline -15` (PR ini menyusul sebagai squash commit berikutnya).

---

## 6. `robots.txt` — Kebijakan AI Crawler

- **Diizinkan:** semua crawler default, `search=yes`, **`ai-train=no`**.
- **Diblokir:** Amazonbot, Applebot-Extended, Bytespider, CCBot, ClaudeBot, CloudflareBrowserRenderingCrawler, Google-Extended, GPTBot, meta-externalagent.

---

## 7. `llms.txt` — Peta Konten Situs

Dibuat Yoast SEO v28.2 untuk dikonsumsi LLM. Isinya daftar URL resmi:

- **Halaman:** beranda, `/ai/` (Chat AI Babada), `/program/ambulance-gratis/`, `/amenities/`, `/pricing/`
- **Artikel:** MoU dengan RS Islam Ibnu Sina, Rotte Mineral, SOP kunjungan industri, peringatan phishing & penipuan lowongan kerja
- **Kategori:** Artikel, Rilis Pers, Kegiatan Sosial, Nilai-Nilai Perusahaan, Rotte Factory
- **Tag:** Rotte Factory, CSR Babada, Rotte Foundation, Babada Foundation, Kecamatan Kulim
- **Sitemap:** `https://www.babada.co.id/sitemap_index.xml`

---

## 8. Cara Kerja / Alur

1. Repo ini = **cetak biru production** (bukan proyek dev dengan build step).
2. Perubahan file (plugin/theme update, tuning `.htaccess`) dilakukan di lokal → commit di **branch** → **PR** → merge ke `main` (aturan lengkap: [`WORKFLOW.md`](WORKFLOW.md) §5).
3. Deploy ke server via cPanel Git Deployment (`.cpanel.yml`), saat ini hanya menyalin `README.md`.
4. Konten (posts, uploads, settings) **hidup di database & `wp-content/uploads/`** — tidak ada di repo.

### Hal yang perlu dijaga
- Jangan commit `wp-config.php` / `.env` (sudah di-`.gitignore`).
- Jangan edit blok `BEGIN WordPress` di `.htaccess` secara manual.
- Update inti WordPress/plugin sebaiknya lewat dashboard WP, lalu commit ulang hasilnya ke repo agar tetap sinkron.
- **Cara sinkron ke versi server bila akses SSH tertutup:** tarik paket resmi upstream dengan versi yang sama persis dengan server (wordpress.org / downloads.wordpress.org), lalu `rsync -a --delete` ke folder masing-masing — sudah dipakai 2026-09-25 dan hasilnya identik (`diff -rq` bersih). Jangan menimpa file root non-WP (`.htaccess`, `.user.ini`, `.cpanel.yml`, `*.md`, `robots.txt`, `llms.txt`, `wordfence-waf.php`).
- File generatif (`advanced-cache.php`, `maintenance.php`) ditulis ulang oleh plugin — perubahan manual bisa hilang.

---

## 9. Status Server, CI/CD & Known Issue

### 9.1 Versi repo vs server staging (dicek & disinkron 2026-09-25)

Akses SSH ke server **ditutup** (workflow `Server Snapshot` mode `probe` gagal — lihat §9.3), jadi file asli tidak bisa ditarik. Sinkron dilakukan dengan **menarik paket resmi upstream dengan versi yang sama persis dengan server**, lalu `rsync -a --delete` per folder. Hasilnya diverifikasi dengan `diff -rq` terhadap paket: **identik, 0 selisih**.

| Komponen | Repo `main` | Server staging | Status |
|---|---|---|---|
| WordPress | 7.1.2 | 7.1.2 | ✓ sinkron |
| Astra (theme) | 4.13.9 | 4.13.9 | ✓ sinkron |
| Wordfence | 9.0.0 | 9.0.0 | ✓ sinkron |
| Yoast SEO | 28.2 | 28.2 | ✓ sinkron |
| Elementor | 4.2.2 | 4.2.2 | ✓ sinkron |
| WP-Optimize | 4.6.1 | 4.6.1 | ✓ sinkron |
| WPForms Lite | 2.0.0.3 | 2.0.0.3 | ✓ sinkron |
| dFlip 3D Flipbook | 2.4.37 | 2.4.37 | ✓ sinkron |
| Header Footer Elementor | 2.9.3 | 2.9.3 | ✓ sinkron |
| Insert Headers and Footers | 2.3.9 | 2.3.9 | ✓ sinkron |
| Quick Adsense | 2.9.4 | 2.9.4 | ✓ sinkron |
| Social Icons (WPZoom) | 4.6.1 | 4.6.1 | ✓ sinkron |
| WPZOOM Elementor Addons | 1.4.11 | 1.4.11 | ✓ sinkron |
| 13 plugin lainnya | — | sama | ✓ |

**Catatan:** isi repo = paket resmi, *bukan* salinan langsung dari server — jadi bila server punya patch lokal di dalam folder plugin/core, patch itu tidak ikut terbawa. Bila nanti SSH dibuka, jalankan `Server Snapshot` mode `pack` untuk membandingkan aslinya (WORKFLOW §1 trigger #9).

**Tindakan selanjutnya:** `.cpanel.yml` production masih hanya menyalin `README.md` — jalur deploy penuh ke production belum ada (lihat §8).

### 9.2 Environment

| | Production | Staging |
|---|---|---|
| URL | https://www.babada.co.id/ | https://staging.babada.co.id/ |
| Branch | `main` | `develop` |
| Cara deploy | cPanel Git (`.cpanel.yml`, masih terbatas salin `README.md`) | **GitHub Actions → FTPS** (otomatis) |
| Tema aktif | — | `babada-child` (child of Astra) |
| Yang di-deploy CI | — | hanya `wp-content/themes/babada-child/**` |

- **`develop` hanya mem-track `babada-child` + file konfigurasi root** — WP core, Astra, dan semua plugin **tidak ada** di branch ini (di-install langsung di server).

### 9.3 CI/CD — GitHub Actions

Ada dua workflow:

| File | Branch | Trigger | Fungsi |
|---|---|---|---|
| `staging.yml` (`Deploy Staging`) | `develop` saja | push ke `develop` (path `babada-child/**`) | deploy theme ke staging via FTPS |
| `server-snapshot.yml` (`Server Snapshot`) | `main` | `workflow_dispatch` saja (mode `probe`/`pack`) | uji SSH + tarik snapshot docroot server |

**`Deploy Staging`**

```yaml
name: Deploy Staging
on:
  push:
    branches: [develop]
    paths:
      - 'wp-content/themes/babada-child/**'
      - '.github/workflows/staging.yml'
  workflow_dispatch:          # ⚠️ tidak bisa dipanggil via API — file tidak ada di default branch
```

- Aksi: `SamKirkland/FTP-Deploy-Action@v4.4.0` → FTPS port 21, incremental pakai state file `.ftp-deploy-theme-state.json`.
- **Belum ada:** test/lint, deploy production, jalur PR otomatis untuk staging.

**`Server Snapshot`** (PR #3)

- Mode `probe`: uji koneksi SSH + info docroot (read-only). Mode `pack`: `tar.gz` isi docroot (uploads/cache dikecualikan) → artifact, retensi 3 hari.
- Tidak ada trigger push → tidak memicu deploy apa pun. Kredensial dari secrets repo.
- **Status: `probe` gagal** — server menolak koneksi (port SSH ditutup/sekat firewall). Belum ada snapshot asli yang bisa diambil; sementara paket resmi upstream dipakai untuk sinkron (§9.1).
- ⚠️ GitHub hanya mendaftarkan workflow yang ada di **default branch** (`main`) — itulah sebabnya `workflow_dispatch` tidak bisa dipanggil selama file hanya ada di `develop`.

- Secrets tersedia: `FTP_HOST/USERNAME/PASSWORD`, `SSH_HOST/PORT/USER/PRIVATE_KEY`.
- Warning yang muncul tiap run: `actions/checkout@v4` masih Node 20 (dipaksa ke Node 24), `ubuntu-latest` migrasi ke Ubuntu 26 per 19 Okt 2026.

### 9.4 Known issue — error WP-Optimize Minify (false alarm, tidak berbahaya)

Gejala: di HTML staging muncul komentar

```
<!-- ERROR: WP-Optimize Minify was not allowed to save its cache on -
     wp-content/cache/wpo-minify/<hash>/assets/...-babada-child-style....min.css -->
<!-- Please check if the path above is correct and ensure your server has write permission there! -->
```

**Penyebab: bukan permission.** Kedua file CSS yang gagal isinya memang kosong:

| File | Isi sumber |
|---|---|
| `babada-child/style.css` | hanya komentar header theme (0 aturan CSS) |
| `wpzoom-portfolio/.../portfolio-layouts/style.css` | 1 byte |

WP-Optimize punya guard `if (empty($code)) continue;` (`class-wp-optimize-minify-front-end.php:2131`) → file tidak pernah ditulis → pengecekan berikutnya `file_exists && filesize > 0` gagal → pesan error menyesatkan yang menyalahkan permission. Folder cache-nya sendiri **bisa ditulis** (file CSS lain di folder yang sama 200 OK).

**Dampak:** nol — CSS-nya memang tidak ada isinya, dan file tidak di-enqueue karena memang kosong. Solusi opsional: beri minimal satu aturan CSS di `babada-child/style.css`, atau abaikan.

### 9.5 Catatan akses

- `.user.ini` & `.htaccess` mengarah ke Wordfence WAF di `/home/babadaco/public_html/wordfence-waf.php` — jangan dihapus selama `auto_prepend_file` masih menunjuk ke sana.
- Folder `wp-content/cache/` bisa di-list publik (`GET /wp-content/cache/` → 200) — sebaiknya diberi `Options -Indexes` bila cache berisi URL privat.
