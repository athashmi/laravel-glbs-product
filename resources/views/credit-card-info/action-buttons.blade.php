<div class="btn-group dropdown-split-primary">
    <td class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
        <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
            @if($result->status != 'verified' && $result->status != 'blocked')
            <a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="delete_id{{$result->id}}" onclick=VerifyCard("{{$result->id}}") >Verify</a>
        @endif
         @if($result->status == 'blocked')
        <a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="delete_id{{$result->id}}" onclick=UnblockCard("{{$result->id}}") >
            Unblock
        </a>
        @endif
        
            
            @if($result->status != 'blocked')
            <a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="delete_id{{$result->id}}" onclick=BlockCard("{{$result->id}}") ><i class="icofont icofont-ui-delete"></i>Block</a>
            @endif
        </div>
    </td>
</div>