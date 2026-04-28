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
        document.body.style.overflow = 'hidden'; 
    }

    function closeSidebar() {
        if(mobileSidebar) mobileSidebar.classList.remove('active');
        if(sidebarOverlay) sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (menuIcon) menuIcon.addEventListener('click', openSidebar);
    if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // List/Grid View Toggle
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const productContainer = document.getElementById('productContainer');
    
    if (gridViewBtn && listViewBtn && productContainer) {
        gridViewBtn.addEventListener('click', function() {
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            productContainer.classList.remove('list-view');
            productContainer.classList.add('grid-view');
        });

        listViewBtn.addEventListener('click', function() {
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            productContainer.classList.remove('grid-view');
            productContainer.classList.add('list-view');
        });
    }

    // Image Gallery
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.querySelector('img').src;
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    // Quantity Selector
    document.querySelectorAll('.item-quantity, .quantity-selector').forEach(selector => {
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

    // General Tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    if (tabBtns.length > 0) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                const targetContent = document.getElementById(targetId);
                if (targetContent) targetContent.classList.add('active');
            });
        });
    }

    // Auth Tabs
    const loginTabBtn = document.querySelector('.tab-btn-login');
    const registerTabBtn = document.querySelector('.tab-btn-register');
    const loginPane = document.getElementById('login-tab');
    const registerPane = document.getElementById('register-tab');

    if (loginTabBtn && registerTabBtn) {
        loginTabBtn.addEventListener('click', () => {
            loginTabBtn.classList.add('active');
            registerTabBtn.classList.remove('active');
            loginPane.classList.add('active');
            registerPane.classList.remove('active');
        });
        registerTabBtn.addEventListener('click', () => {
            registerTabBtn.classList.add('active');
            loginTabBtn.classList.remove('active');
            registerPane.classList.add('active');
            loginPane.classList.remove('active');
        });
    }

    // Password Visibility Toggle
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (input) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            }
        });
    });

    // Password Strength & Match
    const regPassword = document.getElementById('reg_password');
    const confirmPassword = document.getElementById('password_confirmation');
    if (regPassword) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const matchText = document.getElementById('matchText');
        const reqList = document.getElementById('passwordRequirements');
        const reqLength = document.getElementById('req-length');
        const reqCase = document.getElementById('req-case');
        const reqNumber = document.getElementById('req-number');
        const reqSymbol = document.getElementById('req-symbol');

        regPassword.addEventListener('focus', () => reqList?.classList.add('active'));

        regPassword.addEventListener('input', function() {
            const val = this.value;
            let strength = 0;
            if (val.length >= 8) { strength++; reqLength?.classList.add('met'); } else { reqLength?.classList.remove('met'); }
            if (val.match(/[A-Z]/) && val.match(/[a-z]/)) { strength++; reqCase?.classList.add('met'); } else { reqCase?.classList.remove('met'); }
            if (val.match(/[0-9]/)) { strength++; reqNumber?.classList.add('met'); } else { reqNumber?.classList.remove('met'); }
            if (val.match(/[^A-Za-z0-9]/)) { strength++; reqSymbol?.classList.add('met'); } else { reqSymbol?.classList.remove('met'); }

            strengthBar.className = "strength-bar";
            strengthText.className = "strength-text";

            if (val === "") {
                strengthText.innerText = "Enter a password";
                strengthBar.style.width = "0";
            } else if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
                strengthText.classList.add('text-weak');
                strengthText.innerText = "Weak Password";
            } else if (strength === 3) {
                strengthBar.classList.add('strength-medium');
                strengthText.classList.add('text-medium');
                strengthText.innerText = "Medium Password";
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.classList.add('text-strong');
                strengthText.innerText = "Strong Password";
            }
            checkMatch(val, confirmPassword?.value, matchText);
        });

        if (confirmPassword) {
            confirmPassword.addEventListener('input', () => checkMatch(regPassword.value, confirmPassword.value, matchText));
        }
    }

    function checkMatch(p1, p2, matchText) {
        if (!matchText) return;
        if (!p2) { matchText.innerText = ""; matchText.className = "match-text"; }
        else if (p1 === p2) { matchText.innerText = "Passwords match"; matchText.className = "match-text match-success"; }
        else { matchText.innerText = "Passwords do not match"; matchText.className = "match-text match-error"; }
    }

    // Add to Cart Functionality
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;

            fetch(window.routes.cartAdd, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    this.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    const cartCountBadge = document.querySelector('.cart-count');
                    if (cartCountBadge) cartCountBadge.textContent = data.cartCount;
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                        this.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = originalContent;
                this.disabled = false;
            });
        });
    });

    // Countdown Timer
    if (document.getElementById('days')) {
        let countDownDate = new Date();
        countDownDate.setDate(countDownDate.getDate() + 4);
        const targetTime = countDownDate.getTime();
        setInterval(function() {
            const distance = targetTime - new Date().getTime();
            if (distance < 0) return;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("days").innerText = days.toString().padStart(2, '0');
            document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
            document.getElementById("mins").innerText = minutes.toString().padStart(2, '0');
            document.getElementById("secs").innerText = seconds.toString().padStart(2, '0');
        }, 1000);
    }
});