
<ul class="nav nav-pills mb-3">
    <?php foreach ($blocos as $key_bloco => $descricao):?>
        <?php if($key_bloco == 'A') { continue; }?>
        <li role="presentation" class="{{ $key_bloco == $bloco ? 'active' : '' }}"> 
            <a href="{{ route('atividadesconfigShow', ['bloco' => $key_bloco]) }}">
                <i class="fa fa-angle-right"></i> {{ $descricao }}
            </a>
        </li>
    <?php endforeach;?>
</ul>
