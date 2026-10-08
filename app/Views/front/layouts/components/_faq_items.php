<?php foreach ($items as [$question, $answer]): ?>
  <div class="faq-item">
    <button class="faq-btn" onclick="toggleFaq(this)" aria-expanded="false" type="button">
      <span class="faq-q"><?= esc($question) ?></span>
      <div class="faq-icon"><i class="fa-solid fa-plus"></i></div>
    </button>
    <div class="faq-body" role="region">
      <div class="faq-body-inner"><?= esc($answer) ?></div>
    </div>
  </div>
<?php endforeach; ?>
