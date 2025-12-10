# Only Scams - Webshop Project

Een moderne e-commerce webshop gebouwd met Laravel voor het vak **Datamanagement 3**.

## 📋 Over het Project

Only Scams is een **satirische parodie** van een e-commerce webshop - een volledig functionele webshop waar je "scams" als producten kunt kopen. Het project is gebouwd met Laravel 12, Alpine.js, Tailwind CSS en gebruikt DDEV voor lokale development. Dit is een educatief project en de webshop is bedoeld als satire en parodie.

## ✨ Features

- 🛍️ **Product Catalogus**
  - Product overzicht met filters (categorieën, merken)
  - Real-time search functionaliteit
  - Product detail pagina's
  - AJAX-gebaseerde filtering zonder pagina reload
  - Paginatie

- 🛒 **Winkelwagen**
  - Toevoegen/verwijderen van producten
  - Aantal aanpassen
  - Cookie-based cart voor niet-ingelogde gebruikers
  - Database cart voor ingelogde gebruikers

- ❤️ **Favorieten**
  - Producten toevoegen aan favorieten
  - Favorieten overzicht pagina

- ⭐ **Reviews**
  - Product reviews plaatsen
  - Rating systeem

- 💳 **Checkout & Betalingen**
  - Mollie payment integratie
  - Order bevestiging emails
  - Shipping informatie

- 👤 **Authenticatie**
  - Registratie en login
  - Email verificatie
  - Password reset

- 🔐 **Admin Panel**
  - Filament admin interface
  - Product, categorie, merk, order en user management

- 🎨 **Frontend**
  - Responsive design met Tailwind CSS
  - Alpine.js voor interactiviteit
  - AJAX updates zonder pagina reload
  - Toast notifications

## 🛠️ Technologie Stack

- **Backend:** Laravel 12
- **Frontend:** Alpine.js, Tailwind CSS, Vite
- **Database:** MariaDB 10.11
- **Payment:** Mollie
- **Admin:** Filament 4
- **SEO:** Laravel SEO Tools
- **Development:** DDEV

## 📦 Vereisten

- [DDEV](https://ddev.readthedocs.io/) (aanbevolen)
- [Node.js](https://nodejs.org/) (voor npm commando's)
- Of: PHP 8.2+, Composer, Node.js, MySQL/MariaDB

## 🚀 Installatie met DDEV

### 1. Clone het project

```bash
git clone <repository-url>
cd webshop-pgm-zegerschaeverbeke
```

### 2. Start DDEV

```bash
ddev start
```

### 3. Installeer dependencies

```bash
# PHP dependencies
ddev composer install

# Node dependencies
npm install
```

### 4. Configureer environment

```bash
# Kopieer .env.example naar .env (als het bestaat)
ddev exec cp .env.example .env

# Of maak een nieuwe .env aan
ddev exec php -r "file_exists('.env') || copy('.env.example', '.env');"
```

### 5. Genereer application key

```bash
ddev exec php artisan key:generate
```

### 6. Database setup

```bash
# Run migrations en seeders
ddev exec php artisan migrate:fresh --seed
```

### 7. Build assets

```bash
# Development build (Laravel gebruikt Vite voor asset bundling)
npm run dev

# Of production build
npm run build
```

### 8. Maak storage link

```bash
ddev exec php artisan storage:link
```

## 🔑 Standaard Login Gegevens

Na het seeden van de database zijn de volgende test accounts beschikbaar:

**Admin:**
- Email: `admin@example.com` (of waarde uit `ADMIN_EMAIL` in `.env`)
- Password: `password` (of waarde uit `ADMIN_PASSWORD` in `.env`)

**Test Users:**
- Email: `alice@example.com` / Password: `password`
- Email: `bob@example.com` / Password: `password`
- Email: `carol@example.com` / Password: `password`
- Email: `dave@example.com` / Password: `password`
- Email: `eve@example.com` / Password: `password`

## 🌐 Toegang

Na installatie is de applicatie beschikbaar op:
- **Website:** https://webshop-pgm-zegerschaeverbeke.ddev.site
- **Admin Panel:** https://webshop-pgm-zegerschaeverbeke.ddev.site/admin

## 🧪 Development Commands

```bash
# Start development server
ddev start

# Stop DDEV
ddev stop

# Composer commands
ddev composer install
ddev composer update

# Artisan commands
ddev exec php artisan migrate
ddev exec php artisan migrate:fresh --seed
ddev exec php artisan cache:clear

# NPM commands
npm install
npm run dev
npm run build

# Database access
ddev mysql
# Of via phpMyAdmin: https://webshop-pgm-zegerschaeverbeke.ddev.site:8036

# Mailpit (email testing)
# https://webshop-pgm-zegerschaeverbeke.ddev.site:8026
```

## 📁 Project Structuur

```
webshop-pgm-zegerschaeverbeke/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/               # Eloquent models
│   ├── Filament/             # Admin panel resources
│   └── Mail/                 # Email classes
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
├── resources/
│   ├── js/                  # JavaScript files
│   │   ├── product-filter.js # Product filtering met AJAX
│   │   ├── search.js        # Search functionaliteit
│   │   ├── cart.js          # Winkelwagen functionaliteit
│   │   └── favorites.js    # Favorieten functionaliteit
│   ├── views/              # Blade templates
│   └── css/                # Stylesheets
├── routes/                 # Route definitions
└── public/                # Public assets
```

## 🎯 Belangrijke Features Uitleg

### Product Filtering
- AJAX-gebaseerde filtering zonder pagina reload
- Real-time search met debouncing
- URL synchronisatie met browser history
- Filter state behoud bij paginatie

### Winkelwagen
- Cookie-based voor niet-ingelogde gebruikers
- Database-based voor ingelogde gebruikers
- Real-time count updates in header

### Betalingen
- Mollie integratie voor veilige betalingen
- Order bevestiging emails
- Payment status tracking

## 📚 Documentatie

- [Laravel Documentation](https://laravel.com/docs)
- [DDEV Documentation](https://ddev.readthedocs.io/)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)

## 👥 Auteur

Ontwikkeld door Zeger Schaeverbeke voor Datamanagement 3 eindopdracht.

## 📄 License

Dit project is gemaakt voor educatieve doeleinden.

## ⚠️ Disclaimer

**Satire & Parodie:** Deze webshop is een satirische parodie en is uitsluitend bedoeld voor educatieve doeleinden.

**Afbeeldingen:** Ik bezit geen rechten op de gebruikte afbeeldingen in dit project. Alle credits voor de afbeeldingen behoren toe aan de rechtmatige eigenaren.
