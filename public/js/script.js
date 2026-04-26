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

    console.log("Ecommerce UI initialized.");
});
