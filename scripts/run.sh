#!/usr/bin/env bash

set -u

if [ "$#" -lt 1 ] || [ "$#" -gt 2 ]; then
    echo "Error: provide 1 PHP file and optionally a PHP executable path."
    echo "Usage: ./scripts/run.sh <file.php> [php-path]"
    exit 1
fi

script="$1"
php_path="${2:-}"

if [ ! -f "$script" ]; then
    echo "Error: file not found: $script"
    exit 1
fi

if [ -n "$php_path" ]; then
    if [ -x "$php_path" ]; then
        php_cmd="$php_path"
    else
        echo "Error: PHP executable not found: $php_path"
        exit 1
    fi
elif command -v php >/dev/null 2>&1; then
    php_cmd="php"
elif [ -x "/c/xampp/php/php.exe" ]; then
    php_cmd="/c/xampp/php/php.exe"
elif [ -x "/mnt/c/xampp/php/php.exe" ]; then
    php_cmd="/mnt/c/xampp/php/php.exe"
else
    if [ -d "/c/xampp" ] || [ -d "/mnt/c/xampp" ]; then
        echo "Error: PHP is not initialized yet. Open XAMPP Control Panel and complete the setup."
    else
        echo "Error: PHP not found. Install it or add XAMPP's PHP to PATH."
    fi
    exit 1
fi

echo "Running $script with $php_cmd..."
"$php_cmd" "$script"
 