document.addEventListener('DOMContentLoaded', () => {

    // --- Menu Mobile (Hamburger) ---
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        // Toggle Nav
        nav.classList.toggle('nav-active');

        // Animate Links
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
            }
        });

        // Burger Animation
        burger.classList.toggle('toggle');
    });

    // Fermer le menu lors d'un clic sur un lien (mobile)
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('nav-active');
            burger.classList.remove('toggle');
            navLinks.forEach(l => l.style.animation = '');
        });
    });
    // --- Animation d'apparition au Scroll (Reveal) ---
    const revealElements = document.querySelectorAll('.reveal');

    const revealOnScroll = () => {
        const windowHeight = window.innerHeight;
        const revealPoint = 150;

        revealElements.forEach(el => {
            const revealTop = el.getBoundingClientRect().top;
            if (revealTop < windowHeight - revealPoint) {
                el.classList.add('active');
            }
        });
    };

    window.addEventListener('scroll', revealOnScroll);
    // Lancer une fois au chargement
    revealOnScroll();
    // --- Validation du Formulaire de Contact ---
    const medicalForm = document.getElementById('medicalForm');
    const feedback = document.getElementById('formFeedback');

    medicalForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        // Simulation d'envoi
        if (name && email && message) {
            feedback.innerHTML = `<p style="color: green; margin-top: 15px;">Merci ${name}, votre message a été envoyé avec succès ! Un conseiller vous répondra sous peu.</p>`;
            medicalForm.reset();
        } else {
            feedback.innerHTML = `<p style="color: red; margin-top: 15px;">Veuillez remplir tous les champs.</p>`;
        }
    });

    // --- Effet de changement de couleur du Nav au Scroll ---
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.style.padding = '10px 8%';
            navbar.style.background = '#ffffffef';
        } else {
            navbar.style.padding = '20px 8%';
            navbar.style.background = '#ffffff';
        }
    });


    // ---PAGE DE LOGIN ET DE REGISTER -----

    document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Animation d'apparition au Scroll ---
    const revealElements = document.querySelectorAll('.reveal');
    const revealOnScroll = () => {
        revealElements.forEach(el => {
            const revealTop = el.getBoundingClientRect().top;
            if (revealTop < window.innerHeight - 100) {
                el.classList.add('active');
            }
        });
    };
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll(); // Appel initial

    // --- 2. Menu Mobile ---
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    if(burger) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('nav-active');
            burger.classList.toggle('toggle');
        });
    }

    // --- 3. Validation Login ---
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('loginError');

            if (!validateEmail(email)) {
                showError(errorDiv, "Veuillez entrer un email valide.");
            } else if (password.length < 1) {
                showError(errorDiv, "Le mot de passe est requis.");
            } else {
                showSuccess(errorDiv, "Connexion réussie ! Redirection...");
                setTimeout(() => { window.location.href = "index.html"; }, 2000);
            }
        });
    }

    // --- 4. Validation Inscription ---
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('fullName').value;
            const email = document.getElementById('regEmail').value;
            const pass = document.getElementById('regPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            const statusDiv = document.getElementById('registerStatus');

            if (name.length < 3) {
                showError(statusDiv, "Nom trop court.");
            } else if (!validateEmail(email)) {
                showError(statusDiv, "Email invalide.");
            } else if (pass.length < 6) {
                showError(statusDiv, "Le mot de passe doit faire au moins 6 caractères.");
            } else if (pass !== confirm) {
                showError(statusDiv, "Les mots de passe ne correspondent pas.");
            } else {
                showSuccess(statusDiv, "Compte créé avec succès !");
                setTimeout(() => { window.location.href = "login.html"; }, 2500);
            }
        });
    }

    // --- Fonctions Utilitaires ---
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showError(element, message) {
        element.textContent = message;
        element.style.color = "#e74c3c";
        element.classList.add('shake'); // Optionnel: ajouter une animation
        setTimeout(() => element.classList.remove('shake'), 500);
    }

    function showSuccess(element, message) {
        element.textContent = message;
        element.style.color = "#2ecc71";
    }
});
});80