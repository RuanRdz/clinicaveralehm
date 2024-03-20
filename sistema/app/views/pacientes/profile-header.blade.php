
<div style="margin-top: 10px; margin-bottom: 20px;">
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1">
            <div class="circular-crop" style="background-image: url({{ $paciente->foto }})"></div>
        </div>
        <div class="col-xs-14 col-sm-14 col-md-15 col-lg-15">
            <div class="font-bold text-lg">{{ $title }}</div>
            <div class="font-bold text-xl">{{ $paciente->nome }}</div>
        </div>
    </div>
</div>