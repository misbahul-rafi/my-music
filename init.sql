CREATE USER 'nextjs'@'%' IDENTIFIED BY 'myname';
CREATE USER 'nextjs'@'localhost' IDENTIFIED BY 'myname';
CREATE DATABASE IF NOT EXISTS nextjs;
CREATE DATABASE IF NOT EXISTS nextjs_shadow;
GRANT ALL PRIVILEGES ON nextjs.* TO 'nextjs'@'%';
GRANT ALL PRIVILEGES ON nextjs.* TO 'nextjs'@'localhost';
GRANT ALL PRIVILEGES ON nextjs_shadow.* TO 'nextjs'@'%';
GRANT ALL PRIVILEGES ON nextjs_shadow.* TO 'nextjs'@'localhost';

FLUSH PRIVILEGES;
