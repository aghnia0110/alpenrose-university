
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpenrose University</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #102747;
            --gold: #c39a48;
            --cream: #f8f5ee;
            --white: #ffffff;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--cream);
            color: var(--navy);
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Cormorant Garamond', serif;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(255,255,255,0.98);
            padding: 15px 0;
        }

        .navbar-brand {
            color: var(--navy);
            font-family: 'Cormorant Garamond', serif;
            font-size: 27px;
            font-weight: 700;
            line-height: 1;
        }

        .navbar-brand i {
            color: var(--gold);
            font-size: 36px;
        }

        .nav-link {
            color: var(--navy);
            font-size: 12px;
            font-weight: 700;
            margin: 0 9px;
        }

        .nav-link:hover {
            color: var(--gold);
        }

        .btn-login {
            background: var(--navy);
            color: white;
            border-radius: 30px;
            padding: 11px 25px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: var(--gold);
            color: white;
        }

        /* HERO */
        .hero {
            min-height: 590px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(90deg,
                rgba(248,245,238,0.96),
                rgba(248,245,238,0.80) 40%,
                rgba(16,39,71,0.05)),
                url('https://images.unsplash.com/photo-1562774053-701939374585?w=1800');
            background-position: center;
            background-size: cover;
        }

        .hero-content {
            max-width: 650px;
            padding: 70px 0;
        }

        .hero-label, .section-label {
            color: #a47b31;
            letter-spacing: 2px;
            font-size: 12px;
            font-weight: 700;
        }

        .hero h1 {
            font-size: clamp(48px, 6vw, 76px);
            line-height: 0.98;
            font-weight: 700;
            margin: 20px 0;
        }

        .hero p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-style: italic;
        }

        .btn-gold {
            background: var(--gold);
            color: white;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
        }

        .btn-gold:hover {
            background: var(--navy);
            color: white;
        }

        /* STATISTICS */
        .stats {
            background: white;
            padding: 28px 0;
        }

        .stat-item {
            border-right: 1px solid #ddd3c2;
        }

        .stat-item:last-child {
            border: none;
        }

        .stat-item i {
            font-size: 34px;
        }

        .stat-item h3 {
            font-size: 27px;
            font-weight: 700;
            margin: 0;
        }

        .stat-item p {
            font-size: 12px;
            margin: 0;
        }

        /* GENERAL SECTION */
        .section-title {
            font-size: 43px;
            font-weight: 700;
        }

        .about {
            padding: 80px 0;
        }

        .about-img {
            width: 100%;
            height: 360px;
            object-fit: cover;
            border-radius: 8px;
        }

        .about-text {
            line-height: 1.9;
            font-size: 14px;
        }

        /* PROGRAM */
        .program {
            padding: 80px 0;
            background: #eee9df;
        }

        .program-card {
            background: white;
            border: 1px solid #e4ded3;
            border-radius: 10px;
            padding: 28px;
            height: 100%;
            transition: 0.3s;
        }

        .program-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(16,39,71,0.12);
        }

        .program-icon {
            font-size: 38px;
            color: var(--gold);
        }

        .program-card h4 {
            font-weight: 700;
            font-size: 25px;
            margin-top: 15px;
        }

        .program-card p {
            font-size: 13px;
            line-height: 1.8;
            color: #555;
        }

        .program-card h6 {
            font-weight: 700;
            font-size: 12px;
            margin-top: 18px;
            color: var(--navy);
        }

        .program-card ul {
            font-size: 12px;
            color: #555;
            padding-left: 18px;
        }

        .program-code {
            color: #a47b31;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* FACILITIES */
        .campus {
            padding: 80px 0;
        }

        .campus-img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 8px;
        }

        .campus-card h4 {
            font-weight: 700;
            margin-top: 15px;
        }

        /* CTA */
        .cta {
            background:
                linear-gradient(rgba(16,39,71,.9), rgba(16,39,71,.9)),
                url('https://images.unsplash.com/photo-1511818966892-d7d671e672a2?w=1400');
            background-size: cover;
            background-position: center;
            padding: 75px 20px;
            text-align: center;
            color: white;
        }

        .cta h2 {
            font-size: 45px;
            font-style: italic;
        }

        /* FOOTER */
        footer {
            background: #0b1e36;
            color: white;
            padding: 40px 0 20px;
        }

        footer p {
            color: #c9d0dc;
            font-size: 13px;
        }

        footer a {
            color: #d9c49a;
            text-decoration: none;
        }

        @media(max-width:768px) {
            .hero {
                min-height: 520px;
                background-position: 60% center;
            }

            .hero h1 {
                font-size: 48px;
            }

            .stat-item {
                border: none;
                margin-bottom: 20px;
            }

            .section-title {
                font-size: 35px;
            }

            .about-img {
                height: 260px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2" href="#home">
            <i class="bi bi-shield-fill-check"></i>
            <span>ALPENROSE<br>
            <small style="font-size:14px; letter-spacing:3px;">UNIVERSITY</small></span>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="#home">HOME</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">ABOUT</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#program">PROGRAMS</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#campus">CAMPUS LIFE</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">CONTACT</a>
                </li>

                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a href="login.html" class="btn btn-login">
                        <i class="bi bi-person-fill"></i> Login
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>


<!-- HERO -->
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">

            <div class="hero-label">
                KNOWLEDGE · INNOVATION · EXCELLENCE
            </div>

            <h1>
                Welcome to<br>
                Alpenrose<br>
                University
            </h1>

            <p>
                A prestigious university in the heart of Europe,
                shaping a brighter future together.
            </p>

            <a href="#about" class="btn btn-login mt-3">
                Explore More <i class="bi bi-arrow-right"></i>
            </a>

        </div>
    </div>
</section>


<!-- STATISTICS -->
<section class="stats">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-3 stat-item">
                <i class="bi bi-mortarboard-fill"></i>
                <h3>5,000+</h3>
                <p>Active Students</p>
            </div>

            <div class="col-md-3 stat-item">
                <i class="bi bi-people-fill"></i>
                <h3>500+</h3>
                <p>Professional Lecturers</p>
            </div>

            <div class="col-md-3 stat-item">
                <i class="bi bi-bank"></i>
                <h3>30+</h3>
                <p>Years of Excellence</p>
            </div>

            <div class="col-md-3 stat-item">
                <i class="bi bi-globe"></i>
                <h3>Global Network</h3>
                <p>Worldwide Collaboration</p>
            </div>

        </div>
    </div>
</section>


<!-- ABOUT -->
<section class="about" id="about">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-5">
                <img
                    src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=900"
                    alt="Mahasiswa universitas"
                    class="about-img">
            </div>

            <div class="col-lg-7">

                <div class="section-label">ABOUT OUR UNIVERSITY</div>

                <h2 class="section-title">
                    Building a Better Future
                </h2>

                <p class="about-text">
                    Alpenrose University is an international-inspired
                    institution committed to providing excellent
                    education, fostering innovation, and empowering
                    students to reach their full potential.
                </p>

                <p class="about-text">
                    Through academic excellence, modern facilities,
                    and global collaboration, we prepare students
                    to become future leaders.
                </p>

                <a href="#program" class="btn btn-outline-dark rounded-pill px-4">
                    Discover More <i class="bi bi-arrow-right"></i>
                </a>

            </div>
        </div>
    </div>
</section>


<!-- PROGRAM STUDI -->
<section class="program" id="program">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-label">ACADEMIC EXCELLENCE</div>
            <h2 class="section-title">Our Academic Programs</h2>
            <p>Discover your passion and build your future with us.</p>
        </div>

        <div class="row g-4">

            <!-- COMPUTER SCIENCE -->
            <div class="col-lg-6">
                <div class="program-card">

                    <div class="program-code">FACULTY OF TECHNOLOGY</div>
                    <i class="bi bi-laptop program-icon"></i>

                    <h4>Computer Science</h4>

                    <p>
                        Program studi yang mempelajari ilmu komputer,
                        teknologi digital, pemrograman, dan pengembangan
                        perangkat lunak untuk menghadapi perkembangan
                        teknologi global.
                    </p>

                    <h6>MATA KULIAH UTAMA:</h6>
                    <ul>
                        <li>Programming Fundamentals</li>
                        <li>Web and Mobile Development</li>
                        <li>Database Management</li>
                        <li>Artificial Intelligence</li>
                        <li>Cyber Security</li>
                    </ul>

                    <h6>PROSPEK KARIER:</h6>
                    <p>Software Developer, Web Developer, Data Analyst, IT Specialist.</p>

                </div>
            </div>

            <!-- BUSINESS -->
            <div class="col-lg-6">
                <div class="program-card">

                    <div class="program-code">FACULTY OF BUSINESS</div>
                    <i class="bi bi-graph-up-arrow program-icon"></i>

                    <h4>Business Management</h4>

                    <p>
                        Program studi yang berfokus pada pengelolaan
                        organisasi, strategi bisnis, kepemimpinan,
                        pemasaran, serta pengembangan kewirausahaan.
                    </p>

                    <h6>MATA KULIAH UTAMA:</h6>
                    <ul>
                        <li>Business Administration</li>
                        <li>Marketing Management</li>
                        <li>Financial Management</li>
                        <li>Human Resource Management</li>
                        <li>Entrepreneurship</li>
                    </ul>

                    <h6>PROSPEK KARIER:</h6>
                    <p>Business Manager, Entrepreneur, Marketing Specialist, Business Analyst.</p>

                </div>
            </div>

            <!-- LAW -->
            <div class="col-lg-6">
                <div class="program-card">

                    <div class="program-code">FACULTY OF LAW</div>
                    <i class="bi bi-bank program-icon"></i>

                    <h4>Law</h4>

                    <p>
                        Program studi yang mempelajari sistem hukum,
                        peraturan perundang-undangan, hak asasi manusia,
                        serta prinsip keadilan dalam masyarakat.
                    </p>

                    <h6>MATA KULIAH UTAMA:</h6>
                    <ul>
                        <li>Constitutional Law</li>
                        <li>Criminal Law</li>
                        <li>Civil Law</li>
                        <li>International Law</li>
                        <li>Human Rights</li>
                    </ul>

                    <h6>PROSPEK KARIER:</h6>
                    <p>Legal Consultant, Legal Officer, Researcher, Corporate Legal Staff.</p>

                </div>
            </div>

            <!-- DESIGN -->
            <div class="col-lg-6">
                <div class="program-card">

                    <div class="program-code">FACULTY OF ARTS & DESIGN</div>
                    <i class="bi bi-palette-fill program-icon"></i>

                    <h4>Design & Arts</h4>

                    <p>
                        Program studi yang mengembangkan kreativitas,
                        kemampuan visual, komunikasi desain, seni,
                        dan inovasi dalam dunia industri kreatif.
                    </p>

                    <h6>MATA KULIAH UTAMA:</h6>
                    <ul>
                        <li>Graphic Design</li>
                        <li>Digital Illustration</li>
                        <li>Photography</li>
                        <li>UI/UX Design</li>
                        <li>Visual Communication</li>
                    </ul>

                    <h6>PROSPEK KARIER:</h6>
                    <p>Graphic Designer, UI/UX Designer, Illustrator, Creative Director.</p>

                </div>
            </div>

        </div>
    </div>
</section>


<!-- CAMPUS LIFE -->
<section class="campus" id="campus">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-label">EXPERIENCE OUR CAMPUS</div>
            <h2 class="section-title">Campus Life</h2>
            <p>Discover a beautiful environment for learning and growing.</p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=800"
                    class="campus-img" alt="Library">

                <h4 class="mt-3">University Library</h4>
                <p>Modern library with extensive academic resources.</p>
            </div>

            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1564981797816-1043664bf78d?w=800"
                    class="campus-img" alt="Campus Building">

                <h4 class="mt-3">Historic Architecture</h4>
                <p>European-inspired architecture and beautiful surroundings.</p>
            </div>

            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800"
                    class="campus-img" alt="Student Activities">

                <h4 class="mt-3">Student Community</h4>
                <p>A supportive community for learning and collaboration.</p>
            </div>

        </div>
    </div>
</section>


<!-- CTA -->
<section class="cta">
    <div class="container">

        <h2>Together Toward a Greater Tomorrow</h2>

        <p class="mt-3">
            Your journey to excellence begins here.
            Become part of Alpenrose University.
        </p>

        <a href="login.html" class="btn btn-gold mt-3">
            <i class="bi bi-person-fill"></i>
            Login Now <i class="bi bi-arrow-right"></i>
        </a>

    </div>
</section>


<!-- FOOTER -->
<footer id="contact">
    <div class="container">

        <div class="row g-4">

            <div class="col-md-5">
                <h3>ALPENROSE UNIVERSITY</h3>
                <p>
                    Knowledge, Innovation, Excellence.
                    Building a brighter future through education.
                </p>
            </div>

            <div class="col-md-3">
                <h5>Quick Links</h5>
                <p><a href="#home">Home</a></p>
                <p><a href="#about">About Us</a></p>
                <p><a href="#program">Programs</a></p>
            </div>

            <div class="col-md-4">
                <h5>Contact Us</h5>
                <p><i class="bi bi-envelope"></i> info@alpenrose.edu</p>
                <p><i class="bi bi-telephone"></i> +41 123 456 789</p>
                <p><i class="bi bi-geo-alt"></i> Switzerland, Europe</p>
            </div>

        </div>

        <hr>

        <div class="text-center">
            <p class="mb-0">
                © 2026 Alpenrose University. All Rights Reserved.
            </p>
        </div>

    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>