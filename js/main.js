  const burgerIcon = document.getElementById('burger-icon');
  const menu = document.getElementById('menu');
  const overlay = document.getElementById('overlay');
  const toggleSubmenus = document.querySelectorAll('.toggle-submenu');

  function openMenu() {
    burgerIcon.classList.add('close');
    menu.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    burgerIcon.classList.remove('close');
    menu.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  burgerIcon.addEventListener('click', function () {
    if (menu.classList.contains('active')) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  overlay.addEventListener('click', closeMenu);

  toggleSubmenus.forEach((toggle) => {
    toggle.addEventListener('click', function (e) {
      const parentLi = this.closest('li');
      const submenu = parentLi ? parentLi.querySelector('.submenu') : null;

      // only block link if this item actually has submenu
      if (submenu) {
        e.preventDefault();

        document.querySelectorAll('.menu li.open').forEach((item) => {
          if (item !== parentLi) {
            item.classList.remove('open');
          }
        });

        parentLi.classList.toggle('open');
      }
    });
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth >= 1024) {
      closeMenu();
      document.querySelectorAll('.menu li.open').forEach((item) => {
        item.classList.remove('open');
      });
    }
  });
var currentYear = new Date().getFullYear();
$('.latestYear').text(currentYear);

// Contact form validation helpers
var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function setFieldError($field, msg) {
    $field.addClass('border-red-500').removeClass('border-gray-300');
    if (!$field.next('.field-error').length) {
        $field.after('<p class="field-error text-xs text-red-600 mt-1">' + msg + '</p>');
    }
}

function clearFieldError($field) {
    $field.removeClass('border-red-500').addClass('border-gray-300');
    $field.next('.field-error').remove();
}

function validateField($field) {
    var val = $field.val().trim();
    if ($field.hasClass('validate-required') && !val) {
        setFieldError($field, 'This field is required.');
        return false;
    }
    if ($field.hasClass('validate-email') && val && !emailRe.test(val)) {
        setFieldError($field, 'Please enter a valid email address.');
        return false;
    }
    clearFieldError($field);
    return true;
}

// Live validation on blur and on input after first error
$('.form-email').on('blur', 'input, textarea', function () {
    validateField($(this));
});

$('.form-email').on('input', 'input, textarea', function () {
    if ($(this).hasClass('border-red-500')) {
        validateField($(this));
    }
});

// Contact form submission
$('.form-email').on('submit', function (e) {
    e.preventDefault();

    var $form = $(this);
    var $btn  = $form.find('button[type="submit"]');
    var successMsg = $form.data('success');
    var errorMsg   = $form.data('error');

    $form.find('.form-status').remove();

    // Validate all fields and focus the first invalid one
    var valid = true;
    var $firstInvalid = null;
    $form.find('input, textarea').each(function () {
        if (!validateField($(this))) {
            valid = false;
            if (!$firstInvalid) $firstInvalid = $(this);
        }
    });

    if (!valid) {
        $firstInvalid.focus();
        return;
    }

    $btn.prop('disabled', true).text('Sending…');

    $.ajax({
        url: '/send_mail',
        method: 'POST',
        data: $form.serialize(),
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $form.replaceWith(
                    '<div class="form-status w-full max-w-[500px] mx-auto flex flex-col items-center justify-center gap-4 py-12 px-8 bg-white rounded-xl shadow text-center">' +
                        '<div class="text-[2.5rem] text-[#57C43F]">&#10003;</div>' +
                        '<h3 class="text-[1.1rem] font-bold text-[#252B42]">Message Sent!</h3>' +
                        '<p class="text-[#6D6A6A] text-sm">' + successMsg + '</p>' +
                    '</div>'
                );
            } else {
                $form.find('.form-status').remove();
                $form.prepend('<div class="form-status w-full bg-red-50 border border-red-300 text-red-700 text-sm rounded-md px-4 py-3">' + (res.message || errorMsg) + '</div>');
            }
        },
        error: function () {
            $form.find('.form-status').remove();
            $form.prepend('<div class="form-status w-full bg-red-50 border border-red-300 text-red-700 text-sm rounded-md px-4 py-3">' + errorMsg + '</div>');
        },
        complete: function () {
            $btn.prop('disabled', false).text('Submit');
        }
    });
});