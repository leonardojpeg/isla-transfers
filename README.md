init.sql (https://drive.google.com/file/d/1OnUjn7XEQgnzSCqXN8nSgKJcwxrK8rkp/view?usp=drive_link)

CREATE TABLE comentarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL,
  texto TEXT NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Se añade una tabla adicional llamada comentarios, para que los usuarios puedan dejar su experiencia tras completar su trayecto. La tabla incluye el email del usuario, el comentario y la fecha en la que fue enviado. No afecta a ninguna de las funciones básicas del sistema.


producto2/

│

├── public/            ← Aquí van los archivos que se ven en el navegador (index.php, login.php, etc.)

├── app/

│   ├── controllers/   ← Aquí va la lógica de cada página (LoginController.php, AdminController.php, etc.)

│   ├── models/        ← Aquí va la lógica de base de datos (Usuario.php, Reserva.php, etc.)

│   └── views/         ← Aquí va el HTML separado por partes (header.php, login.php, adminPanel.php, etc.)

├── config/

│   └── db.php         ← Archivo de conexión a la base de datos

├── .gitignore

├── docker-compose.yml

└── init.sql

___

//poder conectar en local y que no rompa en  AWS/Git:

.env:

DB_HOST=127.0.0.1

DB_NAME=isla_transfers

DB_USER=root

DB_PASS=root

___________

git clone https://github.com/leonardojpeg/isla-transfers.git

cd isla-transfers

cp .env.example .env

docker compose up -d

cd public

php -S localhost:8000

PhpMyAdmin: http://localhost:8081 (user: root / pass: root)

