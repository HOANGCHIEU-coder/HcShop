document.addEventListener("DOMContentLoaded", () => {
  const logoutBtn = document.getElementById("logoutBtn");
  const userGreeting = document.getElementById("userGreeting");
  const logoutLi = document.getElementById("logoutLi");
  const loginLi = document.getElementById("loginLi");
  const registerLi = document.getElementById("registerLi");

  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();

      fetch("logout.php")
        .then(res => {
          if (res.ok) {
            // Ẩn phần người dùng
            if (userGreeting) userGreeting.style.display = "none";
            if (logoutLi) logoutLi.style.display = "none";

            // Hiện login/register
            if (loginLi) loginLi.style.display = "block";
            if (registerLi) registerLi.style.display = "block";

            // 🟢 Hiển thị thông báo tùy chỉnh
            const msg = document.getElementById("logoutMessage");
            if (msg) {
              msg.style.display = "block";
              setTimeout(() => {
                msg.style.display = "none";
              }, 2000); // tự tắt sau 2s
            }
          }
        });
    });
  }

});