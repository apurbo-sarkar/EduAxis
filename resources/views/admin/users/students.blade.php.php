<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
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
            <h1><i class="fas fa-user-graduate"></i> Manage Students</h1>
            <a href="{{ route('admin.users.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to User Management
            </a>
        </div>

        <div class="content-card">
            @if($students->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admission Number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->admission_number }}</td>
                                <td>
                                    <span class="badge {{ $student->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                        {{ ucfirst($student->status ?? 'active') }}
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
                    {{ $students->links() }}
                </div>
            @else
                <p style="text-align: center; padding: 40px; color: #718096;">No students found.</p>
            @endif
        </div>
    </div>
</body>
</html>