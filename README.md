# WordPress-temautveckling med Vite + SCSS + Tailwind

Det här projektet erbjuder en smidig utvecklingsmiljö för WordPress-teman med hjälp av **Vite**, **SCSS** och **TailwindCSS**. Det integreras med en **Docker-baserad WordPress-miljö** för enkel lokal utveckling.

---

## 🚀 Kom igång

### 1. **Ställ in Docker**

Kopiera följande `docker-compose.yml`-fil till rotmappen där du vill utveckla ditt projekt. Den här filen definierar WordPress-miljön.

<details>
<summary>Klicka för att visa `docker-compose.yml`-filen</summary>

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

Kör sedan docker compose up -d för att installera wordpress.

```bash
docker compose up -d
```

---

### 2. **Klona temarepositoryt**

Navigera till din `themes`-mapp i WordPress-installationen och skapa en ny mapp med önskat temanamn. Klona det här repositoryt i den mappen:

```bash
git clone https://github.com/joeljanson/tema-med-vite.git ditt-tema-namn
```

---

### 3. **Installera beroenden**

I temamappen finns en separat `vite`-mapp där alla Vite-relaterade filer ligger. Navigera till den mappen och installera de nödvändiga beroendena:

```bash
cd ditt-tema-namn/vite
npm install
```

---

### 4. **Starta utvecklingsmiljön**

Kör följande kommando från `vite`-mappen för att starta Docker-containrarna och Vite-utvecklingsservern:

```bash
npm run docker-dev
```

- Detta kommando:
  1. Startar Docker-containrarna med `docker-compose.yml`.
  2. Startar Vite-utvecklingsservern.

När allt är igång kan du besöka:

- WordPress-sidan: [http://localhost:8000](http://localhost:8000)
- phpMyAdmin: [http://localhost:8080](http://localhost:8080)

---

### 5. **Bygg för produktion**

När du är redo att distribuera ditt tema, bygg dina tillgångar:

```bash
npm run build
```

Detta paketerar dina filer i `assets/`-mappen i temamappen.

---

## 📝 Saker att tänka på

### Dynamisk CSS-laddning

Temat laddar CSS dynamiskt via Vite-servern under utveckling. Detta konfigureras i `functions.php` som ligger direkt i temamappen.

- **Utveckling**: Filer serveras från Vite-utvecklingsservern.
- **Produktion**: Filer används från `assets/`-mappen.
  - Kontrollera att `WORDPRESS_ENV` är satt till `production` i `docker-compose.yml`.
  - Kör `npm run build` innan du distribuerar.

### Lägga till CSS-filer

För att inkludera ytterligare CSS-filer, importera dem i `main.js` i `vite`-mappen:

```javascript
import "./styles/extra.css";
```

---

## 📂 Projektstruktur

En uppdaterad översikt över projektstrukturen:

```
projekt-root/
├── docker-compose.yml        # Docker-konfiguration
├── wordpress/                # WordPress-installation (Docker-volym)
│   └── wp-content/
│       └── themes/
│           └── ditt-tema/    # Temamapp
│               ├── functions.php       # WordPress-funktioner
│               ├── style.css           # WordPress temaspecifik CSS
│               ├── vite/               # Vite-relaterade filer (samt tailwind.config etc.)
│               │   ├── src/            # Vite-källfiler
│               │   ├── assets/         # Produktionsfiler
│               │   ├── package.json
│               │   ├── vite.config.js
│               │   └── main.js
│               └── övriga temafiler    # Övriga WordPress-filer
```

---

## 🛠 Utvecklingskommandon

| Kommando              | Beskrivning                                            |
| --------------------- | ------------------------------------------------------ |
| `npm run docker-dev`  | Startar Docker-containrar och Vite-utvecklingsservern. |
| `npm run dev`         | Startar endast Vite-utvecklingsservern.                |
| `npm run build`       | Paketerar temafiler för produktion.                    |
| `npm run docker-stop` | Stoppar och tar bort Docker-containrar.                |

---

## 💡 Tips & tricks

- **phpMyAdmin-åtkomst**: Använd [http://localhost:8080](http://localhost:8080) för att hantera databasen.
- **Portkonflikter**: Om portarna `8000` eller `8080` redan används, ändra dessa i `docker-compose.yml`.
- **Egna skript**: Lägg till egna npm-skript i `package.json` för vanliga uppgifter.
