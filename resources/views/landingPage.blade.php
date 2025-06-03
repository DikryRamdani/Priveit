<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/landingPage.css" />
    <title>Fitness Club | PriveFit</title>
  </head>
  <body>
    <nav>
      <div class="nav__logo">
        <img src="{{ asset('images/logo.png') }}" alt="logo" />
      </div>
      <ul class="nav__links">
        <li class="link"><a href="#home">Home</a></li>
        <li class="link"><a href="#program">Program</a></li>
        <li class="link"><a href="#service">Service</a></li>
        <li class="link"><a href="#about">About</a></li>
        <li class="link"><a href="#community">Community</a></li>
      </ul>
      <button class="btn">
        <a href="/login">Gabung Sekarang</a>
      </button>
    </nav>

    <header class="section__container header__container" id="home">
      <div class="header__content">
        <span class="bg__blur"></span>
        <span class="bg__blur header__blur"></span>
        <h4>FITNESS CLUB TERBAIK DI DUNIA</h4>
        <h1><span>BENTUK</span> BADAN IMPIANMU</h1>
        <p>
          Bebaskan potensi Anda dan mulailah perjalanan menuju diri Anda yang
          lebih kuat, lebih bugar, dan lebih percaya diri. Daftar untuk 'Make
          Your Body Shape' sekarang dan saksikan transformasi luar biasa yang
          dapat dilakukan tubuh Anda!
        </p>
      </div>
      <div class="header__image">
        <img src="{{ asset('images/header.png') }}" alt="header" />
      </div>
    </header>

    <section class="section__container explore__container" id="program">
      <div class="explore__header">
        <h2 class="section__header">JELAJAHI PROGRAM KAMI</h2>
        <div class="explore__nav">
          <span><i class="ri-arrow-left-line"></i></span>
          <span><i class="ri-arrow-right-line"></i></span>
        </div>
      </div>
      <div class="explore__grid">
        <div class="explore__card active">
          <span><i class="ri-boxing-fill"></i></span>
          <h4>Strength Training</h4>
          <p>
            Rangkullah hakikat kekuatan saat kita menyelami berbagai dimensinya,
            fisik, mental, dan emosional.
          </p>
        </div>
        <div class="explore__card">
          <span><i class="ri-heart-pulse-fill"></i></span>
          <h4>Cardio Training</h4>
          <p>
            Ini mencakup berbagai kegiatan yang meningkatkan kesehatan,
            kekuatan, fleksibilitas, dan kesejahteraan secara keseluruhan.
          </p>
        </div>
        <div class="explore__card">
          <span><i class="ri-run-line"></i></span>
          <h4>Defisit Kalori</h4>
          <p>
            Melalui kombinasi rutinitas latihan dan bimbingan ahli, kami akan
            memberdayakan Anda untuk mencapai tujuan Anda.
          </p>
        </div>
        <div class="explore__card">
          <span><i class="ri-shopping-basket-fill"></i></span>
          <h4>Surplus</h4>
          <p>
            Dirancang untuk perorangan, program kami menawarkan pendekatan
            efektif untuk menambah berat badan secara berkelanjutan.
          </p>
        </div>
      </div>
    </section>

    <section class="section__container class__container" id="service">
      <div class="class__image">
        <span class="bg__blur"></span>
        <img src="{{ asset('images/class-1.jpg') }}" alt="class" class="class__img-1" />
        <img src="{{ asset('images/class-2.jpg') }}" class="class__img-2" />
      </div>
      <div class="class__content">
        <h2 class="section__header">KELAS YANG AKAN DI DAPATKAN DISINI</h2>
        <p>
          Dipimpin oleh tim instruktur ahli dan motivator, "Kelas yang Akan Anda
          Dapatkan di Sini" adalah sesi berenergi tinggi dan berorientasi pada
          hasil yang menggabungkan perpaduan sempurna antara latihan kardio,
          latihan kekuatan, dan latihan fungsional. Setiap kelas disusun dengan
          cermat untuk membuat Anda tetap terlibat dan tertantang, memastikan
          Anda tidak pernah mencapai titik jenuh dalam upaya kebugaran Anda.
        </p>
      </div>
    </section>

    <section class="section__container join__container" id="about">
      <h2 class="section__header">KENAPA HARUS JOIN KAMI ?</h2>
      <p class="section__subheader">
        Basis keanggotaan kami yang beragam menciptakan suasana yang bersahabat
        dan mendukung, tempat Anda dapat berteman dan tetap termotivasi.
      </p>
      <div class="join__image">
        <img src="{{ asset('images/join.jpg') }}" alt="Join" />
        <div class="join__grid">
          <div class="join__card">
            <span><i class="ri-user-star-fill"></i></span>
            <div class="join__card__content">
              <h4>Personal Trainer</h4>
              <p>Buka potensi Anda dengan Pelatih Pribadi kami yang ahli.</p>
            </div>
          </div>
          <div class="join__card">
            <span><i class="ri-vidicon-fill"></i></span>
            <div class="join__card__content">
              <h4>Sesi Pelatihan</h4>
              <p>Tingkatkan kebugaran Anda dengan sesi latihan.</p>
            </div>
          </div>
          <div class="join__card">
            <span><i class="ri-building-line"></i></span>
            <div class="join__card__content">
              <h4>Manajemen Yang Baik</h4>
              <p>Manajemen yang mendukung, untuk kesuksesan kebugaran Anda.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section__container price__container" id="community">
      <h2 class="section__header">PRICE LIST KAMI</h2>
      <p class="section__subheader">
        Paket harga kami dilengkapi dengan berbagai tingkatan keanggotaan,
        masing-masing disesuaikan untuk memenuhi preferensi dan aspirasi
        kebugaran yang berbeda.
      </p>
      <div class="price__grid">
        <div class="price__card">
          <div class="price__card__content">
            <h4>Reguler</h4>
            <h3>Rp.1.286.000 <i class="small-text">/3 Bulan</i></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Rencana latihan cerdas
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Latihan di rumah
            </p>
          </div>
          <button class="btn price__btn">
            <a href="../form_login/login.html">Gabung Sekarang</a>
          </button>
        </div>
        <div class="price__card">
          <div class="price__card__content">
            <h4>Premium</h4>
            <h3>Rp.3.418.000 <i class="small-text">/6 Bulan</i></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              PRO Gyms
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Rencana latihan cerdas
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Latihan di rumah
            </p>
          </div>
          <button class="btn price__btn">
            <a href="../form_login/login.html">Gabung Sekarang</a>
          </button>
        </div>
        <div class="price__card">
          <div class="price__card__content">
            <h4>Elite</h4>
            <h3>Rp.6.320.000 <i class="small-text">/12 Bulan</i></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              ELITE Gyms & Kelas
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              PRO Gyms
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Rencana latihan cerdas
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Latihan di rumah
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Personal Training
            </p>
          </div>
          <button class="btn price__btn">
            <a href="../form_login/login.html">Gabung Sekarang</a>
          </button>
        </div>
      </div>
    </section>

    <section class="review">
      <div class="section__container review__container">
        <span><i class="ri-double-quotes-r"></i></span>
        <div class="review__content">
          <h4>MEMBER REVIEW</h4>
          <div class="review__slider">
            <div class="review__item active">
              <p>
                Yang benar-benar membuat pusat kebugaran ini berbeda adalah tim
                pelatih mereka yang ahli. Pelatihnya berpengetahuan luas, mudah
                didekati, dan benar-benar berkomitmen membantu anggota mencapai
                sasaran kebugaran mereka. Mereka meluangkan waktu untuk memahami
                kebutuhan masing-masing dan membuat rencana latihan yang
                dipersonalisasi, memastikan hasil dan keamanan yang maksimal.
              </p>
              <div class="review__member">
                <img src="{{ asset('images/member.jpg') }}" alt="member" />
                <div class="review__member__details">
                  <h4>Udin Petot</h4>
                  <p>Kuli Bangunan</p>
                </div>
              </div>
            </div>
            <div class="review__item">
              <p>
                Saya sangat senang dengan pengalaman saya di sini. Pelatihnya
                sangat membantu dan suasananya sangat mendukung.
              </p>
              <div class="review__member">
                <img src="{{ asset('images/member2.jpg') }}" alt="member" />
                <div class="review__member__details">
                  <h4>Rina Sari</h4>
                  <p>Desainer</p>
                </div>
              </div>
            </div>
            <div class="review__item">
              <p>
                Program yang ditawarkan sangat bermanfaat dan saya merasa lebih
                bugar dari sebelumnya. Jujur pelayanan disini sangat baik dan
                seru. saya sangat suka dengan privefit ini.
              </p>
              <div class="review__member">
                <img src="{{ asset('images/member3.jpg') }}" alt="member" />
                <div class="review__member__details">
                  <h4>Andi Setiawan</h4>
                  <p>Pengusaha</p>
                </div>
              </div>
            </div>
          </div>
          <div class="review__nav">
            <span class="prev"><i class="ri-arrow-left-line"></i></span>
            <span class="next"><i class="ri-arrow-right-line"></i></span>
          </div>
        </div>
      </div>
    </section>

    <footer class="section__container footer__container">
      <span class="bg__blur"></span>
      <span class="bg__blur footer__blur"></span>
      <div class="footer__col">
        <div class="footer__logo">
          <img src="{{ asset('images/logo.png') }}" alt="logo" />
        </div>
        <p>
          Ambil langkah pertama menuju lebih sehat dan lebih kuat dengan paket
          harga kami yang luar biasa. Mari kita berkeringat, berprestasi, dan
          menaklukkan bersama!
        </p>
        <div class="footer__socials">
          <a href="#"><i class="ri-facebook-fill"></i></a>
          <a href="#"><i class="ri-instagram-line"></i></a>
          <a href="#"><i class="ri-twitter-fill"></i></a>
        </div>
      </div>
    </footer>
    <div class="footer__bar">
      Copyright © 2025 Kelompok 2. All rights reserved.
    </div>

    <script src="js/landingPage.js"></script>
  </body>
</html>
