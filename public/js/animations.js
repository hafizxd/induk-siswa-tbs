document.addEventListener("DOMContentLoaded", () => {
    gsap.to(".slogan", {
        opacity: 1,
        y: 0,
        duration: 0.5,
        ease: "power2.inOut",
    });
});

document.addEventListener("DOMContentLoaded", () => {
    // Ensure the DOM is fully loaded before running animations
    gsap.from(".box-content-animate", {
        opacity: 0,
        y: 50,
        duration: 1,
        ease: "power2.out", // You can adjust the easing function
        stagger: 0.2, // Optional: stagger the animation slightly for each element
    });
});
