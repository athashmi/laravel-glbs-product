<!-- shipping calculate model -->
<div class="modal fade" id="shippingCalcutatorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <div class="accordion" id="accordion1" role="tablist">
                <div class="row" style="margin-bottom:15px">
                    <button style="position: absolute;right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="row sp-header" style="margin-top: 40px">
                    <div class="col-3" style="text-align:center;font-weight:500;text-transform: uppercase;">Courier</div>
                    <div class="col-md-2" style="text-align:center;font-weight:500;text-transform: uppercase;">Delivery Time</div>
                    <div class="col-md-2" style="text-align:center;font-weight:500;text-transform: uppercase;">Rating</div>
                    <div class="col-3"  style="text-align:center;font-weight:500;text-transform: uppercase;">Tracking</div>
                    <!-- /*<div class="col-md-2"  margin-top-10-m" style="text-align:center;font-weight:500;text-transform: uppercase;">Dimentional Weight</div>*/ -->
                    <div class="col-md-2"  style="text-align:center;font-weight:500;text-transform: uppercase;">Shipping Cost</div>
                </div>

                <div class="card" id="dhl_rates" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseFour" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/ExpressWorldwideNonDoc.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>DHL Express</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;2 - 4 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-rocket" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Fast</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="fedex_priority" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseOne" data-toggle="collapse" >
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/INTERNATIONAL_PRIORITY.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>FedEx International Priority</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;3 - 5 working days</p>
                                </div>

                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-star" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Best Value</p>
                                </div>

                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>

                                <!-- <div class="col-2 mv-6">
                                   <p style="text-align:center;margin-top:22%;font-weight:600" class="Applicatble">Applicatble</p>
                                </div> -->
                                <div class="col-2 mv-6 text-right">
                                   <!-- <span id="fedex_priority">$0.00</span> -->
                                   <!-- &nbsp; -->
                                   <!-- <span>⚡ 2-7 days</span> -->
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                   <!-- &nbsp; -->
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                  <div class="card" id="ups_express_rate" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseSix2" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="{{URL::to('Front/img/ups.png')}}" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>UPS Express</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;3 - 5 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-paper-plane-o" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Most Reliable</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="fedex_economy" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/INTERNATIONAL_ECONOMY.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>FedEx International Economy</p>
                                </div>

                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;3 - 8 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-star" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Best Value</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <!-- <div class="col-2 mv-6">
                                   <p style="text-align:center;margin-top:13%;font-weight:600" class="Applicatble">Applicatble</p>
                                </div> -->
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="ups_saver_rate" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseSix1" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="{{URL::to('Front/img/ups.png')}}" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>UPS Saver</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;5 - 8 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-paper-plane-o" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Most Reliable</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="airbndirect_rate" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/airbnex.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px;max-width: 160px">
                                    <p>Airbn Express Direct (no consolidations)</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_custom" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;4 - 10 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa fa-cc" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Cost Effective</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_1.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Medium</p>
                                </div>
                                <!-- <div class="col-2 mv-6">
                                   <p style="text-align:center;margin-top:13%;font-weight:600" class="Applicatble">Applicatble</p>
                                </div> -->
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="airbnex_rate" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/airbnex.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px;max-width: 160px">
                                    <p>Airbn Express</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_custom" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;4 - 10 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa fa-cc" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Cost Effective</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_1.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Medium</p>
                                </div>
                                <!-- <div class="col-2 mv-6">
                                   <p style="text-align:center;margin-top:13%;font-weight:600" class="Applicatble">Applicatble</p>
                                </div> -->
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="ups_rate" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseSix" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="{{URL::to('Front/img/ups.png')}}" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>UPS Expedite</p>
                                </div>

                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_custom" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 55%">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;5 - 10 working days</p>
                                </div>

                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-paper-plane-o" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Most Reliable</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="aramex_rate" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/PriorityParcelExpress.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>Aramex Express</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_custom" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;6 - 10 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa fa-cc" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Cost Effective</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_1.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Medium</p>
                                </div>
                                <!-- <div class="col-2 mv-6">
                                   <p style="text-align:center;margin-top:13%;font-weight:600" class="Applicatble">Applicatble</p>
                                </div> -->
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="usps_priority_mail_express" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseSix2" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/ExpressMailInternational.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>USPS Priority Mail Express</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;3 - 5 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-space-shuttle" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Cost Effective</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="usps_first_class" style="border-radius:0px">
                    <div class="card-header"  role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseSeven" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/FirstClassPackageInternationalService.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>USPS First Class</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;3 - 5 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-space-shuttle" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Cost Effective</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80;">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>

                 <div class="card" id="usps_priority_mail" style="border-radius:0px">
                    <div class="card-header" role="tab" style="background-color:#fff;border-bottom:0px">
                       <h6>
                          <a href="#collapseEight" data-toggle="collapse" data-parent="#accordion2">
                             <div class="row">
                                <div class="col-3 mv-12">
                                    <img src="https://globalshopaholics.com/assets/images/carrier/FirstClassPackageInternationalService.png" alt="Fedex Priority" style="min-width:55px; min-height:30px;padding-top:5px">
                                    <p>USPS Priority Mail</p>
                                </div>
                                <div class="col-2 mv-6">
                                  <div class="progress" style="margin-top:22%">
                                     <div class="progress-bar progress-bar-warning progress_green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                     </div>
                                   </div>
                                   <p style="font-size:12px">&nbsp;&nbsp;&nbsp;3 - 5 working days</p>
                                </div>
                                <div class="col-2 mv-6">
                                    <p style="text-align:center;margin-top:22%;font-weight:500"><i class="fa fa-space-shuttle" aria-hidden="true" style="color:#FFC818;margin-right:10px"></i>Cost Effective</p>
                                </div>
                                <div class="col-3 mv-6" style="text-align: center;">
                                    <img src="Front/img/rating_2.png" style="margin-top:20%;width: 140px; ">
                                   <p style="text-align:center;">Excellent</p>
                                </div>
                                <div class="col-2 mv-6 text-right">
                                   <p style="text-align:center;margin-top:22%;font-weight:600;color: #E19B80">USD <span class="rate"></span></p>
                                </div>
                             </div>
                          </a>
                       </h6>
                    </div>
                 </div>                 
              </div>
            </div>
        </div>
    </div>
