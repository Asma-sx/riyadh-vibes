# Riyadh Vibes

A Riyadh Season events website with pages for artists, event areas, pricing and contact, plus an admin panel to add, edit and delete events.

## Tech
PHP · MySQL (mysqli) · Bootstrap · JavaScript · HTML · CSS

## Admin panel
- Admin login with hashed passwords and a server-side session
- Add, edit and delete events with image upload (JPG/PNG only, random file names)
- Prepared statements for every query and CSRF tokens on admin actions

## Run locally (XAMPP)
1. Copy the folder into `htdocs/`.
2. In phpMyAdmin create a database named `login` and import `database.sql`.
3. Check the settings in `config.php`.
4. Open `http://localhost/RiyadhVibes/`.
