<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #2d3748;
            font-size: 28px;
        }
        .back-btn {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: #c82333;
        }
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #f8f9fa;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            font-weight: 600;
            color: #2d3748;
        }
        tbody tr:hover {
            background: #f8f9fa;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        .action-btns button {
            padding: 8px 15px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-edit {
            background: #ffc107;
            color: white;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        .btn-edit:hover {
            background: #e0a800;
        }
        .btn-delete:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</h1>
            <a href="{{ route('admin.users.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to User Management
            </a>
        </div>

        <div class="content-card">
            @if($teachers->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                <td>{{ $teacher->subject ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $teacher->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ ucfirst($teacher->status ?? 'active') }}
                                    </span>
                                </td>
                                <td class="action-btns">
                                    <button class="btn-edit"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div style="margin-top: 20px;">
                    {{ $teachers->links() }}
                </div>
            @else
                <p style="text-align: center; padding: 40px; color: #718096;">No teachers found.</p>
            @endif
        </div>
    </div>
</body>
</html>