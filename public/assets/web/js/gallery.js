(function () {
  var payloadEl = document.getElementById('gallery-items-data');
  var galleryItems = [];
  var currentLightboxIndex = 0;

  if (payloadEl) {
    try {
      galleryItems = JSON.parse(payloadEl.textContent || '[]');
    } catch (error) {
      galleryItems = [];
    }
  }

  function renderLightbox() {
    var item = galleryItems[currentLightboxIndex];
    if (!item) return;
    document.getElementById('lb-image').src = item.src;
    document.getElementById('lb-image').alt = item.caption;
    document.getElementById('lb-caption').textContent = item.caption;
  }

  window.filterGallery = function (btn, category) {
    document.querySelectorAll('.filter-btn').forEach(function (item) {
      item.classList.remove('active');
    });
    btn.classList.add('active');

    document.querySelectorAll('.gallery-item').forEach(function (item) {
      item.style.display = category === 'all' || item.dataset.cat === category ? '' : 'none';
    });
  };

  window.openLightbox = function (index) {
    currentLightboxIndex = index;
    renderLightbox();
    document.body.classList.add('lightbox-open');
    document.getElementById('lightbox').classList.add('open');
  };

  window.closeLightbox = function () {
    document.body.classList.remove('lightbox-open');
    document.getElementById('lightbox').classList.remove('open');
  };

  window.stepLightbox = function (direction) {
    if (!galleryItems.length) return;
    currentLightboxIndex = (currentLightboxIndex + direction + galleryItems.length) % galleryItems.length;
    renderLightbox();
  };

  document.addEventListener('keydown', function (event) {
    var lightbox = document.getElementById('lightbox');
    if (!lightbox || !lightbox.classList.contains('open')) return;

    if (event.key === 'Escape') {
      window.closeLightbox();
    }

    if (event.key === 'ArrowLeft') {
      window.stepLightbox(-1);
    }

    if (event.key === 'ArrowRight') {
      window.stepLightbox(1);
    }
  });
})();
