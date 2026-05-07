// AYSA WORKS — basit ön yüz scriptleri
(function () {
  const header = document.querySelector('.site-header');
  const nav = document.querySelector('.nav');
  const toggle = document.querySelector('.menu-toggle');

  // Scroll'da header alt çizgi
  if (header) {
    const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Mobile menü toggle
  if (toggle && nav) {
    toggle.addEventListener('click', () => nav.classList.toggle('is-open'));
  }

  // Mobile'da submenü tıklayınca aç-kapa
  document.querySelectorAll('.nav .has-sub > a').forEach((a) => {
    a.addEventListener('click', (e) => {
      if (window.innerWidth <= 900) {
        e.preventDefault();
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
})();
