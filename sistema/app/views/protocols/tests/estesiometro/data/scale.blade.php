
<!-- SCALE FOR SVG -->
@foreach($scale as $row)
    <div
        class="js-test-estesiometro-scale"
        data-scale_id="{{ $row->id }}"
        data-scale_hex="{{ $row->colorhex }}">
    </div>
@endforeach