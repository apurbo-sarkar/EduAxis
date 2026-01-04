@extends('student.app')
@section('content')

<div class="dashboard">
    <aside class="profile-summary">
        <div class="avatar-placeholder">
            {{ collect(explode(' ', $student->full_name))
                ->map(fn($n) => strtoupper($n[0]))
                ->join('') }}
        </div>

        <h2>{{ $student->full_name }}</h2>
        <p class="status-badge">
            {{ $student->academic_status ?? 'Active Student' }}
        </p>

        <div class="stats">
            <div class="stat-item">
                <span>Blood Group</span>
                <strong>{{ $student->blood_group ?? 'N/A' }}</strong>
            </div>
            <div class="stat-item">
                <span>Class</span>
                <strong>{{ $student->student_class ?? 'N/A' }}</strong>
            </div>
        </div>

        <div class="info-list">
            <div class="info-item">
                <small>Admission No</small>
                <p>{{ $student->admission_number }}</p>
            </div>
            <div class="info-item">
                <small>Email</small>
                <p>{{ $student->student_email }}</p>
            </div>
        </div>
    </aside>

    <main class="profile-management">

        <header class="content-header">
            <h1>Profile Management</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form class="edit-form"
              method="POST"
              action="{{ route('student.profile.update') }}">

            @csrf
            @method('PUT')

            <section class="form-section">
                <div class="input-grid">
                    <div class="field">
                        <label>Full Name</label>
                        <input type="text"
                               name="full_name"
                               value="{{ old('full_name', $student->full_name) }}">
                    </div>

                    <div class="field">
                        <label>Email</label>
                        <input type="email"
                               name="student_email"
                               value="{{ old('student_email', $student->student_email) }}">
                    </div>

                    <div class="field">
                        <label>Parent Phone</label>
                        <input type="tel"
                               name="parent1_phone"
                               value="{{ old('parent1_phone', $student->parent1_phone) }}">
                    </div>

                    <div class="field">
                        <label>Gender</label>
                        <input type="text"
                               value="{{ $student->gender }}"
                               disabled>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <h3>Address & Contact</h3>

                <div class="field full-width">
                    <label>Residential Address</label>
                    <input type="text"
                           name="address"
                           value="{{ old('address', $student->address) }}">
                </div>
            </section>

            <div class="form-footer">
                <button type="reset" class="btn-ghost">
                    Reset Changes
                </button>
                <button type="submit" class="btn-save">
                    Update Profile
                </button>
            </div>
        </form>

    </main>
</div>

@endsection

@push('styles')
<style>

    :root {
        --primary: #4f46e5;
        --bg-body: #f8fafc;
        --bg-card: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border: #e2e8f0;
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background-color: var(--bg-body);
        color: var(--text-main);
        margin: 0;
        display: flex;
        justify-content: center;
        min-height: 100vh;
    }

    .dashboard {
        display: grid;
        grid-template-columns: 300px 1fr;
        width: 100%;
        max-width: 1100px;
        margin: 40px 20px;
        background: var(--bg-card);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .profile-summary {
        background-color: #f1f5f9;
        padding: 40px 30px;
        border-right: 1px solid var(--border);
        text-align: center;
    }

    .avatar-placeholder {
        width: 80px;
        height: 80px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: bold;
        margin: 0 auto 20px;
    }

    .status-badge {
        display: inline-block;
        background: #dcfce7;
        color: #166534;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        padding: 20px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin-bottom: 30px;
    }

    .stat-item span {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .info-item {
        text-align: left;
        margin-bottom: 15px;
    }

    .info-item small {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .info-item p { margin: 2px 0; font-weight: 500; }

    .profile-management {
        padding: 40px;
    }

    .content-header h1 { margin: 0 0 20px; font-size: 1.5rem; }

    .tabs {
        display: flex;
        gap: 20px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 30px;
    }

    .tab {
        background: none;
        border: none;
        padding: 10px 0;
        cursor: pointer;
        color: var(--text-muted);
        font-weight: 500;
        border-bottom: 2px solid transparent;
    }

    .tab.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .edit-hint { font-size: 0.8rem; color: var(--primary); font-style: italic; }

    .input-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .field { display: flex; flex-direction: column; }

    .field label {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-muted);
    }

    .field input {
        padding: 10px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.95rem;
    }

    .field input:focus {
        outline: 2px solid #e0e7ff;
        border-color: var(--primary);
    }

    .full-width { grid-column: span 2; }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-save {
        background: var(--primary);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-ghost {
        background: none;
        border: 1px solid var(--border);
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
    }

    @media (max-width: 850px) {
        .dashboard { grid-template-columns: 1fr; }
        .profile-summary { border-right: none; border-bottom: 1px solid var(--border); }
        .input-grid { grid-template-columns: 1fr; }
        .full-width { grid-column: span 1; }
    }

</style>
@endpush

