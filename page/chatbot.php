<?php
    global $wpdb;
    $massages = $wpdb->get_results("
        SELECT * FROM {$wpdb->prefix}zalo_chatbot_log WHERE fkCustomer is not null ORDER BY created_at DESC");
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
   
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
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
        .textDetail {
            color: #838383;
            font-size: 16px;
        }
        #datatable_wrapper{
        }
    </style>
</head>
<body>
    <div class="content">
        <div>
            <div class="d-flex flex-row pt-5 pl-5">
                <h5><a href="<?php echo admin_url('admin.php?page=zns-dashboard'); ?>">Dashboard</a> / AI Bao Tran</h5>
                <!--<div class="bg-white rounded ml-4 d-flex align-items-center" style="width: fit-content; padding: 0px 10px"><h5>?</h5></div>-->
            </div>
            <!-- <div class="d-flex flex-row justify-content-start">
                <div class="mt-4">
                    <div class="btn btn-primary px-3 py-2">Thông tin về chat bot</div>
                </div>            
            </div> -->
            <div id="zalo-connector-up-to-pro-version">
            </div>
        </div>  
    </div>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/vendor.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/select2/js/select2.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/jquery-toast-plugin/jquery.toast.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/dropify/js/dropify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <!-- App js -->
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/app.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
     window.addEventListener('load', function() {
            var requestOptions = {
              method: 'GET',
              redirect: 'follow'
            };
            
            fetch("https://shop.mekong-connector.co/wp-json/chat-bot/v1/status", requestOptions)
              .then(response => response.text())
              .then(result =>{
                  if(JSON.parse(result) == "true"){
                      document.getElementById('customSwitch1').checked = true
                  }else{
                      document.getElementById('customSwitch1').checked = false
                  }
              })
    
        });
        $(document).ready(function () {
        var dataTable = $("#datatable").DataTable({
            responsive: true,
            pagingType: "full_numbers",
            // drawCallback: function () {
            //     $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            // },
            // columns: [
            //     { data: 'code' },
            //     { data: 'message' },
            //     { data: 'answer' },
            //     { data: 'created_at' },
            //     { data: 'customer_id' },
            // ],
            });
        });

       
        document.getElementById('customSwitch1').addEventListener('change',function (e) {
            if(e.target.checked){
                var requestOptions = {
                  method: 'GET',
                  redirect: 'follow'
                };
                fetch("https://shop.mekong-connector.co/wp-json/chat-bot/v1/change?status=1", requestOptions)
                  .then(response => console.log(response.text()))
            }else{
                var requestOptions = {
                  method: 'GET',
                  redirect: 'follow'
                };
                fetch("https://shop.mekong-connector.co/wp-json/chat-bot/v1/change?status=0", requestOptions)
                  .then(response => console.log(response.text()))
            }
        })
    
        
      
    </script>
</body>
</html>
