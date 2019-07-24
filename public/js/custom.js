//import Echo from "laravel-echo";
   /*window.Echo.private('statusTest')
    .listen('WareHouseStausEvent', (e) => {
        console.log(e);
    });*/

/*window.Echo.private(`statusTest`)
    .listen('WareHouseStausEvent', (e) => {
        console.log(e.data);
    });*/



function scrollDown(){
            $('html, body').animate({
                 scrollTop: $("#shipping_calculator").offset().top
            }, 2000);
        }

    function scrollBanner8(){
        $('html, body').animate({
             scrollTop: $("#banner-8").offset().top
        }, 2000);
    }

    function scrollBannerVideo(){
        $('html, body').animate({
             scrollTop: $(".second-banner-heading").offset().top
        }, 2000);
    }

    function scrollToSection(class_name){
        $('html, body').animate({
             scrollTop: $(class_name).offset().top
        }, 1000);
    }


      function deleteById(rec_id,action_flag=null)
      {
        //alert((window).del_url);

           swal({
                title: "Are you sure?",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                            type: "POST",
                            url:  (gs_window).del_url,
                            data: {'id' : rec_id},
                            dataType: "JSON",
                            success: function (data) {
                            if(data.status == 1)
                            {
                              swal("Success", "Deleted :)", "success");
                              if(action_flag=='refresh')
                                location.reload();
                              else
                              $('.datatable').DataTable().draw();
                            }
                            if(data.status == 0)
                            {
                              swal("Cancelled", "Somethign went wrong:)", "error");
                            }
                            },
                            error: function (jqXHR, exception) {
                            }
                          });         // submitting the form when user press yes
                  } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                  }
        });
      }
      function responseMsg(type,img,msg = "")
      {
        
        if(type == 'insert'){
          var icons = '<i class="fa fa-warning"></i>';
          if(msg === ''){
              $(function(){
                 $('.page-content-wrapper').pgNotification({
                  style: 'circle',
                  title: '',
                  message: 'Record saved successfully...',
                  position: 'top-right',
                  timeout: 0,
                  type: 'success',
                  thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                }).show();
              });
          }else{
            $(function(){
                     $('.page-content-wrapper').pgNotification({
                        style: 'circle',
                        title: '',
                        message: msg,
                        position: 'top-right',
                        timeout: 0,
                        type: 'success',
                        thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                      }).show();
          });
          }
        }


        if(type == 'update'){
        $(function(){
                     $('.page-content-wrapper').pgNotification({
                        style: 'circle',
                        title: '',
                        message: 'Record updated successfully...',
                        position: 'top-right',
                        timeout: 0,
                        type: 'success',
                        thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                      }).show();
                  });
        }
        if(type == 'delete'){
        $(function(){
                     $('.page-content-wrapper').pgNotification({
                        style: 'circle',
                        title: '',
                        message: 'Record deleted successfully...',
                        position: 'top-right',
                        timeout: 0,
                        type: 'success',
                        thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                      }).show();
                  });
        }
        if(type == 'verified'){
        $(function(){
                     $('.page-content-wrapper').pgNotification({
                        style: 'circle',
                        title: '',
                        message: 'Credit Card verified.',
                        position: 'top-right',
                        timeout: 0,
                        type: 'success',
                        thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                      }).show();
                  });
        }
        if(type == 'error'){
          var icons = '<i class="fa fa-warning"></i>';
          if(msg === ''){
              $(function(){
                     $('.page-content-wrapper').pgNotification({
                        style: 'circle',
                        title: '',
                        message: 'Some Thing went wrong...',
                        position: 'top-right',
                        timeout: 0,
                        type: 'error',
                        thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                      }).show();
          });
          }else{
            $(function(){
                     $('.page-content-wrapper').pgNotification({
                        style: 'circle',
                        title: '',
                        message: msg,
                        position: 'top-right',
                        timeout: 0,
                        type: 'error',
                        thumbnail: '<img width="40" height="40" style="display: inline-block;" src="'+img+'" data-src-retina="'+img+'" alt="">'
                      }).show();
          });
          }
        }
      }

      function manipulateAmount(amount){
        if(amount < 0)
        {
          return '<b class="lbl-red"> -$'+Math.abs(amount)+' USD </b>';
        }
        return '<b> $'+amount+' USD </b>'
      }

      function loadAjaxAnimation(node)
      {
      		$(node).append('<div class="animate-ball-fall"><div></div><div></div><div></div></div>');
      		$(node).parent().css('position','relative');
      		$(node).css('opacity',0.7);
      		//$(node).disable();
      }
    function removeAjaxAnimation(node)
    {
    	$(node).children().remove();

      		$(node).css('opacity',1);
      		//$(node).enable();
    }

    function removeValueFromArray(val,data){
      var index = 0;
      var ids = [];
      for(var i=0;i<data.length;i++){
        if(val != data[i]){
          ids[index] = data[i];
          index++;
        }
      }
      return ids;
    }
