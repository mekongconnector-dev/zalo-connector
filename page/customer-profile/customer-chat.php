<?php
    global $wpdb;
    $username=$_GET["username"];
    $avatar=$_GET["avt"];
    $fk_wc_user_id= $_GET["fk_wc_user_id"];
    $zalo_id= $_GET["zalo_id"];
    $user = get_user_by('login', $username);
    $user_id="";
    if ($user) {
        $user_id = $user->ID;
    } else {
        
    }
    // Lấy danh sách tất cả các đơn hàng
    $customer_orders = wc_get_orders(array(
        'customer' => $user_id, // Lọc theo User ID của khách hàng
        'limit' => -1, // Lấy tất cả các đơn hàng
    ));
    $homepage= admin_url("admin.php?page=follower-management");
    $link_route_user_detail=admin_url("admin.php?page=customer-detail&username=$username&avt=$avatar&fk_wc_user_id=$fk_wc_user_id&zalo_id=$zalo_id");
    $link_route_user_order=admin_url("admin.php?page=customer-order-list&username=$username&avt=$avatar&fk_wc_user_id=$fk_wc_user_id&zalo_id=$zalo_id");
    $link_route_user_chat=admin_url("admin.php?page=customer-chat-history&username=$username&avt=$avatar&fk_wc_user_id=$fk_wc_user_id&zalo_id=$zalo_id");
    $plugin_dir = __DIR__;
    $img_url = plugins_url('img/', __FILE__);
    $image_logo = $img_url . 'avt-logo.jpg';
  // echo $access_token;
?>
<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">-->
    <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
     <!-- Favicon -->
    <!--<link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />-->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />
</head>
<style>
    .card{
        min-width: 65vw !important;
    }
    .custom-color{
        background-color: #e5e5e5;
        color: black;
        border-radius: 5px;
        margin-left: 10px;
    }
    
    .card-cus{
        margin-top:15px;
        border: 1px solid gainsboro;
        border-radius: 5px;
    }
    
    /*.card-body{*/
    /*    min-width: 65vw !important;*/
    /*}*/
</style>
<style>
.--dark-theme {
  --chat-background: #ffffff;
  --chat-panel-background: #f5f5f5;
  --chat-bubble-background: #ffffff;
  --chat-bubble-active-background: #e5e5e5;
  --chat-add-button-background: #212324; /* Giữ nguyên màu này hoặc đổi thành màu nền khác cho nút add */
  --chat-send-button-background: #8147fc; /* Giữ nguyên màu này hoặc đổi thành màu nền khác cho nút gửi */
  --chat-text-color: #333333; /* Màu chữ trong cuộc trò chuyện */
  --chat-options-svg: #333333; /* Màu biểu tượng tùy chọn trong cuộc trò chuyện */
}

body {
  background-color: #f5f5f5;
  background-size: cover;
  /* overflow: hidden; */
}
#wpbody{
  height: calc(100% - 100px);

}
#chat {
  background: var(--chat-background);
  max-width: 100%;
  width: 100%;
  margin: 0px auto;
  box-sizing: border-box;
  padding: 1em;
  border-radius: 12px;
  position: relative;
  overflow: hidden;
}

#chat::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url(https://images.unsplash.com/photo-1495808985667-ba4ce2ef31b3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80) fixed;
  z-index: -1;
}
#chat .btn-icon {
  position: relative;
  cursor: pointer;
}
#chat .btn-icon svg {
  stroke: #FFF;
  fill: #FFF;
  width: 50%;
  height: auto;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
