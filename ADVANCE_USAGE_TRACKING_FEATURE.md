# 📊 Advance Usage Tracking & Reporting Feature

## 🎯 **Overview**

A complete reporting system to visualize and track how customer advances are being used across invoices.

---

## ✨ **What's New**

### **1. New Menu Item** ⭐
```
CRM
├── Customer
├── Employee's Assign
├── ...
├── Invoice Generate
├── Invoice Payment
├── Advance
└── 📊 Advance Usage History ← NEW!
```

**Access:** `http://localhost:8080/elite/admin/advance-usage-history?role=superadmin`

---

## 📈 **Features Implemented**

### **Feature 1: Advance Usage History Page**

**Location:** CRM → Advance Usage History

**What It Shows:**
- ✅ Complete list of all advance usage transactions
- ✅ Which advance was used for which invoice
- ✅ Customer name, branch, ATM details
- ✅ Original advance amount vs used amount
- ✅ Remaining balance after usage
- ✅ Invoice details (ID, month, grand total)
- ✅ Usage date and time

**Summary Cards at Top:**
```
┌─────────────────────────────────────────────────┐
│ Total Advance Used │ Total Transactions │ Average│
│    47,419.00      │        15         │ 3,161.27│
└─────────────────────────────────────────────────┘
```

**Filters Available:**
- 🔍 By Customer (dropdown)
- 🔍 By Date Range (from-to)
- 🔍 By Advance ID (search specific advance)

**Table Shows:**
| Date | Customer | Advance ID | Advance Date | Original | Used | Remaining | Invoice | Month | Branch |
|------|----------|------------|--------------|----------|------|-----------|---------|-------|--------|
| 2025-11-19 | Port Harbor | #45 | 2024-09-18 | 56,000 | 30,000 | 26,000 | #4687 | Oct-25 | GEC |

---

### **Feature 2: Advance Detail Page**

**How to Access:**
1. From Advance Usage History → Click Advance ID badge
2. From Advance List → Click "View Usage History" button (clock icon)

**What It Shows:**

#### **A. Advance Summary Card**
```
┌────────────────────────────────────────────────────────┐
│ Advance Details - ID #45                                │
├────────────────────────────────────────────────────────┤
│ Customer: Port Harbor International                     │
│ Branch: GEC Circle                                      │
│ Advance Date: 2024-09-18                               │
│ Original Amount: 56,000.00                             │
│ Used Amount: 30,000.00                                 │
│ Remaining: 26,000.00                                   │
└────────────────────────────────────────────────────────┘
```

#### **B. Visual Progress Bar**
```
┌────────────────────────────────────────────────────────┐
│ Usage Progress                                          │
├────────────────────────────────────────────────────────┤
│ [██████████████████████░░░░░░░░░░░░]                  │
│  Available: 26,000     Used: 30,000                   │
└────────────────────────────────────────────────────────┘
```

#### **C. Complete Usage History Table**
Shows every transaction where this advance was used:
- Usage date & time
- Amount used
- Invoice ID (clickable)
- Invoice month
- Payment ID
- Grand total
- Remarks

---

### **Feature 3: Enhanced Advance List**

**What Changed:**

**Before:**
| #SL | Month | Customer | Amount | Date | ACTION |
|-----|-------|----------|--------|------|--------|
| 1 | Sep-24 | Customer | 56000 | 2024-09-18 | Edit Delete |

**After:**
| #SL | Month | Customer | Original | Used ⚠️ | Available ✅ | Date | ACTION |
|-----|-------|----------|----------|---------|-------------|------|--------|
| 1 | Sep-24 | Customer | 56,000 | 30,000 | 26,000 | 2024-09-18 | 🕐 Edit Delete |

**New Columns:**
- ✅ **Used** (red text) - Shows how much was already used
- ✅ **Available** (green text) - Shows remaining balance

**New Button:**
- ✅ **View Usage History** (clock icon) - Opens detail page
  - Only appears if advance has been used
  - Click to see complete usage breakdown

---

## 🎨 **User Interface**

### **Color Coding:**
- 🔴 **Red** = Used amount (deducted)
- 🟢 **Green** = Available amount (remaining)
- 🔵 **Blue** = Advance ID badges (clickable)
- 🟡 **Info** = Invoice ID badges (clickable)

### **Icons:**
- 🕐 **Clock** = View Usage History
- 👁️ **Eye** = View Invoice Details
- ✏️ **Pencil** = Edit
- 🗑️ **Trash** = Delete

---

## 📊 **Use Cases & Examples**

### **Use Case 1: Check if advance has been used**
1. Go to: **CRM → Advance**
2. Look at **"Used"** column
3. If > 0, advance has been used
4. Click clock icon to see details

### **Use Case 2: Find which invoice used an advance**
1. Go to: **CRM → Advance Usage History**
2. Filter by customer or date
3. See all invoices that used advances
4. Click invoice ID to view invoice

### **Use Case 3: Track customer's advance usage over time**
1. Go to: **CRM → Advance Usage History**
2. Select customer from dropdown
3. Set date range
4. Click Search
5. See complete history

