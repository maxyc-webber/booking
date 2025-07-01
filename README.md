# Booking

Simple Symfony application for booking desks in a coworking space. It runs in Docker and uses MySQL for storage.

## Requirements

- **PHP** 8 or newer
- **MySQL** database
- **Docker** and **Docker Compose** installed on your machine

## Setup

1. Clone this repository
2. Install PHP dependencies with `composer install`
3. Build the Docker image
4. Start the containers using Docker Compose
5. Run database migrations
6. Open the site in your browser

### Build the Docker image

```bash
docker build -t booking-app .
```

### Start the containers

```bash
docker-compose up -d
```

Copy `.env.example` to `.env.local` and adjust the values:

```bash
cp .env.example .env.local
```

Edit `.env.local` to match your database credentials and mailer settings. At a minimum set `DATABASE_URL` (e.g. `mysql://user:pass@db:3306/booking`) and, if email sending is required, `MAILER_DSN`.

### Run migrations

```
docker-compose exec app php bin/console doctrine:migrations:migrate
```

### Access the site

Visit [http://localhost:8000](http://localhost:8000) after the containers are running.

