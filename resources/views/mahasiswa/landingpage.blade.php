<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLearn - Platform E-Learning Mahasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #667eea;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .hero {
            margin-top: 80px;
            min-height: 90vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem 5%;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .hero-content {
            flex: 1;
            color: white;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.2s backwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 1s ease 0.4s backwards;
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeInRight 1s ease;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero-illustration {
            width: 100%;
            max-width: 500px;
            animation: float 3s ease-in-out infinite;
        }

        .features {
            padding: 5rem 5%;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }

        .feature-card h3 {
            margin-bottom: 0.5rem;
            color: #333;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        .stats {
            padding: 4rem 5%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h2 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .cta {
            padding: 5rem 5%;
            text-align: center;
            background: white;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .cta p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        footer {
            background: #2d3748;
            color: white;
            padding: 2rem 5%;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                display: none;
            }

            .hero-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">EduLearn</div>
        <ul class="nav-links">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#features">Fitur</a></li>
            <li><a href="#courses">Kursus</a></li>
            <li><a href="#about">Tentang</a></li>
        </ul>
        <button class="btn-primary">Masuk</button>
    </nav>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Belajar Tanpa Batas</h1>
            <p>Platform e-learning modern untuk mahasiswa Indonesia. Akses ribuan materi kuliah, video pembelajaran, dan ujian online kapan saja, di mana saja.</p>
            <div class="hero-buttons">
                <button class="btn-primary">Mulai Belajar</button>
                <button class="btn-secondary">Lihat Demo</button>
            </div>
        </div>
        <div class="hero-image">
            <svg class="hero-illustration" viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                <rect x="50" y="50" width="400" height="300" rx="20" fill="white" opacity="0.9"/>
                <rect x="70" y="70" width="150" height="120" rx="10" fill="#667eea" opacity="0.3"/>
                <rect x="240" y="70" width="190" height="60" rx="10" fill="#764ba2" opacity="0.3"/>
                <rect x="240" y="145" width="190" height="45" rx="10" fill="#667eea" opacity="0.2"/>
                <circle cx="250" cy="280" r="40" fill="#667eea" opacity="0.5"/>
                <circle cx="350" cy="280" r="40" fill="#764ba2" opacity="0.5"/>
                <path d="M 100 250 Q 250 200 400 250" stroke="#667eea" stroke-width="3" fill="none" opacity="0.5"/>
            </svg>
        </div>
    </section>

    <section class="features" id="features">
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>Materi Lengkap</h3>
                <p>Akses ribuan materi kuliah dari berbagai jurusan dan mata kuliah yang tersedia 24/7.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎥</div>
                <h3>Video Pembelajaran</h3>
                <p>Pembelajaran interaktif dengan video berkualitas tinggi dari dosen berpengalaman.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✍️</div>
                <h3>Ujian Online</h3>
                <p>Sistem ujian online yang terintegrasi dengan penilaian otomatis dan feedback langsung.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Forum Diskusi</h3>
                <p>Berkolaborasi dengan mahasiswa lain dan berdiskusi dengan dosen kapan saja.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Tracking Progress</h3>
                <p>Pantau perkembangan belajar Anda dengan dashboard analitik yang komprehensif.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Sertifikat</h3>
                <p>Dapatkan sertifikat digital untuk setiap kursus yang berhasil diselesaikan.</p>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <h2>50K+</h2>
                <p>Mahasiswa Aktif</p>
            </div>
            <div class="stat-item">
                <h2>500+</h2>
                <p>Mata Kuliah</p>
            </div>
            <div class="stat-item">
                <h2>100+</h2>
                <p>Dosen Expert</p>
            </div>
            <div class="stat-item">
                <h2>95%</h2>
                <p>Tingkat Kepuasan</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Siap Memulai Perjalanan Belajar?</h2>
        <p>Bergabunglah dengan ribuan mahasiswa yang sudah merasakan kemudahan belajar dengan EduLearn</p>
        <button class="btn-primary" style="padding: 1rem 3rem; font-size: 1.1rem;">Daftar Sekarang Gratis</button>
    </section>

    <footer>
        <p>&copy; 2024 EduLearn. Platform E-Learning untuk Mahasiswa Indonesia.</p>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });

        // Feature cards animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>