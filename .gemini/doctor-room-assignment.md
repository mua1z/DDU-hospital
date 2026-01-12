# Admin: Doctor Room Assignment Implementation

## Overview
Implemented functionality for Admins to assign a room number when creating or editing a Doctor's account.

## Changes Completed

### Database
- Created Migration: `2026_01_13_000001_add_room_number_to_users_table.php`
- Added `room_number` (nullable string) to `users` table.

### Models
- **`app/Models/User.php`**: Added `'room_number'` to `$fillable`.

### Controller
- **`app/Http/Controllers/Admin/UserController.php`**:
    - Updated `store()` method:
        - Added validation rule: `'room_number' => ['nullable', 'string', 'max:20']`
        - Added `room_number` to creation logic.
    - Updated `update()` method:
        - Added validation rule.
        - Added `room_number` to update logic.

### Views
- **`resources/views/admin/users/create.blade.php`**:
    - Added "Room Number" input field.
    - Implemented Alpine.js logic (`x-show="role === 'Doctors'"`) to only show this field when "Doctor" role is selected.
- **`resources/views/admin/users/edit.blade.php`**:
    - Added "Room Number" input field with same Alpine.js logic.
    - Pre-filled with existing `room_number`.
- **`resources/views/admin/users/index.blade.php`**:
    - Updated user list to display "Room [Number]" under the Role badge for Doctors who have a room assigned.

## How to Test
1. Log in as an Admin.
2. Go to **Manage Users** -> **Create User**.
3. Select "Doctor" as the role. Verify that the "Room Number" field appears.
4. Fill in details and a room number (e.g., "101") and create.
5. Verify in the User List that the room number is displayed under the doctor's role.
6. Edit the created user. Verify the room number is pre-filled. Changed it and save.
7. Verify the change is reflected in the list.
8. Create/Edit a non-doctor user. Verify the "Room Number" field is hidden.
