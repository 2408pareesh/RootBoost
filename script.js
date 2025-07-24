function showContent(id) {
  const sections = document.querySelectorAll('.content-section');
  sections.forEach(sec => sec.classList.add('hidden'));
  const active = document.getElementById(id);
  if (active) active.classList.remove('hidden');
}

// Initial splash logic
window.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.getElementById('splash').style.display = 'none';
    const main = document.getElementById('main');
    main.classList.remove('hidden');
    showContent('home'); // Show default section
  }, 1000); // 1 second delay
});

let score = 0;
const scoreElement = document.getElementById("score");

function updateScore() {
  score += Math.floor(Math.random() * 10);
  if (score > 9999) score = 0; // reset for demo loop
  scoreElement.textContent = "SCORE: " + score.toString().padStart(4, "0");
}

setInterval(updateScore, 500);

document.querySelector('.sideMenuCls').addEventListener('click', function () {
  document.querySelector('.sidemenu-wrapper').classList.remove('active');
});

function togglePassword() {
    const passwordField = document.getElementById("password");
    const icon = document.querySelector(".toggle-password i");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}