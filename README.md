NoteIt (PHP + MySQL)

Quick single-file PHP app with MySQL (PDO) and minimal CSS. Ready for Coolify deployment.

Requirements
- Docker (for deployment via Coolify)
- MySQL database (TablePlus for management is fine)

Environment Variables (Coolify)
- DB_CONNECTION=mysql
- DB_DATABASE=default
- DB_HOST=<your-db-host>
- DB_PASSWORD=<your-db-password>
- DB_PORT=3306
- DB_USERNAME=root

Local Dev (optional)
1. Create a `.env` file based on `.env.example` and set your DB credentials.
2. Serve with PHP built-in server:
   php -S 0.0.0.0:8000 -t public

Deployment (Coolify)
1. Create a new application and point to this repo.
2. Set the environment variables in Coolify.
3. Build & deploy. Apache will serve from `/var/www/html`.

Database
- App will auto-create the `notes` table on first run if it does not exist.
- Columns: id (INT AI PK), title (VARCHAR 255), content (TEXT), created_at (TIMESTAMP), updated_at (TIMESTAMP)

File Structure
public/
  index.php
  styles.css
src/
  Database.php
  NotesRepository.php
Dockerfile
README.md
.env.example


