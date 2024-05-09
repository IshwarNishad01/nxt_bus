<?php 
include 'inc/Config.php';
// echo $prints['data'];
?>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<!-- <script src="assets/js/myscript.js?v=<?=date('ymdhis')?>"></script> -->



<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="assets/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="assets/js/notify/bootstrap-notify.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/scrollbar/simplebar.js"></script>
<script src="assets/js/sidebar-menu.js"></script>
<script src="assets/js/select2/select2.full.min.js"></script>
<script src="assets/js/picker.js"></script>
<script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/summer.js"></script>


<script>
$(document).ready(function () {
  $('.cdesc').summernote({
    height: '300px',
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
    ],
  });

  const _0x36d198 = { placeholder: 'Choose City' }
  $('.select2-multi-select').select2(_0x36d198);
  const _0x13d6dd = { placeholder: 'Choose Bus' }
  $('.select2-bus-select').select2(_0x13d6dd);
  const _0x140c97 = { placeholder: 'Choose Boarding Point' }
  $('.select2-board-select').select2(_0x140c97);
  const _0x1b2529 = { placeholder: 'Choose Facility' }
  $('.select2-multi-facility').select2(_0x1b2529);
  const _0x40456a = { placeholder: 'Choose Pickup Point' }
  $('.select2-point-select').select2(_0x40456a);
  const _0x1a12a5 = { placeholder: 'Choose Drop Point' }
  $('.select2-drop-select').select2(_0x1a12a5);
  const _0x164c2 = { placeholder: 'Choose Drop Point' }
  $('.select2-multi-days').select2(_0x164c2);
  $('#basic-1').DataTable();
});

document.addEventListener('DOMContentLoaded', function () {
      flatpickr('.time', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i:S',
        time_24hr: true,
        placeholder: 'Select Time',
      });
    });

function makeid(num){
  let genID = '';
  const codeString = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  var  codeLen = codeString.length
  for (let _0xe572d2 = 0; _0xe572d2 < num; _0xe572d2++) {
    genID += codeString.charAt(Math.floor(Math.random() * codeLen))
  }
  return genID
}
$(document).on('click', '#gen_code', function(){
  return $('#ccode').val(makeid(8));
});




$(document).on('change', '.boardselect', function () {
  var _0x2a3106 = $(this).find('option:selected')
  var _0x402a5c = _0x2a3106.attr('data-city-id')
  const _0x1f397c = { mainid: _0x402a5c }
  $.ajax({
    type: 'post',
    url: 'getroute.php',
    data: _0x1f397c,
    success: function (_0x1526c2) {
      $('.routepoint').html(_0x1526c2)
    },
  })
})
$(document).on('click', '.drop', function (_0x402921) {
  var _0x29b9a2 = $(this).attr('data-id'),
    _0xcf05a2 = $(this).attr('data-status')
  var _0x4c3f53 = $(this).attr('coll-type'),
    _0xa9cbf5 = lastPathSegment
  return (
    $.ajax({
      type: 'post',
      url: 'inc/Operation.php',
      data: {
        type: $(this).attr('data-type'),
        id: _0x29b9a2,
        status: _0xcf05a2,
        coll_type: _0x4c3f53,
        page_name: _0xa9cbf5,
      },
      success: function (_0x36c6e2) {
        const _0x15057a = JSON.parse(_0x36c6e2)
        _0x15057a.Result == 'true'
          ? ($.notify('<i class="fas fa-bell"></i>' + _0x15057a.title, {
              type: 'theme',
              allow_dismiss: true,
              delay: 2000,
              showProgressbar: true,
              timer: 300,
              animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp',
              },
            }),
            setTimeout(function () {
              window.location.href = _0x15057a.action
            }, 2000))
          : ($.notify('<i class="fas fa-bell"></i>' + _0x15057a.title, {
              type: 'theme',
              allow_dismiss: true,
              delay: 2000,
              showProgressbar: true,
              timer: 300,
              animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp',
              },
            }),
            setTimeout(function () {
              window.location.href = _0x15057a.action
            }, 2000))
      },
    }),
    false
  )
})

