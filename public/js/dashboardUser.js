const allSideMenu = document.querySelectorAll("#sidebar .side-menu.top li a");

allSideMenu.forEach((item) => {
    const li = item.parentElement;

    item.addEventListener("click", function () {
        allSideMenu.forEach((i) => {
            i.parentElement.classList.remove("active");
        });
        li.classList.add("active");
    });
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector("#content nav .bx.bx-menu");
const sidebar = document.getElementById("sidebar");

menuBar.addEventListener("click", function () {
    sidebar.classList.toggle("hide");
});

const searchButton = document.querySelector(
    "#content nav form .form-input button"
);
const searchButtonIcon = document.querySelector(
    "#content nav form .form-input button .bx"
);
const searchForm = document.querySelector("#content nav form");

searchButton.addEventListener("click", function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle("show");
        if (searchForm.classList.contains("show")) {
            searchButtonIcon.classList.replace("bx-search", "bx-x");
        } else {
            searchButtonIcon.classList.replace("bx-x", "bx-search");
        }
    }
});

if (window.innerWidth < 768) {
    sidebar.classList.add("hide");
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace("bx-x", "bx-search");
    searchForm.classList.remove("show");
}

window.addEventListener("resize", function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace("bx-x", "bx-search");
        searchForm.classList.remove("show");
    }
});

const switchMode = document.getElementById("switch-mode");

switchMode.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});

