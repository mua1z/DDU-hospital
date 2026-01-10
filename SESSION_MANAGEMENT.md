# Session Management Configuration

This document details the session management implementation for the DDU Hospital Management System, covering automatic logout and manual logout functionality.

---

## FR-25: Automatic Logout (Session Timeout)

### Overview
The system automatically logs out users after a defined period of inactivity to enhance security.

### Configuration

**1. Session Lifetime Setting**

Located in `.env` file:
```env
SESSION_LIFETIME=120  # Minutes of inactivity before auto-logout (default: 120 = 2 hours)
SESSION_DRIVER=database
SESSION_EXPIRE_ON_CLOSE=false
```

**2. Middleware Implementation**

File: `app/Http/Middleware/CheckSessionTimeout.php`

This middleware:
- Tracks user's last activity time in the session
- Compares inactive time with configured session lifetime
- Automatically logs out users exceeding the timeout period
- Displays a friendly message: "Your session has expired due to inactivity. Please login again."

**3. How It Works**

1. User logs in → Last activity time is recorded
2. Each page request → Last activity time is updated
3. If inactivity exceeds `SESSION_LIFETIME`:
   - User is logged out
   - Session is invalidated
   - User is redirected to login page with timeout message

**4. Customization**

To change the timeout duration:

**Option A: Via Environment File**
```env
# Change in .env
SESSION_LIFETIME=30  # 30 minutes
SESSION_LIFETIME=60  # 1 hour
SESSION_LIFETIME=180 # 3 hours
```

**Option B: Via Admin Settings** (If implemented)
- Navigate to Admin → Settings
- Update "Session Timeout" field
- Value is stored in database and overrides .env

---

## FR-26: Manual Logout

### Overview
Users can manually log out from any interface at any time.

### Implementation

**1. Logout Route**

File: `routes/web.php`
```php
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
```

**2. Logout Controller**

File: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

The `destroy()` method:
- Logs out the authenticated user
- Invalidates the current session
- Regenerates CSRF token (security best practice)
- Redirects to homepage

**3. Logout Button Location**

Available in ALL dashboards:

✅ **Admin Dashboard**
- Located in sidebar (bottom)
- File: `resources/views/admin/partials/sidebar.blade.php`

✅ **Doctor Dashboard**
- Located in sidebar (bottom)
- File: `resources/views/doctor/partials/sidebar.blade.php`

✅ **Pharmacy Dashboard**
- Located in sidebar (bottom)
- File: `resources/views/pharmacy/partials/sidebar.blade.php`

✅ **Lab Dashboard**
- Located in sidebar (bottom)
- File: `resources/views/lab/partials/sidebar.blade.php`

✅ **Reception Dashboard**
- Located in sidebar (bottom)
- File: `resources/views/reception/partials/sidebar.blade.php`

**4. Logout Button Code**

```html
<form method="POST" action="{{ route('logout') }}" id="logout-form">
    @csrf
    <button type="submit" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i>
        <span>{{ __('Logout') }}</span>
    </button>
</form>
```

**5. Logout Confirmation** (Optional Enhancement)

To add confirmation dialog before logout:

```javascript
document.getElementById('logout-form')?.addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to logout?')) {
        e.preventDefault();
    }
});
```

---

## Security Features

### Session Security Measures

1. **Session Regeneration**
   - Session ID is regenerated on login (prevents session fixation)
   - CSRF token is regenerated on logout

2. **Session Invalidation**
   - All session data is cleared on logout
   - Prevents unauthorized access to stale sessions

3. **Database Session Storage**
   - Sessions are stored in database (more secure than file storage)
   - Allows for centralized session management
   - Easier to track active users

4. **Inactivity Tracking**
   - Real-time tracking of user activity
   - Precise timeout enforcement

---

## Testing Session Management

### Test Automatic Logout

1. Set short timeout for testing:
   ```env
   SESSION_LIFETIME=1  # 1 minute
   ```

2. Login to any dashboard
3. Wait 1 minute without any activity
4. Try to navigate to any page
5. **Expected**: Redirected to login with timeout message

### Test Manual Logout

1. Login to any dashboard
2. Click "Logout" button in sidebar
3. **Expected**: Redirected to homepage
4. Try to access protected page via URL
5. **Expected**: Redirected to login page

---

## Troubleshooting

### Issue: Users not being logged out automatically

**Solution**:
1. Check `SESSION_LIFETIME` is set in `.env`
2. Verify middleware is registered in `bootstrap/app.php`
3. Ensure session driver is database: `SESSION_DRIVER=database`
4. Run migration to create sessions table:
   ```bash
   php artisan migrate
   ```

### Issue: Logout button not working

**Solution**:
1. Verify logout route exists in `routes/web.php`
2. Check CSRF token is included in form
3. Ensure `AuthenticatedSessionController` exists
4. Clear cache: `php artisan config:clear`

### Issue: Session expires too quickly/slowly

**Solution**:
1. Adjust `SESSION_LIFETIME` in `.env`
2. Clear config cache: `php artisan config:clear`
3. Restart server

---

## Best Practices

1. **Production Settings**:
   - Set `SESSION_LIFETIME` to 30-60 minutes for security
   - Use database or Redis for session storage
   - Enable `SESSION_EXPIRE_ON_CLOSE` for sensitive areas

2. **User Experience**:
   - Show warning before timeout (optional enhancement)
   - Display clear timeout message
   - Preserve form data before logout (optional)

3. **Security**:
   - Never store sensitive data in sessions
   - Always regenerate session on privilege changes
   - Use HTTPS in production

---

**Last Updated**: 2026-01-01  
**Implemented**: FR-25 ✅, FR-26 ✅
