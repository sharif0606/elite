-- Check what's stored for Invoice #14
SELECT 
    ip.id,
    ip.invoice_id,
    ip.received_amount,
    ip.advance_adjusted,
    ip.vat_amount,
    ip.ait_amount,
    ip.fine_deduction,
    ip.paid_by_client,
    ip.less_paid_honor,
    (ip.received_amount + ip.advance_adjusted + ip.vat_amount + ip.ait_amount + ip.fine_deduction + ip.paid_by_client + ip.less_paid_honor) as total_payment,
    ip.pay_date,
    ip.created_at
FROM invoice_payments ip
WHERE ip.invoice_id = 14
ORDER BY ip.id DESC;

-- Check invoice details
SELECT 
    id,
    grand_total,
    customer_id,
    branch_id
FROM invoice_generates
WHERE id = 14;

-- Check how many payments for invoice 14
SELECT 
    invoice_id,
    COUNT(*) as payment_count,
    SUM(received_amount) as total_cash,
    SUM(advance_adjusted) as total_advance,
    SUM(received_amount + advance_adjusted) as combined_total
FROM invoice_payments
WHERE invoice_id = 14
GROUP BY invoice_id;

