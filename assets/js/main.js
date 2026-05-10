// AYSA WORKS — basit ön yüz scriptleri
(function () {
  const header = document.querySelector('.site-header');
  const nav = document.querySelector('.nav');
  const toggle = document.querySelector('.menu-toggle');
  const body = document.body;
  const COMPACT_NAV_BP = 1180;
  const MOBILE_BP = 900;
  const subItems = nav ? Array.from(nav.querySelectorAll('.has-sub')) : [];

  const closeSubmenus = (except) => {
    subItems.forEach((li) => {
      if (li === except) return;
      li.classList.remove('open');
      const trigger = li.querySelector(':scope > a');
      if (trigger) trigger.setAttribute('aria-expanded', 'false');
    });
  };

  // Scroll'da header alt çizgi
  if (header) {
    let lastScrollY = Math.max(window.scrollY, 0);
    let ticking = false;

    const syncHeader = () => {
      const currentScrollY = Math.max(window.scrollY, 0);
      const delta = currentScrollY - lastScrollY;
      const isPastHeader = currentScrollY > header.offsetHeight;
      const isMenuOpen = body.classList.contains('is-menu-open');

      header.classList.toggle('scrolled', currentScrollY > 8);

      if (currentScrollY <= 8 || delta < -4 || isMenuOpen) {
        header.classList.remove('is-hidden');
      } else if (delta > 4 && isPastHeader) {
        header.classList.add('is-hidden');
      }

      lastScrollY = currentScrollY;
      ticking = false;
    };

    const onScroll = () => {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(syncHeader);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Mobile menü toggle
  if (toggle && nav) {
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-controls', 'primary-nav');
    nav.id = nav.id || 'primary-nav';

    const setMenu = (open) => {
      nav.classList.toggle('is-open', open);
      body.classList.toggle('is-menu-open', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (!open) {
        closeSubmenus();
      }
    };

    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      setMenu(!nav.classList.contains('is-open'));
    });

    // Menü içindeki gerçek linkleri tıklayınca kapat
    nav.querySelectorAll('a').forEach((a) => {
      a.addEventListener('click', () => {
        const href = a.getAttribute('href');
        if (href && href !== '#' && !a.parentElement.classList.contains('has-sub')) {
          if (window.innerWidth <= MOBILE_BP) setMenu(false);
        }
      });
    });

    // Dışa tıklama
    document.addEventListener('click', (e) => {
      if (!nav.classList.contains('is-open')) return;
      if (!nav.contains(e.target) && !toggle.contains(e.target)) setMenu(false);
    });

    // ESC kapatır
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) setMenu(false);
    });

    // Mobil boyuttan çıkıldığında menüyü kapat
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (window.innerWidth > COMPACT_NAV_BP && nav.classList.contains('is-open')) setMenu(false);
      }, 120);
    });
  }

  // Mobile'da submenü tıklayınca aç-kapa
  subItems.forEach((li) => {
    const a = li.querySelector(':scope > a');
    if (!a) return;

    a.setAttribute('aria-expanded', 'false');
    a.addEventListener('click', (e) => {
      if (window.innerWidth <= COMPACT_NAV_BP) {
        e.preventDefault();
        e.stopPropagation();
        const open = !li.classList.contains('open');
        closeSubmenus(li);
        li.classList.toggle('open', open);
        a.setAttribute('aria-expanded', open ? 'true' : 'false');
      }
    });
  });

  document.addEventListener('click', (e) => {
    if (!nav || window.innerWidth > COMPACT_NAV_BP) return;
    if (!nav.contains(e.target)) closeSubmenus();
  });

  // Mobilde proje kartı: ilk tık önizleme, ikinci tık linke gider.
  const projectCards = Array.from(document.querySelectorAll('.project-card'));
  const closeProjectPreviews = (except) => {
    projectCards.forEach((card) => {
      if (card !== except) card.classList.remove('is-preview');
    });
  };

  projectCards.forEach((card) => {
    card.addEventListener('click', (e) => {
      if (window.innerWidth > MOBILE_BP) return;
      if (card.classList.contains('is-preview')) return;

      e.preventDefault();
      closeProjectPreviews(card);
      card.classList.add('is-preview');
    });
  });

  document.addEventListener('click', (e) => {
    if (window.innerWidth > MOBILE_BP) return;
    if (!e.target.closest('.project-card')) closeProjectPreviews();
  });

  // Aktif menü öğesi
  const path = location.pathname.replace(/index\.html$/, '').replace(/\/$/, '');
  document.querySelectorAll('.nav a').forEach((a) => {
    const href = a.getAttribute('href');
    if (!href || href === '#') return;
    const linkPath = new URL(href, location.href).pathname.replace(/index\.html$/, '').replace(/\/$/, '');
    if (linkPath && (path === linkPath || (linkPath !== '' && path.startsWith(linkPath)))) {
      a.style.fontWeight = '500';
    }
  });

  document.querySelectorAll('.form-alert--success').forEach((alert) => {
    window.setTimeout(() => {
      alert.classList.add('is-hiding');
      window.setTimeout(() => alert.remove(), 300);
    }, 5000);
  });

  const inquiryForm = document.querySelector('.inquiry-form');
  if (inquiryForm) {
    const projectInputs = inquiryForm.querySelectorAll('input[name="project_type_choice"]');
    const projectSelect = inquiryForm.querySelector('select[name="project_type"]');
    const projectFields = inquiryForm.querySelectorAll('[data-projects]');
    const dynamicLabels = inquiryForm.querySelectorAll('[data-label-konut]');

    const selectedProjectType = () => {
      return projectSelect ? projectSelect.value : 'konut';
    };

    const syncProjectFields = () => {
      const projectType = selectedProjectType();

      projectFields.forEach((field) => {
        const allowed = (field.dataset.projects || '').split(/\s+/).filter(Boolean);
        const isVisible = allowed.includes(projectType);
        field.classList.toggle('form-field-hidden', !isVisible);
        field.querySelectorAll('input, textarea, select').forEach((control) => {
          control.disabled = !isVisible;
          if (control.name === 'square_footage') {
            control.required = isVisible && (projectType === 'konut' || projectType === 'ticari');
          }
          if (control.name === 'item_type') {
            control.required = isVisible && (projectType === 'mobilya' || projectType === 'obje');
          }
        });
      });

      dynamicLabels.forEach((label) => {
        const text = label.dataset[`label${projectType.charAt(0).toUpperCase()}${projectType.slice(1)}`];
        if (text) label.textContent = text;
      });
    };

    projectInputs.forEach((input) => {
      input.addEventListener('change', () => {
        if (projectSelect) {
          projectSelect.value = input.value;
        }
        syncProjectFields();
      });
    });
    if (projectSelect) {
      projectSelect.addEventListener('change', () => {
        const input = inquiryForm.querySelector(`input[name="project_type_choice"][value="${projectSelect.value}"]`);
        if (input) {
          input.checked = true;
        }
        syncProjectFields();
      });
    }
    syncProjectFields();
  }
})();
