
<div class="container" style="margin-top: 5%;">
    <form name="form1" id="form1" method="post" action="https://directpay.my/fpx/pay">
        @csrf
        <div class="card">
            <div class="card-body">
                <table border="0" cellpadding="2" cellspacing="1" width="100%">
                    <tbody>
                        <tr class="infoBoxContents">
                            <td valign="top" width="30%">
                                <table border="0" cellpadding="2" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td height="164" align="center" class="main"><b>Payment Method via FPX</b>
                                                <p>&nbsp;</p>
                                                <div><strong>You are being redirected to secure payment site in <span
                                                            id="time">5</span> seconds</strong></div>

                                                {{-- <input type="submit" style="cursor:hand" class="btn btn-primary"
                                                    onclick="pay()" value="Click to Pay" /> --}}
                                                <br>
                                                <br>
                                                <p> <img src="assets/images/FPXButton.PNG" border="2" /></p>
                                                <p class="main">&nbsp;</p>
                                                <p class="main"><strong>* You must have Internet Banking Account in
                                                        order to
                                                        make transaction using FPX.</strong></p>
                                                <p>&nbsp;</p>
                                                <p class="main"><strong>* Please ensure that your browser's pop up
                                                        blocker has
                                                        been disabled to avoid any interruption during making
                                                        transaction.</strong></p>
                                                <p>&nbsp;</p>
                                                <p class="main"><strong>* You will be redirected to secure payment site.
                                                        Do not close browser / refresh page until you receive
                                                        response.</strong></p>
                                                <p>&nbsp;</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <input type=hidden value="{{ $fpx_buyerName }}" name="BuyerName">
        <input type=hidden value="{{ $fpx_buyerEmail }}" name="BuyerEmail">
        <input type=hidden value="{{$private_key}}" name="PrivateKey">
        <input type=hidden value="{{ $fpx_txnAmount }}" name="Amount">
        <input type=hidden value="{{$fpx_sellerExOrderNo}}" name="SellerOrderNo">
       
       

    </form>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>

    var values = $("#form1").serialize();

    $('#form1').submit();

    // var count = 3;
    // document.getElementById('time').innerHTML = count;
    // setInterval(function(){
    //     count--;
    //     document.getElementById('time').innerHTML = count;
    //     if (count == 0) {
    //         $('#form1').submit();
    //     }
    // },1000);
    
</script>
