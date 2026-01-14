# ❄️ SnowShop - Webshop za Snowboard Opremu

> Projekat iz predmeta **Uvod u Softversko Inženjerstvo** (UuSI)  
> Fakultet organizacionih nauka, 2025/2026

---

## 📋 O projektu

SnowShop je e-commerce web aplikacija za prodaju snowboard opreme. Aplikacija omogućava korisnicima pregled kataloga proizvoda, filtriranje po kategorijama, dodavanje u korpu i naručivanje.

### Kategorije proizvoda
- 🏂 Snoubordovi
- 👢 Čizme
- 🔗 Vezovi
- ⛑️ Kacige
- 🥽 Naočare
- 🧥 Jakne

---

## 🔗 Link ka GitHub repozitorijumu

**GitHub:** https://github.com/VAŠE-KORISNIČKO-IME/uvod-u-softversko-inzenjerstvo

*(Zamenite sa vašim pravim linkom)*

---

## 🛠️ Tehnologije i alati

### Backend
| Tehnologija | Verzija | Opis |
|-------------|---------|------|
| **PHP** | 8.2 | Programski jezik |
| **Laravel** | 11.x | PHP razvojni okvir za web aplikacije |
| **Eloquent ORM** | - | Object-Relational Mapping za rad sa bazom |
| **Laravel Breeze** | 2.x | Starter kit za autentifikaciju |

### Frontend
| Tehnologija | Verzija | Opis |
|-------------|---------|------|
| **Blade** | - | Laravel template engine |
| **Bootstrap** | 5.3 | CSS framework za responzivan dizajn |
| **Vite** | 6.x | Build tool za frontend assets |

### Baza podataka
| Tehnologija | Opis |
|-------------|------|
| **MySQL** | Produkciona baza |
| **SQLite** | Za testiranje |

### Testiranje i CI/CD
| Alat | Opis |
|------|------|
| **PHPUnit** | PHP testing framework |
| **Laravel Pint** | Code style fixer (PSR-12) |
| **GitHub Actions** | CI/CD pipeline |

### Korišćene biblioteke
| Biblioteka | Lokacija | Namena |
|------------|----------|--------|
| **Bootstrap 5.3** | CDN u layout-u | Responzivan grid, komponente, stilizacija |
| **Bootstrap Icons** | CDN | Ikonice u navigaciji i dugmadima |
| **Tailwind CSS** | Breeze auth views | Stilizacija login/register stranica |
| **Faker PHP** | Seederi | Generisanje realističnih test podataka |

---

## 📜 Blueprint skript (draft.yaml)

Aplikacija je generisana korišćenjem **Laravel Blueprint** specifikacije:

```yaml
models:
  Category:
    name: string:50
    relationships:
      hasMany: Product

  Product:
    category_id: id foreign:categories
    name: string
    description: text nullable
    price: decimal:8,2
    stock_quantity: integer
    relationships:
      belongsTo: Category
      hasMany: OrderItem

  Order:
    user_id: id foreign:users
    order_date: timestamp
    status: string:50 default:'na_cekanju'
    total_price: decimal:10,2
    relationships:
      belongsTo: User
      hasMany: OrderItem

  OrderItem:
    order_id: id foreign:orders
    product_id: id foreign:products
    quantity: integer
    unit_price: decimal:8,2
    relationships:
      belongsTo: Order, Product

controllers:
  Category:
    resource: true
  Product:
    resource: true
  Order:
    resource: true
  OrderItem:
    resource: true
```

---

## ⚙️ GitHub Actions (CI/CD Pipeline)

Fajl: `.github/workflows/main.yml`

