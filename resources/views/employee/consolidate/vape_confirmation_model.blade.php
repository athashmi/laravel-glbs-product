<div class="modal fade custom-modal" id="VapeConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title pull-left" id="myModalLabel">Confirm Modal</h4>
               <button type="button" class="close pull-rigth" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <form method="post" onsubmit="return false">
                <div class="modal-body" onsubmit="return false">
                   <label >Is shippment contain VAPE item??</label><br>
                    <div class="form-group radio radio-primary">
                      
                       <input type="radio" id="test1" name="show_option" onclick="showOption()">
                       <label for="test1">Yes</label>

                       <input type="radio" id="test2"  name="show_option" value="no-opt"  onclick="hideOption()">
                       <label for="test2">No</label>

                    </div>
                    <div class="remark form-group checkbox check-primary" style="display:none">
                        <hr>

                    @foreach($consolidate_goods_descriptions as $good)
                      @if($good->key == 'VAPE_DEVICES' || $good->key == 'VAPE_LIQUIDS')
                       <input type="checkbox" id="{{$good->key}}" class="goods-type checkbox-circle  goods_selected" value="{{$good->id}}">
                       <label for="{{$good->key}}">{{$good->title}}</label>
                      
                      @endif
                    @endforeach
                    </div>
                   <div class="modal-footer">
                       <button type="submit" onclick="submit_vape_form()" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>


 <script type="text/javascript">

 function submit_vape_form(){
   
   $(".goods-type").each(function(index){
       if($(this).is(":checked")) {
        
           vap_items_arr[index] = $(this).val();
           $('<input>').attr({
              type: 'hidden',
              
              name: 'goods_id[]',
              value: $(this).val()
          }).appendTo('#formid_create_add_weight');
         
       }
   });


   //submit_form(goodsType);
   submit_form = true;
   $("#VapeConfirmationModel").modal("hide");
   $('.btn-submit-add-actual-weight').trigger('click');
 }

 function showOption(){
   $(".remark").show();
 }
 function hideOption(){
   $(".remark").hide();
 }
 </script>
