<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Base styles */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .dashboard-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
        }
        
        /* Header */
        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        h1 {
            color: #2d3748;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        h1 i {
            color: #dc3545;
            margin-right: 10px;
        }
        
        /* Grid layout for features */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        
        /* Feature card styling */
        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #dc3545, #ff6b6b);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .card:hover::before {
            transform: scaleX(1);
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.2);
            border-color: #dc3545;
        }
        .card i {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
            display: block;
        }
        .card h3 {
            margin: 15px 0;
            font-size: 22px;
            color: #2d3748;
            font-weight: 600;
        }
        .card p {
            font-size: 14px;
            color: #718096;
            margin-bottom: 25px;
            line-height: 1.6;
            min-height: 60px;
        }
        
        /* Link styling */
        .card a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        .card a:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }
        
        /* Logout button styling */
        .logout-btn {
            text-align: center;
            margin-top: 40px;
        }
        .logout-btn button {
            padding: 12px 30px;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .logout-btn button:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }
        
        /* No features message */
        .no-features {
            text-align: center;
            margin-top: 40px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .no-features i {
            font-size: 60px;
            color: #f0ad4e;
            margin-bottom: 20px;
        }
        .no-features p {
            color: #2d3748;
            font-size: 16px;
            margin: 10px 0;
        }
        .no-features code {
            background: #f7fafc;
            padding: 4px 8px;
            border-radius: 4px;
            color: #dc3545;
            font-family: 'Courier New', monospace;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px 15px;
            }
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            h1 {
                font-size: 24px;
            }
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1><i class="fas fa-chart-line"></i>Welcome, {{ $admin_name ?? 'Admin' }}</h1>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" style="padding: 10px 25px; margin: 0;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
       
        @if (isset($features) && count($features) > 0)
            <div class="grid">
                @foreach($features ?? [] as $feature)
                    {{-- This line deletes the fee module from the display --}}
                    @if(isset($feature['route_name']) && $feature['route_name'] == 'admin.fee.index') @continue @endif

                    <div class="card">
                        <i class="{{ $feature['icon'] ?? 'fas fa-cog' }}"></i>
                        <h3>{{ $feature['title'] ?? 'Feature' }}</h3>
                        <p>{{ $feature['description'] ?? 'No description available.' }}</p>
                        <a href="{{ route($feature['route_name']) }}">
                            <i class="fas fa-arrow-right"></i> Access Module
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-features">
                <i class="fas fa-exclamation-triangle"></i>
                <p style="font-weight: bold; font-size: 18px;">No dashboard features found!</p>
                <p>Please check the <code>getDashboardFeatures()</code> method in your AdminDashboardController.</p>
            </div>
        @endif
    </div>
</body>
</html>