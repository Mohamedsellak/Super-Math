# Storage Link Setup - Super Math

This document explains how to make uploaded files and images accessible via the browser in the Super Math Laravel application.

## 📋 Overview

Laravel stores uploaded files in the `storage/app/public` directory for security reasons. However, this directory is not directly accessible via web browsers. To make these files accessible, Laravel provides a symbolic link mechanism that creates a link from `public/storage` to `storage/app/public`.

## 🎯 Purpose

- **File Access**: Make uploaded images and files accessible via browser URLs
- **Security**: Keep files outside the public web directory while allowing controlled access
- **Laravel Standard**: Follow Laravel's recommended file storage practices

## 🔗 How It Works

### Before Storage Link
```
❌ Browser URL: https://yoursite.com/storage/images/photo.jpg
❌ Result: 404 Not Found (files not accessible)
```

### After Storage Link
```
✅ Browser URL: https://yoursite.com/storage/images/photo.jpg
✅ Result: Image displays correctly
```

### Directory Structure
```
your-project/
├── public/
│   ├── storage/ ← Symbolic link (created by command)
│   └── index.php
└── storage/
    └── app/
        └── public/ ← Actual file location
            ├── images/
            ├── documents/
            └── uploads/
```

## 🚀 Setup Instructions

### Method 1: Laravel Artisan Command (Recommended)
```bash
# Navigate to your project directory
cd /home/sellak/Desktop/Super-Math

# Create the symbolic link
php artisan storage:link
```
```

## 📋 Checklist

- [ ] Run `php artisan storage:link`
- [ ] Verify symbolic link creation
- [ ] Test file upload functionality
- [ ] Test file access via browser
- [ ] Configure proper file permissions
- [ ] Implement file validation
- [ ] Test on production server
- [ ] Configure web server if needed

---

**Command**: `php artisan storage:link`  
**Created**: July 23, 2025  
**Version**: 1.0  
**Laravel Version**: 11.x+  
**Project**: Super Math Application
