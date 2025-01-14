const imgURLs = [
    "/resources/images/landing-page-bg1.webp",
    "/resources/images/landing-page-bg2.webp"
]

const sounds = [
    new Audio('/resources/sounds/win.mp3'), 
    new Audio('/resources/sounds/yippe.mp3')
];

document.getElementsByClassName('landing-page')[0].style.backgroundImage = `url(${imgURLs[Math.floor(Math.random() * imgURLs.length)]})`;

const dots = document.querySelectorAll('.dot');

const scrollToTop = () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
}

const scrollToSection = (section) => {
    const sectionElement = document.getElementById(section);
    if (sectionElement) {
        sectionElement.scrollIntoView({behavior: 'smooth'});
    }
}

document.querySelector('.logo').addEventListener('click', () => {
    sounds[Math.floor(Math.random() * sounds.length)].play();

    confetti({
        particleCount: 100,
        angle: 45,
        spread: 80,
        origin: { x: 0, y: 1 }
    });

    confetti({
        particleCount: 100,
        angle: 135,
        spread: 80,
        origin: { x: 1, y: 1 }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    function detectCurrentPage() {
        const sections = document.querySelectorAll('.page');
        const faders = document.querySelectorAll('.fade-in');
        let currentSection = null;

        const appearOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    return;
                } else {
                    entry.target.classList.add('visible');
                    appearOnScroll.unobserve(entry.target);
                }
            });
        }, appearOptions);
    
        faders.forEach(fader => {
            appearOnScroll.observe(fader);
        });

        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top >= 0 && rect.top < window.innerHeight / 2) {
                currentSection = section;
            }
        });

        if (currentSection) {
            dots.forEach(dot => {
                if(dot.id !== `${currentSection.id}-dot`) {
                    dot.classList.remove('active')
                } else {
                    dot.classList.add('active');
                }
            });
        }
    }

    window.addEventListener("scroll", detectCurrentPage);
    detectCurrentPage();
});