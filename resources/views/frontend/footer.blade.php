<footer style="background-image: url({{asset('masjid')}}/main_files/assets/img/footer-bg.jpg);">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-logo">
                        <img src="{{asset('masjid')}}/main_files/assets/img/logo.png" alt="logo"
                             style="max-width: 150px; height: auto;">
                        <h3>Masjid Khairul Amal</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="connect-with">
                        <h4>Sosial Media</h4>
                        <ul class="social-media">
                            <li><a href="#"><i class="fab fa-facebook-f icon"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram icon"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="connect-with">
                        <h4>Berlangganan Newsletter</h4>
                        <form class="subscribe">
                            <input type="text" name="email" placeholder="Masukkan alamat email Anda...">
                            <button class="btn">Berlangganan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-0 row Information">
            <div class="col-lg-4 col-md-6">
                <div class="widget-title">
                    <h3>Tentang Kami</h3>
                    <p>Masjid Khairul Amal adalah pusat kegiatan Islam dan pembinaan umat yang mengajarkan nilai-nilai kebaikan dan ketaqwaan.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="Information widget-title">
                    <h3>Kontak Info</h3>
                    <div class="contact-info">
                        <i class="fa-solid fa-phone text-warning"></i>
                        <div>
                            <h5>Telepon:</h5>
                            <a href="tel:+6281234567890">+62 812-3456-7890</a>
                        </div>
                    </div>
                    <div class="contact-info">
                        <i class="fa-solid fa-envelope text-warning"></i>
                        <div>
                            <h5>Email:</h5>
                            <a href="mailto:info@masjidkhairulamal.com">info@masjidkhairulamal.com</a>
                        </div>
                    </div>
                    <div class="contact-info">
                        <i class="fa-solid fa-location-dot text-warning"></i>
                        <h5>Jl. Contoh No. 123, Bandung</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="widget-title">
                    <h3>Menu Cepat</h3>
                    <ul>
                        <li><i class="fa-solid fa-angle-right"></i><a href="#prayer-times">Jadwal Sholat</a></li>
                        <li><i class="fa-solid fa-angle-right"></i><a href="#kajian">Kegiatan</a></li>
                        <li><i class="fa-solid fa-angle-right"></i><a href="#zakat">Kalkulator Zakat</a></li>
                        <li><i class="fa-solid fa-angle-right"></i><a href="#infaq">Infaq & Sedekah</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="wpo-lower-footer">
            <p>Copyright © <a href="#"><b>Masjid Khairul Amal</b></a> {{ date('Y') }}. All rights reserved.</p>
            <div class="d-flex align-items-center">
                <a href="#">Syarat & Ketentuan</a>
                <div class="border"></div>
                <a href="#">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>

<style>
/* Footer Logo */
.footer-logo img {
    max-width: 150px;
    height: auto;
    margin-bottom: 15px;
}

.footer-logo h3 {
    font-size: 1.5rem;
    margin-top: 10px;
}

/* Footer Links Hover Effect */
.widget-title ul li a {
    transition: color 0.3s ease;
}

.widget-title ul li a:hover {
    color: #fbc50b;
}

/* Newsletter Form */
.subscribe input {
    height: 50px;
    border-radius: 25px;
    padding: 0 20px;
}

.subscribe .btn {
    height: 50px;
    border-radius: 25px;
    padding: 0 30px;
    background-color: #fbc50b;
    border-color: #fbc50b;
}

.subscribe .btn:hover {
    background-color: #e0b00a;
    border-color: #e0b00a;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .footer-logo img {
        max-width: 120px;
    }

    .footer-logo h3 {
        font-size: 1.2rem;
    }

    .widget-title h3 {
        font-size: 1.3rem;
    }
}
</style>
