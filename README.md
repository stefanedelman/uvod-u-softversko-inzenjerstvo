# ❄️ SnowShop - Webshop za Snowboard Opremu

> Projekat iz predmeta **Uvod u Softversko Inženjerstvo** (UuSI)  
> Fakultet organizacionih nauka, 2025/2026

## 📋 O projektu

SnowShop je e-commerce web aplikacija za prodaju snowboard opreme. Aplikacija omogućava korisnicima pregled kataloga proizvoda, filtriranje po kategorijama, dodavanje u korpu i naručivanje.

### Kategorije proizvoda
- 🏂 Snoubordovi
- 👢 Čizme
- 🔗 Vezovi
- ⛑️ Kacige
- 🥽 Naočare
- 🧥 Jakne

## 🛠️ Tehnologije

- **Backend:** Laravel 11 (PHP 8.2)
- **Frontend:** Blade Templates + Bootstrap 5
- **Autentifikacija:** Laravel Breeze
- **Baza:** MySQL / SQLite
- **Testiranje:** PHPUnit
- **CI/CD:** GitHub Actions
- **Code Style:** Laravel Pint

## 📦 Instalacija

```bash
# 1. Kloniraj repozitorijum
git clone https://github.com/your-username/uvod-u-softversko-inzenjerstvo.git
cd uvod-u-softversko-inzenjerstvo

# 2. Instaliraj PHP zavisnosti
composer install

# 3. Instaliraj NPM zavisnosti i builduj assets
npm install && npm run build

# 4. Kopiraj environment fajl
cp .env.example .env

# 5. Generiši application key
php artisan key:generate

# 6. Podesi bazu u .env fajlu, zatim pokreni migracije
php artisan migrate --seed

# 7. Pokreni development server
php artisan serve
```

Aplikacija će biti dostupna na: `http://localhost:8000`

## 🧪 Testiranje

```bash
# Pokreni sve testove
vendor/bin/phpunit

# Proveri code style
vendor/bin/pint --test
```

## 📁 Struktura projekta

```
app/
├── Http/Controllers/     # Kontroleri (CRUD operacije)
├── Models/               # Eloquent modeli (User, Product, Category, Order, OrderItem)
database/
├── migrations/           # Migracije baze
├── seeders/              # Seederi sa test podacima
resources/views/          # Blade šabloni
routes/
├── web.php               # Web rute
├── api.php               # API rute
tests/Feature/            # Feature testovi
```

## 🔗 Glavne rute

| Ruta | Opis |
|------|------|
| `/` | Početna stranica |
| `/katalog` | Katalog proizvoda sa filterima |
| `/proizvod/{id}` | Detalji proizvoda |
| `/korpa` | Korpa za kupovinu |
| `/checkout` | Završetak narudžbine |
| `/login` | Prijava korisnika |
| `/register` | Registracija korisnika |

## ✅ Implementirani Use Case-ovi

- **UC 2.2.1** - Registracija i prijava korisnika
- **UC 2.2.2** - Pregled i filtriranje kataloga proizvoda
- **UC 2.2.3** - Dodavanje proizvoda u korpu
- **UC 2.2.4** - Kreiranje narudžbine

## 👤 Autor

Student Fakulteta organizacionih nauka

## 📄 Licenca

MIT License
