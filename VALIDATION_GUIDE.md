# Form Validation Reference Guide

This document provides a comprehensive overview of all validation rules applied across the DDU Hospital Management System.

## Validation Types

### 1. Text Only (Letters, Spaces, Dots)
**Pattern**: `/^[a-zA-Z\s\.]+$/`

**Fields**:
- Patient full name
- Emergency contact name
- User/Doctor name
- Staff names

**Example**: `John Doe`, `Dr. Smith`

---

### 2. Number Only (Digits and Phone Characters)
**Pattern**: `/^[0-9\+\-\s]+$/`

**Fields**:
- Phone numbers
- Emergency contact phone
- Quantity fields (integer validation)
- Stock levels (integer validation)

**Example**: `+251-911234567`, `123`

---

### 3. Alphanumeric (Letters and Numbers)
**Rule**: `alpha_num`

**Fields**:
- Card numbers
- DDUC ID
- Batch numbers

**Example**: `ABC123`, `DDUC001`

---

### 4. Mixed (Text + Numbers + Special Characters)
**Rule**: `string` or custom regex

**Fields**:
- Addresses
- Medical history
- Allergies
- Diagnosis
- Clinical notes
- Dosage (e.g., "500mg")
- Frequency (e.g., "2 times a day")
- Supplier names: `/^[a-zA-Z0-9\s\.]+$/`

**Example**: `123 Main St., Apt 4B`, `500mg`, `ABC Pharma Ltd.`

---

### 5. Decimal/Numeric
**Rule**: `numeric`

**Fields**:
- Unit price
- Monetary values

**Example**: `25.50`, `100.00`

---

### 6. Integer Only
**Rule**: `integer`

**Fields**:
- Medicine quantity
- Duration (days)
- Stock quantity
- Minimum stock level

**Example**: `10`, `30`

---

## Controller-Specific Validations

### Reception Controller
- **full_name**: Text only
- **card_number**: Alphanumeric
- **phone**: Number only
- **email**: Email format
- **emergency_contact_name**: Text only
- **emergency_contact_phone**: Number only
- **medical_history**: Mixed
- **allergies**: Mixed
- **address**: Mixed

### Doctor Controller
- **test_type**: Mixed (string)
- **diagnosis**: Mixed (string)
- **dosage**: Mixed (string, e.g., "500mg")
- **frequency**: Mixed (string, e.g., "2 times daily")
- **quantity**: Integer only
- **duration**: Integer only (days)
- **clinical_notes**: Mixed
- **visit_date**: Date (past/today)
- **appointment_time**: Time format (H:i)

### Pharmacy Controller
- **batch_number**: Alphanumeric
- **quantity**: Integer only
- **minimum_stock_level**: Integer only
- **unit_price**: Numeric/Decimal
- **supplier**: Mixed (alphanumeric + spaces + dots)

### Lab Controller
- **test_values**: JSON format
- **results**: Mixed (string)
- **findings**: Mixed (string)
- **recommendations**: Mixed (string)
- **test_date**: Date

### Admin Controller
- **name**: Text only
- **dduc_id**: Alphanumeric
- **password**: Min 8 characters
- **role**: Predefined values

---

## Frontend Validation Examples

### HTML Input Attributes

**Text Only**:
```html
<input type="text" pattern="[a-zA-Z\s\.]+" required>
```

**Number Only**:
```html
<input type="number" min="0" required>
<!-- OR for phone -->
<input type="tel" pattern="[0-9\+\-\s]+" required>
```

**Alphanumeric**:
```html
<input type="text" pattern="[a-zA-Z0-9]+" required>
```

**Email**:
```html
<input type="email" required>
```

**Date**:
```html
<input type="date" required>
```

---

## Error Messages

Laravel will automatically return validation error messages. Common examples:

- **Text only violated**: "The name may only contain letters, spaces, and dots."
- **Number only violated**: "The phone must be numeric."
- **Required field**: "The field is required."
- **Integer violated**: "The quantity must be an integer."
- **Date format**: "The date must be a valid date."

---

## Notes

1. All validations are applied at the **backend (Controller)** level
2. Frontend validation should **match** backend rules for better UX
3. **Date fields** have additional logic:
   - Visit dates: Must be today or in the past (`before_or_equal:today`)
   - Due dates: Must be today or in the future (`after_or_equal:today`)
   - Reschedule dates: Must be in the future (`after:today`)
4. **File uploads** are validated for:
   - Type: `pdf,jpg,jpeg,png`
   - Size: Maximum 10MB (10240 KB)

---

**Last Updated**: 2026-01-01
**System Version**: v1.0