document.querySelectorAll(".side-menu a").forEach((link) => {
    link.addEventListener("click", function (e) {
        e.preventDefault(); // Mencegah perilaku default anchor

        // Menghapus kelas aktif dari semua bagian
        document.querySelectorAll(".section").forEach((section) => {
            section.classList.remove("active");
        });

        // Menambahkan kelas aktif pada bagian yang sesuai
        const targetId = this.getAttribute("href");
        const targetSection = document.querySelector(targetId);
        targetSection.classList.add("active");
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector("#dashboard").classList.add("active");
});

// // Menangani klik pada tombol "Gabung Sekarang"
// document.querySelectorAll('.price__btn').forEach((button) => {
//   button.addEventListener('click', function () {
//     document.getElementById('payment-form').classList.remove('hidden')
//   })
// })

// // Menangani klik pada tombol "Batal"
// document
//   .getElementById('close-payment-form')
//   .addEventListener('click', function () {
//     document.getElementById('payment-form').classList.add('hidden')
//   })

// // Menangani pemilihan metode pembayaran
// document
//   .getElementById('payment-method')
//   .addEventListener('change', function () {
//     const selectedMethod = this.value
//     document.getElementById('bank-details').classList.add('hidden')
//     document.getElementById('ewallet-details').classList.add('hidden')

//     if (selectedMethod === 'bank') {
//       document.getElementById('bank-details').classList.remove('hidden')
//     } else if (selectedMethod === 'ewallet') {
//       document.getElementById('ewallet-details').classList.remove('hidden')
//     }
//   })

// // Menangani pengiriman form pembayaran
// document
//   .getElementById('form-payment')
//   .addEventListener('submit', function (e) {
//     e.preventDefault()

//     // Simulasi proses pembayaran
//     setTimeout(() => {
//       document.getElementById('payment-form').classList.add('hidden')
//       document.getElementById('payment-notification').classList.remove('hidden')
//     }, 1000) // Simulasi delay 1 detik untuk pembayaran
//   })

// dashboardUser.js

// ... (kode JavaScript lainnya yang sudah ada) ...

function payNow(membershipType) {
    fetch("/membership/payment", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ membershipType: membershipType }),
    })
        .then((response) => {
            // Cek apakah responsnya OK dan tipenya JSON sebelum parsing
            if (!response.ok) {
                // Jika status error (seperti 403 Forbidden), coba parse JSON untuk pesan error
                return response.json().then((errorData) => {
                    // Lemparkan error dengan data dari server agar bisa ditangkap di .catch()
                    let err = new Error(
                        errorData.message ||
                            "Terjadi kesalahan saat memproses permintaan."
                    );
                    err.errorData = errorData; // Menyimpan data error tambahan jika ada
                    err.status = response.status;
                    throw err;
                });
            }
            return response.json(); // Jika OK, parse JSON seperti biasa
        })
        .then((data) => {
            if (data.token) {
                // Jika ada token, lanjutkan ke pembayaran Midtrans
                window.snap.pay(data.token, {
                    onSuccess: function (result) {
                        console.log("success", result);
                        Swal.fire({
                            title: "Pembayaran Berhasil!",
                            text: "Langganan Anda telah berhasil diaktifkan.",
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            // Anda bisa mengarahkan pengguna atau merefresh halaman di sini jika perlu
                            // window.location.reload();
                        });
                    },
                    onPending: function (result) {
                        console.log("pending", result);
                        Swal.fire({
                            title: "Pembayaran Tertunda",
                            text: "Selesaikan pembayaran Anda melalui metode yang dipilih.",
                            icon: "info",
                            confirmButtonText: "Ok",
                        });
                    },
                    onError: function (result) {
                        console.log("error", result);
                        Swal.fire({
                            title: "Pembayaran Gagal",
                            text: "Terjadi kesalahan saat proses pembayaran. Silakan coba lagi.",
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    },
                    onClose: function () {
                        /* Handle ketika pelanggan menutup popup Snap tanpa menyelesaikan pembayaran */
                        console.log(
                            "customer closed the popup without finishing the payment"
                        );
                    },
                });
            } else if (data.error) {
                // Jika backend mengirim { error: "pesan" } tapi statusnya 200 OK (seharusnya tidak terjadi jika status HTTP benar)
                Swal.fire({
                    title: "Informasi",
                    text: data.message || data.error, // Gunakan data.message jika ada, fallback ke data.error
                    icon: "warning",
                    confirmButtonText: "Ok",
                });
            } else {
                // Ini seharusnya tidak terjadi jika backend selalu mengirim token atau error yang jelas
                console.error(
                    "Token kosong atau format data tidak dikenal:",
                    data
                );
                Swal.fire({
                    title: "Terjadi Kesalahan",
                    text: "Gagal mendapatkan token pembayaran. Respons tidak dikenal.",
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            }
        })
        .catch((error) => {
            console.error("Error pada fungsi payNow:", error);
            if (error.status === 403 && error.errorData) {
                // Tangani error 403 spesifik dari backend
                Swal.fire({
                    title: "Langganan Aktif",
                    html:
                        error.errorData.message ||
                        "Anda sudah memiliki langganan yang aktif.", // Gunakan html agar bisa menampilkan format tanggal
                    icon: "warning",
                    confirmButtonText: "Ok",
                });
            } else {
                // Untuk error lainnya
                Swal.fire({
                    title: "Terjadi Kesalahan",
                    text:
                        error.message ||
                        "Tidak dapat terhubung ke server atau terjadi kesalahan lain.",
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            }
        });
}

function logout() {
    fetch("/logout", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((response) => {
            if (response.redirected) {
                window.location.href = response.url;
            } else if (response.ok) {
                // Jika tidak ada redirect tapi sukses (misal API logout hanya mengembalikan status)
                window.location.href = "/login"; // Arahkan manual ke halaman login
            }
        })
        .catch((error) => {
            console.error("Logout error:", error);
            // Fallback jika fetch gagal
            window.location.href = "/login";
        });
}


// Ambil elemen dari DOM seperti sebelumnya
const absenButton = document.getElementById('btn-absen');
const viewAbsenButton = document.getElementById('btn-view-absen');
const absenDateInput = document.getElementById('absen-date');
const historyListUL = document.getElementById('history-list');
const linkAbsensiSidebar = document.getElementById('link-absensi');

// Fungsi format waktu dan tanggal (sama seperti sebelumnya, bisa disesuaikan)
function formatTime(timeString) {
    if (!timeString) return '-';
    return timeString.substring(0, 5); // HH:mm
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

// Fungsi untuk menampilkan riwayat absensi
function displayAbsenHistory(records) {
    historyListUL.innerHTML = '';
    if (records && records.length > 0) {
        records.forEach(record => {
            const listItem = document.createElement('li');
            // Menyesuaikan dengan field di model Anda: 'date' dan 'time'
            listItem.textContent = `Tanggal: ${formatDate(record.date)} - Jam Masuk: ${formatTime(record.time)}`;
            historyListUL.appendChild(listItem);
        });
    } else {
        historyListUL.innerHTML = '<li>Tidak ada data absensi untuk periode yang dipilih.</li>';
    }
}

// Fungsi untuk mengambil riwayat absensi
async function fetchAbsenHistory(selectedDate = null) {
    try {
        let url = '/absensi'; // Endpoint GET Anda
        if (selectedDate) {
            url += `?date=${selectedDate}`; // Parameter query adalah 'date'
        }
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Gagal mengambil riwayat absensi.');
        }
        const records = await response.json();
        displayAbsenHistory(records);
    } catch (error) {
        console.error('Error fetching absen history:', error);
        if (historyListUL) {
           historyListUL.innerHTML = `<li>Terjadi kesalahan: ${error.message}</li>`;
        }
        Swal.fire('Error', error.message || 'Gagal mengambil riwayat absensi.', 'error');
    }
}

// Event listener untuk tombol "Absen"
if (absenButton) {
    absenButton.addEventListener('click', async function() {
        try {
            absenButton.disabled = true;
            absenButton.textContent = 'Memproses...';

            const response = await fetch('/absensi', { // Endpoint POST Anda
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
                // Tidak perlu mengirim body, karena backend akan mengambil tanggal & waktu saat ini
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 409) { // Sudah absen
                    Swal.fire('Informasi', data.message || 'Anda sudah melakukan absensi hari ini.', 'info');
                } else {
                    throw new Error(data.message || 'Gagal mencatat absensi.');
                }
            } else {
                Swal.fire('Sukses!', data.message || 'Absensi berhasil dicatat.', 'success');
                const today = new Date().toISOString().slice(0, 10);
                absenDateInput.value = today; // Set input tanggal ke hari ini
                fetchAbsenHistory(today);     // Tampilkan riwayat hari ini
            }
        } catch (error) {
            console.error('Error saat mencatat absen:', error);
            Swal.fire('Error', error.message || 'Gagal mencatat absensi.', 'error');
        } finally {
            absenButton.disabled = false;
            absenButton.textContent = 'Absen Sekarang';
        }
    });
}

// Event listener untuk tombol "Lihat Absensi"
if (viewAbsenButton) {
    viewAbsenButton.addEventListener('click', function() {
        const selectedDate = absenDateInput.value;
        fetchAbsenHistory(selectedDate || null); // Jika tanggal kosong, ambil semua riwayat
    });
}

// Event listener untuk link sidebar absensi (untuk memuat riwayat saat tab diklik)
document.querySelectorAll('#sidebar .side-menu.top li a').forEach(item => { //
    item.addEventListener('click', function (e) {
        const li = item.parentElement;
        const targetId = this.getAttribute('href'); // e.g., #absensi

        if (targetId && targetId.startsWith('#')) { // Hanya proses jika href adalah fragment
            // Logika untuk mengaktifkan li dan section (dari kode Anda sebelumnya)
            document.querySelectorAll('#sidebar .side-menu.top li').forEach(i => {
                i.classList.remove('active');
            });
            li.classList.add('active');

            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            const targetSection = document.querySelector(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
            }
            // Akhir logika navigasi

            // Jika target adalah section absensi, muat riwayat awal (semua)
            if (targetId === '#absensi') { //
                fetchAbsenHistory(absenDateInput.value || null); // Muat berdasarkan filter tanggal saat ini atau semua
            }
        }
    });
});


// Memuat riwayat absensi jika tab absensi aktif saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', () => {
    const dashboardSection = document.getElementById('dashboard');
    if (dashboardSection) {
       dashboardSection.classList.add('active');
    }

    // Jika URL hash menunjuk ke #absensi saat load, atau jika #absensi default aktif
    const currentHash = window.location.hash;
    if (currentHash === '#absensi' || document.getElementById('absensi').classList.contains('active')) {
        fetchAbsenHistory(absenDateInput.value || null);
    } else if (!currentHash && document.getElementById('dashboard').classList.contains('active')) {
        // Jika dashboard default aktif dan tidak ada hash, mungkin tidak perlu load absensi
        // kecuali Anda ingin menampilkan sesuatu di #history-list secara default.
        // Untuk saat ini, kita kosongkan atau tampilkan pesan default.
        if (historyListUL) {
            historyListUL.innerHTML = '<li>Pilih tanggal untuk melihat riwayat atau klik tab Absensi.</li>';
        }
    }
});


const srcButton = document.querySelector(
    "#content nav form .form-input button"
);
const searchInput = document.querySelector(
    "#content nav form .form-input input"
);

srcButton.addEventListener("click", function (e) {
    e.preventDefault(); // Mencegah pengiriman form

    const searchTerm = searchInput.value.toLowerCase(); // Ambil nilai pencarian
    const links = {
        dashboard: document.getElementById("link-dashboard"),
        membership: document.getElementById("link-membership"),
        absensi: document.getElementById("link-absensi"),
    };

    // Cek apakah input pencarian cocok dengan salah satu link
    for (const key in links) {
        if (key.includes(searchTerm)) {
            links[key].click(); // Arahkan ke halaman yang sesuai
            break;
        }
    }
});
