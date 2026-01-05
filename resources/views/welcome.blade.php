<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eduaxis International School</title>
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
        }

        /* Header Styles */
        header {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
        }

        .btn-login {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-login:hover {
            background: #667eea;
            color: white;
        }

        .btn-register {
            background: #667eea;
        }

        .btn-register:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section */
        .hero {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3rem;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-btn {
            padding: 1rem 2.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hero-btn:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .hero-image {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .image-placeholder {
            border-radius: 12px;
            height: 400px;
            overflow: hidden;
        }

        .school-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        /* Why Choose Section */
        .why-choose {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .why-choose h2 {
            text-align: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 3rem;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .card-icon {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .card:nth-child(1) .card-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card:nth-child(2) .card-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .card:nth-child(3) .card-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .card:nth-child(4) .card-icon {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .card:nth-child(5) .card-icon {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .card:nth-child(6) .card-icon {
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        }

        .card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .card p {
            color: #666;
            line-height: 1.6;
            font-size: 1rem;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .modal-header h2 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .modal-header p {
            color: #666;
            font-size: 1rem;
        }

        .role-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .role-btn {
            padding: 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }

        .role-btn:hover {
            border-color: #667eea;
            background: #f0f4ff;
            transform: translateX(5px);
        }

        .role-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .admin-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .teacher-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .student-icon {
            background: #d1fae5;
            color: #059669;
        }

        .modal-close {
            margin-top: 1.5rem;
            text-align: center;
        }

        .close-btn {
            background: transparent;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1rem;
            padding: 0.5rem;
        }

        .close-btn:hover {
            color: #333;
        }

        /* Footer */
        footer {
            background: rgba(0, 0, 0, 0.2);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .nav-links {
                flex-wrap: wrap;
            }

            .logo-text {
                font-size: 1rem;
            }

            .cards-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <div class="logo-circle">E</div>
                <span class="logo-text">Eduaxis International School</span>
            </div>
            <div class="nav-links">
                <button class="nav-btn btn-login" onclick="openModal('login')">Login</button>
                <button class="nav-btn btn-register" onclick="openModal('register')">Register</button>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Eduaxis International School</h1>
            <p>Empowering students with quality education, fostering excellence, and building future leaders through innovative learning approaches.</p>
            <button class="hero-btn" onclick="openModal('register')">Apply for Admission</button>
        </div>
        <div class="hero-image">
            <div class="image-placeholder">
                <img src="images/eduaxis-photo.png" alt="Eduaxis International School" class="school-image">
            </div>
        </div>
    </section>

    <!-- Why Choose Section -->
    <section class="why-choose">
        <h2>Why Choose Eduaxis?</h2>
        <div class="cards-container">
            <div class="card">
                <div class="card-icon">🎓</div>
                <h3>Experienced Faculty</h3>
                <p>Our dedicated team of highly qualified educators brings years of expertise and passion for teaching, ensuring personalized attention and academic excellence for every student.</p>
            </div>

            <div class="card">
                <div class="card-icon">🏫</div>
                <h3>Modern Infrastructure</h3>
                <p>State-of-the-art facilities including smart classrooms, advanced laboratories, well-stocked libraries, and sports complexes designed to provide the best learning environment.</p>
            </div>

            <div class="card">
                <div class="card-icon">💡</div>
                <h3>Innovative Learning</h3>
                <p>We embrace cutting-edge teaching methodologies, digital learning tools, and project-based learning to make education engaging, interactive, and relevant to the modern world.</p>
            </div>

            <div class="card">
                <div class="card-icon">🌍</div>
                <h3>Global Curriculum</h3>
                <p>Our internationally recognized curriculum prepares students for success anywhere in the world, combining academic rigor with practical skills and global perspectives.</p>
            </div>

            <div class="card">
                <div class="card-icon">🤝</div>
                <h3>Holistic Development</h3>
                <p>Beyond academics, we focus on character building, emotional intelligence, leadership skills, and social responsibility to develop well-rounded individuals.</p>
            </div>

            <div class="card">
                <div class="card-icon">⚽</div>
                <h3>Extracurricular Excellence</h3>
                <p>A wide range of sports, arts, music, drama, and club activities ensure students discover and nurture their talents while building teamwork and confidence.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Eduaxis International School. All Rights Reserved.</p>
    </footer>

    <!-- Role Selection Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h2>Select Your Role</h2>
                <p>Choose your role to continue</p>
            </div>
            <div class="role-buttons">
                <button class="role-btn" onclick="redirectTo('admin')">
                    <div class="role-icon admin-icon">👨‍💼</div>
                    <span>Admin</span>
                </button>
                <button class="role-btn" onclick="redirectTo('teacher')">
                    <div class="role-icon teacher-icon">👨‍🏫</div>
                    <span>Teacher</span>
                </button>
                <button class="role-btn" onclick="redirectTo('student')">
                    <div class="role-icon student-icon">👨‍🎓</div>
                    <span>Student</span>
                </button>
            </div>
            <div class="modal-close">
                <button class="close-btn" onclick="closeModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        let currentAction = '';

        function openModal(action) {
            currentAction = action;
            document.getElementById('modalOverlay').classList.add('active');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
            currentAction = '';
        }

        function redirectTo(role) {
            // Redirect based on role and action
            const url = `${role}/${currentAction}`;
            window.location.href = url;
        }

        // Close modal when clicking outside
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>