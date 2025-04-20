// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add scroll animation
    const scrollElements = document.querySelectorAll('.service-item, .team-member');
    
    // Create the Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    // Observe each element
    scrollElements.forEach(element => {
        observer.observe(element);
    });
    
    // Mobile navigation toggle
    const mobileToggle = document.createElement('div');
    mobileToggle.className = 'mobile-toggle';
    mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
    document.querySelector('header .container').appendChild(mobileToggle);
    
    const navList = document.querySelector('nav ul');
    
    mobileToggle.addEventListener('click', function() {
        navList.classList.toggle('active');
        this.innerHTML = navList.classList.contains('active') ? 
            '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
    
    // Add some extra CSS for the animation
    const style = document.createElement('style');
    style.textContent = `
        .service-item, .team-member {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .service-item.animate, .team-member.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .mobile-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
        }
    `;
    
    document.head.appendChild(style);
});
