document.addEventListener("DOMContentLoaded", () => {
  const search = document.getElementById("menuSearch");
  const cards = document.querySelectorAll(".menu-product");
  if (search) {
    search.addEventListener("input", () => {
      const term = search.value.trim().toLowerCase();
      cards.forEach(card => {
        card.style.display = card.dataset.name.includes(term) ? "" : "none";
      });
    });
  }
});