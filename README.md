# Payment Flow Service

Laravel 12 API focused on payment lifecycle management with explicit status rules and an auditable history.

## Features

- Create payments
- Update payment status through explicit transition rules
- Idempotent repeated status updates
- Transactional payment + audit-history writes
- Payment status history audit trail
- Paginated payment listing and status filtering
- JSON API Resources and Form Request validation
- Automated feature tests
- GitHub Actions CI
- Enum-based status safety
- Domain Actions pattern

## Status lifecycle

Supported transitions are intentionally constrained:

- `pending` → `processing`, `paid`, `failed`, `cancelled`
- `processing` → `paid`, `failed`, `cancelled`
- `paid` → `refunded`
- `failed`, `cancelled` and `refunded` are terminal states

Submitting the current status again is idempotent and does not create a duplicate audit-history entry. Invalid transitions return a validation error.

## Architecture

- **Models** — persistence and relationships
- **Actions** — use cases and payment state changes
- **Enums** — state-machine rules
- **Resources** — API response contracts
- **Requests** — input validation
- **Feature Tests** — endpoint and lifecycle invariants
- **CI Workflow** — regression protection

## Main endpoints

```http
POST /api/payments
PATCH /api/payments/{id}/status
GET /api/payments
GET /api/payments?status=paid
GET /api/payments/{id}
```

## Running locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Tests

```bash
php artisan test
```

GitHub Actions runs the test suite on every push and pull request.

## Tech stack

- PHP 8.3
- Laravel 12
- MySQL
- SQLite for CI tests
- PHPUnit
- GitHub Actions

## Future improvements

- Webhook processing
- Payment retry flow
- Dead letter queue
- Async events
- Docker setup
- OpenAPI / Swagger documentation
