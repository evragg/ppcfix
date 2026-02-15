# Fixing HTTP 500 Error on Vercel

## What Was Fixed

### 1. Updated `vercel.json`
**Changes:**
- Changed from `builds` to `functions` (correct Vercel v2 syntax)
- Set `maxDuration` to 10 seconds for PHP functions
- Updated environment variables to use `/tmp` for cache and storage
- Changed `SESSION_DRIVER` to `cookie` (works without database)
- Changed `CACHE_DRIVER` to `array` (in-memory, no database needed)

### 2. Enhanced `api/index.php`
**Changes:**
- Added error reporting for debugging
- Created storage directories in `/tmp` (Vercel's writable directory)
- Added try-catch block to show detailed error messages
- Override Laravel storage path to use `/tmp/storage`

### 3. Added `.vercelignore`
**Purpose:** Exclude unnecessary files from deployment to reduce bundle size

### 4. Updated `package.json`
**Changes:** Added `vercel-build` script for automatic asset building

---

## Steps to Redeploy

### Option 1: Git Push (Recommended)
If you connected Vercel to your Git repository:

```bash
# Add all changes
git add .

# Commit changes
git commit -m "Fix Vercel deployment configuration"

# Push to trigger automatic deployment
git push
```

Vercel will automatically detect the changes and redeploy.

### Option 2: Vercel CLI
```bash
# Redeploy
vercel --prod
```

---

## Required Environment Variables in Vercel

Go to your Vercel project → Settings → Environment Variables and add:

### Minimum Required Variables:
```
APP_NAME=PPC System
APP_ENV=production
APP_KEY=base64:lVyWiTo71gSAh4DCWy8zBOosBUKX49We9rEJCpAmhIk=
APP_DEBUG=false
APP_URL=https://ppcfix-hsu4.vercel.app
```

### Database Variables (if using database):
```
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password
```

> [!IMPORTANT]
> The `APP_KEY` is critical! Without it, Laravel will fail. Use the one from your local `.env` file.

---

## Checking Vercel Logs

After redeployment, if you still get errors:

1. Go to [vercel.com/dashboard](https://vercel.com/dashboard)
2. Click on your project
3. Click on the latest deployment
4. Click "Functions" tab
5. Click on `api/index.php`
6. View the logs to see the exact error

---

## Common Issues & Solutions

### Issue 1: "APP_KEY not set"
**Solution:** Add `APP_KEY` to Vercel environment variables

### Issue 2: Database connection errors
**Solution:** 
- Either set up a cloud database (PlanetScale, Railway)
- OR use cookie sessions and array cache (already configured in new `vercel.json`)

### Issue 3: "Class not found" errors
**Solution:** Ensure `composer install` runs during deployment
- Vercel should auto-detect `composer.json` and run it
- If not, check Vercel build logs

### Issue 4: Assets (CSS/JS) not loading
**Solution:** 
- Ensure `npm run build` completed successfully
- Check that `public/build` directory exists
- Verify routes in `vercel.json` are correct

---

## Testing After Deployment

1. Visit `https://ppcfix-hsu4.vercel.app`
2. You should see either:
   - Your Laravel app homepage
   - A JSON error message with details (if still failing)
3. Check browser console for asset loading errors
4. Check Vercel function logs for PHP errors

---

## Temporary Debugging

The updated `api/index.php` now shows detailed error messages. Once everything works, you should:

1. Remove these lines from `api/index.php`:
```php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
```

2. Update `vercel.json` to set:
```json
"APP_DEBUG": "false"
```

---

## Next Steps

1. ✅ Commit and push changes (or redeploy via CLI)
2. ⏳ Wait for Vercel deployment to complete
3. 🔍 Check if the error is resolved
4. 📋 If still failing, check Vercel logs and share the error message
5. 🎯 Once working, set up database and run migrations
