<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; color: #1e293b; margin: 0; background: #ffffff; }
        .header { background: #0f172a; color: #ffffff; padding: 60px 50px; }
        .badge { background: #6366f1; color: white; padding: 4px 12px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .title { font-size: 32px; font-weight: 900; margin-top: 15px; text-transform: uppercase; letter-spacing: -1px; }
        .meta { font-size: 11px; color: #94a3b8; margin-top: 5px; text-transform: uppercase; }
        .container { padding: 50px; }
        .section-label { color: #6366f1; font-size: 10px; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; }
        .content { font-size: 14px; line-height: 1.8; color: #334155; text-align: justify; }
        .footer { position: fixed; bottom: 0; width: 100%; background: #f8fafc; padding: 20px; text-align: center; font-size: 9px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="header">
        <span class="badge">{{ $weapon }} Division</span>
        <div class="title">{{ $title }}</div>
        <div class="meta">Tactical Briefing • Generated on {{ $date }}</div>
    </div>

    <div class="container">
        <div class="section-label">Target Arena: {{ $event_name }}</div>
        <div class="content">
            {!! nl2br(e($content)) !!}
        </div>
    </div>

    <div class="footer">
        PROPERTY OF ELITE CLUB FENCING ACADEMY (ECFA) • ARSENAL PROTOCOL ENFORCED
    </div>
</body>
</html>
