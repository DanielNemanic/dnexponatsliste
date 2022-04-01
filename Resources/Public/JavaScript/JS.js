/**
 * Created by Daniel Nemanic
 * daniel.nemanic@etglobal.com
 */
$(document).ready(function () {
	var ext = '.tx-exponatsliste ';
	
	$(document).on('click', ext + '.ScrollTable tbody tr', function () {
		$(this).find('div').css('height', 'auto');
	});
	$(document).on('click', ext + '#EigeneEintraege', function () {
		$(ext + '.ScrollTable>table>tbody>tr').each(function () {
			if ($(this).attr('creator') != $(ext + '.ScrollTable').attr('UserName')) {
				$(this).hide();
			}
		});
	});
	$(document).on('click', ext + '#AlleAnzeigen', function () {
		$('.ScrollTable tbody tr').each(function () {
			$(this).show();
		});
		$(ext + '.ScrollTable th').show();
		$(ext + '.ScrollTable td').show();
	});
	$(document).on('click', ext + '#MinimizeFormat', function () {
		$(ext + '.ScrollTable tbody tr').find('div').removeAttr('style');
	});
	$(document).on('click', ext + '#MaximizeFormat', function () {
		$(ext + '.ScrollTable tbody tr').find('div').css('height', 'auto');
	});
	
	/* Tabellen scrolling */
	$(ext + '.ScrollTable').stickyTableHeaders();
	var offset = 0;//$('.navbar').height() + 1;
	$("html:not(.legacy) .ScrollTable").stickyTableHeaders({fixedOffset: offset});

	$(document).on( 'click', ext + '.DeleteExponat', function () {
		var Check = confirm($(this).attr('title'));
		if (Check == false) {
			return false;
		} else {
			$(ext + '.ExponatslisteLoading').show();
			$(this).closest('form').submit();
			return true;
		}
		return false;
	});

	$(document).on( 'submit', ext + 'form', function () {
		$(this).Loading();
	});

	$(document).on( 'click', ext + '.ExcelDownload', function () {
		var url = $(this).attr('href');
		var Selected = '';
		$(ext + '.ScrollTable .ExponatslisteSelect').each(function () {
			if ($(this).is(':checked')) {
				Selected += $(this).attr('name') + ",";
			}
		});
		$(this).Loading();
		$.post(url, {'tx_dnexponatsliste_dnexponatsliste[exponate]': Selected}, function (data) {
			// console.log( data );
			Location.reload(true);
		});
		return false;
	});

	$(document).on( 'click', ext + '#HidePrint input', function () {
		var checked = $(this).is(':checked');
		var position = $(this).closest('li').index();

		if (checked) {
			$(ext + '.ScrollTable thead tr').each(function (e) {
				$(this).find("th:eq(" + position + ")").show();
			});
			$(ext + '.ScrollTable tbody tr').each(function (e) {
				$(this).find("td:eq(" + position + ")").show();
			});
		} else {
			$(ext + '.ScrollTable thead tr').each(function (e) {
				$(this).find("th:eq(" + position + ")").hide();
			});
			$(ext + '.ScrollTable tbody tr').each(function (e) {
				$(this).find("td:eq(" + position + ")").hide();
			});
		}
	});
	$(document).on( 'click', ext + '.HidePrint', function () {
		var position = $(this).closest('th').index();
		$(this).closest('th').hide();
		$(ext + '.ScrollTable tbody tr').each(function (e) {
			$(this).find("td:eq(" + position + ")").hide();
		});
		console.log(position);
	});
	$(ext + '.DatePicker').datepicker();
	
	$(ext + '.uk-modal-dialog [maxlength]').each(function () {
		var actchar = $(this).val().length;
		$(this).attr('title', actchar);
	});
	$(document).on( 'keyup', ext + '.uk-modal-dialog [maxlength]', function () {
		// var maxchar = parseInt($(this).attr('maxlength'));
		var actchar = $(this).val().length;
		$(this).attr('title', actchar);
		UIkit.tooltip(this).show();
	});

	$(document).on( 'change', ext + '.notification', function () {
		var form = $(this).parents('form');
		var url = form.attr('action');
		var data = form.serializeArray();
		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			dataType: 'html',
			success: function (result) {
				//console.log(url);
				var erg = $.parseJSON(result);
				UIkit.notification("<i uk-icon='icon: check'></i> " + erg.message, {status: 'success'});
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				console.log(XMLHttpRequest.responseText);
				console.log(textStatus);
				console.log(errorThrown);
				UIkit.notification("Error", {status: 'danger'})
			}
		});
		return false;
	});
});