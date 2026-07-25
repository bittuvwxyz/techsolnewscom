const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");

if (menuBtn && navLinks) {
  menuBtn.addEventListener("click", () => {
    navLinks.classList.toggle("open");
  });
}

const contactForm = document.querySelector("#contactForm");
if (contactForm) {
  contactForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const messageBox = document.querySelector("#formStatus");
    if (messageBox) {
      messageBox.textContent =
        "Thank you! Your request has been received. We will contact you soon.";
    }
    contactForm.reset();
  });
}

// post blog

document.addEventListener("DOMContentLoaded", () => {

    const views = document.querySelector(".staticblog-views");

    let count = 0;
    const target = 24563;

    const timer = setInterval(() => {

        count += Math.ceil(target / 100);

        if (count >= target) {
            count = target;
            clearInterval(timer);
        }

        views.innerHTML = "👁 " + count.toLocaleString() + " Views";

    }, 20);

});

// end blog