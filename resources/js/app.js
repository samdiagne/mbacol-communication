import './bootstrap'
import './scroll-animations'; 

// Scroll to top button
const scrollBtn = document.getElementById('scrollToTopBtn')

if (scrollBtn) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollBtn.classList.remove('hidden')
            scrollBtn.classList.add('flex')
        } else {
            scrollBtn.classList.add('hidden')
            scrollBtn.classList.remove('flex')
        }
    })

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        })
    })
}
