<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #4f46e5; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f9fafb; font-weight: 600; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 12px; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-in-progress { background-color: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Task Due Reminder</h1>
        <p>Hi {{ $user->name }},</p>
        <p>You have <strong>{{ $tasks->count() }}</strong> task(s) due tomorrow ({{ now()->addDay()->format('M d, Y') }}):</p>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="badge badge-{{ $task->status }}">{{ ucfirst($task->status) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 20px;">Please make sure to complete them on time.</p>
        <p>Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
