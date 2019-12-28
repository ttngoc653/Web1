<?php 
include 'header.php';
?>
<?php if (!isset($infoUser)): ?>
  <?php redirectTo("Chức năng yêu cầu đăng nhập. Vui lòng đăng nhập để sử dụng trang này."); ?>
  <?php else: ?>
    <style type="text/css" media="screen">
      img{ max-width:100%;}
      .inbox_people {
        background: #f8f8f8 none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 30%; border-right:1px solid #c4c4c4;
      }
      .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
      }
      .top_spac{ margin: 20px 0 0;}


      .recent_heading {float: left; width:40%;}
      .srch_bar {
        display: inline-block;
        text-align: right;
      }
      .headind_srch{ padding: 10px 0px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

      .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
      }
      .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; background:none;}
      .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
      }
      .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

      .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
      .chat_ib h5 span{ font-size:13px; float:right;}
      .chat_ib p{ font-size:14px; color:#989898; margin:auto}
      .chat_img {
        float: left;
        width: 11%;
      }
      .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
      }

      .chat_people{ overflow:hidden; clear:both;}
      .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
        cursor: pointer;
      }
      .inbox_chat { 
        height: 100vh;
        overflow-y: scroll;
      }

      .active_chat{ background:#ebebeb;}

      .incoming_msg_img {
        display: inline-block;
        width: 6%;
      }
      .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
      }
      .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
      }
      .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
      }
      .received_withd_msg { width: 57%;}
      .mesgs {
        float: left;
        padding: 10px 5px 0 5px;
        width: 70%;
        top: 0;
        bottom: 0;
      }

      .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0; color:#fff;
        padding: 5px 10px 5px 5px;
        width:100%;
      }
      .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
      .sent_msg {
        float: right;
        width: 46%;
      }
      .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
      }

      .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
      .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
      }
      .msg_history {
        height: 100vh;
        overflow-y: auto;
      }
    </style>
    <div>
      <div class="messaging">
        <div class="inbox_msg">
          <div class="inbox_people">
            <div class="headind_srch" style="display: none;">
              <div class="recent_heading">
                <h4>Recent</h4>
              </div>
              <div class="srch_bar">
                <div class="stylish-input-group">
                  <input type="text" class="search-bar"  placeholder="Search" >
                  <span class="input-group-addon">
                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                  </span>
                </div>
              </div>
            </div>
            <div class="inbox_chat">
              <div class="chat_list" style="display: none;">
                <div class="chat_people">
                  <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                  <div class="chat_ib">
                    <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                    <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mesgs">
            <div class="msg_history">
            </div>
            <div class="type_msg">
              <div class="input_msg_write">
                <?php
                $idTrochuyen=0; 
                $nguoidung=new nguoidung;
                  //echo "<script>alert(".$nguoidung->getFromId($_GET['id']).");</script>";
                if(isset($_GET['id']) && $nguoidung->getFromId($_GET['id'])!=NULL) {
                  $trochuyen=new trochuyen;
                  $idTrochuyen=$trochuyen->CheckOneOne($infoUser['ma'],$_GET['id']);
                  //echo "<script>alert(".var_dump($idTrochuyen).");</script>";
                  if($idTrochuyen==null){
                    $idTrochuyen=$trochuyen->createOneOne($infoUser['ma'],$_GET['id']);
                  }
                }
                else if(isset($_GET['t'])) {
                  $idTrochuyen = $_GET['t'];
                } ?>
                <input type="text" class="write_msg" data-chatkey="<?php echo $idTrochuyen; ?>" placeholder="Nhập tin nhắn..." />
                <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
        </div>    
      </div>
    </div>
    <script>
  // load list chat
  setInterval(function() {
    var elementAdd=$('div.inbox_chat');
    $.ajax({
      url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatGetList.php",
      method:"POST",
      data:{userid:<?php echo $infoUser['ma']; ?>},
      success:function(data) {
        elementAdd.html(data);
      }
    })
  },100);

  // load content chat
  setInterval(function() {
    var elementAdd=$('div.msg_history');
    var chatkey=$(".write_msg").data('chatkey');
    if (chatkey==0) {
      chatkey=$("div.chat_list:first").data("chatkey");
      $(".write_msg").data("chatkey",chatkey);
    }
    $.ajax({
      url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatGetContent.php",
      method:"POST",
      data:{userid:<?php echo $infoUser['ma']; ?>,roomid:chatkey},
      success:function(data) {
        elementAdd.html(data);
      }
    })
  },100);


  // set height 100%
  setInterval(function() {
    var heightResized = $(this).height() - $("body").height();
    if (heightResized!=10) {
      heightElement = $('div.msg_history').height();
      $('div.msg_history').height(heightElement+heightResized-10);
    }
    heightResized = $(this).height() - $("body").height();
    if (heightResized!=10) {
      var heightElement = $('div.inbox_chat').height();
      $('div.inbox_chat').height(heightElement+heightResized-10);
    }
  },100);



  // move to tail history chat
  $('div.msg_history').scrollTop($('div.msg_history')[0].scrollHeight);

  $("body").on("click","div.chat_list",function() {
    var dataChat=$(this).data('chatkey');
    $(".write_msg").data("chatkey",dataChat);

    var elementAdd=$('div.msg_history');
    $.ajax({
      url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatGetContent.php",
      method:"POST",
      data:{userid:<?php echo $infoUser['ma']; ?>,roomid:dataChat},
      success:function(data) {
        elementAdd.html(data);
        $('div.msg_history').scrollTop($('div.msg_history')[0].scrollHeight);
      }
    })
  });

  $("body").on("click","button#delMessage",function() {
    var dataMes=$(this).data('idchat');
    $.ajax({
      url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatRemoveMessage.php",
      method:"POST",
      data:{userid:<?php echo $infoUser['ma']; ?>,messageid:dataMes},
      success:function(data) {
        $(this).parent().parent().parent().remove();
      }
    })
  });

  var elementAdd=$('div.inbox_chat');
  $.ajax({
    url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatGetList.php",
    method:"POST",
    data:{userid:<?php echo $infoUser['ma']; ?>},
    success:function(data) {
      elementAdd.html(data);
    }
  })

  $('input.write_msg').keyup(function(e){
    if(e.keyCode == 13 && $(this).val().trim().length!=0)
    {
      $.ajax({
        url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatAdd.php",
        method:"POST",
        data:{userid:<?php echo $infoUser['ma']; ?>,roomid:$(".write_msg").data('chatkey'),content:$(this).val().trim()},
        success:function(data) {
        }
      })
      $('div.msg_history').scrollTop($('div.msg_history')[0].scrollHeight);

      $(this).val("");
    }
  });

  $('button.msg_send_btn').click(function(e){
    if($("input.write_msg").val().trim().length!=0)
    {
      $.ajax({
        url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionChatAdd.php",
        method:"POST",
        data:{userid:<?php echo $infoUser['ma']; ?>,roomid:$(".write_msg").data('chatkey'),content:$("input.write_msg").val().trim()},
        success:function(data) {
        }
      })
      $('div.msg_history').scrollTop($('div.msg_history')[0].scrollHeight);
    $('input.write_msg').val("");
    }
  });
</script>

<?php endif ?>
<?php 
//$trochuyen=new trochuyen;
//var_dump($trochuyen->getListChat(3));
include 'footer.php';
?>