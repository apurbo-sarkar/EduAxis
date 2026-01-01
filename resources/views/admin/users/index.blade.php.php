<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
        .error-alert {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .error-alert i {
            margin-right: 10px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card i {
            font-size: 40px;
            margin-bottom: 15px;
        }
        .stat-card.students i {
            color: #3498db;
        }
        .stat-card.teachers i {
            color: #e74c3c;
        }
        .stat-card.active-students i {
            color: #2ecc71;
        }
        .stat-card.active-teachers i {
            color: #f39c12;
        }
        .stat-card h3 {
            color: #2d3748;
            margin: 10px 0;
            font-size: 32px;
            font-weight: bold;
        }
        .stat-card p {
            color: #718096;
            font-size: 14px;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        .action-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s;
        }
        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        .action-card i {
            font-size: 50px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .action-card h3 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 22px;
        }
        .action-card p {
            color: #718096;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .action-card a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .action-card a:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-users"></i> User Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(isset($error))
            <div class="error-alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Error:</strong> {{ $error }}
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card students">
                <i class="fas fa-user-graduate"></i>
                <h3>{{ $totalStudents ?? 0 }}</h3>
                <p>Total Students</p>
            </div>
            <div class="stat-card teachers">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>{{ $totalTeachers ?? 0 }}</h3>
                <p>Total Teachers</p>
            </div>
            <div class="stat-card active-students">
                <i class="fas fa-check-circle"></i>
                <h3>{{ $activeStudents ?? 0 }}</h3>
                <p>Active Students</p>
            </div>
            <div class="stat-card active-teachers">
                <i class="fas fa-user-check"></i>
                <h3>{{ $activeTeachers ?? 0 }}</h3>
                <p>Active Teachers</p>
            </div>
        </div>

        <div class="actions-grid">
            <div class="action-card">
                <i class="fas fa-user-graduate"></i>
                <h3>Manage Students</h3>
                <p>View, add, edit, or delete student accounts. Manage student profiles and information.</p>
                <a href="{{ route('admin.users.students') }}">
                    <i class="fas fa-arrow-right"></i> Manage Students
                </a>
            </div>

            <div class="action-card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Manage Teachers</h3>
                <p>View, add, edit, or delete teacher accounts. Manage teacher profiles and assignments.</p>
                <a href="{{ route('admin.users.teachers') }}">
                    <i class="fas fa-arrow-right"></i> Manage Teachers
                </a>
            </div>
        </div>
    </div>
</body>
</html>