$(document).ready(function () {
  $('.numberonly').keypress(function (_0x1b4489) {
    var _0x4cc352 = _0x1b4489.which ? _0x1b4489.which : event.keyCode
    if (String.fromCharCode(_0x4cc352).match(/[^0-9]/g)) {
      return false
    }
  })
  $('.mobile').keypress(function (_0x42c1e5) {
    var _0x5ccedb = _0x42c1e5.which ? _0x42c1e5.which : event.keyCode
    if (String.fromCharCode(_0x5ccedb).match(/[^0-9+]/g)) {
      return false
    }
  })
})
$(document).on('submit', 'form', function (_0x1a141d) {
  $(':input[type="submit"]').prop('disabled', true)
  var _0x1d2813 = new FormData(this)
  $.ajax({
    url: 'inc/Operation.php',
    method: 'post',
    async: false,
    cache: false,
    data: _0x1d2813,
    contentType: false,
    processData: false,
    success: function (_0x2c4b21) {
      const _0x34c9d1 = JSON.parse(_0x2c4b21)
      console.log(_0x34c9d1)
      _0x34c9d1.Result == 'true'
        ? ($.notify(
            '<p><i class="fas fa-bell"></i>' + _0x34c9d1.title + '</p>',
            {
              type: 'theme',
              allow_dismiss: true,
              delay: 2000,
              showProgressbar: true,
              timer: 300,
              animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp',
              },
            }
          ),
          setTimeout(function () {
            window.location.href = _0x34c9d1.action
          }, 2000))
        : ($.notify('<i class="fas fa-bell"></i>' + _0x34c9d1.title, {
            type: 'theme',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            animate: {
              enter: 'animated fadeInDown',
              exit: 'animated fadeOutUp',
            },
          }),
          setTimeout(function () {
            if(_0x34c9d1.action){
              window.location.href = _0x34c9d1.action
            }
          }, 2000))
    },
  })
  return false
})


$(document).on('change', '#decker', function () {
  var _0x327c20 = $(this).val()
  if ($(this).val().length === 0) {
    $('.lower_show').hide()
    $('.upper_show').hide()
  } else {
    if (_0x327c20 == 1) {
      $('.lower_show').show()
      $('.upper_show').hide()
    } else {
      $('.lower_show').show(), $('.upper_show').show()
    }
  }
})
function generateUpperPlan() {
  const _0x48ab3a = parseInt(document.getElementById('rowss').value)
  const _0xcfd8e5 = parseInt(document.getElementById('columnss').value)
  let _0x7b5cbf = '<table id="uppertable">'
  for (let _0x2f71c5 = 0; _0x2f71c5 < _0x48ab3a; _0x2f71c5++) {
    _0x7b5cbf += '<tr>'
    for (let _0x30550a = 0; _0x30550a < _0xcfd8e5; _0x30550a++) {
      _0x7b5cbf +=
        '<td><input type="text" name="upper_' +
        _0x2f71c5 +
        '_' +
        _0x30550a +
        '" style="width:80px;"></td>'
    }
    if (_0x2f71c5 < 2) {
      _0x7b5cbf += '<td></td>'
    } else {
      _0x7b5cbf +=
        '<td><button class="remove-button" onclick="removeRows(this)">Remove</button></td>'
    }
    _0x7b5cbf += '</tr>'
  }
  _0x7b5cbf += '</table>'
  return (
    (document.getElementById('seats-plan').innerHTML = _0x7b5cbf),
    (document.getElementById('add-rows-button').style.display = 'block'),
    false
  )
}
function generateSeatPlan() {
  const _0x268b18 = parseInt(document.getElementById('rows').value),
    _0x23c54a = parseInt(document.getElementById('columns').value)
  let _0x4d55fe = '<table id="lowertable">'
  for (let _0x1be033 = 0; _0x1be033 < _0x268b18; _0x1be033++) {
    _0x4d55fe += '<tr>'
    for (let _0xaa4932 = 0; _0xaa4932 < _0x23c54a; _0xaa4932++) {
      _0x4d55fe +=
        '<td><input type="text" name="lower_' +
        _0x1be033 +
        '_' +
        _0xaa4932 +
        '" style="width:80px;"></td>'
    }
    if (_0x1be033 < 2) {
      _0x4d55fe += '<td></td>'
    } else {
      _0x4d55fe +=
        '<td><button class="remove-button" onclick="removeRow(this)">Remove</button></td>'
    }
    _0x4d55fe += '</tr>'
  }
  _0x4d55fe += '</table>'
  return (
    (document.getElementById('seat-plan').innerHTML = _0x4d55fe),
    (document.getElementById('add-row-button').style.display = 'block'),
    false
  )
}
function addRow() {
  const _0x493cd1 = document.querySelector('table#lowertable'),
    _0x4d824a = _0x493cd1.rows.length,
    _0x44f96a = parseInt(document.getElementById('columns').value),
    _0xb6968f = document.createElement('tr')
  for (let _0x38344f = 0; _0x38344f < _0x44f96a; _0x38344f++) {
    _0xb6968f.innerHTML +=
      '<td><input type="text" name="lower_' +
      _0x4d824a +
      '_' +
      _0x38344f +
      '" style="width:80px;"></td>'
  }
  _0xb6968f.innerHTML +=
    '<td><button class="remove-button" onclick="removeRow(this)">Remove</button></td>'
  _0x493cd1.appendChild(_0xb6968f)
  const _0x1ffba5 = document.getElementById('rows')
  return (_0x1ffba5.value = _0x4d824a + 1), false
}



