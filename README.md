# your_budget
Collection of YourBudget apps

# Docker

## Initialize

### Create .env file

POSTGRES_VERSION=13
POSTGRES_USER=user
POSTGRES_PASSWORD=password
POSTGRES_HOST=database
POSTGRES_PORT=5432
POSTGRES_DB=schema

DATABASE_URL="postgresql://${POSTGRES_USER:-yourbudget}:${POSTGRES_PASSWORD:-yourbudget!1234}@${POSTGRES_HOST:-database}:${POSTGRES_PORT:-5432}/${POSTGRES_DB:-yourbudget}?serverVersion=${POSTGRES_VERSION:-13}"

TRUSTED_PROXIES="^(localhost|127\.0\.0\.1|yourbudget\.test)$"
TRUSTED_HOSTS="^(localhost|127\.0\.0\.1|yourbudget\.test)$"

APP_ENV=dev
APP_SECRET=253d84f3bf4f96e2fe030f559578ae705a3ed26c
JWT_PASSPHRASE=145493c2be2bf2207133c0c856724a26
