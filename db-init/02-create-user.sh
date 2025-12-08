#!/bin/bash
set -e

mysql -u root -p"$MYSQL_ROOT_PASSWORD" <<EOF
CREATE USER IF NOT EXISTS 'www_quint_felicity'@'%' IDENTIFIED BY '${MYSQL_PASSWORD_QUINT_FELICITY}';
GRANT ALL PRIVILEGES ON quint_felicity.* TO 'www_quint_felicity'@'%';
FLUSH PRIVILEGES;
EOF