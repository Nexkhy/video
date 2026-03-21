<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éco-Santé - Téléconsultation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/eco_sante.css">
</head>


<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-heartbeat"></i>
            <h4>Eco_santé</h4>
        </div>

        <ul class="nav-links">
            <li><a href="#hero">Accueil</a></li>
            <li><a href="#disponibilites">Disponibilités</a></li>
            <li><a href="#propos">À Propos</a></li>
            <li><a href="#premiers-soins">Premiers Soins</a></li>
            <li><a href="#contact">Contact</a></li>
            <li>
                <a href="./login.php" class="nav-link" class="btn" id="btn-login">
                    Se connecter
                </a>
            </li>
             
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
               

    <!-- Section 1: Hero Banner -->
    <section id="hero" class="hero-section" style="background-image: url('./assets/images/theme.png');">
        <div class="hero-overlay"></div>
        <div class="hero-content reveal">
            <h1>Votre santé, notre priorité, <br>où que vous soyez.</h1>
            <p>Consultez des médecins qualifiés en vidéo depuis le confort de votre domicile.</p>
            <div class="hero-btns">
                <a href="./register.php" class="btn ">S'inscrire</a>
                <a href="./view/CONNEXION.php" class="btn btn-soignant" style="background: #28a745; "  >Vous êtes soignant ?</a>
                <!-- <a href="view/CONNEXION.php" class="btn " style="background: #02dd56;">Espace soignant</a> -->
            </div>
        </div>
    </section>

    <!-- Section 2: Nos Disponibilités -->
    <section id="disponibilites" class="section-padding">
        <h2 class="section-title reveal">Nos Disponibilités & Spécialités</h2>
        <div class="grid-container reveal">
            <div class="card">
                <div class="icon">📅</div>
                <h3>Généralistes</h3>
                <p>Lun - Dim : 24h/24</p>
                <span class="badge">Disponible</span>
            </div>
            <div class="card">
                <div class="icon">👶</div>
                <h3>Pédiatrie</h3>
                <p>Lun - Ven : 08h - 20h</p>
                <span class="badge">Sur RDV</span>
            </div>
            <div class="card">
                <div class="icon">🌿</div>
                <h3>Nathurophate</h3>
                <p>Mar - Sam : 09h - 18h</p>
                <span class="badge">Sur RDV</span>
            </div>
            <div class="card">
                <div class="icon">❤️</div>
                <h3>Cardiologie</h3>
                <p>Mer - Ven : 10h - 16h</p>
                <span class="badge">Urgence possible</span>
            </div>
        </div>
    </section>

    <!-- Section 3: Témoignages & À Propos -->
    <section id="propos" class="about-section section-padding">
        <div class="about-container">
            <div class="about-text reveal">
                <h2>À propos de EcoSanter</h2>
                <p>EcoSanter est une plateforme innovante conçue pour faciliter l'accès aux soins de santé en
                    Afrique. Nous connectons des patients avec des praticiens expérimentés via une interface sécurisée
                    et intuitive.</p>
                <p>Notre mission est de briser les barrières géographiques pour offrir une expertise médicale de haute
                    qualité à tous.</p>
            </div>
            <div class="testimonials reveal">
                <h3>Ce que disent nos patients</h3>
                <div class="testimonial-card">
                    <img src="./assets/images/naturoSoins.png"
                        alt="Patient">
                    <div>
                        <p>"Le praticiens a été très à l'écoute. Service rapide et efficace !"</p>
                        <h4>Aminata K.</h4>
                    </div>
                </div>
                <div class="testimonial-card">
                    <img src="./assets/images/client.png"
                        alt="Patient">
                    <div>
                        <p>"Pratique pour consulter sans avoir à traverser les embouteillages."</p>
                        <h4>ignace fokou </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Premiers Soins -->
    <section id="premiers-soins" class="section-padding bg-light">
        <h2 class="section-title reveal">Conseils de Premiers Soins</h2>
        <div class="grid-container reveal">
            <div class="step-card">
                <div class="step-num">01</div>
                <h3>Brûlures</h3>
                <p>Faites couler de l'eau tiède (pas froide) sur la zone pendant 15 minutes avant de couvrir d'un linge
                    propre.</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <h3>Étouffement</h3>
                <p>Encouragez la personne à tousser. Si elle ne peut plus respirer, pratiquez la manœuvre de Heimlich.
                </p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <h3>Inconscience</h3>
                <p>Vérifiez la respiration, placez la personne en Position Latérale de Sécurité (PLS) et appelez les
                    secours.</p>
            </div>
        </div>
    </section>

    <!-- Section 5: Urgence -->
    <section class="emergency-section reveal">
        <div class="emergency-box">
            <h2 style="color: red;">⚠️ Urgence Médicale ?</h2>
            <p>Si vous faites face à une détresse vitale, n'attendez pas la consultation en ligne.</p>
            <div class="emergency-call">
                <a href="tel:119" class="btn btn-emergency">Appeler le SAMU (119)</a>
            </div>
            <small>Note : Notre service de téléconsultation ne remplace pas les urgences hospitalières pour les cas
                critiques.</small>
        </div>
    </section>

    <!-- Formulaire de Contact -->
    <section id="contact" class="section-padding">
        <div class="contact-form-container reveal">
            <h2>Contactez-nous</h2>
            <form id="medicalForm">
                <input type="text" id="name" placeholder="Votre Nom complet" required>
                <input type="email" id="email" placeholder="Votre Email" required>
                <textarea id="message" rows="5" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                <button type="submit" class="btn btn-primary">Envoyer le message</button>
            </form>
            <div id="formFeedback"></div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Eco_santé</h3>
                    <p>Plateforme de téléconsultation médicale</p>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <a href="#" id="footer-accueil">Accueil</a>
                    <a href="#about" id="footer-about">À propos</a>
                    <a href="#">Mentions légales</a>
                    <a href="#">Politique de confidentialité</a>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>contact@Eco_santé.fr</p>
                    <p>+237 98 30 87 80</p>
                    <p>123 Rue de la Santé, Douala</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Eco_santé. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    <script src="./assets/js/index.js"></script>
</body>

</html>