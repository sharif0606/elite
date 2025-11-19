-- SQL Script to Verify Advance Payment Feature
-- Run this to check if advance payments are working correctly

-- ========================================
-- 1. Check Latest Invoice Payment
-- ========================================
SELECT 
    ip.id as payment_id,
    ip.invoice_id,
    ip.customer_id,
    c.name as customer_name,
    ip.received_amount as cash_payment,
    ip.advance_adjusted,
    ip.vat_amount,
    ip.ait_amount,
    ip.pay_date,
    ip.created_at
FROM invoice_payments ip
LEFT JOIN customers c ON c.id = ip.customer_id
ORDER BY ip.id DESC
LIMIT 5;

-- ========================================
-- 2. Check Advance Usages (Which advance was used for which payment)
-- ========================================
SELECT 
    au.id,
    au.invoice_payment_id,
    au.advance_id,
    au.used_amount,
    a.amount as original_advance_amount,
    a.remaining_amount as advance_remaining,
    a.taken_date as advance_date,
    c.name as customer_name
FROM advance_usages au
LEFT JOIN advances a ON a.id = au.advance_id
LEFT JOIN customers c ON c.id = au.customer_id
ORDER BY au.id DESC
LIMIT 10;

-- ========================================
-- 3. Check Advances Balance for Customer ID 92
-- ========================================
SELECT 
    a.id as advance_id,
    a.customer_id,
    c.name as customer_name,
    a.amount as original_amount,
    a.used_amount,
    a.remaining_amount,
    a.taken_date,
    a.created_at
FROM advances a
LEFT JOIN customers c ON c.id = a.customer_id
WHERE a.customer_id = 92
ORDER BY a.taken_date ASC;

-- ========================================
-- 4. Check Total Advance Balance for Customer ID 92
-- ========================================
SELECT 
    customer_id,
    SUM(amount) as total_advance,
    SUM(used_amount) as total_used,
    SUM(remaining_amount) as total_available
FROM advances
WHERE customer_id = 92
GROUP BY customer_id;

-- ========================================
-- 5. Check Invoice Due Amount (After Payment)
-- ========================================
SELECT 
    ig.id as invoice_id,
    ig.customer_id,
    c.name as customer_name,
    ig.grand_total as invoice_amount,
    COALESCE(SUM(ip.received_amount), 0) as total_cash_received,
    COALESCE(SUM(ip.advance_adjusted), 0) as total_advance_used,
    COALESCE(SUM(ip.vat_amount), 0) as total_vat,
    COALESCE(SUM(ip.ait_amount), 0) as total_ait,
    COALESCE(SUM(ip.fine_deduction), 0) as total_fine,
    COALESCE(SUM(ip.paid_by_client), 0) as total_paid_by_client,
    COALESCE(SUM(ip.less_paid_honor), 0) as total_discount,
    (ig.grand_total - (
        COALESCE(SUM(ip.received_amount), 0) + 
        COALESCE(SUM(ip.advance_adjusted), 0) + 
        COALESCE(SUM(ip.vat_amount), 0) + 
        COALESCE(SUM(ip.ait_amount), 0) + 
        COALESCE(SUM(ip.fine_deduction), 0) + 
        COALESCE(SUM(ip.paid_by_client), 0) + 
        COALESCE(SUM(ip.less_paid_honor), 0)
    )) as due_amount
FROM invoice_generates ig
LEFT JOIN customers c ON c.id = ig.customer_id
LEFT JOIN invoice_payments ip ON ip.invoice_id = ig.id
WHERE ig.customer_id = 92
GROUP BY ig.id, ig.grand_total, ig.customer_id, c.name
ORDER BY ig.id DESC
LIMIT 10;

-- ========================================
-- 6. Detailed View: Which Advances Were Used for Which Invoice
-- ========================================
SELECT 
    ig.id as invoice_id,
    CONCAT('INV-', ig.id) as invoice_number,
    ig.grand_total as invoice_amount,
    ip.id as payment_id,
    ip.advance_adjusted as total_advance_in_payment,
    au.advance_id,
    au.used_amount as advance_portion_used,
    a.taken_date as advance_date,
    a.amount as original_advance,
    a.remaining_amount as advance_remaining
FROM invoice_generates ig
LEFT JOIN invoice_payments ip ON ip.invoice_id = ig.id
LEFT JOIN advance_usages au ON au.invoice_payment_id = ip.id
LEFT JOIN advances a ON a.id = au.advance_id
WHERE ip.advance_adjusted > 0
ORDER BY ig.id DESC, au.id
LIMIT 20;

-- ========================================
-- 7. Summary: Advance Usage by Customer
-- ========================================
SELECT 
    c.id as customer_id,
    c.name as customer_name,
    COUNT(DISTINCT a.id) as total_advances,
    SUM(a.amount) as total_advance_given,
    SUM(a.used_amount) as total_advance_used,
    SUM(a.remaining_amount) as total_advance_available,
    COUNT(DISTINCT au.id) as total_usage_records,
    COUNT(DISTINCT ip.id) as total_payments_with_advance
FROM customers c
LEFT JOIN advances a ON a.customer_id = c.id
LEFT JOIN advance_usages au ON au.customer_id = c.id
LEFT JOIN invoice_payments ip ON ip.id = au.invoice_payment_id
WHERE c.id = 92
GROUP BY c.id, c.name;

-- ========================================
-- 8. Find Invoices Still Showing as DUE (But shouldn't be)
-- ========================================
SELECT 
    ig.id as invoice_id,
    ig.grand_total,
    COALESCE(SUM(ip.received_amount), 0) as cash_received,
    COALESCE(SUM(ip.advance_adjusted), 0) as advance_used,
    (COALESCE(SUM(ip.received_amount), 0) + 
     COALESCE(SUM(ip.advance_adjusted), 0) + 
     COALESCE(SUM(ip.vat_amount), 0) + 
     COALESCE(SUM(ip.ait_amount), 0) + 
     COALESCE(SUM(ip.fine_deduction), 0) + 
     COALESCE(SUM(ip.paid_by_client), 0) + 
     COALESCE(SUM(ip.less_paid_honor), 0)) as total_paid,
    (ig.grand_total - (
        COALESCE(SUM(ip.received_amount), 0) + 
        COALESCE(SUM(ip.advance_adjusted), 0) + 
        COALESCE(SUM(ip.vat_amount), 0) + 
        COALESCE(SUM(ip.ait_amount), 0) + 
        COALESCE(SUM(ip.fine_deduction), 0) + 
        COALESCE(SUM(ip.paid_by_client), 0) + 
        COALESCE(SUM(ip.less_paid_honor), 0)
    )) as calculated_due,
    CASE 
        WHEN (ig.grand_total - (
            COALESCE(SUM(ip.received_amount), 0) + 
            COALESCE(SUM(ip.advance_adjusted), 0) + 
            COALESCE(SUM(ip.vat_amount), 0) + 
            COALESCE(SUM(ip.ait_amount), 0) + 
            COALESCE(SUM(ip.fine_deduction), 0) + 
            COALESCE(SUM(ip.paid_by_client), 0) + 
            COALESCE(SUM(ip.less_paid_honor), 0)
        )) = 0 THEN 'PAID'
        ELSE 'DUE'
    END as status
FROM invoice_generates ig
LEFT JOIN invoice_payments ip ON ip.invoice_id = ig.id
WHERE ig.customer_id = 92
GROUP BY ig.id, ig.grand_total
ORDER BY ig.id DESC
LIMIT 10;

