# Deployment Guide

This guide covers free deployment options for your Laravel Task Manager application with automatic GitHub deployment and database access.

---

## Option 1: Railway.app (Recommended - Easiest Setup)

### Why Railway?
- ✅ Free $5 credit/month (enough for small apps)
- ✅ MySQL database included
- ✅ Auto-deployment from GitHub
- ✅ Easy environment variable management
- ✅ Full database access via Railway CLI or web interface

### Deployment Steps

#### 1. Prepare Your Repository
Make sure these files are in your GitHub repository:
- `.env.example` (for reference)
- `Procfile` (create this - see below)
- `railway.json` (optional - see below)

#### 2. Create Procfile
Create a file named `Procfile` in your project root:
```
web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

#### 3. Sign Up & Deploy
1. Go to https://railway.app
2. Click "Login" and sign in with GitHub
3. Click "New Project"
4. Select "Deploy from GitHub repo"
5. Choose your task-manager repository
6. Railway will start building automatically

#### 4. Add MySQL Database
1. In your Railway project dashboard
2. Click "+ New" button
3. Select "Database" → "Add MySQL"
4. Wait for database to provision

#### 5. Configure Environment Variables
1. Click on your Laravel service (not the database)
2. Go to "Variables" tab
3. Click "Raw Editor" and paste:

```env
APP_NAME=TaskManager
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:OJHcQ9jXdbjzaFu+DpZwRHSmGtqtTlUULxgyQBGzwBc=
APP_URL=https://your-app-url.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note**: Replace `MySQL` with your actual database service name if different.

#### 6. Generate Public Domain
1. Go to "Settings" tab of your Laravel service
2. Scroll to "Networking"
3. Click "Generate Domain"
4. Copy the URL (e.g., `your-app-name.railway.app`)
5. Update `APP_URL` in environment variables with this URL

#### 7. Access Database
**Via Railway Dashboard:**
- Click on MySQL service
- Go to "Data" tab to view tables
- Use "Query" tab to run SQL commands

**Via MySQL Client:**
- Click "Connect" tab to get credentials
- Use any MySQL client (phpMyAdmin, MySQL Workbench, TablePlus)

#### 8. Auto-Deployment Setup
✅ Already enabled! Any push to your GitHub main/master branch will automatically deploy.

To trigger deployment:
```bash
git add .
git commit -m "Update application"
git push origin main
```

---

## Option 2: Render.com (100% Free Forever)

### Why Render?
- ✅ Completely free tier (no credit card required)
- ✅ PostgreSQL database included
- ✅ Auto-deployment from GitHub
- ✅ SSL certificates included
- ⚠️ Free tier spins down after 15 min of inactivity (cold starts)

### Deployment Steps

#### 1. Install PostgreSQL Support
Run this command locally:
```bash
composer require --dev doctrine/dbal
```

Commit and push:
```bash
git add composer.json composer.lock
git commit -m "Add PostgreSQL support"
git push origin main
```

#### 2. Sign Up & Create Database
1. Go to https://render.com
2. Sign up with GitHub
3. Click "New +" → "PostgreSQL"
4. Name: `task-manager-db`
5. Choose "Free" plan
6. Click "Create Database"
7. **Save the connection details** (you'll need them)

#### 3. Create Web Service
1. Click "New +" → "Web Service"
2. Connect your GitHub repository
3. Configure:
   - **Name**: task-manager
   - **Environment**: Docker (recommended) or Native
   - **Region**: Choose closest to you
   - **Branch**: main
   - **Build Command**:
     ```
     composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache
     ```
   - **Start Command**:
     ```
     php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
     ```

#### 4. Add Environment Variables
In "Environment" tab, add:
```env
APP_NAME=TaskManager
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:OJHcQ9jXdbjzaFu+DpZwRHSmGtqtTlUULxgyQBGzwBc=
APP_URL=https://your-app-name.onrender.com

DB_CONNECTION=pgsql
DB_HOST=[from database internal URL]
DB_PORT=5432
DB_DATABASE=[from database]
DB_USERNAME=[from database]
DB_PASSWORD=[from database]

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
```

#### 5. Access Database
**Via Render Dashboard:**
- Go to your PostgreSQL service
- Click "Connect" → "External Connection"
- Use credentials with any PostgreSQL client (pgAdmin, DBeaver)

---

## Option 3: Heroku (Paid but Popular)

**Note**: Heroku eliminated their free tier in November 2022. Now starts at $5/month.

---

## Post-Deployment Checklist

### 1. Test Your Application
- [ ] Can you access the URL?
- [ ] Can you register a new user?
- [ ] Can you login?
- [ ] Can you create tasks?
- [ ] Can you edit/delete tasks?

### 2. Set Up Email (Optional)
For production password reset emails, update these in your deployment platform:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
```

### 3. Monitor Your App
- Check deployment logs for errors
- Monitor database usage
- Watch for any performance issues

---

## Accessing Your Database

### Railway
- **Web Interface**: Railway Dashboard → MySQL service → "Data" tab
- **CLI**: Install Railway CLI and run `railway connect MySQL`
- **External Tool**: Get connection details from "Connect" tab

### Render
- **Web Interface**: Render Dashboard → PostgreSQL → "Connect"
- **External Tool**: Use External Connection URL with tools like:
  - pgAdmin (free PostgreSQL GUI)
  - DBeaver (free universal database tool)
  - TablePlus (free tier available)

---

## Troubleshooting

### Issue: 500 Error After Deployment
**Solution**: Check logs and ensure:
- APP_KEY is set in environment variables
- Database credentials are correct
- Migrations ran successfully

### Issue: CSS Not Loading
**Solution**: Clear cache and rebuild
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Issue: Cold Starts (Render Free Tier)
**Explanation**: Free tier services sleep after 15 minutes of inactivity. First request will be slow (15-30 seconds).

---

## Recommended: Railway.app

For your use case, I recommend **Railway.app** because:
1. MySQL support (no code changes needed)
2. Simple setup process
3. Good free tier ($5 credit/month)
4. Easy database access
5. Fast deployment
6. No cold starts

---

## Need Help?

If you encounter issues:
1. Check the deployment logs in your platform dashboard
2. Verify environment variables are set correctly
3. Ensure database connection is established
4. Check Laravel logs: `storage/logs/laravel.log`
