(function (window, document, $) {

    var editor_prontuario;
    var mediumEditorOptions = {
        toolbar: {
            buttons: [
                'bold',
                'italic',
                'underline',
                'h3',
                'orderedlist',
                'unorderedlist',
                'strikethrough'
            ]
        },
        placeholder: {
            text: '',
            hideOnClick: true
        },
        autoLink: true,
        paste: {
            forcePlainText: true,
            cleanPastedHTML: true,
            cleanReplacements: [],
            cleanAttrs: ['class', 'style', 'dir'],
            cleanTags: ['meta'],
            unwrapTags: []
        }
    };

    var sistemaAdmin = function () {

        return {

            init: function () {

                sistemaAdmin().app();

                sistemaAdmin().ajaxInit();
                sistemaAdmin().confDatepicker();
                sistemaAdmin().alterarFoto();
                sistemaAdmin().removerFoto();
                sistemaAdmin().salvaFormAnamnesePaciente();
                sistemaAdmin().agendaControleGraficoSessoes();
                sistemaAdmin().agendaControleGraficoMedicos();
                sistemaAdmin().agendaControleGraficoConvenios();
                sistemaAdmin().agenda();
                sistemaAdmin().agendaWhatsapp();
                sistemaAdmin().horariosDoDia();
                sistemaAdmin().createBloqueio();
                sistemaAdmin().addDatasBloqueio();
                sistemaAdmin().editBloqueio();
                sistemaAdmin().agendamento();
                sistemaAdmin().editAgendamento();
                sistemaAdmin().notificacoesTratamento();
                sistemaAdmin().financeiro();
                sistemaAdmin().anamnesetratamentos();
                sistemaAdmin().amplitude();
                sistemaAdmin().comboboxAtendimento();
                sistemaAdmin().inbox();
                sistemaAdmin().laudo();
                sistemaAdmin().atividadesConfig();

                sistemaAdmin().formSearchPaciente();

                sistemaAdmin().ocultarItensRelatorio();

                // Autocomplete
                sistemaAdmin().foreignKey('#cidade', '#cidade_id', 'cidade');
                sistemaAdmin().foreignKey('#paciente', '#paciente_id', 'paciente');
                sistemaAdmin().foreignKey('#lesao', '#lesao_id', 'lesao');
                sistemaAdmin().foreignKey('#membro', '#membro_id', 'membro');
                sistemaAdmin().foreignKey('#medico', '#medico_id', 'medico');
                sistemaAdmin().foreignKey('#convenio', '#convenio_id', 'convenio');
                sistemaAdmin().foreignKey('#testeforca', '#testeforca_id', 'testeforca');
                sistemaAdmin().foreignKey('#fornecedor', '#fornecedor_id', 'fornecedor');

                sistemaAdmin().novaCidade();
            },

            app: function () {

                // Alert success message
                if ($('.alert-sistema').length) {
                    window.setTimeout(function () {
                        $(".alert-sistema").alert('close');
                    }, 5000);
                }

                // Ao fechar o modal, limpa os dados 
                // e força fechamento backdrop 
                $('#modal_geral').modal('hide').on('hidden.bs.modal', function () {
                    $('#modal_geral').find('.modal-body').html('');
                });

                $('body').on('click', '.js-btn-close-window', function (event) {
                    event.preventDefault();
                    window.close();
                });

                // Trigger Print
                $('body').on('click', '.print-trigger', function (event) {
                    event.preventDefault();
                    window.print();
                });

                $('.js-btn-reset').on('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    var $form = $(this).closest('form');
                    $form[0].reset();
                    $form.find('.selectpicker').val('').selectpicker('render');
                });

                // Adicionar essa classe a todos os botões que tem ação de exclusão
                $('body').on('click', '.confirm-destroy', function (event) {
                    if (!confirm('Confirma exclusão?')) {
                        event.preventDefault();
                    }
                });

                $('body').keydown(function (e) {
                    // ESCAPE key pressed
                    if (e.keyCode == 27) {

                        $('div[data-atalhos-id]', document).hide();

                    }
                });

                $('[data-toggle="popover"]').popover();
                $('[data-toggle="tooltip"]').tooltip();

                $('body').on('focus', '.input-valor', function() {
                    $('.input-valor').priceFormat({
                        prefix: '',
                        clearPrefix: true,
                        centsLimit: 2,
                        centsSeparator: '.',
                        thousandsSeparator: ''
                    });
                });

                $('body').on('focus', '.input-moeda', function() {
                    $('.input-moeda').priceFormat({
                        prefix: '',
                        clearPrefix: true,
                        centsLimit: 2,
                        centsSeparator: ',',
                        thousandsSeparator: '.'
                    });
                });

                $('body').on('focus', '.input-taxa', function() {
                    $('.input-taxa').priceFormat({
                        prefix: '',
                        suffix: '%',
                        allowNegative: true,
                        clearPrefix: true,
                        centsLimit: 2,
                        centsSeparator: '.',
                        thousandsSeparator: ''
                    });
                });

                $('body').on('focus', '.simple_color', function() {
                    $('.simple_color').simpleColor({
                        livePreview: false,
                        displayColorCode: false,
                        colorCodeAlign: 'left',
                        colorCodeColor: '#000',
                        boxWidth: 25,
                        boxHeight: 25,
                        cellWidth: 20,
                        cellHeight: 20,
                        columns: 6,
                        chooserCSS: { 'border': '1px solid #505050' },
                        displayCSS: { 'border': '1px solid #505050' },
                        colors: [
                            'FFFFFF', 'FFFF99', 'fbd38d', 'FDB480', 'fed7d7', 'BFF073', 'c6f6d5', 'A7DBDB', 'c3dafe', 'd6bcfa' 
                        ],
                        onSelect: function (hex, element) {
                            // alert("You selected #" + hex + " for input #" + element.attr('class'));
                        }
                    });
                });

                // Seleciona TAB
                $(function() {
                    $('.nav-tabs').stickyTabs();
                    // var options = { 
                    //     selectorAttribute: "data-target",
                    //     backToTop: true
                    // };
                    // $('.nav-tabs').stickyTabs( options );
                    //// selectorAttribute: false,	Override the default href attribute used as selector when you need to activate multiple TabPanels at once with a single Tab using the data-target attribute.
                    //// backToTop: false,	        Prevent the page from jumping down to the tab content by setting the backToTop setting to true.
                });
            },

            ajaxInit: function () {

                $.ajaxSetup({
                    context: document.body,
                    cache: false,
                    async: false,
                    type: "GET", // is default
                    dataType: "json",
                    statusCode: {
                        403: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        },
                        404: function () {
                            alert("404. Página não encontrada.");
                        },
                        500: function () {
                            //console.log(textStatus);
                            alert("500. Erro interno servidor.");
                        }
                    }
                });
            },

            confDatepicker: function () {

                let numberOfMonths = [1, 3];
                let showCurrentAtPos = 1;
                if ($(window).width() < 1024) {
                    numberOfMonths = [1, 1];
                    showCurrentAtPos = 0;
                }

                $.datepicker.setDefaults({
                    dateFormat: 'dd-mm-yy',
                    changeYear: true,
                    yearRange: '-90:+3',
                    numberOfMonths: numberOfMonths,
                    showCurrentAtPos: showCurrentAtPos,
                    dayNamesMin: [
                        'Dom', 'Seg', 'Ter',
                        'Qua', 'Qui', 'Sex', 'Sáb'
                    ],
                    monthNames: [
                        'Janeiro', 'Fevereiro', 'Março',
                        'Abril', 'Maio', 'Junho',
                        'Julho', 'Agosto', 'Setembro',
                        'Outubro', 'Novembro', 'Dezembro'
                    ]
                });

                $('.datepicker', 'body').datepicker();
                $('body').on('focus', '.datepicker', function () {
                    $(this).datepicker();
                });
            },

            ocultarItensRelatorio: function () {

                $('body').on('click', '.js-btn-hide-content', function (event) {
                    event.preventDefault();
                    $(this).closest('.js-hide-content').fadeOut('800');
                });
            },

            alterarFoto: function () {

                $('body').on('click', '#upload_foto_link', function (e) {
                    e.preventDefault();
                    $("#upload_foto:hidden").trigger('click');
                });

                function readURL(input) {

                    var url = input.value;
                    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                    if (input.files && input.files[0] && (ext === "png" || ext === "jpeg" || ext === "jpg")) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            // $('#foto').attr('src', e.target.result).hide().fadeIn("slow");
                            $('#foto').css('background-image', 'url(' + e.target.result + ')');
                        };
                        reader.readAsDataURL(input.files[0]);
                        $('#delete_foto').val('');
                    } else {
                        alert("Formato de arquivo não suportado.");
                    }
                }

                $("#upload_foto").change(function () {
                    readURL(this);
                });
            },

            removerFoto: function () {

                $('body').on('click', '#delete_foto_link', function (e) {
                    e.preventDefault();
                    $('#foto').css('background-image', 'url(/img/foto.png)');
                    // $('#foto').attr('src', '/img/foto.png');
                    $('#upload_foto').val('');
                    $('#delete_foto').val('1');
                });
            },

            formSearchPaciente: function () {

                var formSearch = $('#formSearchPaciente');
                formSearch.on("keyup keypress", function (e) {
                    var code = e.keyCode || e.which;
                    if (code === 13) {
                        e.preventDefault();
                        return false;
                    }
                });
                formSearch.find('input').on('focus', function (e) {
                    e.preventDefault();
                    $(this).val('');
                });
                formSearch.find('input').autocomplete({
                    minLength: 2,
                    autoFocus: true,
                    selectFirst: true,
                    source: function (request, response) {
                        $.ajax({
                            context: document.body,
                            cache: false,
                            async: false,
                            type: "POST",
                            url: formSearch.attr('data-action'),
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    select: function (event, ui) {
                        window.location.href = ui.item.route;
                    }
                });
            },

            foreignKey: function (seletor_label, seletor_foreign_key, model_name) {

                $('body').on('focus', seletor_label, function() {
                    $(seletor_label).autocomplete({
                        minLength: 2,
                        autoFocus: true,
                        selectFirst: true,
                        source: function (request, response) {
                            $.ajax({
                                context: document.body,
                                cache: false,
                                async: false,
                                type: "POST",
                                url: "/autocomplete",
                                dataType: "json",
                                data: {
                                    model_name: model_name,
                                    term: request.term
                                },
                                success: function (data) {
                                    response(data);
                                }
                            });
                        },
                        response: function (event, ui) {
                            if (ui.content.length === 0) {
                                $(seletor_label).val("");
                                $(seletor_foreign_key).val("");
                            }
                        },
                        select: function (event, ui) {
                            $(seletor_foreign_key).val(ui.item.id);
                        },
                        change: function (event, ui) {
                            if (!ui.item) {
                                //https://api.jqueryui.com/autocomplete/#event-change -
                                // The item selected from the menu, if any. Otherwise the property is null
                                //so clear the item for force selection
                                $(seletor_label).val("");
                                $(seletor_foreign_key).val("");
                            }
                        }
                    });
                });
            },

            novaCidade: function () {

                var label = $('#nova_cidade', document);
                label.autocomplete({
                    minLength: 2,
                    autoFocus: true,
                    selectFirst: true,
                    source: function (request, response) {
                        $.ajax({
                            context: document.body,
                            cache: false,
                            async: false,
                            type: "POST",
                            url: "/autocomplete",
                            dataType: "json",
                            data: {
                                model_name: 'cidade',
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    response: function (event, ui) {
                        if (ui.content.length > 0) {
                            label.val("");
                        }
                    },
                    select: function (event, ui) {
                        alert('Esta cidade já está cadastrada.');
                        label.val("");
                    },
                    change: function (event, ui) {
                        if (ui.item.id) {
                            label.val("");
                        }
                    }

                });
            },

            agendaControleGraficoSessoes: function () {
                var data, options, chart, periodo, profissional, medico, convenio;
                var subtitle = [];
                if ($('#chart_agenda_sessoes').length) {
                    periodo = $("input[name=data_inicial]").val()+' a '+$("input[name=data_final]").val();
                    profissional = $("select[name=terapeuta_id]").find("option:selected").text();
                    medico = $("select[name=medico_id]").find("option:selected").text();
                    convenio = $("select[name=convenio_id]").find("option:selected").text();
                    if (profissional) { subtitle.push('Profissional: '+profissional); }
                    if (medico) { subtitle.push('Médico: '+medico); }
                    if (convenio) { subtitle.push('Convênio: '+convenio); }
                    subtitle = subtitle.join('; ');
                    data = $('#chart_agenda_sessoes').attr('data-grafico');
                    data = JSON.parse(data);
                    options = {
                        chart: { type: 'bar', height: 300 },
                        title: { text: 'Sessões por situação - '+periodo },
                        subtitle: { text: subtitle},
                        colors: ['#6CB2EB'],
                        plotOptions: {
                            bar: { horizontal: true, barHeight: '80%' }
                        },
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'end',
                            offsetX: 50,
                            style: { fontSize: '13px', colors: ['#000'] },
                            formatter: function (val, opts) { return val+'%' }
                        },
                        labels: data.labels,
                        series: [{ name: '% Sessões', data: data.series }],
                        xaxis: {
                            min: 0,
                            max: 100,
                            labels: { show: false },
                            axisTicks: { show: false },
                            axisBorder: { show: false }
                        },
                        yaxis: {
                            labels: { 
                                show: true, 
                                align: 'right',
                                style: { fontSize: '14px' },
                            }
                        },
                        grid: {
                            padding: {
                                top: 0,
                                right: 20,
                                bottom: 0,
                                left: 80
                            }
                        }
                    };
                    chart = new ApexCharts(
                        document.querySelector("#chart_agenda_sessoes"),
                        options
                    );
                    chart.render();
                }
            },

            agendaControleGraficoMedicos: function () {
                var data, options, chart, chartHeight, periodo, profissional, medico, convenio;
                var subtitle = [];
                if ($('#chart_agenda_lista_medicos').length) {
                    periodo = $("input[name=data_inicial]").val()+' a '+$("input[name=data_final]").val();
                    profissional = $("select[name=terapeuta_id]").find("option:selected").text();
                    medico = $("select[name=medico_id]").find("option:selected").text();
                    convenio = $("select[name=convenio_id]").find("option:selected").text();
                    if (profissional) { subtitle.push('Profissional: '+profissional); }
                    if (medico) { subtitle.push('Médico: '+medico); }
                    if (convenio) { subtitle.push('Convênio: '+convenio); }
                    subtitle = subtitle.join('; ');
                    data = $('#chart_agenda_lista_medicos').attr('data-grafico');
                    data = JSON.parse(data);
                    if (data.series.length > 50) {
                        chartHeight = 1000;
                    } else if (data.series.length > 30) {
                        chartHeight = 800;
                    } else if (data.series.length > 10) {
                        chartHeight = 600;
                    } else if (data.series.length == 1) {
                        chartHeight = 200;
                    } else {
                        chartHeight = 400;
                    }
                    options = {
                        chart: { type: 'bar', height: chartHeight },
                        title: { text: 'Sessões concluídas por médico - '+periodo },
                        subtitle: { text: subtitle },
                        colors: ['#6CB2EB'],
                        plotOptions: {
                            bar: { horizontal: true, barHeight: '80%' }
                        },
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'end',
                            offsetX: 50,
                            style: { fontSize: '12px', colors: ['#000'] },
                            formatter: function (val, opts) { return val+'%' }
                        },
                        labels: data.labels,
                        series: [{ name: '% sessões', data: data.series }],
                        xaxis: {
                            min: 0,
                            max: 100,
                            labels: { show: false },
                            axisTicks: { show: false },
                            axisBorder: { show: false }
                        },
                        yaxis: {
                            labels: { show: true, align: 'right' }
                        },
                        grid: {
                            padding: {
                                top: 0,
                                right: 20,
                                bottom: 0,
                                left: 200
                            }
                        }
                    };
                    chart = new ApexCharts(
                        document.querySelector("#chart_agenda_lista_medicos"),
                        options
                    );
                    chart.render();
                }
            },

            agendaControleGraficoConvenios: function () {
                var data, options, chart, chartHeight, periodo, profissional, medico, convenio;
                var subtitle = [];
                if ($('#chart_agenda_lista_convenios').length) {
                    periodo = $("input[name=data_inicial]").val()+' a '+$("input[name=data_final]").val();
                    profissional = $("select[name=terapeuta_id]").find("option:selected").text();
                    medico = $("select[name=medico_id]").find("option:selected").text();
                    convenio = $("select[name=convenio_id]").find("option:selected").text();
                    if (profissional) { subtitle.push('Profissional: '+profissional); }
                    if (medico) { subtitle.push('Médico: '+medico); }
                    if (convenio) { subtitle.push('Convênio: '+convenio); }
                    subtitle = subtitle.join('; ');
                    data = $('#chart_agenda_lista_convenios').attr('data-grafico');
                    data = JSON.parse(data);
                    if (data.series.length > 30) {
                        chartHeight = 800;
                    } else if (data.series.length > 15) {
                        chartHeight = 600;
                    } else if (data.series.length > 10) {
                        chartHeight = 400;
                    } else if (data.series.length == 1) {
                        chartHeight = 200;
                    } else {
                        chartHeight = 300;
                    }
                    options = {
                        chart: { type: 'bar', height: chartHeight },
                        title: { text: 'Sessões concluídas por convênio - '+periodo },
                        subtitle: { text: subtitle },
                        colors: ['#6CB2EB'],
                        plotOptions: {
                            bar: { horizontal: true, barHeight: '80%' }
                        },
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'end',
                            offsetX: 50,
                            style: {
                                fontSize: '12px',
                                colors: ['#000']
                            },
                            formatter: function (val, opts) { return val+'%' }
                        },
                        labels: data.labels,
                        series: [{ name: '% sessões', data: data.series }],
                        xaxis: {
                            min: 0,
                            max: 100,
                            labels: { show: false },
                            axisTicks: { show: false },
                            axisBorder: { show: false }
                        },
                        yaxis: {
                            labels: { show: true, align: 'right' }
                        },
                        grid: {
                            padding: {
                                top: 0,
                                right: 20,
                                bottom: 0,
                                left: 200
                            }
                        }
                    };
                    chart = new ApexCharts(
                        document.querySelector("#chart_agenda_lista_convenios"),
                        options
                    );
                    chart.render();
                }
            },

            agenda: function () {

                // Incrementa o tempo final em 1h ao alterar tempo inicial
                $('body').on('change', '.select_inicio', function () {
                    var hora, fim;
                    hora = $(this).val().split(':');
                    fim = $(this).closest('tr').find('.select_fim');
                    if (fim.length == 0) {
                        fim = $(this).closest('.row').find('.select_fim');
                    }
                    if (fim.length) {
                        hora[0] = parseInt(hora[0]);
                        if (hora[0] < 22) {
                            hora[0] = hora[0] + 1;
                            if (hora[0] < 10) {
                                hora[0] = '0' + hora[0];
                            }
                            hora = hora.join(':');
                            console.log(hora);
                            fim.val(hora);
                        }
                    }
                });

                // Abre formulário agendamento
                $('body').on('click', '.btn-agendar', function (e) {
                    e.preventDefault();
                    var route = $(this).attr('href');
                    //clearTimeout(window.timer);
                    //window.timer = setTimeout(function(){
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').find('.modal-body').html(view);
                            $('#modal_geral').modal('show');
                            $('.datepicker').datepicker();
                            $('.selectpicker').selectpicker();
                            $('.hdd-atalhos').hide();
                        }
                    });
                    //}, 800);
                });

                // Enviar formulário agendamento
                $('body').on('submit', '#form-agendar', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (result) {
                            location.reload();
                        }
                    });
                });

                // Consultar sessões disponíveis
                $('body').on('change', '#data_sessao, #terapeuta_id', function (e) {
                    if ($('#data_sessao').val() === '' || $('#terapeuta_id').val() === '') {
                        alert('Selecionar Data e Terapeuta para consulta');
                    } else {
                        var formulario = $('#form-agendar').serialize();
                        $('#consulta-sessoes')
                            .html('<p class="text-center text-muted"><i class="fa fa-refresh fa-spin fa-3x"></i></p>');
                        clearTimeout(window.timer);
                        window.timer = setTimeout(function () {
                            $.ajax({
                                url: '/agendas/consultar-sessoes',
                                type: 'POST',
                                dataType: 'html',
                                data: formulario,
                                success: function (view) {
                                    $('#consulta-sessoes').html(view);
                                    $('[data-toggle="popover"]').popover();
                                }
                            });
                        }, 600);
                    }
                });

                // Abre formulário (edição rápida de sessões)
                $('body').on('click', '.btn-edicao-rapida-sessoes', function (e) {
                    e.preventDefault();
                    var route = $(this).attr('href');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                            $('.hdd-atalhos').hide();
                            $('.datepicker').each(function (index, value) {
                                $(this).css('zIndex', '9999999').datepicker({ startDate: '-0m', minDate: 0 });
                            });
                        }
                    });
                });

                // Enviar formulário agendamento (edição rápida de sessões)
                $('body').on('submit', '#form-edicao-rapida_sessoes', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

                // Consultar sessões disponíveis (edição rápida de sessões)
                $('body').on('change', '.data_sessao_edicao_rapida', function (e) {
                    var data_sessao = $(this).val();
                    var terapeuta_id = $('#terapeuta_id').val();
                    $('#consulta-sessoes').html('<p class="text-center text-muted"><i class="fa fa-refresh fa-spin fa-3x"></i></p>');
                    clearTimeout(window.timer);
                    window.timer = setTimeout(function () {
                        $.ajax({
                            url: '/agendas/consultar-sessoes',
                            type: 'POST',
                            dataType: 'html',
                            data: 'data_sessao=' + data_sessao + '&terapeuta_id=' + terapeuta_id,
                            success: function (view) {
                                $('#consulta-sessoes').html(view);
                                $('[data-toggle="popover"]').popover();
                            }
                        });
                    }, 600);
                });

                // Abre listagem alteracoes agenda
                $('body').on('click', '.btn-visualizar-alteracoes-agenda', function (e) {
                    e.preventDefault();
                    $('#modal_geral').modal('show');
                    $('#modal_geral')
                        .find('.modal-body')
                        .html('')
                        .html($('.listagem-ateracoes-agenda').clone().show());
                });

                $('.js-sort-items-agenda').sortable({
                    opacity: 1,
                    placeholder: 'ui-state-highlight',
                    items: '> tr',
                    update: function (event, ui) {
                        var array_items = $('.js-sort-items-agenda')
                            .sortable('toArray', { attribute: 'data-item-id' });
                        $.ajax({
                            url: '/agendas/ordenar-sessoes',
                            type: 'POST',
                            async: true,
                            dataType: 'json',
                            data: { items: array_items },
                            success: function (result) {
                                //
                            }
                        });
                    }
                }).disableSelection();

                $('body').on('click', '#btnSaveStatusMultiPatients', function() {
                    var ids = [];
                    var agendasituacao_id = null;
                    agendasituacao_id = $('.radio_status_patient_card:checked').val();
                    $('.checkbox_patient_card:checked').each(function () {
                        ids.push($(this).val());
                    });
                    if (ids.length == 0) {
                        alert('Selecione ao menos um paciente para prosseguir');
                        return;
                    }
                    $('#modalSessionStatus').modal('hide');
                    $.ajax({
                        url: 'agendas/update-status-multiple-sessions',
                        type: 'POST',
                        data: {
                            agendasituacao_id: agendasituacao_id,
                            ids: ids
                        },
                        success: function (response) {
                            location.reload();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status+' '+thrownError);
                        }
                    });
                });
            },

            agendaWhatsapp: function () {
                $('body').on('click', '.btn-agenda-whatsapp', function (event) {
                    event.preventDefault();
                    var route = $(this).attr('data-route');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                        }
                    });
                });

                $('body').on('submit', '#form-paciente-update-celular', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        data: $(this).serialize(),
                        success: function (number) {
                            $.each($('.whatsapp_links').find('a'), function(index, item) {
                                var item = $(item);
                                item.attr('href', 'https://wa.me/'+number+item.attr('data-text'));
                            });
                        }
                    });
                });

                // $('body').on('keyup', '#input-fone-whatsapp', function() {
                //     $('#link-whatsapp').attr('href', 'https://wa.me/'+$('#input-fone-whatsapp').val()+'/?text='+$(this).val());
                //     $('#link-whatsapp').text('https://wa.me/'+$('#input-fone-whatsapp').val()+'/?text='+$(this).val());
                // });
            },

            horariosDoDia: function () {

                $('body').on('change', '#formDataAgenda input, #formDataAgenda select', function () {
                    $('#formDataAgenda').submit();
                });

                // Abre menu atalhos
                $('body').on('click', '.btn-abrir-atalhos', function (event) {
                    event.preventDefault();
                    var atalhosId = $(event.currentTarget).attr('data-button-atalhos-id');
                    $('div[data-atalhos-id="' + atalhosId + '"]').toggle();
                });
            },
            
            createBloqueio: function () {

                $('body').on('click', '#btn-agenda-bloquear', function (event) {
                    event.preventDefault();
                    var route = $(this).attr('href');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                            $('.datepicker').datepicker({ startDate: '-0m', minDate: 0 });
                        }
                    });
                });
            },

            addDatasBloqueio: function () {

                // ADD

                $('body').on('click', '.js-btn-add-data-bloqueio', function (e) {
                    e.preventDefault();

                    $('.js-datas-bloqueio')
                        .find('.datepicker')
                        .datepicker('destroy');

                    newDateGroup = $('.js-datas-bloqueio')
                        .find('.row:first')
                        .clone(false)
                        .insertAfter($('.js-datas-bloqueio').find('.row').last());

                    newDateGroup.find('input.data_bloqueio').val('');
                    newDateGroup.find('.js-btn-delete-data-bloqueio').show();

                    var i = 0;
                    $('.js-datas-bloqueio input.data_bloqueio').each(function () {
                        $(this).attr('id', 'date' + i).datepicker({
                            startDate: '-0m',
                            minDate: 0
                        });
                        i++;
                    });
                });

                // REMOVE

                $('body').on('click', '.js-btn-delete-data-bloqueio', function (e) {
                    e.preventDefault();
                    $(this).closest('.row').remove();
                });
            },

            editBloqueio: function () {

                $('body').on('click', '.btn-agenda-editar-bloqueio', function (event) {
                    event.preventDefault();

                    var route = $(this).attr('href');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                            $('.datepicker').datepicker({ startDate: '-0m', minDate: 0 });
                        }
                    });
                });
            },

            agendamento: function () {

                $('body').on('click', '#btn-agenda-agendamento', function (event) {
                    event.preventDefault();

                    var route = $(this).attr('href');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                            $('.datepicker').datepicker({ startDate: '-0m', minDate: 0 });
                        }
                    });
                });
            },

            editAgendamento: function () {

                $('body').on('click', '.btn-agenda-editar-agendamento', function (event) {
                    event.preventDefault();

                    var route = $(this).attr('href');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                            $('.datepicker').datepicker({ startDate: '-0m', minDate: 0 });
                        }
                    });
                });
            },

            salvaFormAnamnesePaciente: function () {
                $('body').on('submit', '#form-paciente-anamnese', function (event) {
                    event.preventDefault();
                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('action'),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        data: $(this).serialize(),
                        success: function (response) {
                            alert('Dados Anamnese atualizados');
                            // console.log(response);
                        }
                    });
                });
            },

            notificacoesTratamento: function () {

                // CREATE NOTIFICACOES

                $('body').on('click', '#btn-notificacoes-listagem', function (event) {
                    event.preventDefault();
                    var route = $(this).attr('href');
                    $.ajax({
                        url: route,
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                        }
                    });
                });

                $('body').on('click', '.btn-notificacoes-excluir', function (event) {
                    event.preventDefault();
                    var route = $(this).attr('href');
                    $(this).closest('.alert').remove();
                    $.ajax({ url: route });
                });

                $('body').on('click', '.notificacoes-mensagem', function (event) {
                    event.preventDefault();
                    var route = $(this).data('route');
                    var box = $(this).closest('.alert');
                    $(box).toggleClass('alert-warning alert-success');
                    $.ajax({ url: route });
                });

                $('body').on('submit', '#form-tratamentonotificacoes', function (event) {
                    event.preventDefault();
                    var formumario = $(this);
                    $.ajax({
                        url: formumario.attr('action'),
                        type: 'POST',
                        data: formumario.serialize(),
                        dataType: "html",
                        success: function (result) {
                            $('.tratamentonotificacoes-listagem', document).prepend(result);
                            formumario[0].reset();
                        }
                    });
                });

                // READ NOTIFICACOES

                $('body').on('click', '.btn-notificacoes-agenda', function (event) {
                    event.preventDefault();
                    var btn = $(this);
                    btn.find('i').removeClass('fa-bell').addClass('fa-bell-o');
                    $.ajax({
                        url: btn.attr('href'),
                        dataType: "html",
                        success: function (view) {
                            $('#modal_geral').modal('show');
                            $('#modal_geral').find('.modal-body').html(view);
                        }
                    });
                });
            },

            financeiro: function () {

                $('body').on('submit', '#form_modal_transferencia_contas', function (event) {
                    if (!confirm('Confirma a transferência entre contas?')) {
                        event.preventDefault();
                    }
                });

                $('body').on('click', '#btnFinanceiroProcessarSaldo', function(e) {
                    if (!confirm('O Saldo será recalculado a partir do saldo inicial de cada conta. Deseja prosseguir?')) {
                        e.preventDefault();
                    }
                });

                $('body').on('change', '#dropdown_visao_saldo', function() {
                    if ($(this).val() == 'diario') {
                        $('#dropdown_saldo_mensal').addClass('hide');
                        $('#dropdown_saldo_diario').removeClass('hide');
                    } else {
                        $('#dropdown_saldo_diario').addClass('hide');
                        $('#dropdown_saldo_mensal').removeClass('hide');
                    }
                });

                $('body').on('click', '.set-previsao', function (event) {
                    event.preventDefault();
                    var previsao = $(this);
                    $.ajax({
                        url: previsao.attr('href'),
                        success: function (data) {
                            switch (data) {
                                case 0: previsao.find('.label-previsao').text('Marcar como Previsão'); break;
                                case 1: previsao.find('.label-previsao').text('Remover Previsão'); break;
                            }
                            previsao.closest('tr').toggleClass('activePrevisao');
                        }
                    });
                });

                $('body').on('click', '.confirm-duplicate', function (event) {
                    if (!confirm('Confirma geração de cópia deste registro?')) {
                        event.preventDefault();
                    }
                });

                $('body').on('click', '#btn_simular_parcelamento', function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: $(this).attr('href'),
                        type: 'POST',
                        dataType: "html",
                        data: $(this).closest('form').serialize(),
                        success: function (result) {
                            $('#display_simulacao_parcelamento').html(result);
                        }
                    });
                });
            },

            anamnesetratamentos: function () {

                $('.form-anamnesetratamentos').on('change', 'input[type=checkbox]', function (event) {
                    event.preventDefault();
                    this.checked ? this.value = 'on' : this.value = 'off';
                });
            },

            amplitude: function () {

                $('#selectbox-amplitudegrupo').selectize({
                    create: true,
                    sortField: 'text'
                });
            },

            comboboxAtendimento: function () {

                $('body').on('change', '#combobox_workspace', function (event) {
                    event.preventDefault();
                    if (this.value !== '') {
                        $.ajax({
                            url: '/tratamentos/comboboxAtendimento/' + this.value,
                            success: function (dados) {
                                var htmlOpcoes = '<option value="">Selecione</option>';
                                $.each(dados, function (index, user) {
                                    htmlOpcoes = htmlOpcoes + '<option value="' + user.id + '">' + user.name + ' ' + user.last_name + '</option>';
                                });
                                $('#combobox_terapeuta', document).html(htmlOpcoes);
                            }
                        });
                    } else {
                        $('#combobox_terapeuta', document).html('<option></option>');
                    }
                });
            },

            inbox: function () {

                $('.inbox_messages').scrollTop($('.inbox_messages').prop("scrollHeight"));
            },

            laudo: function () {
                var editor_laudo = new MediumEditor('.editor_laudo', mediumEditorOptions);
            },

            atividadesConfig: function () {
                $('.js-sort-items-atividades-config').sortable({
                    opacity: 1,
                    placeholder: 'ui-state-highlight',
                    items: '> tr',
                    update: function (event, ui) {
                        var array_items = $('.js-sort-items-atividades-config')
                            .sortable('toArray', { attribute: 'data-item-id' });
                        $.ajax({
                            url: '/atividades_config/ordenar',
                            type: 'POST',
                            async: true,
                            dataType: 'json',
                            data: { items: array_items },
                            success: function (result) {
                                $('.js-sort-items-atividades-config td')
                                    .css({ backgroundColor: 'rgb(232, 247, 208)' })
                                    .animate({ backgroundColor: '#fff' }, 300);
                            }
                        });
                    }
                }).disableSelection();
            }
        };
    };

    $(document).ready(function () {
        sistemaAdmin().init();
    });
})(window, document, jQuery);