function addUpperRow() {
  const _0x2d7c38 = document.querySelector('table#uppertable')
  const _0x391620 = _0x2d7c38.rows.length
  const _0x2c2376 = parseInt(document.getElementById('columnss').value),
    _0x1e9947 = document.createElement('tr')
  for (let _0x477790 = 0; _0x477790 < _0x2c2376; _0x477790++) {
    _0x1e9947.innerHTML +=
      '<td><input type="text" name="upper_' +
      _0x391620 +
      '_' +
      _0x477790 +
      '" style="width:80px;"></td>'
  }
  _0x1e9947.innerHTML +=
    '<td><button class="remove-button" onclick="removeRows(this)">Remove</button></td>'
  _0x2d7c38.appendChild(_0x1e9947)
  const _0x576c89 = document.getElementById('rowss')
  return (_0x576c89.value = _0x391620 + 1), false
}

function removeRow(_0x3e5d82) {
  const _0x8b002a = _0x3e5d82.parentNode.parentNode
  _0x8b002a.parentNode.removeChild(_0x8b002a)
  const _0x37276b = document.getElementById('rows')
  _0x37276b.value = parseInt(_0x37276b.value) - 1
}


function removeRows(_0x1c38c7) {
  const _0x8ec0d5 = _0x1c38c7.parentNode.parentNode
  _0x8ec0d5.parentNode.removeChild(_0x8ec0d5)
  const _0x4855b0 = document.getElementById('rowss')
  _0x4855b0.value = parseInt(_0x4855b0.value) - 1
}

function hideAddRowButton(argument) {
  // $('#seat-plan').hide();
}
function hideAddRowButtons(argument) {
  // $('#seat-plans').hide();
}

// $.ajax({
//   url: 'mode.php',
//   async: false,
//   cache: false,
//   success: function (_0x3f7aab) {
//     _0x3f7aab == 1 && $('body').addClass('dark-only')
//   },
// })
var myElement = document.getElementById('simple-bar')
if (myElement !== null) {
  const _0x407772 = { autoHide: true }
  new SimpleBar(myElement, _0x407772)
} else {
}

</script>