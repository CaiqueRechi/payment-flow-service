# Payment Flow Service

Microservice built with Laravel 12 to manage the complete payment lifecycle.

## 🚀 Features

* Create payments
* Update payment status
* Payment status history audit trail
* Paginated payment listing
* Filter by status
* JSON API Resources
* Automated tests
* GitHub Actions CI
* Enum-based status safety
* Domain Actions pattern

---

## 🧱 Architecture

This project follows a domain-oriented layered architecture:

* **Models** → persistence layer
* **Actions** → use cases / business rules
* **Enums** → status safety
* **Resources** → API response contracts
* **Requests** → validation layer
* **Feature Tests** → endpoint coverage
* **CI Workflow** → regression protection

---

## 📦 Main Endpoints

### Create payment

```http
POST /api/payments
```

### Update status

```http
PATCH /api/payments/{id}/status
```

### List payments

```http
GET /api/payments
```

### Filter by status

```http
GET /api/payments?status=paid
```

### Show payment

```http
GET /api/payments/{id}
```

---

## ⚙️ Running locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## 🧪 Run tests

```bash
php artisan test
```

---

## 🔄 CI

GitHub Actions runs the full test suite on every push and pull request.

---

## 🛠 Tech stack

* PHP 8.3
* Laravel 12
* MySQL
* SQLite (CI tests)
* PHPUnit
* GitHub Actions

---

## 📈 Future Improvements

* Webhook processing
* Payment retry flow
* Dead letter queue
* Async events
* Docker setup
* OpenAPI / Swagger docs
