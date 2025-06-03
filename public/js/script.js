//smooth scroll untuk navigasi link
document.querySelectorAll(".nav__links a").forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const targetId = this.getAttribute("href");
    const targetElement = document.querySelector(targetId);
    targetElement.scrollIntoView({ behavior: "smooth" });
  });
});

// Carousel gambar untuk eksplorasi program
let currentIndex = 0;
const cards = document.querySelectorAll(".explore__card");
const totalCards = cards.length;

document
  .querySelector(".explore__nav .ri-arrow-right-line")
  .addEventListener("click", () => {
    cards[currentIndex].classList.remove("active");
    currentIndex = (currentIndex + 1) % totalCards;
    cards[currentIndex].classList.add("active");
  });

document
  .querySelector(".explore__nav .ri-arrow-left-line")
  .addEventListener("click", () => {
    cards[currentIndex].classList.remove("active");
    currentIndex = (currentIndex - 1 + totalCards) % totalCards;
    cards[currentIndex].classList.add("active");
  });

// Review slider fungsional
let reviewIndex = 0;
const reviews = document.querySelectorAll(".review__item");
const totalReviews = reviews.length;

function showReview(index) {
  reviews.forEach((review, i) => {
    review.classList.toggle("active", i === index);
  });
}

document.querySelector(".review__nav .next").addEventListener("click", () => {
  reviewIndex = (reviewIndex + 1) % totalReviews;
  showReview(reviewIndex);
});

document.querySelector(".review__nav .prev").addEventListener("click", () => {
  reviewIndex = (reviewIndex - 1 + totalReviews) % totalReviews;
  showReview(reviewIndex);
});

// Toggle class for mobile navigation
const navToggle = document.querySelector(".nav__toggle");
const navLinks = document.querySelector(".nav__links");

navToggle.addEventListener("click", () => {
  navLinks.classList.toggle("active");
});

// Validasi formulir untuk pemesanan kelas
document
  .querySelector(".booking-form")
  .addEventListener("submit", function (e) {
    const name = document.querySelector("#name").value;
    const email = document.querySelector("#email").value;

    if (!name || !email) {
      e.preventDefault();
      alert("Please fill out all fields.");
    }
  });

//Pembaruan harga dinamis
const membershipSelect = document.querySelector("#membership");
const priceDisplay = document.querySelector(".price-display");

membershipSelect.addEventListener("change", function () {
  const selectedPrice = this.value;
  priceDisplay.textContent = `$${selectedPrice}`;
});

//untuk nav agar tetap stay diatas
const nav = document.querySelector("nav");

window.addEventListener("scroll", () => {
  if (window.scrollY > 50) {
    nav.classList.add("scrolled");
  } else {
    nav.classList.remove("scrolled");
  }
});
