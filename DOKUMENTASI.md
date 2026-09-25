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
| CMS | WordPress `7.0.2` |
| Theme | Astra `4.13.2` (Brainstorm Force) |
| PHP | `ea-php83` (PHP 8.3, via handler cPanel) |
| Hosting | cPanel, docroot `/home/babadaco/public_html/` |
| Total file ter-track | ± 18.341 file (± 14.830 di `wp-content/`) |
| Bahasa konten | Indonesia (`llms.txt` → Yoast SEO v28.1) |

---

## 2. Struktur Repo

```
babada-corp/
├── README.md            ← file ini (dokumentasi)
├── llms.txt             ← ringkasan situs untuk LLM (dari Yoast SEO)
├── readme.html          ← readme bawaan WordPress
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
├── wp-admin/            ← 590 file ter-track (dashboard)
├── wp-includes/         ← 2.898 file ter-track (library inti)
└── wp-content/          ← 14.830 file ter-track
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

## 4. Theme & Plugin (tertrack, versi saat commit terakhir)

**Theme**
| Theme | Versi |
|---|---|
| Astra | 4.13.2 |

**Plugins (19)**
| Plugin | Versi | Fungsi |
|---|---|---|
| Wordfence Security | 8.2.2 | Security + WAF |
| Yoast SEO (`wordpress-seo`) | 28.1 | SEO + `llms.txt` |
| Elementor | 4.2.1 | Page builder |
| WPZOOM Elementor Addons | 1.4.9 | Addon Elementor |
| WPZOOM Portfolio | 1.4.31 | Portfolio |
| Header Footer Elementor | 2.9.2 | Header/footer via Elementor |
| Astra Widgets | 1.2.17 | Widget tambahan |
| WPForms Lite | 2.0.0.2 | Formulir |
| Polylang | 3.8.6 | Multibahasa |
| WP-Optimize | 4.5.3 | Cache + optimasi DB |
| OneSignal Free Web Push | 3.9.2 | Push notification |
| Quick Adsense | 2.8.7 | Slot iklan |
| Sassy Social Share | 3.3.79 | Tombol share |
| Social Icons Widget (WPZoom) | 4.6.0 | Ikon sosial |
| 3D Flipbook (dFlip Lite) | 2.4.30 | Buku flip |
| Classic Editor | 1.7.0 | Editor lama |
| Classic Widgets | 0.3 | Widget lama |
| Duplicate Page | 4.5.9 | Duplikat halaman |
| Insert Headers and Footers | 2.3.8 | Skrip head/body |

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
- Daftar lengkap terbaru: `git log --oneline -15`.

---

## 6. `robots.txt` — Kebijakan AI Crawler

- **Diizinkan:** semua crawler default, `search=yes`, **`ai-train=no`**.
- **Diblokir:** Amazonbot, Applebot-Extended, Bytespider, CCBot, ClaudeBot, CloudflareBrowserRenderingCrawler, Google-Extended, GPTBot, meta-externalagent.

---

## 7. `llms.txt` — Peta Konten Situs

Dibuat Yoast SEO v28.1 untuk dikonsumsi LLM. Isinya daftar URL resmi:

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
- File generatif (`advanced-cache.php`, `maintenance.php`) ditulis ulang oleh plugin — perubahan manual bisa hilang.
