# Deploying Laravel to Vercel

This guide will help you deploy your Laravel application to Vercel.

## Prerequisites

1. **Vercel Account**: Sign up at [vercel.com](https://vercel.com)
2. **Vercel CLI** (optional): Install with `npm i -g vercel`
3. **Cloud Database**: You need a MySQL database hosted in the cloud

## Database Setup Options

Choose one of these cloud database providers:

### Option 1: PlanetScale (Recommended - Free Tier Available)
1. Sign up at [planetscale.com](https://planetscale.com)
2. Create a new database
3. Get connection details (host, username, password, database name)

### Option 2: Railway (Easy Setup - Free Tier Available)
1. Sign up at [railway.app](https://railway.app)
2. Create a new MySQL database
3. Copy the connection details

### Option 3: AWS RDS (Production Grade)
1. Create MySQL instance in AWS RDS
2. Configure security groups
3. Get connection details

## Deployment Steps

### 1. Install Vercel CLI (Optional)
```bash
npm install -g vercel
```

### 2. Configure Environment Variables in Vercel

Go to your Vercel project settings and add these environment variables:

**Required Variables:**
```
APP_NAME=YourAppName
APP_ENV=production
APP_KEY=your-app-key-from-local-env
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stderr
```

**Optional Variables:**
```
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-mail-username
MAIL_PASSWORD=your-mail-password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

### 3. Deploy via Vercel Dashboard

1. Go to [vercel.com/new](https://vercel.com/new)
2. Import your Git repository (GitHub, GitLab, or Bitbucket)
3. Vercel will auto-detect the `vercel.json` configuration
4. Click "Deploy"

### 4. Deploy via CLI (Alternative)

```bash
# Login to Vercel
vercel login

# Deploy
vercel --prod
```

### 5. Run Database Migrations

After deployment, you need to run migrations. You have two options:

**Option A: Using Vercel CLI**
```bash
vercel env pull .env.production
php artisan migrate --force --env=production
```

**Option B: Create a Migration Endpoint (Temporary)**
Create a route in `routes/web.php`:
```php
Route::get('/migrate-database', function() {
    if (config('app.env') !== 'production') {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migrations completed!';
    }
    return 'Not allowed';
});
```
Visit `https://your-app.vercel.app/migrate-database` once, then remove this route.

## Post-Deployment Checklist

- [ ] Verify the app loads at your Vercel URL
- [ ] Test database connectivity
- [ ] Test user authentication/login
- [ ] Check that CSS/JS assets load correctly
- [ ] Test all major features
- [ ] Remove any temporary migration endpoints
- [ ] Set up custom domain (optional)

## Troubleshooting

### Assets Not Loading
- Ensure `npm run build` was run before deployment
- Check that `public/build` directory exists
- Verify Vite configuration

### Database Connection Errors
- Double-check environment variables in Vercel
- Ensure database allows connections from Vercel IPs
- Test connection string locally

### 500 Errors
- Check Vercel function logs in the dashboard
- Ensure `APP_KEY` is set correctly
- Verify all required environment variables are set

### Session Issues
- Ensure `SESSION_DRIVER=database` is set
- Run migrations to create sessions table
- Check database connectivity

## Important Notes

> **File Storage**: Vercel's filesystem is read-only except for `/tmp`. If you need file uploads, configure cloud storage (S3, Cloudinary, etc.)

> **Cron Jobs**: Vercel doesn't support cron jobs. Use Vercel Cron (beta) or external services like EasyCron.

> **Queue Workers**: For background jobs, consider using a queue service like Laravel Vapor Queue or AWS SQS.

## Support

- Vercel Documentation: https://vercel.com/docs
- Laravel Documentation: https://laravel.com/docs
- vercel-php Runtime: https://github.com/vercel-community/php
