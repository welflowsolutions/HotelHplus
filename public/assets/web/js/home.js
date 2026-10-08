(function () {
  const today = new Date().toISOString().split('T')[0];
  const tmrw = new Date(Date.now() + 86400000).toISOString().split('T')[0];
  const ci = document.getElementById('hero-ci');
  const co = document.getElementById('hero-co');

  if (ci) { ci.min = today; ci.value = today; }
  if (co) { co.min = tmrw; co.value = tmrw; }

  if (ci && co) {
    ci.addEventListener('change', function () {
      const next = new Date(this.value);
      next.setDate(next.getDate() + 1);
      co.min = next.toISOString().split('T')[0];
      if (co.value <= this.value) co.value = co.min;
    });
  }
})();

function heroBook(e) {
  e.preventDefault();
  const form = e.target;
  const ci = document.getElementById('hero-ci');
  const co = document.getElementById('hero-co');
  const err = document.getElementById('hero-book-error');

  if (!ci.value || !co.value) {
    err.classList.remove('hidden');
    return;
  }

  err.classList.add('hidden');

  const room = form.room_type.value;
  const baseRoomsUrl = form.dataset.roomsUrl || '/rooms';
  const dest = room ? baseRoomsUrl.replace(/\/$/, '') + '/' + encodeURIComponent(room) : baseRoomsUrl;

  window.location.href = dest
    + '?checkin=' + encodeURIComponent(ci.value)
    + '&checkout=' + encodeURIComponent(co.value)
    + '&guests=' + encodeURIComponent(form.guests.value);
}
