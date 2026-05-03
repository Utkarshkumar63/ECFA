<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #0f172a; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .badge { font-weight: bold; color: #2563eb; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $event->title }}</h2>
        <p>Type: <strong>{{ strtoupper($status ?? 'ALL REGISTERED') }}</strong> | Date: {{ $date }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Athlete</th>
                <th>Contact</th>
                <th>Category</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->athletes as $player)
            <tr>
                <td>{{ $player->name }} ({{ $player->gender }})</td>
                <td>{{ $player->phone }}</td>
                <td>{{ $player->category }} ({{ $player->age_group }})</td>
                <td>{{ $player->city }}</td>
                <td>{{ strtoupper($player->pivot->status ?? 'waiting') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
