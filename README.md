# car-swaps-app – Car Engine Swap Manager

**SwapEngine** to aplikacja webowa stworzona w Laravelu, przeznaczona dla warsztatów i pasjonatów motoryzacji. Umożliwa zarządzanie modyfikacjami silników (swapami) dla konkretnych modeli samochodów.

---

## Stack technologiczny
- **Laravel** (MVC, routing, Eloquent ORM)
- **Blade** (szablony HTML)
- **TailwindCSS** (stylowanie UI)
- **Vite** (kompilacja frontendu)
- **Laravel Breeze** (autoryzacja)
- **AJAX / fetch API** (dynamiczne wyszukiwanie)
- **SQLite** (baza danych)

---

## Główne funkcje
- CRUD dla modeli: `CarModel`, `Engine`, `Swap`, `Tag`
- Dynamiczne filtrowanie swapów po marce, modelu i roczniku
- Wiele-do-wielu: `Swap` ↔ `Engine` (z `note` w pivot)
- Specjalna relacja pivot: `Engine` ↔ `Tag` dla danego `Swap` (z `swap_id`)
- AJAX-owe ładowanie modeli, lat i swapów bez przeładowania strony
- System logowania i rejestracji (Laravel Breeze)

---

## install localnie (Laravel + SQLite)

```bash
# 1. Sklonuj repozytorium
git clone https://github.com/rafaraf75/car-swaps-app.git
cd car-swaps-app

# 2. Zainstaluj zależności
composer install
npm install && npm run build

# 3. Skonfiguruj plik .env
cp .env.example .env

# 4. Wygeneruj klucz aplikacji
php artisan key:generate

# 5. Utwórz plik bazy danych
mkdir -p database
touch database/database.sqlite

# 6. Migracje + seedy
php artisan migrate --seed

# 7. Odpal aplikację
npm run serve
```

##  Autor
Projekt stworzony przez **@rafaraf75** .

---