```yaml
name: Laravel CI

on:
  push:
    branches: [ "main" ]
  pull_request:
    branches: [ "main" ]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v4

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'

    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"

    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

    - name: Setup Node.js
      uses: actions/setup-node@v4
      with:
        node-version: '20'

    - name: Install NPM Dependencies
      run: npm ci

    - name: Build Assets
      run: npm run build

    - name: Generate Key
      run: php artisan key:generate

    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache

    - name: Create Database
      run: |
        mkdir -p database
        touch database/database.sqlite

    - name: Execute tests (Unit and Feature)
      env:
        DB_CONNECTION: sqlite
        DB_DATABASE: database/database.sqlite
      run: |
        php artisan migrate --force
        vendor/bin/phpunit

    - name: Run Pint (Code Style)
      run: ./vendor/bin/pint --test
```

### Šta CI/CD radi:
1. **Checkout** - Preuzima kod iz repozitorijuma
2. **PHP Setup** - Instalira PHP 8.2
3. **Composer Install** - Instalira PHP zavisnosti
4. **Node.js Setup** - Instalira Node.js 20 za Vite
5. **NPM Build** - Kompajlira frontend assets
6. **Key Generate** - Generiše Laravel application key
7. **Database** - Kreira SQLite bazu za testove
8. **PHPUnit** - Pokreće sve testove (32 testa)
9. **Pint** - Proverava code style

---

## 📁 Dokumentacija fajlova

### Modeli (`app/Models/`)

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `User.php` | Generisano (Laravel) + Ručno modifikovano | Korisnik sistema. Dodat `is_admin` atribut i relacije sa Order |
| `Category.php` | Generisano (Blueprint) | Kategorija proizvoda. Ima `hasMany` relaciju sa Product |
| `Product.php` | Generisano (Blueprint) + Ručno | Proizvod. Relacije: `belongsTo` Category, `hasMany` OrderItem. Dodata `image` kolona |
| `Order.php` | Generisano (Blueprint) | Narudžbina. Relacije: `belongsTo` User, `hasMany` OrderItem |
| `OrderItem.php` | Generisano (Blueprint) | Stavka narudžbine. Relacije: `belongsTo` Order i Product |

### Kontroleri (`app/Http/Controllers/`)

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `WebController.php` | Ručno | Glavni kontroler za frontend. Metode: `home()`, `katalog()`, `proizvod()`, `korpa()`, `dodajUKorpu()`, `ukloniIzKorpe()`, `checkout()`, `posaljiNarudzbinu()` |
| `AdminController.php` | Ručno | Admin panel CRUD. Metode za upravljanje proizvodima, kategorijama, narudžbinama i korisnicima |
| `CategoryController.php` | Generisano (Blueprint) | REST API kontroler za kategorije |
| `ProductController.php` | Generisano (Blueprint) | REST API kontroler za proizvode |
| `OrderController.php` | Generisano (Blueprint) | REST API kontroler za narudžbine |
| `OrderItemController.php` | Generisano (Blueprint) | REST API kontroler za stavke narudžbina |
| `Auth/*` | Generisano (Breeze) | Autentifikacija: login, register, password reset, email verification |

### Migracije (`database/migrations/`)

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `create_users_table.php` | Generisano (Laravel) + Ručno | Dodato `is_admin` polje |
| `create_categories_table.php` | Generisano (Blueprint) | Tabela kategorija |
| `create_products_table.php` | Generisano (Blueprint) + Ručno | Dodato `image` polje |
| `create_orders_table.php` | Generisano (Blueprint) | Tabela narudžbina |
| `create_order_items_table.php` | Generisano (Blueprint) | Tabela stavki narudžbina |
| `create_cache_table.php` | Generisano (Laravel) | Cache tabela |
| `create_jobs_table.php` | Generisano (Laravel) | Queue jobs tabela |

### Seederi (`database/seeders/`)

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `DatabaseSeeder.php` | Ručno | Glavni seeder - poziva ostale seedere |
| `CategoryFactory.php` | Ručno | Kreira 6 kategorija snowboard opreme |
| `ProductFactory.php` | Ručno | Kreira realistične proizvode sa cenama |
| `UserFactory.php` | Generisano (Laravel) + Ručno | Dodato kreiranje admin korisnika |
| `OrderFactory.php` | Generisano | Factory za narudžbine |
| `OrderItemFactory.php` | Generisano | Factory za stavke narudžbina |

