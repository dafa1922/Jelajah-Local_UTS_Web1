(function () {
    const navigation = document.querySelector(".site-navbar .navbar-nav");
    if (!navigation) return;

    const loggedIn = Boolean(localStorage.getItem("loggedInUser"));
    const loginLink = navigation.querySelector('a[href="login.html"]');
    const registerLink = navigation.querySelector('.navbar-auth a[href="register.html"]');

    if (loggedIn) {
        if (registerLink) registerLink.hidden = true;
    }

    if (loginLink && loggedIn) {
        loginLink.href = "index.html";
        loginLink.textContent = "Logout";
        loginLink.classList.remove("active");
        loginLink.dataset.logout = "true";
    }

    navigation.addEventListener("click", function (event) {
        if (!(event.target instanceof Element)) return;

        const logoutLink = event.target.closest("[data-logout]");
        if (!logoutLink) return;

        event.preventDefault();
        localStorage.removeItem("loggedInUser");
        window.location.href = "index.html";
    });
})();
