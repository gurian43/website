const imgURLs = [
    "/resources/images/landing-page-bg1.webp",
    "/resources/images/landing-page-bg2.webp"
]

document.getElementsByClassName('landing-page')[0].style.backgroundImage = `url(${imgURLs[Math.floor(Math.random() * imgURLs.length)]})`;

const landerDot = document.getElementById('lander-dot');
const aboutDot = document.getElementById('about-dot');
const projectsDot = document.getElementById('projects-dot');


const scrollToTop = () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
}

const scrollToSection = (section) => {
    const sectionElement = document.getElementById(section);
    if (sectionElement) {
        sectionElement.scrollIntoView({behavior: 'smooth'});
    }
}

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
            switch (currentSection.id) {
                case 'welcome':
                    landerDot.classList.add('active');
                    aboutDot.classList.remove('active');
                    projectsDot.classList.remove('active');
                    break;
                case 'about':
                    landerDot.classList.remove('active');
                    aboutDot.classList.add('active');
                    projectsDot.classList.remove('active');
                    break;
                case 'projects':
                    landerDot.classList.remove('active');
                    aboutDot.classList.remove('active');
                    projectsDot.classList.add('active');
                    break;
            }
        }
    }

    window.addEventListener("scroll", detectCurrentPage);
    detectCurrentPage();
});