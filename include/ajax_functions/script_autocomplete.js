// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#nr_determina').val();
    var anno = $('#anno_determina').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: '/script/ajax_albo.php',
			type: 'POST',
			data: {keyword:keyword, anno:anno},
			success:function(data){
				$('#determina_list_id').show();
				$('#determina_list_id').html(data);
			}
		});
	} else {
		$('#determina_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item, id_item) {
    // change input value
    $('#nr_determina').val(item);
    $('#id_determina').val(id_item);
    // hide proposition list
    $('#determina_list_id').hide();

}


function autocomplet_uffici($el) {
//    $( "input[type='text']" ).change(function() {
//        var keyword = $( this ).val()
//    });

    //var $el = event.target;
    var $ident = $el.id;



    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $el.value;

    if (keyword.length >= min_length) {
        $.ajax({
            url: '/script/ajax_uffici.php',
            type: 'POST',
            data: {keyword:keyword, ident:$ident},
            success:function(data){
                $('#uffici_list_id').show();
                $('#uffici_list_id').html(data);
            }
        });
    } else {
        $('#uffici_list_id').hide();
    }
}

// set_item : this function will be executed when we select an item
function set_item_uffici(ident, item, id_item) {
    // change input value
    document.getElementById(ident).value = item;
    document.getElementById(ident+'_hide').value = id_item;
    //alert(document.getElementById(ident).value);
    //getElementById(ident+'_hide').val(id_item);
    // hide proposition list
    $('#uffici_list_id').hide();

}




function autocomplet_responsabile($el) {
//    $( "input[type='text']" ).change(function() {
//        var keyword = $( this ).val()
//    });

    //var $el = event.target;
    var $ident = $el.id;



    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $el.value;

    if (keyword.length >= min_length) {
        $.ajax({
            url: '/include/ajax_functions/ajax_responsabile.php',
            type: 'POST',
            data: {keyword:keyword, ident:$ident},
            success:function(data){
                $('#responsabile_list_id').show();
                $('#responsabile_list_id').html(data);
            }
        });
    } else {
        $('#responsabile_list_id').hide();
    }
}

// set_item : this function will be executed when we select an item
function set_item_responsabile(ident, resp, id_resp, id_servizio_resp) {
    // change input value
    document.getElementById(ident).value = resp;
    document.getElementById(ident+'_id').value = id_resp;
    document.getElementById(ident+'_id_servizio').value = id_servizio_resp;
    //alert(document.getElementById(ident).value);
    //getElementById(ident+'_hide').val(id_item);
    // hide proposition list
    $('#responsabile_list_id').hide();

}




function ins_link($el, $nr) {

    var $ident = $el.id;
    var $id_link = "linkupload_link_"+$nr;
    var $id_name = "linkupload_nr_"+$nr;
    var $button = "linkupload_"+$nr;



    var $link = document.getElementById($id_link).value;
    var $name = document.getElementById($id_name).value;

    var $tipo = document.getElementById('tipo_documento').value;
    var $id_bando = document.getElementById('id_bando').value;


    $.ajax({
            url: '/script/ajax_ins_link.php',
            type: 'POST',
            data: {name:$name, link:$link, tipo:$tipo, id_bando:$id_bando},
            success:function(data){
                $('#linkupload_result_location_'+$nr).show();
                $('#linkupload_result_location_'+$nr).html(data);
                $('#'+$button).attr('disabled', true);
            }
        });


}