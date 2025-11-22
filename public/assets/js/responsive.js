// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-nav-toggle');
    const navMenu = document.querySelector('.navmenu');
    
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
        
        // Close menu when clicking on menu items
        const menuItems = navMenu.querySelectorAll('a');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                navMenu.classList.remove('active');
            });
        });
    }
    
    // Responsive table scroll
    const tables = document.querySelectorAll('.table-responsive');
    tables.forEach(table => {
        if (window.innerWidth < 768) {
            table.style.overflowX = 'auto';
        }
    });
    
    // Responsive card layout
    function adjustCardLayout() {
        const cards = document.querySelectorAll('.card');
        if (window.innerWidth < 576) {
            cards.forEach(card => {
                card.style.margin = '10px 0';
            });
        }
    }
    
    adjustCardLayout();
    window.addEventListener('resize', adjustCardLayout);
});