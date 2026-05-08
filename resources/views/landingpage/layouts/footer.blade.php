<footer class="footer-modern mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h4 class="footer-brand">Botol Plastik Riau</h4>
                <p class="footer-desc">
                    Menyediakan plastik & packaging berkualitas tinggi untuk kebutuhan harian,
                    usaha kecil, hingga grosir — lengkap, cepat, dan terpercaya.
                </p>
                <div class="footer-social">
                    <a href="mailto:plastikbotol491@gmail.com" class="soc">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                    <a href="https://wa.me/6281371209486" class="soc"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center text-md-start">
                <h5 class="footer-title">Menu</h5>
                <ul class="footer-links">
                    <li><a href="/">Beranda</a></li>
                    <li><a href="/semuaproduk">Produk</a></li>
                    <li><a href="/tentang">Tentang</a></li>
                    <li><a href="/contactus">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12 text-center text-md-start">
                <h5 class="footer-title">Informasi</h5>
                <p class="footer-info">
                    <i class="bi bi-geo-alt-fill"></i> Jl. Paus, Tangkerang Tengah, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28282 <br>
                    <i class="bi bi-telephone-fill"></i> 081371209486 <br>
                    <i class="bi bi-clock-fill"></i> Buka Setiap Hari
                </p>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="text-center footer-copy">
            &copy; {{ date('Y') }} Botol Plastik Riau — All Rights Reserved.
        </div>
    </div>
</footer>

<style>
    .footer-modern {
        background: #0f1a2b;
        padding: 50px 0 30px;
        color: #c9d6e2;
        font-family: "Poppins", sans-serif;
    }
    .footer-brand {
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
    }
    .footer-desc {
        font-size: 14px;
        color: #a8b4c6;
        line-height: 1.6;
        max-width: 320px;
    }
    .footer-title {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 12px;
    }
    .footer-links {
        padding: 0;
        list-style: none;
    }
    .footer-links li {
        margin: 8px 0;
    }
    .footer-links a {
        color: #c9d6e2;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }
    .footer-links a:hover {
        color: #4fa3ff;
        padding-left: 6px;
    }
    .footer-info {
        font-size: 14px;
        line-height: 1.8;
        color: #c9d6e2;
    }
    .footer-info i {
        color: #4fa3ff;
        margin-right: 6px;
    }
    .footer-divider {
        border-color: #2c3b52;
        margin: 25px 0;
    }
    .footer-copy {
        font-size: 13px;
        color: #9fb3cc;
    }
    .footer-social .soc {
        display: inline-flex;
        width: 36px;
        height: 36px;
        justify-content: center;
        align-items: center;
        margin-right: 8px;
        border-radius: 50%;
        background: #1b2a41;
        color: #c9d6e2;
        font-size: 18px;
        transition: 0.3s;
    }
    .footer-social .soc:hover {
        background: #4fa3ff;
        color: #fff;
    }
    @media (max-width: 768px) {
        .footer-modern {
            text-align: center;
            padding: 40px 15px 25px;
        }
        .footer-desc {
            margin: 0 auto 15px;
            max-width: 100%;
        }
        .footer-title {
            margin-top: 20px;
        }
        .footer-links {
            margin-bottom: 10px;
        }
        .footer-links li {
            margin: 6px 0;
        }
        .footer-info {
            margin-top: 10px;
        }
        .footer-social {
            margin-top: 15px;
        }
        .footer-social .soc {
            margin: 5px;
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        .footer-divider {
            margin: 20px 0;
        }
        .footer-copy {
            font-size: 12px;
            padding: 0 10px;
        }
    }
</style>
