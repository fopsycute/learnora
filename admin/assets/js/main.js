/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();


function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const icon = passwordField.nextElementSibling.querySelector('i');
  if (passwordField.type === 'password') {
  passwordField.type = 'text';
  icon.classList.remove('bx-low-vision');
  icon.classList.add('bxs-low-vision');
  } else {
  passwordField.type = 'password';
  icon.classList.remove('bxs-low-vision');
  icon.classList.add('bx-low-vision');
  }
}

   // If using jQuery.noConflict()
   var $j = jQuery.noConflict();
   $j(document).ready(function() {
     $j('.select-multiple').select2();
   });
 

document.querySelectorAll('a.delete').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});


document.querySelectorAll('a.read').forEach(link => {
  link.addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to mark all notifications as read?')) {
          e.preventDefault();
      }
  });
});


function previewProfilePicture(event) {
  var reader = new FileReader();
  reader.onload = function(){
      var output = document.getElementById('profilePicturePreview');
      output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}



function togglePricingFields() {
  var pricing = document.getElementById('pricingSelect').value;
  document.getElementById('donationFields').style.display = (pricing === 'donation') ? 'block' : 'none';
  document.getElementById('freeFields').style.display = (pricing === 'free') ? 'block' : 'none';
  document.getElementById('paidFields').style.display = (pricing === 'paid') ? 'block' : 'none';
}

function displayInstructorInfo() {
  var select = document.getElementById('instructorSelect');
  var selected = select.options[select.selectedIndex];
  var infoDiv = document.getElementById('instructorInfo');
  var addFields = document.getElementById('addInstructorFields');
  if (select.value === "add_new") {
    infoDiv.style.display = "none";
    addFields.style.display = "block";
  } else if (select.value !== "") {
    document.getElementById('instructorPhoto').src = selected.getAttribute('data-photo');
    document.getElementById('instructorName').textContent = selected.getAttribute('data-name');
    infoDiv.style.display = "block";
    addFields.style.display = "none";
  } else {
    infoDiv.style.display = "none";
    addFields.style.display = "none";
  }
}

function toggleDeliveryFields() {
  const format = document.getElementById('deliveryFormat').value;
  document.getElementById('physicalFields').style.display = (format === 'physical') ? 'block' : 'none';
  document.getElementById('onlineFields').style.display = (format === 'online') ? 'block' : 'none';
  document.getElementById('hybridFields').style.display = (format === 'hybrid') ? 'block' : 'none';
}

function togglePhysicalLocationFields() {
  const type = document.getElementById('physicalLocationType').value;
  document.getElementById('nigeriaPhysicalFields').style.display = (type === 'nigeria') ? 'block' : 'none';
  document.getElementById('foreignPhysicalFields').style.display = (type === 'foreign') ? 'block' : 'none';
}


function toggleHybridLocationFields() {
  const type = document.getElementById('hybridLocationType').value;
  document.getElementById('nigeriaHybridFields').style.display = (type === 'nigeria') ? 'block' : 'none';
  document.getElementById('foreignHybridFields').style.display = (type === 'foreign') ? 'block' : 'none';
}

function addDateTimeRow() {
  const container = document.getElementById('dateTimeRepeater');
  const row = document.createElement('div');
  row.className = 'row mb-2 dateTimeRow';
  row.innerHTML = `
    <div class="col">
      <input type="date" class="form-control" name="event_dates[]" required>
    </div>
    <div class="col">
      <input type="time" class="form-control" name="event_start_times[]" required>
    </div>
    <div class="col">
      <input type="time" class="form-control" name="event_end_times[]" required>
    </div>
    <div class="col-auto">
      <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.dateTimeRow').remove()">-</button>
    </div>
  `;
  container.appendChild(row);
}

function toggleQuizOption(option) {
  document.getElementById('quizText').style.display = 'none';
  document.getElementById('quizUpload').style.display = 'none';
  document.getElementById('quizFormButton').style.display = 'none';

  if (option === 'text') {
    document.getElementById('quizText').style.display = 'block';
  } else if (option === 'upload') {
    document.getElementById('quizUpload').style.display = 'block';
  } else if (option === 'form') {
    document.getElementById('quizFormButton').style.display = 'block';
  }
}


function toggleReplies(commentId) {
  var replies = document.getElementById('replies-' + commentId);
  if (replies.style.display === 'none') {
    replies.style.display = 'block';
  } else {
    replies.style.display = 'none';
  }
}
function showReplyForm(commentId) {
  var form = document.getElementById('reply-form-' + commentId);
  if (form.style.display === 'none') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}

function updateStatus() {
  const status = document.getElementById('statusAction').value;
  if (!status) return;
  
  if (confirm('Are you sure you want to update the status?')) {
      const form = document.createElement('form');
      form.method = 'POST';
      
      const ticketInput = document.createElement('input');
      ticketInput.type = 'hidden';
      ticketInput.name = 'ticket_id';
      ticketInput.value = document.getElementById('ticket_id').value;

      const actionInput = document.createElement('input');
      actionInput.type = 'hidden';
      actionInput.name = 'update-dispute';
      actionInput.value = 'dispute_update';
      
      const statusInput = document.createElement('input');
      statusInput.type = 'hidden';
      statusInput.name = 'status';
      statusInput.value = status;
      
      form.appendChild(ticketInput);
      form.appendChild(actionInput);
      form.appendChild(statusInput);
      document.body.appendChild(form);
      form.submit();
  }
}


function updateWallet() {
  const walletForm = document.getElementById('walletForm');
  if (confirm('Are you sure you want to modify the wallet?')) {
      walletForm.method = 'POST';
      walletForm.submit();
  }
}


function openQuizModal() {
  document.getElementById('quizModal').style.display = 'block';
}

function closeQuizModal() {
  document.getElementById('quizModal').style.display = 'none';
}

function addQuizQuestionModal() {
  const block = document.querySelector('.question-block');
  const clone = block.cloneNode(true);
  document.getElementById('quizBuilderModal').appendChild(clone);
}



