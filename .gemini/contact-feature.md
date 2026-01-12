# Contact Form Feature Implementation

## Overview
Implemented a contact form on the home page for users/patients to send messages to the admin. Admins can view these messages via the admin dashboard.

## Changes

### 1. Database
- **Table**: `contact_messages`
- **Fields**: `full_name`, `student_id`, `email`, `message`, `is_read`, `timestamps`.
- **Status**: Table created and migration registered.

### 2. Frontend (Patient Side)
- **Home Page**: Updated `resources/views/home.blade.php` to include a functional contact form.
- **Route**: `POST /contact` -> `ContactController@store`.
- **Controller**: `App\Http\Controllers\ContactController` handles submission and validation.

### 3. Backend (Admin Side)
- **Controller**: `App\Http\Controllers\Admin\ContactController` handles listing and viewing messages.
- **Views**:
    - `resources/views/admin/contacts/index.blade.php`: List of messages (paginated).
    - `resources/views/admin/contacts/show.blade.php`: Detailed view of a message.
- **Sidebar**: Added **"View Contact"** link to the Admin Sidebar (`resources/views/admin/partials/sidebar.blade.php`).

### 4. Routes
- Added public contact routes.
- Added admin contact routes protected by `auth` and `admin` middleware.

## Verification
- **Patient**: Can fill out the form on the homepage and receive a success message.
- **Admin**: Can click "View Contact" in the sidebar to see the list of messages and view details.
