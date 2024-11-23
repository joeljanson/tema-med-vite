# WordPress Theme Development with Vite + SCSS + Tailwind

This setup is a streamlined development environment for WordPress themes using **Vite**, **SCSS**, and **TailwindCSS**. It integrates with a **Dockerized WordPress environment** for seamless local development.

---

## 🚀 Quick Start

### 1. **Set Up Docker**

Copy the following `docker-compose.yml` file to the root directory where you want to develop your project. This file defines the WordPress environment.

<details>
<summary>Click to view the `docker-compose.yml` file</summary>

```yaml
services:
  db:
    platform: linux/x86_64
    image: mysql:8.0
    container_name: wordpress_db
    volumes:
      - db_data:/var/lib/mysql
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: wordpress
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpresspassword

  wordpress:
    image: wordpress:latest
    depends_on:
      - db
    ports:
      - "8000:80"
    restart: always
    environment:
      WORDPRESS_DB_HOST: db:3306
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpresspassword
      WORDPRESS_DB_NAME: wordpress
      WORDPRESS_ENV: development
    volumes:
      - ./wordpress:/var/www/html

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    platform: linux/amd64
    depends_on:
      - db
    ports:
      - "8080:80"
    restart: always
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: rootpassword

volumes:
  db_data:
```

</details>

---

### 2. **Clone the Theme Repository**

Navigate to your `themes` folder in the WordPress installation and create a new folder with your desired theme name. Clone this repository into that folder:

```bash
git clone <repository-url> your-theme-name
```

---

### 3. **Install Dependencies**

Navigate to your theme directory and install the required dependencies:

```bash
npm install
```

---

### 4. **Start the Development Environment**

Run the following command to start the Docker containers and the Vite development server:

```bash
npm run docker-dev
```

- This command:
  1. Starts the Docker containers using the `docker-compose.yml` file.
  2. Runs the Vite development server.

Once everything is up and running, you can visit:

- WordPress site: [http://localhost:8000](http://localhost:8000)
- phpMyAdmin: [http://localhost:8080](http://localhost:8080)

---

### 5. **Build for Production**

When you're ready to deploy your theme, build the assets:

```bash
npm run build
```

This bundles your files into the `assets/` folder in the theme directory.

---

## 📝 Things to Keep in Mind

### Dynamic CSS Loading

The theme dynamically serves CSS via the Vite server during development. This is configured in the `functions.php` file.

- **Development**: Serves files from the Vite dev server.
- **Production**: Uses bundled files from the `assets/` folder.
  - Ensure you set `WORDPRESS_ENV` to `production` in the `docker-compose.yml`.
  - Run `npm run build` before deploying.

### Adding CSS Files

To include additional CSS files, import them into `main.js`:

```javascript
import "./styles/extra.css";
```

---

## 📂 Folder Structure

Here’s an overview of the project structure:

```
project-root/
├── docker-compose.yml        # Docker configuration
├── wordpress/                # WordPress installation (Docker volume)
│   └── wp-content/
│       └── themes/
│           └── your-theme/   # Theme directory
│               ├── src/      # Vite source files
│               ├── assets/   # Built files for production
│               ├── package.json
│               ├── vite.config.js
│               └── functions.php
```

---

## 🛠 Development Commands

| Command               | Description                                       |
| --------------------- | ------------------------------------------------- |
| `npm run docker-dev`  | Starts Docker containers and the Vite dev server. |
| `npm run dev`         | Starts the Vite dev server only.                  |
| `npm run build`       | Bundles theme files for production.               |
| `npm run docker-stop` | Stops and removes Docker containers.              |

---

## 💡 Tips & Tricks

- **phpMyAdmin Access**: Use [http://localhost:8080](http://localhost:8080) to manage the database.
- **Port Conflicts**: If ports `8000` or `8080` are in use, modify the `docker-compose.yml` file accordingly.
- **Custom Scripts**: Add additional npm scripts to your `package.json` for common tasks.
