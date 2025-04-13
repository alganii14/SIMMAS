<header>
    <div class="container">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="">
                        <ul class="social-media">
                            <li><a href="#"><i class="fab fa-facebook-f icon"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram icon"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="location">
                            <i class="fa-solid fa-location-dot text-warning"></i>
                            <span>Jl. Contoh No. 123, Bandung</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bottom-bar">
            <div class="two-bar">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <a href="#home">
                            <img alt="Masjid Khairul Amal" src="{{asset('masjid')}}/main_files/assets/img/logo.png"
                                 class="img-fluid">
                        </a>
                    </div>
                    <div class="bar-menu">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>
                <nav class="navbar">
                    <ul class="navbar-links">
                        <li><a href="#home" class="nav-link">Beranda</a></li>
                        <li><a href="#prayer-times" class="nav-link">Jadwal Sholat</a></li>
                        <li><a href="#kajian" class="nav-link">Kegiatan</a></li>
                        <li><a href="#zakat" class="nav-link">Kalkulator Zakat</a></li>
                        <li><a href="#infaq" class="nav-link">Infaq</a></li>
                        <li><a href="#features" class="nav-link">Inventori</a></li>
                    </ul>
                </nav>
                <div class="header-search">
                    <a href="tel:+6281234567890">
                        <i class="fa-solid fa-phone text-warning me-2"></i>
                        +62 812-3456-7890
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="mobile-nav hmburger-menu" id="mobile-nav" style="display:none;">
        <div class="res-log">
            <a href="#home">
                <img src="{{asset('masjid')}}/main_files/assets/img/logo.png" alt="Masjid Khairul Amal" class="white-logo">
            </a>
        </div>
        <ul>
            <li><a href="#home" class="nav-link">Beranda</a></li>
            <li><a href="#prayer-times" class="nav-link">Jadwal Sholat</a></li>
            <li><a href="#kajian" class="nav-link">Kegiatan</a></li>
            <li><a href="#zakat" class="nav-link">Kalkulator Zakat</a></li>
            <li><a href="#infaq" class="nav-link">Infaq</a></li>
        </ul>
        <a href="JavaScript:void(0)" id="res-cross"></a>
    </div>
</header>

<style>
/* Logo Styles */
.logo {
    max-width: 200px;
    padding: 10px 0;
}

.logo img {
    width: 100%;
    height: auto;
    max-height: 60px;
    object-fit: contain;
}

/* Mobile Logo */
.res-log {
    max-width: 150px;
    padding: 10px;
}

.res-log img {
    width: 100%;
    height: auto;
    max-height: 50px;
    object-fit: contain;
}

/* Navigation Styles */
.nav-link {
    position: relative;
    padding: 0.5rem 1rem;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: #fbc50b;
    left: 0;
    bottom: -5px;
    transition: width 0.3s ease;
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 100%;
}

.navbar-links li a:hover,
.navbar-links li a.active {
    color: #fbc50b;
}

/* Top Bar Styles */
.top-bar {
    padding: 10px 0;
}

.social-media {
    display: flex;
    gap: 15px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.social-media li a {
    color: #fbc50b;
    transition: color 0.3s ease;
}

.social-media li a:hover {
    color: #e0b00a;
}

.location {
    display: flex;
    align-items: center;
    gap: 10px;
}

.location i {
    font-size: 1.2rem;
}

/* Mobile Navigation */
@media (max-width: 768px) {
    .logo {
        max-width: 150px;
    }

    .logo img {
        max-height: 50px;
    }

    .top-bar .social-media {
        justify-content: center;
        margin-bottom: 10px;
    }

    .location {
        justify-content: center;
    }

    .col-xl-6 {
        text-align: center;
    }

    .justify-content-end {
        justify-content: center !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for navigation links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                // Close mobile menu if open
                const mobileNav = document.getElementById('mobile-nav');
                if (mobileNav.style.display === 'block') {
                    mobileNav.style.display = 'none';
                }

                // Smooth scroll to target
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Handle mobile menu toggle
    const barMenu = document.querySelector('.bar-menu');
    const mobileNav = document.getElementById('mobile-nav');
    const resCross = document.getElementById('res-cross');

    barMenu.addEventListener('click', function() {
        mobileNav.style.display = mobileNav.style.display === 'block' ? 'none' : 'block';
    });

    resCross.addEventListener('click', function() {
        mobileNav.style.display = 'none';
    });

    // Add active class to current section
    function setActiveLink() {
        const sections = document.querySelectorAll('section[id]');
        const scrollPosition = window.scrollY + 150;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            const sectionId = section.getAttribute('id');

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${sectionId}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }

    window.addEventListener('scroll', setActiveLink);
    setActiveLink();
});
</script>
