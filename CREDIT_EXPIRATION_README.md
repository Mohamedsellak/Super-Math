# Credit Expiration System - Super Math

This document explains the automatic credit expiration system implemented for the Super Math application.

## 📋 Overview

The credit expiration system automatically handles user credits that have passed their expiration date. When credits expire, they are automatically reset to 0 and a record is created in the credit history.

## 🏗️ System Components

### 1. Console Command (`ExpireCredits.php`)
- **Location**: `app/Console/Commands/ExpireCredits.php`
- **Command**: `php artisan credits:expire`
- **Purpose**: Finds and processes expired user credits

### 2. Console Kernel (`Kernel.php`)
- **Location**: `app/Console/Kernel.php`
- **Purpose**: Schedules the credit expiration command to run automatically

### 3. User Model Updates
- **Location**: `app/Models/User.php`
- **Enhancement**: Added `credit_expires_at` datetime casting

## ⚙️ How It Works

### Automatic Process
1. **Daily Check**: System runs at midnight every day
2. **Find Expired Credits**: Identifies users with credits past their expiration date
3. **Reset Credits**: Sets user credit to `0`
4. **Clear Expiration**: Sets `credit_expires_at` to `null`
5. **Log History**: Creates a credit history record with action "Expired"

### Database Changes
When credits expire, the system performs these operations:

```sql
-- Reset user credits
UPDATE users SET credit = 0, credit_expires_at = NULL WHERE credit_expires_at < NOW();

-- Insert credit history
INSERT INTO credit_histories (user_id, amount, action, description, created_at, updated_at) 
VALUES (user_id, '-{expired_credits}', 'Expired', 'Credits expired on {date}...', NOW(), NOW());
```

## 🚀 Setup Instructions

### 1. Code Implementation ✅
The following files have been created/updated:
- ✅ `app/Console/Commands/ExpireCredits.php`
- ✅ `app/Console/Kernel.php`
- ✅ `app/Models/User.php` (updated casts)

### 2. Server Configuration (Required)
To enable automatic execution, add this cron job to your server:

```bash
# Open crontab
crontab -e

# Add this line (replace with your actual project path)
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

**Example for this project:**
```bash
* * * * * cd /home/sellak/Desktop/Super-Math && php artisan schedule:run >> /dev/null 2>&1
```

## 🧪 Testing

### Manual Testing
You can manually test the credit expiration system:

```bash
# Run the credit expiration command manually
php artisan credits:expire
```

### Expected Output
```
Checking for expired credits...
Expired 50 credits for user john@example.com (ID: 1)
Expired 25 credits for user jane@example.com (ID: 2)
Successfully expired credits for 2 users.
```

If no credits are expired:
```
Checking for expired credits...
No expired credits found.
```

## 📅 Schedule Configuration

### Current Schedule
- **Frequency**: Daily at midnight
- **Command**: `credits:expire`

### Alternative Schedules
You can modify the schedule in `app/Console/Kernel.php`:

```php
// Daily at midnight (current)
$schedule->command('credits:expire')->daily();

// Every hour
$schedule->command('credits:expire')->hourly();

// Every 30 minutes
$schedule->command('credits:expire')->everyThirtyMinutes();

// Custom time (e.g., 2 AM daily)
$schedule->command('credits:expire')->dailyAt('02:00');

// Weekdays only at midnight
$schedule->command('credits:expire')->weekdays()->daily();
```

## 📊 Credit History Records

When credits expire, a record is automatically created in the `credit_histories` table:

| Field | Value | Example |
|-------|-------|---------|
| `user_id` | User ID | `1` |
| `amount` | Negative expired amount | `-50` |
| `action` | Fixed value | `Expired` |
| `description` | Detailed message | `Credits expired on 2025-07-23 00:00:00. 50 credits have been reset to 0.` |
| `created_at` | Current timestamp | `2025-07-23 00:00:01` |

## 🔍 Monitoring

### Log Files
The system logs its activities. Check Laravel logs for any issues:
```bash
tail -f storage/logs/laravel.log
```

### Database Queries
Monitor expired credits with these queries:

```sql
-- Check users with expired credits
SELECT id, email, credit, credit_expires_at 
FROM users 
WHERE credit > 0 
  AND credit_expires_at IS NOT NULL 
  AND credit_expires_at < NOW();

-- View recent expiration history
SELECT ch.*, u.email 
FROM credit_histories ch 
JOIN users u ON ch.user_id = u.id 
WHERE ch.action = 'Expired' 
ORDER BY ch.created_at DESC 
LIMIT 10;
```

## 🚨 Troubleshooting

### Command Not Running Automatically
1. **Check cron job**: Ensure the cron job is added correctly
2. **Verify path**: Make sure the project path in cron job is correct
3. **Check permissions**: Ensure the web server has permission to run PHP/Artisan
4. **Test manually**: Run `php artisan schedule:list` to see scheduled tasks

### No Credits Being Expired
1. **Check data**: Verify users have `credit_expires_at` dates in the past
2. **Database connection**: Ensure the application can connect to the database
3. **Manual test**: Run `php artisan credits:expire` manually

### Logs and Debugging
```bash
# Check if Laravel scheduler is working
php artisan schedule:list

# Run scheduler manually (for testing)
php artisan schedule:run

# Check application logs
tail -f storage/logs/laravel.log
```

## 💡 Best Practices

1. **Backup Strategy**: Always backup your database before running expiration processes
2. **Test Environment**: Test the expiration logic in a staging environment first
3. **Monitor Regularly**: Check logs periodically to ensure the system is working
4. **User Notifications**: Consider adding email notifications before credits expire
5. **Grace Period**: Consider implementing a grace period before hard expiration

## 🔧 Configuration Variables

### Environment Variables
No additional environment variables are required for the basic functionality.

### Database Requirements
- `users` table must have `credit` and `credit_expires_at` columns
- `credit_histories` table must exist with proper structure

## 📝 Notes

- The system only processes users with `credit > 0` and valid `credit_expires_at` dates
- Expiration runs at midnight server time
- The process is atomic and safe for concurrent access
- No user data is permanently lost (history is maintained)

---

**Created**: July 23, 2025  
**Version**: 1.0  
**Laravel Version**: 11.x+  
**Project**: Super Math Application
