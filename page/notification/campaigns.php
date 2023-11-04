<?php 
    $isPromotionNotificationEnabled = get_option('zalo_follow_management_active_notification_promotion_template', false);
    $isAutoSendTransactionEnabled = get_option('zalo_follow_management_auto_send_transaction_message_from_promotion', false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <title>Document</title>

    <style>
        .cardMenu{
            padding: 50px;
        }
        .label{
            font-weight: 500;
        }
        .inputURL{
            width: fit-content;
        }
        input:focus {
            outline: none; 
          }

        .textDetail{
            color: #838383;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div>
            <div class="d-flex flex-row">
                <h3>Notification Center</h3>
                <div class="bg-white rounded-circle ml-4 d-flex align-items-center p-2" style="width: 30px; height: 30px"><i class="fa-solid fa-question"></i></div>
            </div>
            <div class="d-flex flex-row justify-content-start mt-4" style="gap: 15px">
                <a href="<?php echo admin_url();?>admin.php?page=notification-management">
                    <div class="">
                        <div class="btn btn-light shadow-sm px-3 py-2" key="order_status">Tình trạng đơn hàng</div>
                    </div>
                </a>
                <div class="">
                    <div class="btn btn-primary px-3 py-2" key="promotions">Chương trình khuyến mãi</div>
                </div>
            </div>
            <div id="zalo-connector-up-to-pro-version">
            </div>
        </div>    
    </div>
</body>
    <script>
        document.getElementById('copyButton').addEventListener('click', function() {
            const textInput = document.getElementById('textToCopy');
            const textToCopy = textInput.value;
            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = textToCopy;
            document.body.appendChild(tempTextArea);
            tempTextArea.select();
            document.execCommand('copy');
            document.body.removeChild(tempTextArea);

        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy các phần tử checkbox
        const checkbox1 = document.getElementById('customSwitch1');
        const checkbox2 = document.getElementById('customSwitch2');
    
        // Thiết lập sự kiện khi checkbox thay đổi
        checkbox1.addEventListener('change', function() {
            const isPromotionNotificationEnabled = this.checked;
            const isAutoSendTransactionEnabled = checkbox2.checked;
    
            // Gọi API để cập nhật giá trị
            updateSettings(isPromotionNotificationEnabled, isAutoSendTransactionEnabled);
        });
    
        checkbox2.addEventListener('change', function() {
            const isPromotionNotificationEnabled = checkbox1.checked;
            const isAutoSendTransactionEnabled = this.checked;
    
            // Gọi API để cập nhật giá trị
            updateSettings(isPromotionNotificationEnabled, isAutoSendTransactionEnabled);
        });
    
        function updateSettings(isPromotionNotificationEnabled, isAutoSendTransactionEnabled) {
            const apiUrl = '/wp-json/zalo-management/v1/update-settings-notification-center-from_promotion-callback';
    
            const data = {
                isPromotionNotificationEnabled: isPromotionNotificationEnabled,
                isAutoSendTransactionEnabled: isAutoSendTransactionEnabled,
            };
    
            // Sử dụng AJAX để gọi API REST
            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message); // Hiển thị thông báo từ API
            })
            .catch(error => {
                console.error(error);
            });
        }
    });
    </script>
    
    
</html>