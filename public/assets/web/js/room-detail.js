function swapRoomImage(el, src) {
  var main = document.getElementById('main-room-image');
  if (main) {
    main.src = src;
  }

  document.querySelectorAll('.thumb').forEach(function (thumb) {
    thumb.classList.remove('active');
  });

  el.classList.add('active');
}

(function () {
  var form = document.querySelector('[data-booking-form]');

  if (!form) {
    return;
  }

  var checkin = form.querySelector('[data-checkin-input]');
  var checkout = form.querySelector('[data-checkout-input]');
  var guests = form.querySelector('[data-guests-input]');
  var rooms = form.querySelector('[data-rooms-input]');
  var nightsLabel = form.querySelector('[data-booking-summary-nights]');
  var roomsLabel = form.querySelector('[data-booking-summary-rooms]');
  var guestsLabel = form.querySelector('[data-booking-summary-guests]');
  var totalLabel = form.querySelector('[data-booking-summary-total]');
  var capacityMessage = form.querySelector('[data-capacity-message]');
  var submitButton = form.querySelector('[data-booking-submit]');
  var nightlyRate = Number(form.dataset.nightlyRate || 0);
  var currency = form.dataset.currency || 'INR';
  var maxGuestsPerRoom = Math.max(1, Number(form.dataset.maxGuestsPerRoom || 1));
  var availableUnits = Math.max(1, Number(form.dataset.availableUnits || 1));
  var formatter = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: currency,
    maximumFractionDigits: 0
  });

  function isoDate(date) {
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var day = String(date.getDate()).padStart(2, '0');

    return date.getFullYear() + '-' + month + '-' + day;
  }

  function addDays(value, days) {
    var date = new Date(value + 'T00:00:00');
    date.setDate(date.getDate() + days);
    return isoDate(date);
  }

  function nightsBetween(startValue, endValue) {
    if (!startValue || !endValue) {
      return 0;
    }

    var start = new Date(startValue + 'T00:00:00');
    var end = new Date(endValue + 'T00:00:00');
    var diff = Math.round((end - start) / 86400000);

    return diff > 0 ? diff : 0;
  }

  function syncDateLimits() {
    var today = isoDate(new Date());

    if (checkin) {
      checkin.min = today;
    }

    if (!checkin || !checkout) {
      return;
    }

    if (checkin.value) {
      checkout.min = addDays(checkin.value, 1);

      if (!checkout.value || checkout.value <= checkin.value) {
        checkout.value = checkout.min;
      }
    } else {
      checkout.min = today;
    }
  }

  function updateSummary() {
    syncDateLimits();

    var nights = nightsBetween(checkin ? checkin.value : '', checkout ? checkout.value : '');
    var guestCount = guests ? Number(guests.value || 1) : 1;
    var roomCount = rooms ? Number(rooms.value || 1) : 1;
    var minimumRooms = Math.max(1, Math.ceil(guestCount / maxGuestsPerRoom));
    var canFitOnline = minimumRooms <= availableUnits;

    if (rooms) {
      rooms.max = String(availableUnits);

      if (roomCount > availableUnits) {
        roomCount = availableUnits;
        rooms.value = String(roomCount);
      }

      if (canFitOnline && roomCount < minimumRooms) {
        roomCount = minimumRooms;
        rooms.value = String(roomCount);
      }

      if (!canFitOnline) {
        roomCount = availableUnits;
        rooms.value = String(roomCount);
      }
    }

    if (capacityMessage) {
      capacityMessage.classList.toggle('hidden', canFitOnline);
    }

    if (submitButton) {
      submitButton.disabled = !canFitOnline;
      submitButton.classList.toggle('opacity-60', !canFitOnline);
      submitButton.classList.toggle('pointer-events-none', !canFitOnline);
    }

    if (guestsLabel) {
      guestsLabel.textContent = guestCount + ' Guest' + (guestCount > 1 ? 's' : '');
    }

    if (roomsLabel) {
      roomsLabel.textContent = roomCount + ' Room' + (roomCount > 1 ? 's' : '');
    }

    if (!nights) {
      if (nightsLabel) nightsLabel.textContent = 'Select dates';
      if (totalLabel) totalLabel.textContent = 'Choose dates';
      return;
    }

    if (nightsLabel) {
      nightsLabel.textContent = nights + ' night' + (nights > 1 ? 's' : '');
    }

    if (totalLabel) {
      totalLabel.textContent = formatter.format(nightlyRate * nights * roomCount);
    }
  }

  [checkin, checkout, guests, rooms].forEach(function (field) {
    if (field) {
      field.addEventListener('change', updateSummary);
      field.addEventListener('input', updateSummary);
    }
  });

  updateSummary();
}());