### Views (`resources/views/`)

| Fajl/Folder | Generisano/Ručno | Opis |
|-------------|------------------|------|
| `layouts/shop.blade.php` | Ručno | Glavni layout za frontend sa Bootstrap 5 |
| `home.blade.php` | Ručno | Početna stranica sa hero sekcijom |
| `katalog.blade.php` | Ručno | Katalog proizvoda sa filterom po kategorijama |
| `proizvod.blade.php` | Ručno | Detalji pojedinačnog proizvoda |
| `korpa.blade.php` | Ručno | Korpa za kupovinu |
| `checkout.blade.php` | Ručno | Stranica za završetak kupovine |
| `admin/layouts/admin.blade.php` | Ručno | Layout za admin panel |
| `admin/dashboard.blade.php` | Ručno | Admin dashboard sa statistikama |
| `admin/products/*` | Ručno | CRUD view-ovi za proizvode |
| `admin/categories/*` | Ručno | CRUD view-ovi za kategorije |
| `admin/orders/*` | Ručno | Pregled i upravljanje narudžbinama |
| `admin/users/*` | Ručno | Upravljanje korisnicima |
| `auth/*` | Generisano (Breeze) | Login, register, forgot password stranice |

### Middleware

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `AdminMiddleware.php` | Ručno | Proverava da li je korisnik admin (`is_admin = true`) |

### Testovi (`tests/`)

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `Unit/ProductTest.php` | Ručno | Unit testovi za Product model (3 testa) |
| `Unit/CategoryTest.php` | Ručno | Unit testovi za Category model (2 testa) |
| `Feature/OrderTest.php` | Ručno | Feature testovi za narudžbine |
| `Feature/Auth/*` | Generisano (Breeze) | Testovi za autentifikaciju (27 testova) |

### Rute (`routes/`)

| Fajl | Generisano/Ručno | Opis |
|------|------------------|------|
| `web.php` | Ručno | Frontend i admin rute |
| `api.php` | Generisano + Ručno | REST API rute za sve resource kontrolere |
| `auth.php` | Generisano (Breeze) | Rute za autentifikaciju |

---

## 🖥️ Ručno pisan kod

### 1. WebController.php - Frontend logika

```php
// Prikaz kataloga sa filterom po kategoriji
public function katalog(Request $request)
{
    $query = Product::with('category');
    
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }
    
    $products = $query->paginate(12);
    $categories = Category::all();
    
    return view('katalog', compact('products', 'categories'));
}

// Dodavanje proizvoda u korpu (session-based)
public function dodajUKorpu(Product $product)
{
    $cart = session()->get('cart', []);
    
    if (isset($cart[$product->id])) {
        $cart[$product->id]['quantity']++;
    } else {
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
        ];
    }
    
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Proizvod dodat u korpu!');
}
```

**Namena:** Upravljanje frontend funkcionalnostima - prikaz proizvoda, korpa bazirana na session-u, checkout proces.

### 2. AdminController.php - Admin panel

```php
// Dashboard sa statistikama
public function dashboard()
{
    $stats = [
        'products' => Product::count(),
        'categories' => Category::count(),
        'orders' => Order::count(),
        'users' => User::count(),
        'revenue' => Order::where('status', 'zavrsena')->sum('total_price'),
    ];
    
    $recentOrders = Order::with('user')->latest()->take(5)->get();
    
    return view('admin.dashboard', compact('stats', 'recentOrders'));
}
```

**Namena:** Kompletan CRUD za admin panel - upravljanje proizvodima, kategorijama, narudžbinama i korisnicima.

### 3. AdminMiddleware.php - Zaštita admin ruta

