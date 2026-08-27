<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BindTech Faculty Workload Management System</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet"></style>

<!-- STYLES -->
    <style>
        /* === MODIFIED: GLOBAL LAYOUT & BACKGROUND === */
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/food-bg.jpg') no-repeat center center/cover;
            background-attachment: fixed;
            color: #fff;
        }

        /* Dark overlay as seen in Image 2 */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); 
            z-index: 0;
        }

        /* === MODIFIED: LOGO STYLE === */
        /* === MODIFIED: LOGO ALIGNMENT + TIGHT SPACING === */

        .logo-container {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            line-height: 0.15; /* tighter overall spacing */
            text-align: left; /* force left alignment */
        }

        .logo-main {
            color: #ff6600;
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 900;
            display: block;
            margin: 0;              /* remove any default spacing */
            margin-bottom: -10px;    /* 🔥 pulls subtitle upward (tight/kiss effect) */
        }

        .logo-sub {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;              /* remove spacing */
        }
                /* === MODIFIED: HERO SECTION (IMAGE 1) === */
        
        .hero-section {
            position: relative;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            z-index: 1;
            padding: 20px;
        }

        .header-logo {
            position: absolute;
            top: 30px;
            left: 30px;
            font-size: 3rem;
            font-weight: 800;
            color: #ff0000; /* Matching 'logo' text color in image */
            margin: 0;
            line-height: 1;
        }


        .hero-title {
            font-family: sans-serif ;
            font-size: clamp(2rem, 4vw, 4.5rem);
            font-weight: 800;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            margin-bottom: 60px;
        }

        /* === MODIFIED: ORDER BUTTON DESIGN === */
        .btn-order-now {
            background: linear-gradient(135deg, #ff7a18, #ff3d00); /* food-like orange/red */
            color: #fff;
            font-weight: 700;
            font-size: 1.6rem;
            padding: 16px 50px;
            border-radius: 20px; /* less oval, more modern */
            text-decoration: none;
            border: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            transition: 0.3s;
            display: inline-block;
        }

        .btn-order-now:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 25px rgba(0,0,0,0.4);
        }

        /* === MODIFIED: SVG ARROW STYLE === */

        .scroll-down-btn {
            position: absolute;
            bottom: 40px;
            width: 60px;  /* controls size */
            height: 60px;
            cursor: pointer;
            transition: 0.3s;
            opacity: 0; /* hidden by default */
        }

        /* Show only on hover */
        .hero-section:hover .scroll-down-btn {
            opacity: 1;
            animation: bounce 1.5s infinite;
        }

        /* SVG inside */
        .arrow-svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        /* Hover effect */
        .scroll-down-btn:hover .arrow-svg path {
            stroke: #ff7a18; /* food color on hover */
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }

        /* === MODIFIED: LOGIN CONTAINER (IMAGE 2) === */
        .login-section {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .custom-card {
            border: none;
            border-radius: 30px; /* More rounded as per Image 2 */
            background: #f8f5f2; /* Off-white background from image */
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }

        .brand-title {
            font-weight: 800;
            color: #000000;
            font-size: 2.2rem;
        }

        /* Button Styles to match Image 2 */
        .btn-custom {
            background: linear-gradient(135deg, #ff7a18, #ff3d00); /* Solid deep red from image */
            color: #fff;
            font-weight: 600;
            padding: 14px;
            border-radius: 20px;
            transition: 0.3s ease;
            border: none;
        }

        .btn-custom:hover {
            opacity: 0.7;
            color: #fff;
        }

        .btn-outline-custom {
            border: 2px solid #ce6e00;
            color: #5a360f;
            font-weight: 600;
            padding: 14px;
            border-radius: 20px;
            transition: 0.3s ease;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background-color: #000000;
            color: #fff;
        }

        @media (max-width: 576px) {
            .hero-title { font-size: 2.5rem; }
            .header-logo { font-size: 2rem; top: 15px; left: 15px; }
        }
    </style>
</head>

<body>
<section class="hero-section">
    <!-- MODIFIED: LOGO TEXT -->
        
        <h1 class="header-logo logo-container">
            <span class="logo-main">BINDTECH</span>
            <span class="logo-sub">FACULTY WORKLOAD MANAGEMENT SYSTEM</span>
        </h1>
    <div class="hero-content">
        <!-- MODIFIED: HERO TITLE -->
        <h2 class="hero-title">Schedule your workload with just a few clicks!</h2>
        <a href="#login-ui" class="btn-order-now">Login Now</a>
    </div>

    <!-- MODIFIED: SVG ARROW -->
    <a href="#login-ui" class="scroll-down-btn">
        <svg viewBox="0 0 960 960" class="arrow-svg">
            <g transform="matrix(1.09,0,0,1.09,480,374.7)">
                <path d="M-180,12 C-180,12 12,204 12,204 C12,204 198,18 198,18"
                    fill="none"
                    stroke="#ffffff"
                    stroke-width="80"
                    stroke-linecap="round"
                    stroke-linejoin="round"/>
            </g>
        </svg>
    </a>
</section>

<section id="login-ui" class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card custom-card text-center">
                    <div class="card-body p-5">
                        <h1 class="brand-title mb-3">BindTech</h1>
                        <p class="text-muted mb-4">Faculty Workload</p>
                        <p class="text-muted mb-4">Management System</p>

                        <a class="btn btn-custom w-100 mb-3" href="<?= site_url('login') ?>">
                            Login
                        </a>
                        <a class="btn btn-outline-custom w-100" href="<?= site_url('register') ?>">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- CONTENT -->
<section>
    <h1>About this page</h1>
    <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>
    <p>If you would like to edit this page you will find it located at:</p>
    <pre><code>app/Views/welcome_message.php</code></pre>
    <p>The corresponding controller for this page can be found at:</p>
    <pre><code>app/Controllers/Home.php</code></pre>
</section>

<div class="further">
    <section>

        <h1>Go further</h1>
        <h2>
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><rect x='32' y='96' width='64' height='368' rx='16' ry='16' class="svg-stroke" /><line x1='112' y1='224' x2='240' y2='224' class="svg-stroke" /><line x1='112' y1='400' x2='240' y2='400' class="svg-stroke" /><rect x='112' y='160' width='128' height='304' rx='16' ry='16' class="svg-stroke" /><rect x='256' y='48' width='96' height='416' rx='16' ry='16' class="svg-stroke" /><path d='M422.46,96.11l-40.4,4.25c-11.12,1.17-19.18,11.57-17.93,23.1l34.92,321.59c1.26,11.53,11.37,20,22.49,18.84l40.4-4.25c11.12-1.17,19.18-11.57,17.93-23.1L445,115C443.69,103.42,433.58,94.94,422.46,96.11Z' class="svg-stroke"/></svg>
            Learn
        </h2>
        <p>The User Guide contains an introduction, tutorial, a number of "how to"
            guides, and then reference documentation for the components that make up
            the framework. Check the <a href="https://codeigniter.com/user_guide/"
            target="_blank">User Guide</a> !</p>
        <h2>
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M431,320.6c-1-3.6,1.2-8.6,3.3-12.2a33.68,33.68,0,0,1,2.1-3.1A162,162,0,0,0,464,215c.3-92.2-77.5-167-173.7-167C206.4,48,136.4,105.1,120,180.9a160.7,160.7,0,0,0-3.7,34.2c0,92.3,74.8,169.1,171,169.1,15.3,0,35.9-4.6,47.2-7.7s22.5-7.2,25.4-8.3a26.44,26.44,0,0,1,9.3-1.7,26,26,0,0,1,10.1,2L436,388.6a13.52,13.52,0,0,0,3.9,1,8,8,0,0,0,8-8,12.85,12.85,0,0,0-.5-2.7Z' class="svg-stroke" /><path d='M66.46,232a146.23,146.23,0,0,0,6.39,152.67c2.31,3.49,3.61,6.19,3.21,8s-11.93,61.87-11.93,61.87a8,8,0,0,0,2.71,7.68A8.17,8.17,0,0,0,72,464a7.26,7.26,0,0,0,2.91-.6l56.21-22a15.7,15.7,0,0,1,12,.2c18.94,7.38,39.88,12,60.83,12A159.21,159.21,0,0,0,284,432.11' class="svg-stroke" /></svg>
            Discuss
        </h2>
        <p>CodeIgniter is a community-developed open source project, with several
             venues for the community members to gather and exchange ideas. View all
             the threads on <a href="https://forum.codeigniter.com/"
             target="_blank">CodeIgniter's forum</a>, or <a href="https://join.slack.com/t/codeigniterchat/shared_invite/zt-rl30zw00-obL1Hr1q1ATvkzVkFp8S0Q"
             target="_blank">chat on Slack</a> !</p>
        <h2>
        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><line x1='176' y1='48' x2='336' y2='48' class="svg-stroke" /><line x1='118' y1='304' x2='394' y2='304' class="svg-stroke" /><path d='M208,48v93.48a64.09,64.09,0,0,1-9.88,34.18L73.21,373.49C48.4,412.78,76.63,464,123.08,464H388.92c46.45,0,74.68-51.22,49.87-90.51L313.87,175.66A64.09,64.09,0,0,1,304,141.48V48' class="svg-stroke" /></svg>
             Contribute
        </h2>
        <p>CodeIgniter is a community driven project and accepts contributions
             of code and documentation from the community. Why not
             <a href="https://codeigniter.com/contribute" target="_blank">
             join us</a> ?</p>
    </section>
</div>

<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer>
    <div class="environment">
        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>
        <p>Environment: <?= ENVIRONMENT ?></p>
    </div>
    <div class="copyrights">
        <p>&copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
            open source licence.</p>
    </div>
</footer>

<!-- SCRIPTS -->

<script {csp-script-nonce}>
    document.getElementById("menuToggle").addEventListener('click', toggleMenu);
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

<!-- -->

</body>
</html>
