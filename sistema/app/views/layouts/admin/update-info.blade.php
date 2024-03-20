<div 
    class="text-center no-print" 
    style="font-size: 11px; margin: 0; padding: 0;">

    Criado por
    <i class="text-warning">
        @if($user->createdBy)
            {{ $user->createdBy->fullName }}
            @if($user->createdBy->crefito)
                CREFITO {{ $user->createdBy->crefito }}
            @endif
        @endif
    </i>
    em <i class="text-warning">{{ timestampToBr($user->created_at, true) }}</i>
    @if($user->updatedBy)
        <br>
        Editado por
        <i class="text-warning">
            {{ $user->updatedBy->fullName }} 
            @if($user->updatedBy->crefito)
                - {{ $user->updatedBy->crefito }}
            @endif
        </i>
        em <i class="text-warning">{{ timestampToBr($user->updated_at, true) }}</i>
    @endif
</div>