<div class="btn-group dropdown-split-primary">
    <td class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
        <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
            <a class="dropdown-item" href="{{route('consolidation.shipment.review_request',$result->id)}}"><i class="icofont icofont-edit"></i>Review Request</a>
            <a class="dropdown-item" href="javascript:void(0)" onclick ="reOpen({{$result->id}})" data-id="{{$result->id}}"><i class="icofont icofont-edit"></i>ReOpen</a>
        </div>
    </td>
</div>