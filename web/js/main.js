/* CUSTOM JAVASCRIPT */

/* =========== HELPERS TO DEBUG =========== */
const c = log => console.log(log);
/* =========== END HELPERS TO DEBUG =========== */

/* =========== ADD DATEPICKERS =========== */
$('#user-birthdate').datepicker({
    dateFormat: 'dd/mm/yy',
    altFormat: 'yy-mm-dd',
    altField: '#birthdate',
    onSelect: function() {
        
    }
});

$('#ride-date').datepicker({
    dateFormat: 'dd/mm/yy',
    altFormat: 'yy-mm-dd',
    altField: '#date'
});
/* =========== END ADD DATEPICKERS =========== */

$(function() {
    /* =========== ENABLE OR DISABLE SUBMIT BUTTON WHEN FIELDS ARE FILLED =========== */
    function enableDisableSubmit() {    
        if ($('.inputs .form-group').length == $('.inputs .form-group.has-success').length) {
            $('.btn-register').prop('disabled', false);
        } else {
            $('.btn-register').prop('disabled', true);
        }
    }
    /* =========== END ENABLE OR DISABLE SUBMIT BUTTON WHEN FIELDS ARE FILLED =========== */

    /* =========== SHOW MORE INFORMATIONS ON CLICK =========== */
    $('.btn-more-info').on('click', function(e) {
        var status = $(this).attr('data-status');
        if (status == 'closed') {
            $(this).attr('data-status', 'opened');
            $(this).html('<span class="glyphicon glyphicon-remove"></span> Close info</a>');
            $(this).parent().parent().next('.more-info-content').show();
        } else {
            $(this).attr('data-status', 'closed');
            $(this).html('<span class="glyphicon glyphicon-plus"></span> More info</button>');
            $(this).parent().parent().next('.more-info-content').hide();
        }
    });
    /* =========== END SHOW MORE INFORMATIONS ON CLICK =========== */

    /* =========== JOIN RIDE THROUGH AJAX =========== */
    $('.btn-join').on('click', function(e) {
        var id = $(this).data('id');
        $('#ride-id').val(id);
        $('#modal-confirm').modal('show');
    });

    /* =========== SHOW CONFIRMATION MODAL =========== */
    $('[data-yes]').on('click', function(e) {
        var id = $('#ride-id').val();

        $.post(BASE_URL + 'ride/associate?id=' + id, {user_id: USER_ID}).done(data => {
            var json = JSON.parse(data);
            var html = '<div class="alert alert-success">' + json.success + '</div>';
            $('button[data-id="' + id + '"]').prop('disabled', true);
            $('button[data-id="' + id + '"]').html('JOINED');
            $('.feedback').html(html);
        });
    });
    /* =========== END SHOW CONFIRMATION MODAL =========== */
    
    /* =========== JOIN RIDE THROUGH AJAX =========== */
});