<!-- Direct Purchase Request Form -->
<div class="modal fade custom-modal" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog"  style="top:10px;width:80%" role="document">
        <div class="modal-content">
           <form  onsubmit="return false;" >
                <div class="modal-body">
                    <button type="button" class="close" onClick="stopVideo()"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="embed-responsive embed-responsive-16by9" >
                                  <iframe id="player_id" class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/OO8ZHjgzkaE?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                           </div>
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function displayVideoModal(){
        $(".offcanvas-wrapper").css("z-index", 'unset');
        $("#videoModal").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#player_id")[0].src += "&autoplay=1";
    }

    function stopVideo(){
        $('iframe').attr('src', $('iframe').attr('src'));
        $("#player_id")[0].src = "https://www.youtube.com/embed/OO8ZHjgzkaE?rel=0";
        $("#videoModal").modal("hide");
        location.reload();
    }
</script>



    
