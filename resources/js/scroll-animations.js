// ===== SCROLL REVEAL ANIMATIONS =====

document.addEventListener('DOMContentLoaded', function() {
    
    // Configuration de l'observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // L'élément doit être visible à 10%
    };

    // Callback quand un élément entre dans le viewport
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                // Optionnel : arrêter d'observer après animation
                // observer.unobserve(entry.target);
            }
        });
    };

    // Créer l'observer
    const observer = new IntersectionObserver(observerCallback, observerOptions);

    // Observer tous les éléments avec les classes scroll-reveal
    const elementsToReveal = document.querySelectorAll(
        '.scroll-reveal, .scroll-reveal-left, .scroll-reveal-right, .scroll-reveal-scale'
    );

    elementsToReveal.forEach(element => {
        observer.observe(element);
    });

    // ===== PAGE LOAD ANIMATION =====
    
    // Ajouter la classe de transition au body
    document.body.classList.add('page-transition');

    // Cacher le loader si présent
    const loader = document.querySelector('.page-loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 300);
    }
});

// ===== SMOOTH SCROLL POUR LES ANCRES =====

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});