#chat .chat__conversation-board {
  padding: 1em 0 2em;
  height: calc(100vh - 55px - 2em - 25px * 2 - .5em - 3em);
  overflow: auto;
  position:relative;
}
#chat .chat__conversation-board::-webkit-scrollbar {
    display: none;
}
#chat .chat__conversation-board__message-container.reversed {
  flex-direction: row-reverse;
}
#chat .chat__conversation-board__message-container.reversed .chat__conversation-board__message__bubble {
  position: relative;

}
#chat .chat__conversation-board__message-container.reversed .chat__conversation-board__message__bubble span:not(:last-child) {
  margin: 0 0 2em 0;
}
#chat .chat__conversation-board__message-container.reversed .chat__conversation-board__message__person {
  margin: 0 0 0 1.2em;
}
#chat .chat__conversation-board__message-container.reversed .chat__conversation-board__message__options {
  align-self: center;
  position: absolute;
  left: 0;
  display: none;
}
#chat .chat__conversation-board__message-container {
  position: relative;
  display: flex;
  flex-direction: row;
}
#chat .chat__conversation-board__message-container:hover .chat__conversation-board__message__options {
  display: flex;
  align-items: center;
}
#chat .chat__conversation-board__message-container:hover .option-item:not(:last-child) {
  margin: 0 0.5em 0 0;
}
#chat .chat__conversation-board__message-container:not(:last-child) {
  margin: 0 0 2em 0;
}
#chat .chat__conversation-board__message__person {
  text-align: center;
  margin: 0 1.2em 0 0;
}
#chat .chat__conversation-board__message__person__avatar {
  height: 35px;
  width: 35px;
  overflow: hidden;
  border-radius: 50%;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  ms-user-select: none;
  position: relative;
}
#chat .chat__conversation-board__message__person__avatar::before {
  content: "";
  position: absolute;
  height: 100%;
  width: 100%;
}
#chat .chat__conversation-board__message__person__avatar img {
  height: 100%;
  width: auto;
}
#chat .chat__conversation-board__message__person__nickname {
  font-size: 9px;
  color: #484848;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  display: none;
}
#chat .chat__conversation-board__message__context {
  max-width: 55%;
  align-self: flex-end;
}
#chat .chat__conversation-board__message__options {
  align-self: center;
  position: absolute;
  right: 0;
  display: none;
}
#chat .chat__conversation-board__message__options .option-item {
  border: 0;
  background: 0;
  padding: 0;
  margin: 0;
  height: 16px;
  width: 16px;
  outline: none;
}
#chat .chat__conversation-board__message__options .emoji-button svg {
  stroke: var(--chat-options-svg);
  fill: transparent;
  width: 100%;
}
#chat .chat__conversation-board__message__options .more-button svg {
  stroke: var(--chat-options-svg);
  fill: transparent;
  width: 100%;
}
#chat .chat__conversation-board__message__bubble span {
  width: -webkit-fit-content;
  width: -moz-fit-content;
  width: fit-content;
  display: inline-table;
  word-wrap: break-word;
  background: var(--chat-bubble-background);
  font-size: 13px;
  color: var(--chat-text-color);
  padding: 0.5em 0.8em;
  line-height: 1.5;
  border-radius: 6px;
  font-family: "Lato", sans-serif;
}
#chat .chat__conversation-board__message__bubble:not(:last-child) {
  margin: 0 0 0.3em;
}
#chat .chat__conversation-board__message__bubble:active {
  background: var(--chat-bubble-active-background);
}
#chat .chat__conversation-panel {
  background: var(--chat-panel-background);
  border-radius: 12px;
  padding: 0 1em;
  height: 55px;
  margin: 0.5em 0 0;
}
#chat .chat__conversation-panel__container {
  display: flex;
  flex-direction: row;
  align-items: center;
  height: 100%;
}
#chat .chat__conversation-panel__container .panel-item:not(:last-child) {
  margin: 0 1em 0 0;
}
#chat .chat__conversation-panel__button {
  background: grey;
  height: 20px;
  width: 30px;
  border: 0;
  padding: 0;
  outline: none;
  cursor: pointer;
  position: relative;
}
#chat .chat__conversation-panel .add-file-button {
  height: 23px;
  min-width: 23px;
  width: 23px;
  background: var(--chat-add-button-background);
  border-radius: 50%;
}
#chat .chat__conversation-panel .add-file-button svg {
  width: 70%;
  stroke: #54575c;
}
#chat .chat__conversation-panel .emoji-button {
  min-width: 23px;
  width: 23px;
  height: 23px;
  background: transparent;
  border-radius: 50%;
}
#chat .chat__conversation-panel .emoji-button svg {
  width: 100%;
  fill: transparent;
  stroke: #54575c;
}
#chat .chat__conversation-panel .send-message-button {
  background: var(--chat-send-button-background);
  height: 30px;
  min-width: 30px;
  border-radius: 50%;
  transition: 0.3s ease;
}
#chat .chat__conversation-panel .send-message-button:active {
  transform: scale(0.97);
}
#chat .chat__conversation-panel .send-message-button svg {
  margin: 1px -1px;
}
#chat .chat__conversation-panel__input {
  width: 100%;
  height: 100%;
  outline: none;
  position: relative;
  color: var(--chat-text-color);
  font-size: 13px;
  background: transparent;
  border: 0;
  font-family: "Lato", sans-serif;
  resize: none;
}

