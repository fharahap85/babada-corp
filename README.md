# Babada Corporation (babada-corp)

Situs resmi [PT Babada Wasaka Indonesia](https://www.babada.co.id/) — perusahaan holding yang bergerak di bidang industri kuliner / F&B di Riau.

## Struktur Repository

Repository ini hanya berisi **custom code** — WordPress core, plugins, dan themes **tidak di-track di git** karena dikelola langsung di server (cPanel/FTP).

| Path | Keterangan |
|------|------------|
| `.github/workflows/` | CI/CD GitHub Actions |
| `.htaccess`, `.user.ini` | Konfigurasi server |
| `README.md`, `llms.txt` | Dokumentasi |

### Yang tidak di-track (dikelola di server)
- `wp-admin/` — WordPress core
- `wp-includes/` — WordPress core
- `wp-content/plugins/` — plugins
- `wp-content/themes/` — themes
- `wp-content/uploads/`, cache, languages, dst — konten user

## Deployment

Deploy ke staging otomatis via GitHub Actions saat ada push ke branch `develop`. Hanya 27 file custom code yang di-deploy melalui FTP.

Update WordPress core, plugin, dan theme dilakukan langsung di server staging — bukan melalui git.

## Environment

- **Staging:** build dari branch `develop`
- **Production:** `https://www.babada.co.id/`
