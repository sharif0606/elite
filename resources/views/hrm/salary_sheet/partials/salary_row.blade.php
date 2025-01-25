<!-- resources/views/partials/salary_row.blade.php -->
 
<tr class="text-center tbl_border">
    <td class="tbl_border">{{-- $index --}}</td>
    <td class="tbl_border">{{ $detail->employee?->admission_id_no }}</td>
    <td class="tbl_border">
        {{ $detail->employee->salary_joining_date ? \Carbon\Carbon::parse($detail->employee->salary_joining_date)->format('d-m-Y') : '' }}
    </td>
    <td class="tbl_border">{{ $detail->position?->name }}</td>
    <td class="tbl_border">{{ $detail->employee?->en_applicants_name }}</td>
    <td class="tbl_border">{{ $detail->duty_qty != 0 ? round($detail->duty_rate) : '' }}</td>
    <td class="tbl_border">{{ $detail->duty_qty != 0 ? $detail->duty_qty : '' }}</td>
    <td class="tbl_border">{{ $detail->duty_amount != 0 ? round($detail->duty_amount) : '' }}</td>
    <td class="tbl_border">{{ $detail->ot_qty != 0 ? $detail->ot_qty : '' }}</td>
    <td class="tbl_border">{{ $detail->ot_qty != 0 ? round($detail->ot_rate) : '' }}</td>
    <td class="tbl_border">{{ $detail->ot_amount != 0 ? round($detail->ot_amount) : '' }}</td>
    <td class="tbl_border">{{ $detail->allownce != 0 ? round($detail->allownce) : '' }}</td>
    <td class="tbl_border">{{ round($detail->gross_salary) }}</td>
    <td class="tbl_border">{{ $detail->deduction_dress != 0 ? round($detail->deduction_dress) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_fine != 0 ? round($detail->deduction_fine) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_banck_charge != 0 ? round($detail->deduction_banck_charge) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_ins != 0 ? round($detail->deduction_ins) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_p_f != 0 ? round($detail->deduction_p_f) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_revenue_stamp != 0 ? round($detail->deduction_revenue_stamp) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_traningcost != 0 ? round($detail->deduction_traningcost) : '' }}</td>
    <td class="tbl_border">{{ $detail->deduction_loan != 0 ? round($detail->deduction_loan) : '' }}</td>
    <td class="tbl_border">{{ $detail->net_salary != 0 ? $detail->net_salary : '' }}</td>
    <td class="tbl_border">{{ $detail->sing_of_ind }}</td>
    <td class="tbl_border">{{ $detail->sing_account }}</td>
    <td class="tbl_border">{{ $detail->remark }}</td>
</tr>

