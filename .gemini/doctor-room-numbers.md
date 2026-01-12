# Doctor Room Number Display Implementation

## Summary
Added doctor room number display across all dashboards where doctors appear.

## Changes Made

### 1. Reception - Schedule Appointments
- **File**: `resources/views/reception/schedule-appointments.blade.php`
- **Changes**: Added room number to both doctor dropdown selects
- **Display Format**: "Dr. Name - Room 101" (if room number exists)

### Usage
Doctors with assigned room numbers will now display as:
- "Dr. John Doe - Room 101"
- "Dr. Jane Smith - Room 202"

Doctors without room numbers will display as:
- "Dr. John Doe"

## Room Number Field
- Added to `users` table via migration
- Only applies to users with role "Doctors"
- Optional field (nullable)
- Can be assigned/edited in Admin > User Management

## Next Steps (if needed)
To extend room number display to other areas:
1. Patient dashboard (my appointments)
2. Medical records views  
3. Doctor profile cards
4. Appointment tables/lists
