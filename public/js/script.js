// js/script.js
document.addEventListener('DOMContentLoaded', () => {
    // Preloader
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        document.body.classList.add('loading');
        const minimumLoadTime = 4000;
        const startTime = Date.now();

        window.addEventListener('load', () => {
            const elapsedTime = Date.now() - startTime;
            const remainingTime = Math.max(0, minimumLoadTime - elapsedTime);

            setTimeout(() => {
                preloader.classList.add('hidden');
                document.body.classList.remove('loading');
                document.body.classList.add('loaded');
            }, remainingTime);
        });
    }

    // Owl Carousel
    if (typeof $.fn.owlCarousel !== 'undefined' && $('.owl-carousel').length) {
        $('.owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            nav: false,
            dots: false,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>']
        });
    }

    // Smooth Scrolling for Anchor Links
    $('a[href^="#"]').on('click', (e) => {
        e.preventDefault();
        const target = $(e.currentTarget.getAttribute('href'));
        if (target.length) {
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 20
            }, 800, 'swing');
        }
    });

    // Intersection Observer for Animated Items
    const animateItems = document.querySelectorAll('.animate-item');
    if (animateItems.length) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animate__animated', 'animate__fadeInUp', 'visible');
                            entry.target.style.opacity = '1';
                            observer.unobserve(entry.target);
                        }, index * 200);
                    }
                });
            },
            { threshold: 0.3 }
        );

        animateItems.forEach((item) => observer.observe(item));
    }

    // Scroll to Top Button
    const scrollTopWrapper = $('.scroll-top-wrapper');
    if (scrollTopWrapper.length) {
        $(window).on('scroll', () => {
            scrollTopWrapper.toggleClass('show', $(window).scrollTop() > 100);
        });

        scrollTopWrapper.on('click', () => {
            $('html, body').animate({ scrollTop: 0 }, 500, 'linear');
        });
    }

    // Animated Counters
    const counters = document.querySelectorAll('.counter-item h2');
    if (counters.length) {
        const counterObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.textContent);
                        let count = 0;
                        const increment = target / 50;

                        const updateCounter = () => {
                            if (count < target) {
                                count += increment;
                                counter.textContent = Math.ceil(count);
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target;
                            }
                        };

                        updateCounter();
                        counterObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.5 }
        );

        counters.forEach((counter) => counterObserver.observe(counter));
    }
});