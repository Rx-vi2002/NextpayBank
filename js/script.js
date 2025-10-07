// Basic JavaScript for interactive elements
document.addEventListener("DOMContentLoaded", function () {
  // Add smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // Add loading states to buttons
  document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", function () {
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.innerHTML = "Processing...";
        submitBtn.disabled = true;
      }
    });
  });

  // Demo functionality for dashboard
  console.log("NextPay Bank System Loaded");
  console.log("CTF Challenges Available:");
  console.log("1. IDOR - Try accessing different invoice IDs");
  console.log("2. SQL Injection - Use payload in admin login");
  console.log("3. XSS - Submit script in feedback form");
});