### **Use Case 4: Verify a specific advance usage**
1. Go to: **CRM → Advance**
2. Find the advance (e.g., ID #45)
3. Click clock icon
4. See:
   - How much was used
   - For which invoices
   - When it was used
   - What's remaining

### **Use Case 5: Report for management**
Use the **Advance Usage History** page to:
- Generate monthly usage reports
- Track advance consumption patterns
- Identify customers using advances most
- Calculate average usage per transaction

---

## 🔗 **Navigation Flow**

```
Option A: From Advance List
├─ CRM → Advance
├─ Click clock icon (🕐)
└─ View Advance Detail Page

Option B: From Usage History
├─ CRM → Advance Usage History
├─ Click Advance ID badge
└─ View Advance Detail Page

Option C: From Invoice Payment
├─ CRM → Invoice Payment
├─ Click info icon on "advance(s) used"
└─ View Usage Modal (quick view)

Option D: Direct Link
└─ /admin/advance-usage-history?role=superadmin
```

---

## 📊 **Data Shown**

### **Advance Usage History Table:**
1. **Date** - When advance was used
2. **Customer** - Customer name
3. **Advance ID** - Which advance (clickable to details)
4. **Advance Date** - When advance was taken
5. **Original Amount** - Full advance amount
6. **Used Amount** - Amount deducted (green, bold)
7. **Remaining** - Balance left
8. **Invoice ID** - Invoice it was applied to (clickable)
9. **Invoice Month** - Billing period
10. **Branch/ATM** - Location details
11. **ACTION** - View invoice button

### **Advance Detail Page:**
1. **Advance Summary** - All advance details
2. **Progress Bar** - Visual representation
3. **Usage History** - Transaction-by-transaction breakdown
4. **Totals** - Sum of all usage

---

## 🎯 **Benefits**

✅ **Transparency** - See exactly where advances went  
✅ **Accountability** - Complete audit trail  
✅ **Quick Access** - Multiple ways to view data  
✅ **Filters** - Find what you need fast  
✅ **Visual** - Progress bars and color coding  
✅ **Clickable** - Navigate between related records  
✅ **Summary** - Overview cards show key metrics  
✅ **Export Ready** - Can be enhanced to export reports  

---

## 🛠️ **Technical Details**

### **New Files Created:**
```
app/Http/Controllers/AdvanceUsageController.php
resources/views/advance_usage/index.blade.php
resources/views/advance_usage/detail.blade.php
```

### **Routes Added:**
```php
GET /advance-usage-history → index page
GET /advance-usage-detail/{id} → detail page
```

### **Database Used:**
```
advance_usages table:
- id, advance_id, invoice_payment_id
- customer_id, branch_id
- used_amount, remarks
- created_at, updated_at

Relationships:
- advance_usages → advances
- advance_usages → invoice_payments → invoices
- advance_usages → customers
```

### **Filters:**
- Customer dropdown (select2)
- Date range (from-to)
- Advance ID (text input)
- Pagination (20 per page)

---

## 📸 **Screenshots Guide**

### **Where to Find:**

**1. Menu Item:**
- Sidebar → CRM section → "Advance Usage History"

**2. Main Page:**
- Summary cards at top
- Filter section
- Full table with all data

**3. Detail Page:**
- Advance summary card
- Progress bar
- Usage history table

**4. Enhanced Advance List:**
- New "Used" and "Available" columns
- Clock icon button for used advances

---

## 🚀 **How to Use - Step by Step**

### **Scenario: "I want to see where Advance #45 was used"**

**Step 1:** Go to CRM → Advance  
**Step 2:** Find Advance #45 in the list  
**Step 3:** Look at the "Used" column  
- If it shows a number (e.g., 30,000), it's been used
- If it shows 0.00, it hasn't been used yet

**Step 4:** Click the clock icon (🕐) in ACTION column  
**Step 5:** You'll see:
- Original amount: 56,000
- Used: 30,000
- Remaining: 26,000
- Progress bar showing 53% used
- Table showing it was used for Invoice #4687

---

### **Scenario: "I want to see all advances used in October 2025"**

**Step 1:** Go to CRM → Advance Usage History  
**Step 2:** Set filters:
- From Date: 2025-10-01
- To Date: 2025-10-31

**Step 3:** Click "Search"  
**Step 4:** See all October usage  
**Step 5:** Can export or analyze the data

---

## 📋 **Summary**

| Feature | Location | Purpose |
|---------|----------|---------|
| **Advance Usage History** | CRM Menu | View all usage transactions |
| **Advance Detail Page** | Click Advance ID | Deep dive into one advance |
| **Enhanced Advance List** | CRM → Advance | Quick view of all advances |
| **Invoice Payment Details** | Click info icon | See advances used per payment |

---

## ✅ **Testing Checklist**

- [x] Menu item appears in CRM section
- [x] Advance Usage History page loads
- [x] Filters work (customer, date, advance ID)
- [x] Can click Advance ID to see details
- [x] Progress bar displays correctly
- [x] Usage history table shows data
- [x] Can navigate to invoices from links
- [x] Advance list shows Used/Available columns
- [x] Clock icon appears for used advances
- [x] Pagination works
- [x] Summary cards show correct totals

---

**Feature Complete!** 🎉

**Last Updated:** November 19, 2025  
**Version:** 1.0  
**Status:** ✅ Ready for Production