@media only screen and (max-width: 600px) {
  #chat {
    margin: 0;
    border-radius: 0;
  }

  #chat .chat__conversation-board {
    height: calc(100vh - 55px - 2em - .5em - 3em);
  }
  #chat .chat__conversation-board__message__options {
    display: none !important;
  } 
  .input-search{
    max-width: 300px;
  }
}
  .header{
    display: flex;
    margin-top: 16px;
    width: 100%;
    justify-content: center;
    flex-direction: "row";
    position: relative;
  }
  #arrow-back{
    position: absolute;
    color: black;
    left: 0;
    top: 0;
  }
  .input-search{
    width: 500px;
    background-color: #EAEDF0;
    font-size: 14px;
  }
  .input-search:focus{
    box-shadow: none !important;
  }
#input-img{
  width: 25px;
  min-width: 25px;
  height:25px;
  min-height: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: grey;
  margin: 0px 8px;
  border-radius: 50%;
}
#input-img::-webkit-file-upload-button {
  visibility: hidden;
}
#input-img::before {
  content: '+';
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(top, #f9f9f9, #e3e3e3);
  border: none;
  border-radius: 3px;
  padding: 0px 0px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  color: #fff;
  font-weight: 700;
  transition: scale(-50%,-50%);
  font-size: 10pt;
}
#input-img:hover::before {
  border-color: black;
}
#input-img:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}

