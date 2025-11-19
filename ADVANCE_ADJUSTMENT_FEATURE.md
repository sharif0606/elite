# Advance Invoice Adjustment Feature

## Overview
This feature allows you to adjust/deduct advance payments made by customers against their invoice payments. When collecting payment for an invoice, you can now use the customer's available advance balance to partially or fully pay the invoice.

## Branch Information
- **Branch Name**: `feature/advance-invoice-adjustment`
- **Created Date**: November 19, 2025

## What's Implemented

### 1. Database Changes

#### New Table: `advance_usages`
Tracks individual advance usage transactions when advances are applied to invoice payments.

**Columns:**
- `id` - Primary key
- `advance_id` - Reference to the advance being used
- `invoice_payment_id` - Reference to the invoice payment
- `customer_id` - Customer ID
- `branch_id` - Branch ID
- `used_amount` - Amount of advance used
- `remarks` - Optional notes
- `created_by` - User who created the record
- `timestamps` - Created and updated timestamps

#### Modified Table: `advances`
Added columns to track advance usage:
- `used_amount` (decimal 15,2) - Total amount already used from this advance
- `remaining_amount` (decimal 15,2) - Available balance remaining

#### Modified Table: `invoice_payments`
Added column to track advance adjustment:
- `advance_adjusted` (decimal 15,2) - Amount of advance applied to this payment

### 2. Models Created/Updated

#### New Model: `AdvanceUsage`
- Location: `app/Models/AdvanceUsage.php`
- Relationships:
  - `advance()` - Belongs to Advance
  - `invoicePayment()` - Belongs to InvoicePayment
  - `customer()` - Belongs to Customer
  - `branch()` - Belongs to CustomerBrance

#### Updated Model: `Advance`
- Location: `app/Models/Advance.php`
- New Methods:
  - `usages()` - Has many AdvanceUsage records
  - `getAvailableBalanceAttribute()` - Calculate remaining balance
  - `getAvailableAdvance($customerId, $branchId)` - Static method to get total available advance for a customer

#### Updated Model: `InvoicePayment`
- Location: `app/Models/Crm/InvoicePayment.php`
- New Methods:
  - `advanceUsages()` - Has many AdvanceUsage records
- Added fillable fields including `advance_adjusted`

### 3. Controller Updates

#### Updated: `InvoicePaymentController`
- Location: `app/Http/Controllers/Crm/InvoicePaymentController.php`

**New Methods:**
1. `getAvailableAdvance(Request $request)` - API endpoint to fetch available advance balance
2. `processAdvanceAdjustment()` - Private method to handle advance usage logic

**Updated Methods:**
1. `store()` - Now handles advance adjustment during payment creation
   - Uses database transactions for data integrity
   - Automatically allocates advances (oldest first - FIFO)
   - Updates advance used/remaining amounts
   - Creates advance usage records

### 4. Routes Added

#### New Route:
```php
Route::get('/get-available-advance', [invPayment::class, 'getAvailableAdvance'])
    ->name('get_available_advance');
```

### 5. Frontend Changes

#### Updated View: `invoice_generate/index.blade.php`
- Location: `resources/views/invoice_generate/index.blade.php`

**New UI Elements in Collection Modal:**
1. **Advance Adjusted Field**
   - Input field to enter advance amount to adjust
   - Shows available advance balance in real-time
   - Validates against available balance
   - Auto-calculates remaining payment amount

**New JavaScript Functions:**
1. `fetchAvailableAdvance(customerId, branchId)` - Fetches available advance via AJAX
2. `validateAndCalculateAdvance()` - Validates advance input and recalculates payment
3. Updated `billTotal()` - Now includes advance adjustment in calculation

**Features:**
- Real-time balance display
- Input validation (cannot exceed available balance)
- Error messages for invalid inputs
- Automatic calculation of less paid amount

## How It Works

### Flow:

1. **Customer has advance**: Advances are recorded in the `advances` table with amount and date.

2. **Creating Invoice Payment**: When you click the dollar ($) button to collect payment:
   - Modal opens with invoice details
   - System automatically fetches available advance balance for that customer/branch
   - Available balance is displayed next to "Advance Adjusted" field

3. **Adjusting Advance**: You can enter an amount in the "Advance Adjusted" field:
   - System validates the amount doesn't exceed available balance
   - As you type, it recalculates the "Less Paid" amount
   - If invalid, error message is shown

4. **Saving Payment**: When you save:
   - System uses oldest advances first (FIFO method)
   - Updates each advance's `used_amount` and `remaining_amount`
   - Creates `advance_usage` records linking advance to payment
   - All operations are wrapped in a database transaction for safety

### Business Logic:

- **FIFO (First In, First Out)**: Oldest advances are used first
- **Cross-branch support**: Can use advances from branch_id=0 (general advances)
- **Validation**: Cannot use more advance than available
- **Atomic operations**: All database updates happen together or not at all
- **Audit trail**: Complete tracking of which advance was used for which payment

## Testing the Feature

### Prerequisites:
1. Customer must have advance records in the database
2. Advance must have available balance (amount > used_amount)

### Steps to Test:

1. **Create an Advance** (if not exists):
   - Go to Advance List page
   - Create a new advance for a customer
   - Note the amount

2. **Generate/View Invoice**:
   - Go to Invoice Generate page
   - Filter by customer who has advance
   - Click the dollar ($) icon to collect payment

3. **Use Advance**:
   - In the Collection modal, you'll see "Available: X.XX" next to Advance Adjusted
   - Enter an amount in the "Advance Adjusted" field
   - Notice "Less Paid" updates automatically
   - Fill in other required fields (Receive Date, etc.)
   - Click Save

4. **Verify**:
   - Check invoice payment record - should show advance_adjusted amount
   - Check advance record - used_amount should be updated
   - Check advance_usages table - should have new record linking them

## Database Migration

Migrations have been run successfully:
- `2025_11_19_141936_create_advance_usages_table.php` ✓
- `2025_11_19_142002_add_advance_columns_to_tables.php` ✓

## Files Modified

1. `app/Http/Controllers/Crm/InvoicePaymentController.php` - Added advance logic
2. `app/Models/Advance.php` - Added relationships and methods
3. `app/Models/AdvanceUsage.php` - New model
4. `app/Models/Crm/InvoicePayment.php` - Added relationships
5. `resources/views/invoice_generate/index.blade.php` - Added UI and JavaScript
6. `routes/web.php` - Added API route
7. `database/migrations/2025_11_19_141936_create_advance_usages_table.php` - New migration
8. `database/migrations/2025_11_19_142002_add_advance_columns_to_tables.php` - New migration

## Future Enhancements (Optional)

1. **Advance History Report**: Show which advances were used for which invoices
2. **Advance Refund**: Handle advance refunds if needed
3. **Branch-specific advances**: Restrict advances to specific branches only
4. **Advance Expiry**: Add expiry dates for advances
5. **Advance Approval**: Add approval workflow for advance usage

## Notes

- All database operations use transactions for data integrity
- Advance usage follows FIFO (First In, First Out) principle
- The feature is backward compatible - existing invoices work as before
- No changes required to existing advance or invoice payment records

## Support

If you encounter any issues:
1. Check browser console for JavaScript errors
2. Check Laravel logs in `storage/logs/`
3. Verify database migrations ran successfully
4. Ensure customer has available advance balance

---

**Implementation Date**: November 19, 2025  
**Developer**: AI Assistant  
**Status**: ✅ Complete and Ready for Testing

