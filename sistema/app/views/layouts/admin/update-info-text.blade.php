Criado por 
@if($user->createdBy)
    {{ $user->createdBy->fullName }}
    @if($user->createdBy->crefito)
        - {{ $user->createdBy->crefito }}
    @endif
@endif
em {{ timestampToBr($user->created_at, true) }}
@if($user->updatedBy)
    Editado por
        {{ $user->updatedBy->fullName }}
        @if($user->updatedBy->crefito)
            CREFITO {{ $user->updatedBy->crefito }}
        @endif
    em {{ timestampToBr($user->updated_at, true) }}
@endif
