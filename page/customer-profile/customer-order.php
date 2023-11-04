<?php
    global $wpdb;
    $username=$_GET["username"];
    $avatar=$_GET["avt"];
    $fk_wc_user_id= $_GET["fk_wc_user_id"];
    $user = get_user_by('login', $username);
    $zalo_id= $_GET["zalo_id"];
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />
</head>
<style>
    .card{
        
    }
    .card-cus{
        margin-top:15px;
        border: 1px solid gainsboro;
        border-radius: 5px;
    }
    .custom-color{
        background-color: #e5e5e5;
        color: black;
        border-radius: 5px;
        margin-left: 10px;
    }
    .display{
        width: 100%;
    }
    .dataTables_processing {
        
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
              <h5 class="py-3 mb-4"><a href="<?php echo $link_dashboard; ?>" style="text-decoration: none;">Dashboard</a> / <a href="<?php echo $homepage; ?>" style="text-decoration: none;">Customers Integration</a> / Order List</h5>
                <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item custom-color" style="margin-left: 0px">
                      <a class="nav-link" href="<?php echo $link_route_user_detail; ?>"><i class="fa-regular fa-user"></i> <span key="General_Information">Thông tin chung</span></a>
                    </li>
                    <li class="nav-item" style="margin-left: 10px">
                      <a class="nav-link active" href="javascript:void(0);"
                        ><i class="fa-solid fa-basket-shopping"></i> <span key="Orders">Đơn hàng</span></a
                      >
                    </li>
                    <li class="nav-item custom-color">
                      <a class="nav-link" href="<?php echo $link_route_user_chat; ?>"
                        ><i class="fa-solid fa-z"></i> <span key="Zalo_Interaction">Tương tác Zalo</span></a
                      >
                    </li>
                  </ul>
                  <div class="card mb-4" style="min-width: 100% !important;">
                    <h5 class="card-header mb-3" key="Order_List">Danh sách đơn hàng</h5>
                    <table id="ordersTable" class="display table table-bordered table-striped" style="max-width: 100% !important;">
                        <thead>
                            <tr>
                                <th key="Order_Code">Mã đơn hàng</th>
                                <th key="Order_Date">Ngày đặt hàng</th>
                                <th key="Total_Amount">Tổng tiền</th>
                                <th key="Order_Status">Trạng thái đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <!--<footer class="content-footer footer bg-footer-theme">-->
            <!--  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">-->
            <!--    <div class="mb-2 mb-md-0">-->
            <!--      ©-->
            <!--      <script>-->
            <!--        document.write(new Date().getFullYear());-->
            <!--      </script>-->
            <!--      , made with ❤️ by-->
            <!--      <a href="#" target="_blank" class="footer-link fw-medium">MKC</a>-->
            <!--    </div>-->
            <!--    <div class="d-none d-lg-inline-block">-->
            <!--      <a href="#" class="footer-link me-4" target="_blank">License</a>-->
            <!--      <a href="#" target="_blank" class="footer-link me-4">More Themes</a>-->

            <!--      <a-->
            <!--        href="#"-->
            <!--        target="_blank"-->
            <!--        class="footer-link me-4"-->
            <!--        >Documentation</a-->
            <!--      >-->

            <!--      <a-->
            <!--        href="https://github.com/themeselection/sneat-html-admin-template-free/issues"-->
            <!--        target="_blank"-->
            <!--        class="footer-link me-4"-->
            <!--        >Support</a-->
            <!--      >-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</footer>-->
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    
    
    <!-- js bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- js datatable -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <!--<script async defer src="https://buttons.github.io/buttons.js"></script>-->
    
    <script>
        var user_id_9 = "<?php echo $user_id; ?>";
        obTable = $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:"/wp-json/zalo-management/v1/get-wc-order-data-list"+ '?user_id=' + user_id_9,
            columns: [
                {data: 'ID'},
                {data: 'date'},
                {data: 'total'},
                {data: 'status'},
            ],
            order:[0, 'DESC'],
            columnDefs: [
                {
                    targets: 0,
                },
            ],
        });
        
        obTable.on('draw.dt',()=>{
            $("#ordersTable_first a").eq(0).text('First');
            $('#ordersTable_previous a').eq(0).text('Prev');
            $('#ordersTable_next a').eq(0).text('Next');
            $("#ordersTable_last a").eq(0).text('Last');
        })
        
        // $('.dataTables_filter input').unbind().bind('keyup', function(event) {
        //     if (event.type === 'keyup' && (event.which == 13 || event.keyCode == 13) || (event.which == 32 || event.keyCode == 32)) {
        //         event.preventDefault(); 
        //         obTable.search($(this).val()).draw();
        //     } else if (event.type === 'keyup') {
        //         if(event.target.value == ''){
        //             obTable.search($(this).val()).draw();
        //         }
        //     }
        // })
            
       
    </script>
  </body>
</html>
<!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>-->
