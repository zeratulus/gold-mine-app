#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE DATABASE gold;
    CREATE USER gold;
    GRANT ALL PRIVILEGES ON DATABASE gold TO gold;
    GRANT ALL PRIVILEGES ON DATABASE gold TO postgres;
EOSQL
