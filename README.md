 
# Hirely

This is a guide to set up and run the project locally.  

## Prerequisites  

Ensure the following software is installed on your system:  

1. **Node.js** (latest stable version)  
2. **Composer**  
3. **PHP** (compatible with the project)  
4. A web server, such as **XAMPP**  
5. A database management tool, such as **phpMyAdmin**  

## Steps to Set Up the Project  

### Step 1: Clone the Repository  

Download or clone the project repository from its source. Navigate to the project directory after cloning:  

```bash
git clone https://github.com/yourusername/yourproject.git
cd yourproject
```

### Step 2: Install Dependencies  

#### Node.js Dependencies  
Install Node.js dependencies using the following command:  

```bash
npm install
```

#### PHP Dependencies  
Install PHP dependencies using Composer:  

```bash
composer install
```

### Step 3: Set Up Storage  

Create a symbolic link for the storage directory as required by the project:  

```bash
php artisan storage:link
```

### Step 4: Configure the Environment  

1. Duplicate the example environment file provided in the project and rename it to `.env`:  

```bash
cp .env.example .env
```

2. Open the `.env` file and make the following changes:  
   - Set the database name to `yourjob`:  
     ```plaintext
     DB_DATABASE=yourjob
     ```  
   - Update the database username and password as needed:  
     ```plaintext
     DB_USERNAME=yourusername
     DB_PASSWORD=yourpassword
     ```  

### Step 5: Import the Database  

1. Open phpMyAdmin or your preferred database tool.  
2. Create a new database named `yourjob`.  
3. Import the database file located in the `database` folder of the project into the newly created database.  
   - File path: `database/yourjob.sql`  

### Step 6: Run the Application  

#### Start the Development Server  

Run the following command to start the PHP development server:  

```bash
php artisan serve
```

#### Compile Assets for Development  

Run the following command to compile assets (e.g., CSS/JS):  

```bash
npm run dev
```

### Step 7: Access the Application  

Open your web browser and navigate to:  

```plaintext
http://localhost:8000
```

## Additional Notes  

- To compile assets for production use, run:  

```bash
npm run build
```

- To clear the application cache, run:  

```bash
php artisan cache:clear
```

---  

This guide provides a step-by-step overview of setting up and running the project on your local machine.
