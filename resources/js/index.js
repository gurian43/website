const imgURLs = [
    {
        url: "/resources/images/landing-page-bg1.webp",
        author: "narukami tooru ❤️"
    },
    {
        url: "/resources/images/landing-page-bg2.webp",
        author: "narukami tooru ❤️"
    }
]

const sounds = [
    new Audio('/resources/sounds/win.mp3'), 
    new Audio('/resources/sounds/yippe.mp3')
];

const sections = [
    'lander',
    'about',
    'projects',
    'stuff'
]

let currentSection = null;

let randImg = imgURLs[Math.floor(Math.random() * imgURLs.length)];

document.getElementsByClassName('landing-page')[0].style.backgroundImage = `url(${randImg.url})`;
document.getElementById('author').innerText = `art by ${randImg.author}`;

//1 in 10 to get miku :3
if(Math.random() < 0.1) {
    document.getElementsByClassName('landing-page')[0].style.backgroundImage = `url(/resources/images/miku.webp)`;
    document.getElementById('author').innerText = `art by koafreedraw`;
}

const dots = document.querySelectorAll('.dot');

const scrollToTop = () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
}

const scrollToSection = (sectionID) => {
    const sectionElement = document.getElementById(sectionID);
    if (sectionElement) {
        sectionElement.scrollIntoView({behavior: 'smooth'});
    }
}

const scrollToNextSection = () => {
    let nextSection = sections[sections.indexOf(currentSection.id)+1];

    if (nextSection) {
        scrollToSection(nextSection);
    } else {
        scrollToTop();
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

document.addEventListener('keydown', (event) => {
    if (event.key == ' ') {
        scrollToNextSection();
        event.preventDefault();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    function detectCurrentPage() {
        const sections = document.querySelectorAll('.page');
        const faders = document.querySelectorAll('.fade-in');

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