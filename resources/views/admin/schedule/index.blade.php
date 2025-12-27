<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Schedule Management - Admin Portal</title>
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
            padding: 20px;
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
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #2d3748;
            font-size: 28px;
            font-weight: 600;
        }

        .header h1 i {
            color: #dc3545;
            margin-right: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 25px;
            margin-bottom: 25px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header h2 {
            color: #2d3748;
            font-size: 22px;
            font-weight: 600;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }

        .tab {
            padding: 12px 24px;
            background: transparent;
            border: none;
            color: #718096;
            font-weight: 600;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab:hover {
            color: #dc3545;
        }

        .tab.active {
            color: #dc3545;
            border-bottom-color: #dc3545;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #dc3545;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: 100px repeat(7, 1fr);
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        .grid-header, .grid-cell {
            padding: 12px 8px;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
            min-height: 80px;
        }

        .grid-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .time-label {
            background: #f7fafc;
            color: #2d3748;
            font-weight: 600;
            font-size: 14px;
        }

        .course-event {
            background: #eef5fb;
            border-left: 4px solid #4682b4;
            border-radius: 6px;
            padding: 10px;
            margin: 4px;
            text-align: left;
            font-size: 13px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .course-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .event-title {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #2d3748;
        }

        .event-time, .event-location, .event-instructor {
            display: block;
            color: #718096;
            line-height: 1.4;
            font-size: 12px;
        }

        .event-actions {
            margin-top: 8px;
            display: flex;
            gap: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .table th {
            background: #f7fafc;
            font-weight: 600;
            color: #2d3748;
        }

        .table tbody tr:hover {
            background: #f7fafc;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-header h3 {
            color: #2d3748;
            font-size: 22px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #718096;
        }

        .close-modal:hover {
            color: #dc3545;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #718096;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #cbd5e0;
        }

        @media (max-width: 768px) {
            .schedule-grid {
                grid-template-columns: 80px 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-calendar-alt"></i>Schedule Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="tabs">
                <button class="tab active" data-tab="schedule-view">
                    <i class="fas fa-calendar"></i> View Schedules
                </button>
                <button class="tab" data-tab="manage-classes">
                    <i class="fas fa-school"></i> Manage Classes
                </button>
                <button class="tab" data-tab="manage-subjects">
                    <i class="fas fa-book"></i> Manage Subjects
                </button>
            </div>

            <!-- Schedule View Tab -->
            <div class="tab-content active" id="schedule-view">
                <div class="card-header">
                    <h2>Weekly Schedule</h2>
                    <button class="btn btn-primary" onclick="openScheduleModal()">
                        <i class="fas fa-plus"></i> Add New Schedule
                    </button>
                </div>

                <div class="form-group">
                    <label for="class-select">Select Class:</label>
                    <select id="class-select" class="form-control" onchange="loadSchedule()">
                        <option value="">-- Select a class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="schedule-container">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>Please select a class to view its schedule</p>
                    </div>
                </div>
            </div>

            <!-- Manage Classes Tab -->
            <div class="tab-content" id="manage-classes">
                <div class="card-header">
                    <h2>Classes</h2>
                    <button class="btn btn-primary" onclick="openClassModal()">
                        <i class="fas fa-plus"></i> Add New Class
                    </button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                            <tr>
                                <td><strong>{{ $class->name }}</strong></td>
                                <td>{{ $class->description ?? 'N/A' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.schedule.class.destroy', $class->class_id) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this class?')" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: #718096;">
                                    No classes found. Create your first class!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Manage Subjects Tab -->
            <div class="tab-content" id="manage-subjects">
                <div class="card-header">
                    <h2>Subjects</h2>
                    <button class="btn btn-primary" onclick="openSubjectModal()">
                        <i class="fas fa-plus"></i> Add New Subject
                    </button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr>
                                <td><strong>{{ $subject->name }}</strong></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.schedule.subject.destroy', $subject->subject_id) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this subject?')" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align: center; color: #718096;">
                                    No subjects found. Create your first subject!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div class="modal" id="schedule-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="schedule-modal-title">Add New Schedule</h3>
                <button class="close-modal" onclick="closeScheduleModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.schedule.store') }}" id="schedule-form">
                @csrf
                <input type="hidden" name="_method" value="POST" id="schedule-method">
                
                <div class="form-group">
                    <label for="modal-class">Class:</label>
                    <select name="class_id" id="modal-class" class="form-control" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="modal-subject">Subject:</label>
                    <select name="subject_id" id="modal-subject" class="form-control" required>
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="modal-day">Day:</label>
                    <select name="day_name" id="modal-day" class="form-control" required>
                        <option value="">-- Select Day --</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="modal-start-time">Start Time:</label>
                        <input type="time" name="start_time" id="modal-start-time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="modal-end-time">End Time:</label>
                        <input type="time" name="end_time" id="modal-end-time" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="modal-location">Location (Room):</label>
                    <input type="text" name="location" id="modal-location" class="form-control" 
                           placeholder="e.g., Room 101" required>
                </div>

                <div class="form-group">
                    <label for="modal-teacher">Teacher Name:</label>
                    <input type="text" name="teacher_name" id="modal-teacher" class="form-control" 
                           placeholder="e.g., Mr. Ali" required>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success" style="flex: 1;">
                        <i class="fas fa-save"></i> Save Schedule
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeScheduleModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Class Modal -->
    <div class="modal" id="class-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Class</h3>
                <button class="close-modal" onclick="closeClassModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.schedule.class.store') }}">
                @csrf
                
                <div class="form-group">
                    <label for="class-name">Class Name:</label>
                    <input type="text" name="name" id="class-name" class="form-control" 
                           placeholder="e.g., Grade 10, Class A" required>
                </div>

                <div class="form-group">
                    <label for="class-description">Description:</label>
                    <textarea name="description" id="class-description" class="form-control" 
                              rows="3" placeholder="Optional description"></textarea>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success" style="flex: 1;">
                        <i class="fas fa-save"></i> Save Class
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeClassModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal" id="subject-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Subject</h3>
                <button class="close-modal" onclick="closeSubjectModal()">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.schedule.subject.store') }}">
                @csrf
                
                <div class="form-group">
                    <label for="subject-name">Subject Name:</label>
                    <input type="text" name="name" id="subject-name" class="form-control" 
                           placeholder="e.g., Mathematics, English" required>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success" style="flex: 1;">
                        <i class="fas fa-save"></i> Save Subject
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeSubjectModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Load schedule for selected class
        function loadSchedule() {
            const classId = document.getElementById('class-select').value;
            const container = document.getElementById('schedule-container');

            if (!classId) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>Please select a class to view its schedule</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = '<div class="empty-state"><i class="fas fa-spinner fa-spin"></i><p>Loading...</p></div>';

            fetch(`{{ route('admin.schedule.get-schedules') }}?class_id=${classId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                displaySchedule(data.schedules);
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-triangle"></i><p>Error loading schedule</p></div>';
            });
        }

        function displaySchedule(schedules) {
            const container = document.getElementById('schedule-container');
            
            if (schedules.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-calendar-plus"></i>
                        <p>No schedules found for this class. Add your first schedule!</p>
                    </div>
                `;
                return;
            }

            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const timeSlots = [...new Set(schedules.map(s => s.start_time))].sort();

            let html = '<div class="schedule-grid">';
            
            // Header row
            html += '<div class="grid-header"></div>';
            days.forEach(day => {
                html += `<div class="grid-header">${day}</div>`;
            });

            // Time slot rows
            timeSlots.forEach(time => {
                const timeFormatted = formatTime(time);
                html += `<div class="grid-header time-label">${timeFormatted}</div>`;
                
                days.forEach(day => {
                    const daySchedules = schedules.filter(s => s.day_name === day && s.start_time === time);
                    html += '<div class="grid-cell">';
                    
                    daySchedules.forEach(schedule => {
                        html += `
                            <div class="course-event">
                                <span class="event-title">${schedule.subject.name}</span>
                                <span class="event-time">${formatTime(schedule.start_time)} - ${formatTime(schedule.end_time)}</span>
                                <span class="event-location">${schedule.location}</span>
                                <span class="event-instructor">${schedule.teacher_name}</span>
                                <div class="event-actions">
                                    <button class="btn btn-warning btn-sm" onclick="editSchedule(${schedule.schedule_id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSchedule(${schedule.schedule_id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                });
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function formatTime(time) {
            const [hours, minutes] = time.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        // Modal functions
        function openScheduleModal() {
            const classSelect = document.getElementById('class-select');
            if (classSelect.value) {
                document.getElementById('modal-class').value = classSelect.value;
            }
            document.getElementById('schedule-modal').classList.add('active');
        }

        function closeScheduleModal() {
            document.getElementById('schedule-modal').classList.remove('active');
            document.getElementById('schedule-form').reset();
        }

        function openClassModal() {
            document.getElementById('class-modal').classList.add('active');
        }

        function closeClassModal() {
            document.getElementById('class-modal').classList.remove('active');
        }

        function openSubjectModal() {
            document.getElementById('subject-modal').classList.add('active');
        }

        function closeSubjectModal() {
            document.getElementById('subject-modal').classList.remove('active');
        }

        function editSchedule(scheduleId) {
            window.location.href = `{{ url('admin/schedule/edit') }}/${scheduleId}`;
        }

        function deleteSchedule(scheduleId) {
            if (confirm('Are you sure you want to delete this schedule?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin/schedule') }}/${scheduleId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>
</html>