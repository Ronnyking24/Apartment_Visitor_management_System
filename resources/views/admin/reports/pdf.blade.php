<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visitor Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        h1 { font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 4px; }
        .sub { font-size: 12px; color: #64748b; margin-bottom: 20px; }
        .meta { display: flex; gap: 30px; margin-bottom: 20px; background: #f8fafc; padding: 12px 16px; border-radius: 6px; }
        .meta-item { }
        .meta-label { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
        .meta-value { font-size: 14px; font-weight: 700; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th { background: #0f1623; color: #fff; padding: 8px 10px; font-size: 10px; text-transform: uppercase; letter-spacing: .5px; font-weight: 600; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; }
        .badge-active    { background: #dcfce7; color: #16a34a; }
        .badge-completed { background: #e0f2fe; color: #0369a1; }
        .badge-pending   { background: #fef9c3; color: #b45309; }
        .badge-rejected  { background: #fee2e2; color: #dc2626; }
        .footer { margin-top: 20px; font-size: 10px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <h1>Apartment Visitors Management System</h1>
    <div class="sub">Visitor Report — Generated {{ now()->format('F d, Y \a\t H:i') }}</div>

    <div class="meta">
        <div class="meta-item">
            <div class="meta-label">Period</div>
            <div class="meta-value">{{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} – {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Total Records</div>
            <div class="meta-value">{{ $visits->count() }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Completed</div>
            <div class="meta-value">{{ $visits->where('status','completed')->count() }}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Active</div>
            <div class="meta-value">{{ $visits->where('status','active')->count() }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Visitor</th>
                <th>National ID</th>
                <th>Tenant</th>
                <th>Apartment</th>
                <th>Purpose</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visits as $i => $visit)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $visit->visitor->full_name }}</td>
                <td>{{ $visit->visitor->national_id ?? '—' }}</td>
                <td>{{ $visit->tenant->user->name ?? '—' }}</td>
                <td>{{ $visit->tenant->apartment->apartment_number ?? '—' }}</td>
                <td>{{ Str::limit($visit->purpose, 30) }}</td>
                <td>{{ $visit->check_in_time?->format('M d, H:i') ?? '—' }}</td>
                <td>{{ $visit->check_out_time?->format('M d, H:i') ?? '—' }}</td>
                <td><span class="badge badge-{{ $visit->status }}">{{ ucfirst($visit->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Apartment Visitors Management System &mdash; Confidential Report</div>
</body>
</html>
