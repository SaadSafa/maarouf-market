window.showToast = function(message) {
    const t = document.createElement("div");
    t.className = "toast";
    t.textContent = message;

    document.body.appendChild(t);

    setTimeout(() => t.classList.add("show"), 50);
    setTimeout(() => t.classList.remove("show"), 2500);
    setTimeout(() => t.remove(), 3000);
    
}

window.showToast = showToast;