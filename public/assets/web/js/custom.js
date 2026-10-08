(function () {
  const header = document.getElementById('header');
  const headerTheme = header ? header.dataset.headerTheme || 'light' : 'light';
  const logoText = document.getElementById('logo-text');
  const logoSub = document.getElementById('logo-sub');
  const headerPhone = document.getElementById('header-phone');
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuBars = menuToggle ? menuToggle.querySelectorAll('span') : [];
  const navLinks = document.querySelectorAll('#header nav .nav-link');
  const mobileMenuLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];
  const scrollTopBtn = document.getElementById('scroll-top');
  const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
  const isHomeHeader = headerTheme === 'dark';
  const isMobileViewport = function () {
    return window.innerWidth < 1024;
  };

  function syncMobileMenuPosition() {
    if (!header || !mobileMenu) return;
    const headerHeight = Math.ceil(header.getBoundingClientRect().height);
    mobileMenu.style.top = headerHeight + 'px';
    mobileMenu.style.maxHeight = 'calc(100vh - ' + headerHeight + 'px)';
  }

  function closeMobileMenu() {
    if (!menuToggle || !mobileMenu) return;
    mobileMenu.classList.add('hidden');
    menuToggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('mobile-menu-open');
  }

  function openMobileMenu() {
    if (!menuToggle || !mobileMenu) return;
    syncMobileMenuPosition();
    mobileMenu.classList.remove('hidden');
    menuToggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('mobile-menu-open');
  }

  function applyHeaderState(isScrolled) {
    if (!header) return;
    const isMobile = isMobileViewport();

    header.classList.toggle('scrolled', isScrolled);

    if (isScrolled) {
      header.style.background = 'rgba(250,248,244,0.96)';
      header.style.paddingTop = isMobile ? '18px' : (isHomeHeader ? '24px' : '12px');
      header.style.paddingBottom = isMobile ? '18px' : (isHomeHeader ? '24px' : '12px');
      header.style.boxShadow = '0 10px 30px rgba(17,16,16,0.06), 0 1px 0 rgba(184,150,46,0.12)';
      if (logoText) logoText.style.color = '#111010';
      if (logoSub) logoSub.style.color = 'rgba(17,16,16,0.4)';
      navLinks.forEach(function (link) {
        if (!link.classList.contains('active')) link.style.color = 'rgba(17,16,16,0.7)';
      });
      if (headerPhone) headerPhone.style.color = 'rgba(17,16,16,0.45)';
      menuBars.forEach(function (bar) { bar.style.background = '#111010'; });
      syncMobileMenuPosition();
      return;
    }

    header.style.paddingTop = isMobile ? '18px' : (isHomeHeader ? '24px' : '');
    header.style.paddingBottom = isMobile ? '18px' : (isHomeHeader ? '24px' : '');

    if (headerTheme === 'dark') {
      header.style.background = 'transparent';
      header.style.boxShadow = '';
      if (logoText) logoText.style.color = 'white';
      if (logoSub) logoSub.style.color = 'rgba(255,255,255,0.5)';
      navLinks.forEach(function (link) {
        if (!link.classList.contains('active')) link.style.color = 'rgba(255,255,255,0.85)';
      });
      if (headerPhone) headerPhone.style.color = 'rgba(255,255,255,0.7)';
      menuBars.forEach(function (bar) { bar.style.background = 'white'; });
    } else {
      header.style.background = 'rgba(250,248,244,0.95)';
      header.style.boxShadow = '0 1px 0 rgba(184,150,46,0.15)';
      if (logoText) logoText.style.color = '#111010';
      if (logoSub) logoSub.style.color = 'rgba(17,16,16,0.3)';
      navLinks.forEach(function (link) {
        if (!link.classList.contains('active')) link.style.color = 'rgba(17,16,16,0.7)';
      });
      if (headerPhone) headerPhone.style.color = 'rgba(17,16,16,0.4)';
      menuBars.forEach(function (bar) { bar.style.background = '#111010'; });
    }

    syncMobileMenuPosition();
  }

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', function () {
      if (mobileMenu.classList.contains('hidden')) {
        openMobileMenu();
      } else {
        closeMobileMenu();
      }
    });

    mobileMenuLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        closeMobileMenu();
      });
    });

    document.addEventListener('click', function (event) {
      if (mobileMenu.classList.contains('hidden')) return;
      if (header.contains(event.target)) return;
      closeMobileMenu();
    });

    window.addEventListener('resize', function () {
      syncMobileMenuPosition();
      if (window.innerWidth >= 1024) {
        closeMobileMenu();
      }
    });
  }

  window.addEventListener('scroll', function () {
    applyHeaderState(window.scrollY > 80);
    if (scrollTopBtn) {
      if (window.scrollY > 400) {
        scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
      } else {
        scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
      }
    }
  });

  if (revealEls.length) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    revealEls.forEach(function (el) { observer.observe(el); });
  }

  syncMobileMenuPosition();
  applyHeaderState(window.scrollY > 80);
})();

function switchTab(btn, id) {
  document.querySelectorAll('.tab-btn').forEach(function (b) {
    b.classList.remove('text-gold', 'border-gold', 'bg-gold/5');
    b.classList.add('text-ink/40', 'border-transparent');
    b.setAttribute('aria-selected', 'false');
  });
  document.querySelectorAll('.tab-panel').forEach(function (panel) {
    panel.classList.add('hidden');
  });
  btn.classList.add('text-gold', 'border-gold', 'bg-gold/5');
  btn.classList.remove('text-ink/40', 'border-transparent');
  btn.setAttribute('aria-selected', 'true');
  document.getElementById('tab-' + id).classList.remove('hidden');
}
