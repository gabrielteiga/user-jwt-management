#!/bin/bash

set -e

echo "Aguardando o banco de dados iniciar..."

until php artisan migrate; do
    sleep 2
done

echo "Iniciando o servidor Laravel..."
exec php artisan serve --host=0.0.0.0 --port=8000
