(function(window, document, $){

	var protocols = function(){

		return {

			init: function(){
					protocols().avds();
					protocols().estesiometro();
					protocols().forca();
					protocols().funcaomuscular();
					protocols().filterOptionsFuncaoMuscular();
					protocols().reportControl();
			},

			avds: function () {

				$('.avds-input-wrap').on('click', 'input[type=radio]', function () {
					$(this)
						.closest('tr')
						.find('td.avds-input-wrap')
						.css('backgroundColor', '#D9F2F8');
				});

				$('.avds-input-wrap').on('click', 'button.js-uncheck-row', function () {
					$(this)
						.closest('tr')
						.find('input[type=radio]')
						.removeAttr('checked');
					$(this)
						.closest('tr')
						.find('td.avds-input-wrap')
						.css('backgroundColor', 'white');
				});
			},

			estesiometro: function(){

				var $form = $('#estesiometro-data-form');

				if ($form.length) {

					// Editing the map
					$('.btn-sorri-hand', $form).on('click', function(e){
						e.preventDefault();
						e.stopPropagation();
						$('.btn-sorri-hand', $form).removeClass('active');
						$(this).addClass('active');
						svgref = $(this).attr('data-svgref');
						if (svgref == 'sorri-left-hand') {
							$('.sorri-right-hand', $form).hide();
							$('.sorri-left-hand', $form).show();
						} else if (svgref == 'sorri-right-hand') {
							$('.sorri-left-hand', $form).hide();
							$('.sorri-right-hand', $form).show();
						}
					});

					var estesiometroScale = $('.js-test-estesiometro-scale').toArray();
					$('.sorri-right-hand .boxes, .sorri-left-hand .boxes', $form).on('click', '.box', function(e){
						e.preventDefault();
						e.stopPropagation();
						n = Number($(this).attr('data-scale_n')) + 1;
						if (n == estesiometroScale.length) {
							n = 0;
						}
						$(this)
							.css('fill', $(estesiometroScale[n]).attr('data-scale_hex'))
							.attr('data-scale_id', $(estesiometroScale[n]).attr('data-scale_id'))
							.attr('data-scale_n', n);
					});

					// Submit data
					$($form).on('submit', function(e){
						// e.preventDefault();
						// e.stopPropagation();
						svgref = $('.btn-sorri-hand.active').attr('data-svgref');
						svgmap = $('.'+svgref).wrap('<div />').parent().clone().html();
						$('input[name=svg]', $form).val(svgmap);
						$(this).submit();
					});					
				}

				// Disable colors for report
				var $container = $('.js-estesiometro-container');
				if ($container.length) {
					$(document).on('click', '.js-estesiometro-btn-disable-colors', function(){
						$container.find('.box').css('fill', '#fff');
						$(this).css('color', '#909090');
					});
				}
			},

			forca: function () {

				$('.input-weight').priceFormat({
					prefix: '',
					clearPrefix: true,
					centsLimit: 1,
					centsSeparator: '.',
					thousandsSeparator: ''
				});
			},

			funcaomuscular: function () {

				$(document).on('click', '#js-open-modal-funcamuscular', function(event) {
					event.preventDefault();
					$('#js-modal-funcamuscular').modal('show');
					// $('#js-modal-funcamuscular').on('shown.bs.modal', function () {
					// });
				});

				$(document).on('click', '#js-list-funcamuscular-param_id tbody tr', function (event) {
					event.preventDefault();
					$('#js-input-funcaomuscular-param_id').val($(this).attr('id'));
					$('#js-input-funcaomuscular-param_label').val($(this).find('td.label-muscle').text()+' - '+$(this).find('td.label-moviment').text());
					$('#js-modal-funcamuscular').modal('hide');
				});
			},

            filterOptionsFuncaoMuscular: function () {
                $('body').on('click, keyup', '#js-list-funcamuscular-filter', function() {
                    // Declare variables 
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("js-list-funcamuscular-filter");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("js-list-funcamuscular-param_id");
                    tr = table.getElementsByTagName("tr");

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                });
            },

			reportControl: function () {

				// display protocol
				$(document).on('click', '.js-btn-control-content', function (event) {
					event.preventDefault();
					$(this).closest('.js-report-content').toggleClass('hidden-print');
					$(this).toggleClass('text-danger');
				});

				// page break
				$(document).on('click', '.js-btn-control-page-break', function (event) {
					event.preventDefault();
					$(this).closest('.report-control').toggleClass('report-page-break');
					$(this).toggleClass('fa-plus-square-o').toggleClass('fa-minus-square-o');
				});

				// display settings
				$(document).on('click', '.js-btn-show-report-form-configs', function (event) {
					event.preventDefault();
					$('.js-show-report-form-configs').slideDown('800');
					$(this).fadeOut('800');
				});
			}
		};
	};

	$(document).ready(function(){
		protocols().init();
	});
})(window, document, jQuery);
