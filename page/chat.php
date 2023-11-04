<?php
  if($_SERVER['REQUEST_METHOD'] == 'GET'){
    global $wpdb;
    $user_id = $_GET['id'];
    $query_zalo_user_info = "
        SELECT Zalo_Name, Zalo_URL_Img
        FROM wp_zalo_followers
        WHERE Zalo_ID = '{$user_id}';
    ";
    $zalo_name="";
    $zalo_avatar_url="";
    $zalo_user_info = $wpdb->get_row($query_zalo_user_info);
    if ($zalo_user_info) {
        $zalo_name = $zalo_user_info->Zalo_Name;
        $zalo_avatar_url = $zalo_user_info->Zalo_URL_Img;
    }
    $sql_query = "SELECT * FROM `wp_message_zalo` WHERE User_id_zalo = '$user_id' OR SendTo = '$user_id' ORDER BY create_at DESC";
    // echo $sql_query;
    $messages = $wpdb->get_results($sql_query);
    // print_r($message);
    $messages =  array_reverse($messages);
  }
  $plugin_dir = __DIR__;
  // Sử dụng plugins_url() để lấy đường dẫn tới thư mục img
  $image_logo = plugins_url('assets/avt-logo.jpg', $plugin_dir);
  $bg = plugins_url('assets/bg.svg', $plugin_dir);
  // echo $access_token;
?>


<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
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
  max-width: 600px;
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
<div class="header">
  <a href="javascript:history.go(-1)" id="arrow-back" style="">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px" height="24px">
      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
    </svg>
  </a>

</div>
<div id="zalo-connector-up-to-pro-version">
</div>
</body>
</html>