</style>
<body>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <?php $link_dashboard=admin_url("admin.php?page=main-menu"); ?>
            <div class="container-xxl flex-grow-1 container-p-y">
              <h5 class="py-3 mb-4"><a href="<?php echo $link_dashboard; ?>" style="text-decoration: none;">Dashboard</a> / <a href="<?php echo $homepage; ?>" style="text-decoration: none;">Customers Integration</a> / Zalo interaction</h5>
                <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item custom-color" style="margin-left: 0px">
                      <a class="nav-link" href="<?php echo $link_route_user_detail; ?>"><i class="fa-regular fa-user"></i> <span key="General_Information">Thông tin chung</span></a>
                    </li>
                    <li class="nav-item custom-color">
                      <a class="nav-link" href="<?php echo $link_route_user_order; ?>"
                        ><i class="fa-solid fa-basket-shopping"></i> <span key="Orders">Đơn hàng</span></a
                      >
                    </li>
                    <li class="nav-item" style="margin-left: 10px">
                      <a class="nav-link active" href="javascript:void(0);"
                        ><i class="fa-solid fa-z"></i> <span key="Zalo_Interaction">Tương tác Zalo</span></a
                      >
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header mb-3" key="Chat_History">Lịch sử chat</h5>
                
                    <div class="--dark-theme" id="chat">
                      <div class="search" style="background-color: var(--chat-background); color:gray; height: 80px; width: 600px; border-radius: 10px 10px 0px 0xp; display: flex; justify-content: center; align-items:center; position: absolute;z-index: 1;top: 0px;left: 0px; width: 100%">
                          <div style="background-color: var(--chat-panel-background);width: 90%;display: flex;justify-content:center;border-radius: 5px;align-items: center; width:100%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="margin-left: 10px" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            <input type="text" name="search" class="input-search" placeholder="Enter search content ..." style="background: var(--chat-panel-background); outline: none; border: none; width: 100%; color: black;"/>
                          </div>
                      </div>
                      <div id="chat-box" class="chat__conversation-board" style="heigth:100%; padding-top:100px;">
                      
                        <div id="zalo-connector-up-to-pro-version">
                        </div>
                        <div class="chat__conversation-board__message-container">
                          <!--<div class="chat__conversation-board__message__person">-->
                          <!--  <div class="chat__conversation-board__message__person__avatar"><img src="" alt="Monika Figi"/></div><span class="chat__conversation-board__message__person__nickname">Monika Figi</span>-->
                          <!--</div>-->
                          <div class="chat__conversation-board__message__context">
                            <div class="chat__conversation-board__message__bubble" style="display: flex; flex-direction: column; max-width: 100%">
                              <span style="max-width: 100%; word-wrap: break-word;white-space: pre-line;overflow-x: auto;display: contents;"></span>
                            </div>
                          </div>
                          <div class="chat__conversation-board__message__options">
                            <button class="btn-icon chat__conversation-board__message__option-button option-item emoji-button">
                              <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                              </svg>
                            </button>
                            <button class="btn-icon chat__conversation-board__message__option-button option-item more-button">
                              <svg class="feather feather-more-horizontal sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                              </svg>
                            </button>
                          </div>
                        </div>
                        <div class="chat__conversation-board__message-container reversed">
                          <!--<div class="chat__conversation-board__message__person">-->
                          <!--  <div class="chat__conversation-board__message__person__avatar"><img src="" alt="Dennis Mikle"/></div><span class="chat__conversation-board__message__person__nickname">Dennis Mikle</span>-->
                          <!--</div>-->
                          <div class="chat__conversation-board__message__context">
                            <div class="chat__conversation-board__message__bubble" style="display: flex; flex-direction: column; max-width: 100%; text-align: end;"> 
                            
                            <span style="max-width: 100%; word-wrap: break-word;white-space: pre-line;overflow-x: auto;display: contents;"></span>
                          </div>
                          </div>
                          <div class="chat__conversation-board__message__options">
                            <button class="btn-icon chat__conversation-board__message__option-button option-item emoji-button">
                              <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                              </svg>
                            </button>
                            <button class="btn-icon chat__conversation-board__message__option-button option-item more-button">
                              <svg class="feather feather-more-horizontal sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                              </svg>
                            </button>
                          </div>
                        </div>
                       
                      </div>
                      <div class="chat__conversation-panel">
                        <div class="chat__conversation-panel__container">
                          <input type="file" id="input-img" class="custom-file-input" accept="image/*"/>
                          <button class="chat__conversation-panel__button panel-item btn-icon emoji-button">
                            <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                              <circle cx="12" cy="12" r="10"></circle>
                              <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                              <line x1="9" y1="9" x2="9.01" y2="9"></line>
                              <line x1="15" y1="9" x2="15.01" y2="9"></line>
                            </svg>
                          </button>
                          <form style="width:100%; display: flex; align-items:center;" action="" method="POST" id='form-message'>
                            <input class="chat__conversation-panel__input panel-item" placeholder="Type a message..." id="message"/>
                            <button type="submit" class="chat__conversation-panel__button panel-item btn-icon send-message-button">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-reactid="1036">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                              </svg>
                            </button>
                          </form>
                        </div>
                      </div>
                      <div id="imageContainer" style="display:none; flex-direction: row; position: absolute; width: calc(100% - 48px); max-height: 200px; height: 300px; bottom: 72px; background-color: #fff; justify-content: space-between;">
                        <div id='render-img' style='height: 100%; padding:10px'>
                    
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" id="remove-img" width="16" height="16" style="color: black; margin:10px" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                      </div>
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>
           

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>


</script>
</body>
</html>