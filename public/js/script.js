// Main Script File
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle functionality
    const menuIcon = document.querySelector('.mobile-menu-icon');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    
    function openSidebar() {
        if(mobileSidebar) mobileSidebar.classList.add('active');
        if(sidebarOverlay) sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeSidebar() {
        if(mobileSidebar) mobileSidebar.classList.remove('active');
        if(sidebarOverlay) sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (menuIcon) {
        menuIcon.addEventListener('click', openSidebar);
    }
    
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', closeSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // List/Grid View Toggle Functionality for web-list page
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const productContainer = document.getElementById('productContainer');
    
    // Add event listeners if these buttons exist on the page
    if (gridViewBtn && listViewBtn && productContainer) {
        gridViewBtn.addEventListener('click', function() {
            // Change active state on buttons
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            // Change view class on container
            productContainer.classList.remove('list-view');
            productContainer.classList.add('grid-view');
        });

        listViewBtn.addEventListener('click', function() {
            // Change active state on buttons
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            // Change view class on container
            productContainer.classList.remove('grid-view');
            productContainer.classList.add('list-view');
        });
    }

    // Product Detail Page Logic
    // 1. Image Gallery Switching
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Update main image source
                const newSrc = this.querySelector('img').src;
                mainImage.src = newSrc;
                
                // Update active thumbnail state
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    // 2. Quantity Selector (handles multiple items)
    const quantitySelectors = document.querySelectorAll('.item-quantity, .quantity-selector');
    
    quantitySelectors.forEach(selector => {
        const qtyInput = selector.querySelector('.qty-input');
        const minusBtn = selector.querySelector('.qty-btn.minus');
        const plusBtn = selector.querySelector('.qty-btn.plus');
        
        if (qtyInput && minusBtn && plusBtn) {
            minusBtn.addEventListener('click', () => {
                let val = parseInt(qtyInput.value);
                if (val > 1) qtyInput.value = val - 1;
            });
            
            plusBtn.addEventListener('click', () => {
                let val = parseInt(qtyInput.value);
                qtyInput.value = val + 1;
            });
        }
    });

    // 3. Tab Switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    if (tabBtns.length > 0) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-tab');
                
                // Remove active classes
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to current
                this.classList.add('active');
                const targetContent = document.getElementById(targetId);
                if (targetContent) targetContent.classList.add('active');
            });
        });
    }

    console.log("Ecommerce UI initialized.");
});
