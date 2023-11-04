document.addEventListener("DOMContentLoaded", function () {
    // Lấy tham chiếu đến phần tử có id "wpfooter"
    var wpfooter = document.getElementById("wpfooter");
    
    // Kiểm tra xem phần tử có tồn tại hay không
    if (wpfooter) {
        // Sử dụng thuộc tính style để ẩn phần tử
        wpfooter.style.display = "none";
    }
});

function addContentToDiv() {
    const pageParamUptoPro = searchParams.get("page"); 
    var imageUrl="";
    if ( pageParam == "marketing-dashboard" ) 
    { 
        title="Advertisement";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/plugin_zalo_connector_quangcao_2.png" 
    }
    if ( pageParam == "article-dashboard" ) 
    { 
        title="Article";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/plugin_zalo_connector_baiviet_2.png" 
    }
    if ( pageParam == "zns-dashboard" ) 
    { 
        title="Message";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/plugin_zalo_connector_tinhnhan_2.png" 
    }
    if ( pageParam == "marketing-management" ) 
    { 
        title="Campaigns";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/chiendichquangcao_2.png" 
    }
    if ( pageParam == "quota-management" ) 
    { 
        title="Quotation";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/chaohang_2.png" 
    }
    if ( pageParam == "article-management" ) 
    { 
        title="Write articles using AI";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/taobaivietzalo_2.png" 
    }
    if ( pageParam == "notification-management" ) 
    { 
        title="Order Notification";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/noti_2.png" 
    }
    if ( pageParam == "campaign-management" ) 
    { 
        title="Promotion Notification";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/promotion_2.png" 
    }
    if ( pageParam == "Chat_bot_management" ) 
    { 
        title="AI Chatbot";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/chat_bot_2.png" 
    }
    if ( pageParam == "tags" ) 
    { 
        title="Customer tag";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/tag_2.png" 
    }
    if ( pageParam == "follower-chat" ) 
    { 
        title="Chat directly with customers and manage chat history";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/chat_bot_ai_history_2.png" 
    }
    if ( pageParam == "customer-chat-history" ) 
    { 
        title="Chat directly with customers and manage chat history";
        imageUrl="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/chat_bot_ai_history_2.png" 
    }
    const style = document.createElement('style');
    style.innerHTML = `
        .box {
            width: 75%;
            height: auto;
        }
        @media (max-width: 1200px) {
            .box {
                width: 80%;
            }
        }
        .bg-div {
            background-image: url('${imageUrl}');
            background-size: cover;
            width: 100%;
            height: 700px;
        }
        .no-grayscale {
            filter: grayscale(0%) !important;
        }
        .text-stroke {
          border 1px solid white;
        }
    `;
    var title="";
    // Tạo thẻ div chứa nội dung
    const contentDiv = document.createElement('div');
    contentDiv.className = 'd-flex justify-content-center vh-100 align-items-center';
    contentDiv.innerHTML = `
        <div class="box border p-4 d-flex flex-column">
            <div class="title text-center">
                <h1 class="text-secondary">${title}</h1>
            </div>
            <div class="w-100">
                <div class="d-flex justify-content-center bg-div align-items-center">
                    <div class="content flex align-items-center no-grayscale">
                        <h3 class="text-center text-stroke" style="color:red;">Available in Pro Version</h3>
                        <div class="mt-4 text-center">
                            <a class="btn btn-primary text-white" target="_blank" href="https://zaloconnector.com/pricing/">Upgrade to Pro Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    const targetDiv = document.getElementById('zalo-connector-up-to-pro-version');

    if (targetDiv) {
        targetDiv.appendChild(style);
        targetDiv.appendChild(contentDiv);
    }
}
document.addEventListener("DOMContentLoaded", function () {
    addContentToDiv()
});
