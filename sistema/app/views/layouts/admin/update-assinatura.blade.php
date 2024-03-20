
<div class="text-center">
    @if($user->updatedBy) 
        @if($user->updatedBy->assinatura)
            <img src="{{$user->updatedBy->url_assinatura}}" class="inline"  style="height: 40px!important;">
        @endif
    @else 
        @if($user->createdBy->assinatura)
            <img src="{{$user->createdBy->url_assinatura}}" class="inline"  style="height: 40px!important;">
        @endif
    @endif
</div>
