// AYSA WORKS — basit ön yüz scriptleri
(function () {
  const header = document.querySelector('.site-header');
  const nav = document.querySelector('.nav');
  const toggle = document.querySelector('.menu-toggle');
  const body = document.body;
  const MOBILE_BP = 900;

  // Scroll'da header alt çizgi
  if (header) {
    const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 8);
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
        nav.querySelectorAll('.has-sub.open').forEach((li) => li.classList.remove('open'));
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
        if (window.innerWidth > MOBILE_BP && nav.classList.contains('is-open')) setMenu(false);
      }, 120);
    });
  }

  // Mobile'da submenü tıklayınca aç-kapa
  document.querySelectorAll('.nav .has-sub > a').forEach((a) => {
    a.addEventListener('click', (e) => {
      if (window.innerWidth <= MOBILE_BP) {
        e.preventDefault();
        e.stopPropagation();
        a.parentElement.classList.toggle('open');
      }
    });
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
    const projectInputs = inquiryForm.querySelectorAll('input[name="project_type"]');
    const projectFields = inquiryForm.querySelectorAll('[data-projects]');
    const dynamicLabels = inquiryForm.querySelectorAll('[data-label-konut]');

    const selectedProjectType = () => {
      const selected = inquiryForm.querySelector('input[name="project_type"]:checked');
      return selected ? selected.value : 'konut';
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

    projectInputs.forEach((input) => input.addEventListener('change', syncProjectFields));
    syncProjectFields();
  }
})();