</div>

<script>
  function calculateTotal(){
    // $("#shippingCalcutatorModal").modal('show');
    $(".offcanvas-wrapper").css("z-index", 'unset');
    //return false;
    var unit=$("input[name='unit']:checked").val();
    var weight=$("#weight").val();
    var length=$("#length").val();
    var height=$("#height").val();
    var width=$("#width").val();
    var country=$("#country_selector_code").val();
    var zip=$("#zip_code").val();
    mydata = {
    "country":country,
    "zip":zip,
    "unit":unit,
    "weight":weight,
    "height":height,
    "width":width,
    "length":length
  }
  $.ajax({
                 type: "POST",
                 url: "{{url('shipping/rates/load-shipping-rate')}}",
                 data: mydata,
                 dataType: 'JSON',
                 success: function(data) {
                     $("#shippingCalcutatorModal").modal('show');
                   if(data['fedex_priority']){
                     $("#fedex_priority").show();
                     $('#fedex_priority .rate').html("$"+data['fedex_priority'].toFixed(2));
                   }else{
                    $("#fedex_priority").hide();
                   }

                   if(data['fedex_economy']){
                     $("#fedex_economy").show();
                     $('#fedex_economy .rate').html("$"+data['fedex_economy'].toFixed(2));
                   }else{
                     $('#fedex_economy').hide();
                   }

                   if(data['airbn_direct']){
                     $("#airbndirect_rate").show();
                     $('#airbndirect_rate .rate').html("$"+data['airbn_direct'].toFixed(2));
                   }else{
                     $('#airbndirect_rate').hide();
                   }

                   if(data['airbn_ex']){
                     $("#airbnex_rate").show();
                     $('#airbnex_rate .rate').html("$"+data['airbn_ex'].toFixed(2));
                   }else{
                     $('#airbnex_rate').hide();
                   }

                   if(data['aramex_rate']){
                     $("#aramex_rate").show();
                     $('#aramex_rate .rate').html("$"+data['aramex_rate'].toFixed(2));
                   }else{
                     $('#aramex_rate').hide();
                   }

                   if(data['dhl_rates']){
                     $("#dhl_rates").show();
                     $('#dhl_rates .rate').html("$"+data['dhl_rates'].toFixed(2));
                   }else{
                     $('#dhl_rates').hide();
                   }

                   if(data['ups_rate']){
                     $("#ups_rate").show();
                     $('#ups_rate .rate').html("$"+data['ups_rate'].toFixed(2));
                   }else{
                     $('#ups_rate').hide;
                   }

                   if(data['ups_saver_rate']){
                     $("#ups_saver_rate").show();
                     $('#ups_saver_rate .rate').html("$"+data['ups_saver_rate'].toFixed(2));
                   }else{
                     $('#ups_saver_rate').hide();
                   }

                   if(data['ups_express_rate']){
                     $("#ups_express_rate").show();
                     $('#ups_express_rate .rate').html("$"+data['ups_express_rate'].toFixed(2));
                   }else{
                     $('#ups_express_rate').hide();
                   }

                   if(data['usps_first_class']){
                     $("#usps_first_class").show();
                     $('#usps_first_class .rate').html("$"+data['usps_first_class']);
                   }else{
                     $('#usps_first_class').hide();
                   }

                   if(data['usps_priority_mail_express']){
                     $("#usps_priority_mail_express").show();
                     $('#usps_priority_mail_express .rate').html("$"+data['usps_priority_mail_express']);
                   }else{
                     $('#usps_priority_mail_express').hide();
                   }

                   if(data['usps_priority_mail']){
                     $("#usps_priority_mail").show();
                     $('#usps_priority_mail .rate').html("$"+data['usps_priority_mail']);
                   }else{
                     $('#usps_priority_mail').hide();
                   }
              },
                 error: function() {
                   alert('Rates not available for selcted country');
            }
             });
  }
</script>