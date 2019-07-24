<div class="btn-group dropdown-split-primary">
    <td class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
        <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
             
            <a class="dropdown-item" href="javascript:void(0)"  data-id="{{$result->id}}" id="delete_id{{$result->id}}" onclick=deleteById("{{$result->id}}") ><i class="icofont icofont-ui-delete"></i>Delete</a>
        </div>
    </td>
</div>