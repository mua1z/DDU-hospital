# Reception: Search and Edit Patient

## Implementation Summary
Enabled Receptionists to easily find patients by Name or ID and edit their information.

## Access Points
1. **Search Patients**:
    - Navigate to Reception Dashboard > Search Patients.
    - Enter **Name** OR **Card Number** (ID) OR **Phone**.
    - The results table now includes a green **Edit** button in the "Actions" column.
2. **Patient Profile**:
    - When viewing a patient's profile (`view-patient`), a new **"Edit Patient Info"** button is available in the "Quick Actions" sidebar.

## Functional Changes
- **Search (already existed)**: Logic verified to support Name and ID search.
- **Edit (already existed)**: Form allows updating details.
- **UI Updates**:
    - `resources/views/reception/search-patients.blade.php`: Added Edit button.
    - `resources/views/reception/view-patient.blade.php`: Added Edit Patient Info button.

This fulfills the requirement: "make as reception is call patient by thier name or ID and edit thei info".
