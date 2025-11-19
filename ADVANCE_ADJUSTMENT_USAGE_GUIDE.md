# 📘 Advance Adjustment Feature - Usage Guide

## 🎯 Understanding the Feature

This feature allows you to **adjust customer advance payments against invoice bills**. Instead of collecting cash/bank payment, you can deduct from the customer's pre-paid advance balance.

---

## 💡 Key Concepts

### Payment Types:
1. **Received Amount (Cash/Bank)** - Physical payment received from customer
2. **Advance Adjusted** - Payment deducted from customer's advance balance

### Example Scenario:
```
Invoice Amount: 47,419.00
Customer has Advance: 112,000.00

Option 1: Full Cash Payment
- Received Amount: 47,419.00
- Advance Adjusted: 0.00
- Customer Advance Remains: 112,000.00

Option 2: Full Advance Payment  
- Received Amount: 0.00 (No cash needed!)
- Advance Adjusted: 47,419.00
- Customer Advance Becomes: 64,581.00

Option 3: Mixed Payment
- Received Amount: 20,000.00 (Cash)
- Advance Adjusted: 27,419.00 (From advance)
- Customer Advance Becomes: 84,581.00
```

---

## 🚀 How to Use

### Step 1: Collect Payment from Invoice
1. Go to: `http://localhost:8080/elite/admin/invoiceGenerate`
2. Filter by customer (who has advance balance)
3. Click the **$ (Dollar Icon)** button on any invoice

### Step 2: In Collection Modal
You'll see:
```
┌─────────────────────────────────────────────────┐
│ Customer Name: Port Harbor International        │
│ Billable Amount: 47,419                         │
├─────────────────────────────────────────────────┤
│ Received Amount (Cash/Bank): [        ]        │
│ └─ Enter 0 if paying fully from advance         │
│                                                  │
│ Advance Adjusted (From Customer Balance)        │
│ Available: 112000.00                            │
│ └─ Amount to deduct from advance balance        │
│    [        ]                                    │
├─────────────────────────────────────────────────┤
│ Less Paid: (Auto-calculated)                    │
└─────────────────────────────────────────────────┘
```

### Step 3: Enter Payment Details

**Scenario A: Pay Fully from Advance**
1. Received Amount: Enter `0` or leave blank
2. Advance Adjusted: Enter `47419` (or partial amount)
3. System validates amount doesn't exceed available balance
4. Fill required fields (Receive Date, etc.)
5. Click **Save**

**Scenario B: Mixed Payment**
1. Received Amount: Enter `20000` (cash amount)
2. Advance Adjusted: Enter `27419` (from advance)
3. Total = 47,419 (invoice fully paid)
4. Fill required fields
5. Click **Save**

### Step 4: System Auto-Processing
When you save, the system automatically:
- ✅ Uses oldest advances first (FIFO)
- ✅ Updates advance `used_amount` and `remaining_amount`
- ✅ Creates tracking records in `advance_usages` table
- ✅ Links advance to invoice payment
- ✅ Reduces customer's available advance balance

---

## 📊 How to Check/Track Advance Usage

### Method 1: Invoice Payment List
1. Go to: `http://localhost:8080/elite/admin/invoice-payment`
2. You'll see a new column: **"Advance Used"** (in green)
3. If advance was used, you'll see:
   ```
   56,000.00
   ⓘ 2 advance(s) used ← Click this
   ```
4. Click the info icon to see details popup

### Method 2: Advance Usage Details Modal
When you click the info icon, you'll see:
```
┌─────────────────────────────────────────────────────────────┐
│              Advance Usage Details                          │
├────┬──────────┬──────────┬─────────┬──────┬──────┬─────────┤
│ #  │ Adv ID   │ Date     │ Original│ Used │ Remain│ Branch  │
├────┼──────────┼──────────┼─────────┼──────┼──────┼─────────┤
│ 1  │ #45      │2024-09-18│ 56000.00│30000 │26000 │ GEC     │
│ 2  │ #46      │2024-10-01│ 56000.00│17419 │38581 │ Vacant  │
├────┴──────────┴──────────┴─────────┴──────┴──────┴─────────┤
│                Total Advance Used: 47,419.00                 │
└──────────────────────────────────────────────────────────────┘
```

This shows:
- Which specific advances were used
- How much was deducted from each advance
- Remaining balance in each advance
- Total advance used for this payment

### Method 3: Direct Database Query

#### Check which advances were used for a payment:
```sql
SELECT 
    au.id,
    au.invoice_payment_id,
    au.advance_id,
    au.used_amount,
    a.amount as original_advance,
    a.remaining_amount,
    a.taken_date,
    c.name as customer_name
FROM advance_usages au
JOIN advances a ON a.id = au.advance_id
JOIN customers c ON c.id = au.customer_id
WHERE au.invoice_payment_id = [PAYMENT_ID];
```

#### Check all advances used by a customer:
```sql
SELECT 
    a.id,
    a.amount as original_amount,
    a.used_amount,
    a.remaining_amount,
    a.taken_date,
    COUNT(au.id) as times_used
FROM advances a
LEFT JOIN advance_usages au ON au.advance_id = a.id
WHERE a.customer_id = [CUSTOMER_ID]
GROUP BY a.id;
```

#### Check advance balance for a customer:
```sql
SELECT 
    customer_id,
    SUM(amount) as total_advance,
    SUM(used_amount) as total_used,
    SUM(remaining_amount) as total_available
FROM advances
WHERE customer_id = [CUSTOMER_ID]
GROUP BY customer_id;
```

---

## 🗄️ Database Tables Reference

