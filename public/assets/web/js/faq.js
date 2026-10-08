function toggleFaq(btn) {
  var item = btn.closest('.faq-item');
  var body = item.querySelector('.faq-body');
  var isOpen = item.classList.contains('open');

  document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
    openItem.classList.remove('open');
    openItem.querySelector('.faq-body').style.maxHeight = '0';
    openItem.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
  });

  if (!isOpen) {
    item.classList.add('open');
    body.style.maxHeight = body.scrollHeight + 'px';
    btn.setAttribute('aria-expanded', 'true');
  }
}

function filterFaq(btn, cat) {
  document.querySelectorAll('.cat-btn').forEach(function (button) {
    button.classList.remove('active');
    button.setAttribute('aria-selected', 'false');
  });

  btn.classList.add('active');
  btn.setAttribute('aria-selected', 'true');

  document.querySelectorAll('.faq-group').forEach(function (group) {
    group.style.display = cat === 'all' || group.dataset.cat === cat ? '' : 'none';
  });

  document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
    openItem.classList.remove('open');
    openItem.querySelector('.faq-body').style.maxHeight = '0';
    openItem.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
  });
}
