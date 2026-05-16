<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Today's Visitor Log</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10.5px; color: #1e293b; padding: 24px 28px; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px; border-bottom: 2px solid #0f172a; padding-bottom: 12px; }
        .header-left h1 { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .header-left p  { font-size: 11px; color: #64748b; }
        .header-right   { text-align: right; }
        .header-right .label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
        .header-right .value { font-size: 13px; font-weight: 700; color: #0f172a; }

        .stats { display: table; width: 100%; margin-bottom: 16px; }
        .stat  { display: table-cell; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 14px; width: 25%; text-align: center; }
        .stat-num   { font-size: 18px; font-weight: 800; color: #0f172a; }
        .stat-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-top: 2px; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #0f172a; }
        thead th { color: #fff; padding: 8px 10px; font-size: 9.5px; text-transform: uppercase; letter-spacing: .5px; font-weight: 600; text-align: left; }
        tbody td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 10.5px; }
        tbody tr:nth-child(even) { background: #fafbfc; }

        .badge { padding: 2px 8px; border-radius: 10px; font-size: 9.5px; font-weight: 700; }
        .badge-active    { background: #dcfce7; color: #16a34a; }
        .badge-completed { background: #f1f5f9; color: #64748b; }
        .badge-pending   { background: #fef9c3; color: #b45309; }

        .apt  { background: #f1f5f9; color: #475569; font-size: 9.5px; font-weight: 700; padding: 1px 6px; border-radius: 4px; }
        .name { font-weight: 700; color: #0f172a; }
        .sub  { font-size: 9.5px; color: #94a3b8; display: block; margin-top: 1px; }
        .dur  { font-size: 10px; color: #64748b; }

        .footer { margin-top: 18px; padding-top: 10px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <h1>Apartment Visitors Management System</h1>
            <p>Today's Visitor Log &mdash; {{ $date }}</p>
        </div>
        <div class="header-right">
            <div class="label">Generated</div>
            <div class="value">{{ now()->format('H:i') }}</div>
        </div>
    </div>

    @php
        $total     = $visits->count();
        $inside    = $visits->where('status','active')->count();
        $out       = $visits->where('status','completed')->count();
    @endphp

    <table style="margin-bottom:14px;border-collapse:separate;border-spacing:6px 0;">
        <tr>
            <td style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:8px 20px;text-align:center;width:33%;">
                <div style="font-size:20px;font-weight:800;color:#0f172a;">{{ $total }}</div>
                <div style="font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-top:2px;">Total Visits</div>
            </td>
            <td style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:8px 20px;text-align:center;width:33%;">
                <div style="font-size:20px;font-weight:800;color:#ef4444;">{{ $inside }}</div>
                <div style="font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-top:2px;">Currently Inside</div>
            </td>
            <td style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:8px 20px;text-align:center;width:33%;">
                <div style="font-size:20px;font-weight:800;color:#16a34a;">{{ $out }}</div>
                <div style="font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-top:2px;">Checked Out</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width:32px;">#</th>
                <th>Visitor</th>
                <th>National ID</th>
                <th>Host</th>
                <th>Apt</th>
                <th>Purpose</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Duration</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visits as $i => $visit)
            @php
                $dur = '—';
                if($visit->check_in_time && $visit->check_out_time) {
                    $mins = (int)$visit->check_in_time->diffInMinutes($visit->check_out_time);
                    $dur  = $mins < 60 ? $mins.'m' : floor($mins/60).'h '.($mins%60).'m';
                }
            @endphp
            <tr>
                <td style="color:#94a3b8;font-weight:700;">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</td>
                <td>
                    <span class="name">{{ $visit->visitor->full_name }}</span>
                    <span class="sub">{{ $visit->visitor->phone_number ?: '' }}</span>
                </td>
                <td>{{ $visit->visitor->national_id ?? '—' }}</td>
                <td>{{ $visit->tenant->user->name ?? '—' }}</td>
                <td><span class="apt">{{ $visit->tenant->apartment_display ?? '—' }}</span></td>
                <td>{{ $visit->purpose }}</td>
                <td style="font-weight:700;">{{ $visit->check_in_time?->format('H:i') ?? '—' }}</td>
                <td style="font-weight:700;">{{ $visit->check_out_time?->format('H:i') ?? '—' }}</td>
                <td class="dur">{{ $dur }}</td>
                <td><span class="badge badge-{{ $visit->status }}">{{ $visit->status === 'active' ? 'Inside' : 'Out' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;padding:20px;color:#94a3b8;">No visits recorded today.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>Apartment Visitors Management System &mdash; Confidential</span>
        <span>Printed by {{ auth()->user()->name }} on {{ now()->format('F d, Y \a\t H:i') }}</span>
    </div>

</body>
</html>