### 1. `advances` table
```
┌─────────────────┬────────────┬────────────────────┐
│ Column          │ Type       │ Description        │
├─────────────────┼────────────┼────────────────────┤
│ id              │ bigint     │ Primary key        │
│ customer_id     │ bigint     │ Customer ID        │
│ branch_id       │ bigint     │ Branch ID          │
│ amount          │ decimal    │ Original amount    │
│ used_amount     │ decimal    │ Already used ✨NEW │
│ remaining_amount│ decimal    │ Available ✨NEW    │
│ taken_date      │ date       │ Advance date       │
└─────────────────┴────────────┴────────────────────┘
```

### 2. `advance_usages` table ✨NEW
```
┌────────────────────┬────────────┬────────────────────┐
│ Column             │ Type       │ Description        │
├────────────────────┼────────────┼────────────────────┤
│ id                 │ bigint     │ Primary key        │
│ advance_id         │ bigint     │ Which advance used │
│ invoice_payment_id │ bigint     │ For which payment  │
│ customer_id        │ bigint     │ Customer ID        │
│ branch_id          │ bigint     │ Branch ID          │
│ used_amount        │ decimal    │ Amount used        │
│ remarks            │ text       │ Optional notes     │
│ created_by         │ bigint     │ User who created   │
└────────────────────┴────────────┴────────────────────┘
```

### 3. `invoice_payments` table
```
┌─────────────────┬────────────┬────────────────────┐
│ Column          │ Type       │ Description        │
├─────────────────┼────────────┼────────────────────┤
│ id              │ bigint     │ Primary key        │
│ invoice_id      │ integer    │ Invoice ID         │
│ received_amount │ decimal    │ Cash/Bank payment  │
│ advance_adjusted│ decimal    │ Advance used ✨NEW │
│ vat_amount      │ decimal    │ VAT deduction      │
│ ait_amount      │ decimal    │ AIT deduction      │
│ ... (other payment fields)                        │
└─────────────────┴────────────┴────────────────────┘
```

---

## ✅ Validation Rules

1. **Advance Amount** cannot be negative
2. **Advance Amount** cannot exceed available balance
3. If advance exceeds available: System auto-sets to maximum available
4. **FIFO Rule**: Oldest advances are used first automatically
5. **Cross-branch**: Can use general advances (branch_id = 0) for any branch

---

## 🔍 Common Questions

### Q1: Can I pay an invoice fully from advance without cash?
**A:** Yes! Just enter:
- Received Amount: `0`
- Advance Adjusted: `[invoice amount]`

### Q2: How do I know which advance was used?
**A:** 
- Go to invoice payment list
- Find your payment
- Click the info icon (ⓘ) next to "X advance(s) used"
- See detailed breakdown

### Q3: What if customer has multiple advances?
**A:** System automatically uses oldest advances first (FIFO). You'll see in the details modal which advances were used.

### Q4: Can I partially use an advance?
**A:** Yes! System can split one advance across multiple payments, or use multiple advances for one payment.

### Q5: How is "Billing Amount" calculated in payment list?
**A:** 
```
Billing Amount = 
    Received Amount (Cash/Bank)
  + Advance Adjusted
  + VAT Amount
  + AIT Amount
  + Fine Deduction
  + Paid by Client
  + Less Paid Honor
```

### Q6: Where can I see advance balance history?
**A:**
1. In Collection modal (shows current available balance)
2. In Invoice Payment list (shows amount used per payment)
3. In advance_usages table (complete transaction history)

---

## 🎨 Visual Changes in UI

### Collection Modal (Invoice Generate):
- ✨ New field: "Advance Adjusted"
- ✨ Shows: "Available: X.XX" balance
- ✨ Helper text: "Amount to deduct from advance balance"
- ✨ Real-time validation
- ✨ Auto-calculates "Less Paid"

### Invoice Payment List:
- ✨ New column: "Advance Used" (green)
- ✨ Shows amount with info icon
- ✨ Clickable detail link
- ✨ Received Amount labeled as "(Cash/Bank)"
- ✨ Billing amount includes advance

---

## 🛠️ Technical Details

### API Endpoints:
1. **GET** `/get-available-advance` - Fetch customer's available advance
   - Parameters: `customer_id`, `branch_id`
   - Returns: Total available balance

2. **GET** `/get-advance-usage-details` - Fetch advance usage for a payment
   - Parameters: `payment_id`
   - Returns: List of advances used with details

### How FIFO Works:
```php
1. Query all available advances (amount > used_amount)
2. Order by taken_date ASC (oldest first)
3. Loop through advances:
   - Calculate available in this advance
   - Use minimum of (needed amount, available)
   - Update advance used_amount
   - Create usage record
   - Reduce remaining needed amount
4. If still need more, use next advance
```

---

## 📞 Support & Troubleshooting

### Issue: Available balance shows 0.00
**Solution:** Customer doesn't have advances or all advances are fully used. Check advance table.

### Issue: Can't enter advance amount
**Solution:** Make sure customer has available balance. System won't allow if balance is 0.

### Issue: Advance not deducting after save
**Solution:** Check browser console for errors. Verify database transaction completed successfully.

### Issue: Wrong advance balance showing
**Solution:** Clear browser cache. Verify `used_amount` and `remaining_amount` in advances table.

---

## 🎉 Benefits

✅ **No cash handling** - Pay invoices from advance balance  
✅ **Complete tracking** - Know exactly which advance was used  
✅ **Automatic allocation** - System handles FIFO logic  
✅ **Audit trail** - Full history in database  
✅ **Real-time validation** - Prevents errors  
✅ **User friendly** - Clear UI and messages  
✅ **Flexible** - Mix advance and cash payments  

---

**Last Updated:** November 19, 2025  
**Feature Version:** 1.0  
**Status:** ✅ Production Ready