```php
public function handle(Request $request, Closure $next): Response
{
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Nemate pristup ovoj stranici.');
    }
    
    return $next($request);
}
```

**Namena:** Sprečava pristup admin panelu korisnicima koji nisu administratori.

### 4. Unit testovi

```php
// tests/Unit/ProductTest.php
public function test_product_belongs_to_category(): void
{
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);
    
    $this->assertInstanceOf(Category::class, $product->category);
    $this->assertEquals($category->id, $product->category->id);
}
```

**Namena:** Verifikacija ispravnosti Eloquent relacija i atributa modela.

---

## 📸 Screenshot-ovi aplikacije

*(Dodajte screenshot-ove sledećih ekrana)*

### 1. Početna stranica
![Početna stranica](screenshots/home.png)

### 2. Katalog proizvoda
![Katalog](screenshots/katalog.png)

### 3. Detalji proizvoda
![Proizvod](screenshots/proizvod.png)

### 4. Korpa
![Korpa](screenshots/korpa.png)

### 5. Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

### 6. Admin - Lista proizvoda
![Admin Proizvodi](screenshots/admin-products.png)

---

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

---

## 🧪 Testiranje

```bash
# Pokreni sve testove
vendor/bin/phpunit

# Proveri code style
vendor/bin/pint --test
```

### Rezultati testova
- **Ukupno testova:** 32
- **Assertions:** 76
- **Status:** ✅ Svi prolaze

---

## 🔗 Glavne rute

| Ruta | Metoda | Kontroler | Opis |
|------|--------|-----------|------|
| `/` | GET | WebController@home | Početna stranica |
| `/katalog` | GET | WebController@katalog | Katalog proizvoda |
| `/proizvod/{product}` | GET | WebController@proizvod | Detalji proizvoda |
| `/korpa` | GET | WebController@korpa | Korpa |
| `/korpa/dodaj/{product}` | POST | WebController@dodajUKorpu | Dodaj u korpu |
| `/checkout` | GET | WebController@checkout | Checkout stranica |
| `/login` | GET/POST | Auth\LoginController | Prijava |
| `/register` | GET/POST | Auth\RegisterController | Registracija |
| `/admin` | GET | AdminController@dashboard | Admin dashboard |
| `/admin/products` | GET | AdminController@products | Lista proizvoda |
| `/admin/categories` | GET | AdminController@categories | Lista kategorija |
| `/admin/orders` | GET | AdminController@orders | Lista narudžbina |
| `/admin/users` | GET | AdminController@users | Lista korisnika |

---

## 👤 Test kredencijali

### Admin pristup
- **Email:** `admin@webshop.com`
- **Lozinka:** `admin123`

### Običan korisnik
- **Email:** `user@webshop.com`
- **Lozinka:** `password`

---

## 📝 Zaključak

Projekat je uspešno implementiran korišćenjem Laravel 11 framework-a sa svim zahtevani funkcionalnostima:
- ✅ 4 Eloquent modela sa relacijama
- ✅ Resource kontroleri za CRUD operacije
- ✅ Frontend sa Bootstrap 5
- ✅ Autentifikacija sa Laravel Breeze
- ✅ Admin panel za upravljanje sadržajem
- ✅ 32 automatizovana testa
- ✅ CI/CD pipeline sa GitHub Actions

---

*Projekat izrađen za potrebe predmeta Uvod u Softversko Inženjerstvo, FON, 2025/2026*

## ✅ Implementirani Use Case-ovi

- **UC 2.2.1** - Registracija i prijava korisnika
- **UC 2.2.2** - Pregled i filtriranje kataloga proizvoda
- **UC 2.2.3** - Dodavanje proizvoda u korpu
- **UC 2.2.4** - Kreiranje narudžbine
- **Admin panel** - CRUD za proizvode, kategorije, narudžbine i korisnike

## 👤 Autor

Student Fakulteta organizacionih nauka

## 📄 Licenca

MIT License
