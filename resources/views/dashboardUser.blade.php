<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-uVcwFx6WGJxOq-G4"></script>


    <!-- Boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
      rel="stylesheet"
    />
    <!-- My CSS -->
    <link rel="stylesheet" href="css/dashboardUser.css" />

    <title>PriveFit</title>
  </head>
  <body>
    <!-- SIDEBAR -->
    <section id="sidebar">
      <a href="#" class="brand">
        <i class="bx bxs-smile"></i>
        <span class="text">PriveFit</span>
      </a>
      <ul class="side-menu top">
        <li class="active">
          <a href="#dashboard" id="link-dashboard">
            <i class="bx bxs-dashboard"></i>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#membership" id="link-membership">
            <i class="bx bxs-shopping-bag-alt"></i>
            <span class="text">Membership</span>
          </a>
        </li>
        <li>
          <a href="#absensi" id="link-absensi">
            <i class="bx bxs-doughnut-chart"></i>
            <span class="text">Absensi</span>
          </a>
        </li>
      </ul>
      <ul class="side-menu">
        <li>
          <a href="#" class="logout">
            <i class="bx bxs-log-out-circle"></i>
            <span class="text" onclick="logout()" >Logout</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
      <!-- NAVBAR -->
      <nav>
        <i class="bx bx-menu"></i>
        <a href="#" class="nav-link">Categories</a>
        <form action="#">
          <div class="form-input">
            <input type="search" placeholder="Search..." />
            <button type="submit" class="search-btn">
              <i class="bx bx-search"></i>
            </button>
          </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden />
        <label for="switch-mode" class="switch-mode"></label>
      </nav>
      <!-- NAVBAR -->

      <!-- MAIN -->
      <main>
        <div id="dashboard" class="section active">
          <div class="head-title">
            <div class="left">
              <h1>Dashboard</h1>
            </div>
            {{-- <a href="#" class="btn-download">
              <i class="bx bxs-cloud-download"></i>
              <span class="text">Download PDF</span>
            </a> --}}
          </div>

          <ul class="box-info">
            <li>
              <i class="bx bxs-calendar-check"></i>
              <span class="text">
                <h3>Membership</h3>
                @if($membership && $membership->status == 'settlement')
                    <p style="color: green;">Aktif</p>
                @else
                    <p style="color: red;">Tidak Aktif</p>
                @endif
              </span>
            </li>
            <li>
              <i class="bx bxs-group"></i>
              <span class="text">
                <h3>Kelas</h3>
                @if($membership && $membership->kelas)
                    <p>{{ $membership->kelas }}</p>
                @else
                    <p>-</p>
                @endif
              </span>
            </li>
            <li>
              <i class="bx bxs-time"></i>
             <span class="text">
                <h3>Life Time</h3>
                @if(isset($daysLeft))
                    <p>{{ $daysLeft }} Hari</p>
                @else
                    <p>0 Hari</p> @endif
              </span>
            </li>
          </ul>

          <div class="table-data">
            <div class="order">
              <div class="head">
                <h3>Recent Orders</h3>
              </div>
              <table>
                <thead>
                  <tr>
                    <th>Kelas</th>
                    <th>Date Order</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($recentOrders) && $recentOrders->count() > 0)
                    @foreach($recentOrders as $order)
                      <tr>
                        <td>
                          <p>{{ $order->kelas ?? '-' }}</p>
                        </td>
                        <td>
                          <p>{{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d-m-Y') : \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</p>
                        </td>
                        <td>
                          @php
                            $statusClass = '';
                            $statusText = '';
                            if ($order->status == 'settlement') {
                                if ($order->expired_date && \Carbon\Carbon::parse($order->expired_date)->isFuture()) {
                                    $statusClass = 'onGoing'; // atau 'active'
                                    $statusText = 'On Going'; // atau 'Aktif'
                                } else {
                                    $statusClass = 'completed'; // atau 'expired'
                                    $statusText = 'Completed'; // atau 'Selesai' / 'Expired'
                                }
                            } elseif ($order->status == 'pending') {
                                $statusClass = 'pending';
                                $statusText = 'Pending';
                            } elseif ($order->status == 'cancelled' || $order->status == 'denied') {
                                $statusClass = 'cancelled'; // atau 'failed'
                                $statusText = ucfirst($order->status); // 'Cancelled' atau 'Denied'
                            } else {
                                $statusClass = 'default';
                                $statusText = ucfirst($order->status);
                            }
                          @endphp
                          <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="3" style="text-align: center;">Tidak ada riwayat pesanan.</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            {{-- <div class="todo">
              <div class="head">
                <h3>To Do Daily</h3>
              </div>
              <ul class="todo-list">
                <li class="completed">
                  <p>Push Up 15x3</p>
                  <i class="bx bx-dots-vertical-rounded"></i>
                </li>
                <li class="completed">
                  <p>Pull up 10x3</p>
                  <i class="bx bx-dots-vertical-rounded"></i>
                </li>
                <li class="not-completed">
                  <p>Sit Up 15x3</p>
                  <i class="bx bx-dots-vertical-rounded"></i>
                </li>
                <li class="completed">
                  <p>Biceps Curl 15x3</p>
                  <i class="bx bx-dots-vertical-rounded"></i>
                </li>
                <li class="not-completed">
                  <p>Squat Jump 20x3</p>
                  <i class="bx bx-dots-vertical-rounded"></i>
                </li>
              </ul>
            </div> --}}
          </div>
        </div>

        <div id="membership" class="section">
          <h1>Membership</h1>
          <section class="section__container price__container" id="community">
            <div class="price__grid">
              <div class="price__card">
                <div class="price__card__content">
                  <h4>Reguler</h4>
                  <h3>Rp.1.286.000 <i class="small-text">/3 Bulan</i></h3>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Rencana latihan cerdas
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Latihan di rumah
                  </p>
                </div>
                <button type="button" class="btn price__btn"
                onclick="payNow('Reguler')">
                  Gabung Sekarang
                </button>
              </div>
              <div class="price__card">
                <div class="price__card__content">
                  <h4>Premium</h4>
                  <h3>Rp.3.418.000 <i class="small-text">/6 Bulan</i></h3>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    PRO Gyms
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Rencana latihan cerdas
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Latihan di rumah
                  </p>
                </div>
                <button type="button" class="btn price__btn"
                onclick="payNow('Premium')">
                  Gabung Sekarang
                </button>
              </div>
              <div class="price__card">
                <div class="price__card__content">
                  <h4>Elite</h4>
                  <h3>Rp.6.320.000 <i class="small-text">/12 Bulan</i></h3>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    ELITE Gyms & Kelas
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    PRO Gyms
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Rencana latihan cerdas
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Latihan di rumah
                  </p>
                  <p>
                    <i class="bx bxs-check-circle"></i>
                    Personal Training
                  </p>
                </div>
                <button type="button" class="btn price__btn"
                onclick="payNow('Elite')">
                  Gabung Sekarang
                </button>
              </div>
            </div>
          </section>
        </div>

        {{-- <!-- Form Pembayaran -->
        <div id="payment-form" class="payment-form hidden">
          <div class="payment-form-content">
            <h2>Form Pembayaran</h2>
            <form id="form-payment">
              <label for="name">Nama Lengkap:</label>
              <input type="text" id="name" required />

              <label for="email">Email:</label>
              <input type="email" id="email" required />

              <label for="payment-method">Metode Pembayaran:</label>
              <select id="payment-method" required>
                <option value="" disabled selected>
                  Pilih Metode Pembayaran
                </option>
                <option value="bank">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
              </select>

              <div id="bank-details" class="hidden">
                <label>Nomor Rekening:</label>
                <p>123-456-7890 (Bank BCA)</p>
              </div>

              <div id="ewallet-details" class="hidden">
                <label>Nomor E-Wallet:</label>
                <p>0896-0261-5957 (E-Wallet Dana)</p>
              </div>

              <button type="submit">Bayar</button>
              <button type="button" id="close-payment-form">Batal</button>
            </form>
            <div id="payment-notification" class="hidden">
              Pembayaran Berhasil!
            </div>
          </div>
        </div> --}}

        <div id="absensi" class="section">
          <h1>Absensi</h1>
        <div class="absensi-container">
          <button id="btn-absen" class="btn absensi-btn">Absen</button>  
      <div class="date-picker">
      <input type="date" id="absen-date" />
      <button id="btn-view-absen" class="btn view-btn">Lihat Absensi</button>
    </div>
    
    <div id="absen-history" class="absen-history">
      <h3>Riwayat Absen</h3>
      <ul id="history-list">
        <!-- Riwayat absen akan ditambahkan di sini -->
      </ul>
    </div>

          </div>
        </div>
      </main>
      <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="js/dashboardUser.js"></script>
  </body>
</html>
