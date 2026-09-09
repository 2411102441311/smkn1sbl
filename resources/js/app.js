document.addEventListener('DOMContentLoaded', function () {

  // Navbar solid saat discroll
  const header = document.getElementById('siteHeader');
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 40);
  });

  // Burger menu mobile (toggle nav.links)
  const burger = document.getElementById('burgerBtn');
  const navLinks = document.querySelector('nav.links');
  if (burger && navLinks) {
    burger.addEventListener('click', () => {
      navLinks.classList.toggle('open');
      navLinks.style.display = navLinks.classList.contains('open') ? 'flex' : 'none';
    });
  }

  // Filter tab Pengumuman
  const tabs = document.querySelectorAll('.peng-tabs button');
  const rows = document.querySelectorAll('.peng-row');
  tabs.forEach(btn => {
    btn.addEventListener('click', () => {
      tabs.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      rows.forEach(row => {
        const show = filter === 'semua' || row.dataset.tag === filter;
        row.classList.toggle('hidden', !show);
      });
    });
  });

  // Reveal animasi saat scroll (IntersectionObserver)
  const revealEls = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });
  revealEls.forEach(el => io.observe(el));

});
