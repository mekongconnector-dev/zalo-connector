<?php
    $apikey= get_option('zalo_follow_management_license_apikey');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!--select 2-->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   

</head>
<style>
    .dot {
        display: inline-block;
        border-radius: 50%;
        width: 50%;
        background-color: #EEE;
        height: 15px;
        width: 15px;
        margin: 0 2px;
    }
    .dot.dot-success {
        background-color: #449D44;
    }
    .dot.dot-warning {
        background-color: #F0AD4E;
    }
    .dot.dot-danger {
        background-color: #D9534F;
    }
    #chat2 .form-control {
        border-color: transparent;
    }
    
    #chat2 .form-control:focus {
        border-color: transparent;
        box-shadow: inset 0px 0px 0px 1px transparent;
    }
    
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
    .select2-container{
        z-index:1000000000 !important;
    }
    .filter-form{
        display: flex;
        flex-direction: row;
    }
    .filter-form button{
       margin-left:10px;
    }
    .filter-form label{
        font-size:12px;
        color: gray;
    }
    /*css cho dropdown*/
    /* CSS cho dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
        margin-right: 10px; /* Khoảng cách giữa các dropdown */
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 9999;
    }

    .show {
        display: block;
    }

    .dropdown-item {
        cursor: pointer;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    
    .btn-action-menu{
        display: flex;
        justify-content: center;
        align-items: center;
        align-content: center;
        text-align: center;
        width: 25px;
        height: 35px;
        background-color: #F2F4F7;
        border: solid gray 1px;
        border-radius: 3px;
    }
    .dataTables_filter {
        display: none;
    }
    
    td{
        vertical-align: middle;
    }
    
     /*Định dạng tổng thể của phân trang */
    /*.pagination {*/
    /*    text-align: center;*/
    /*    margin-top: 10px;*/
    /*}*/
    
     /*Định dạng nút Previous */
    /*.pagination .prev {*/
    /*    display: inline-block;*/
    /*    padding: 5px 10px;*/
    /*    background-color: white;*/
    /*    color: #007bff;*/
    /*    border: 1px solid #dee2e6;*/
    /*    border-top-left-radius: 5px;*/
    /*    border-bottom-left-radius: 5px;*/
    /*    margin-right: 0px;*/
    /*    cursor: pointer;*/
    /*    text-decoration: none;*/
    /*}*/
    
     /*Định dạng nút Next */
    /*.pagination .next {*/
    /*    display: inline-block;*/
    /*    padding: 5px 10px;*/
    /*    background-color: white;*/
    /*    color: #007bff;*/
    /*    border: 1px solid #dee2e6;*/
    /*    border-top-right-radius: 5px;*/
    /*    border-bottom-right-radius: 5px;*/
    /*    cursor: pointer;*/
    /*    text-decoration: none;*/
    /*}*/
    
     /*Định dạng liên kết trang */
    /*.pagination a {*/
    /*    display: inline-block;*/
    /*    padding: 5px 10px;*/
    /*    background-color: #fff;*/
    /*    color: #007bff;*/
    /*    border: 1px solid #dee2e6;*/
        /*border-radius: 5px;*/
    /*    margin-right: 0px;*/
    /*    cursor: pointer;*/
    /*    text-decoration: none;*/
    /*}*/
    
     /*Định dạng liên kết trang hiện tại */
    /*.pagination .current {*/
    /*    background-color: #007bff;*/
    /*    padding: 5px 10px;*/
    /*    color: white;*/
    /*    background-color: #007bff;*/
    /*    border: 1px solid #007bff;*/
        /*border-radius: 5px;*/
    /*    margin-right: 0px;*/
    /*}*/
    


</style>
<body>
    <div class="mt-5">
        <?php $link_dashboard=admin_url("admin.php?page=main-menu"); ?>
        <h5><a href="<?php echo $link_dashboard; ?>" style="text-decoration: none;">Dashboard</a>  / Customers Integration</h5>
        <?php
            global $wpdb;
            // Xử lý form khi nó được gửi đi
            if (isset($_GET['fillter-btn'])) {
                // Lấy giá trị từ form (nếu có)
                $dateRange = $_GET['dateRange'];
                $linkedStatus = $_GET['linkedStatus'];
                $followStatus = $_GET['followStatus'];
                // Bắt đầu truy vấn SQL dựa trên bộ lọc
                // $query = "
                //     SELECT zf.id, zf.Zalo_ID, zf.Zalo_Name, zf.Zalo_URL_Img, zf.Zalo_ID_By_App, zf.Follow_Status, zf.Follow_Start_Date, zf.Unfollow_Date, zf.fk_wc_customer_id, cl.first_name, cl.last_name, um.meta_value AS billing_address_1
                //     FROM {$wpdb->prefix}zalo_followers AS zf
                //     LEFT JOIN {$wpdb->prefix}wc_customer_lookup AS cl ON zf.fk_wc_customer_id = cl.customer_id
                //     LEFT JOIN {$wpdb->prefix}usermeta AS um ON cl.user_id = um.user_id AND um.meta_key = 'billing_address_1'
                //     WHERE 1=1"; // Sử dụng 1=1 để dễ dàng thêm điều kiện sau
            
                // Thêm điều kiện cho bộ lọc
                // if (!empty($dateRange)) {
                //     // Khởi tạo ngày bắt đầu và ngày kết thúc mặc định
                //     $startDate = '';
                //     $endDate = '';
                
                //     // Xác định ngày bắt đầu và kết thúc dựa trên giá trị của $dateRange
                //     switch ($dateRange) {
                //         case 'today':
                //             $startDate = date('Y-m-d', strtotime('today'));
                //             $endDate = date('Y-m-d', strtotime('today'));
                //             break;
                //         case 'yesterday':
                //             $startDate = date('Y-m-d', strtotime('yesterday'));
                //             $endDate = date('Y-m-d', strtotime('yesterday'));
                //             break;
                //         case 'this_week':
                //             $startDate = date('Y-m-d', strtotime('this week'));
                //             $endDate = date('Y-m-d', strtotime('today'));
                //             break;
                //         case 'last_week':
                //             $startDate = date('Y-m-d', strtotime('last week'));
                //             $endDate = date('Y-m-d', strtotime('last week +6 days'));
                //             break;
                //         case 'this_month':
                //             $startDate = date('Y-m-d', strtotime('first day of this month'));
                //             $endDate = date('Y-m-d', strtotime('today'));
                //             break;
                //         case 'last_month':
                //             $startDate = date('Y-m-d', strtotime('first day of last month'));
                //             $endDate = date('Y-m-d', strtotime('last day of last month'));
                //             break;
                //         case '6_months_ago':
                //             $startDate = date('Y-m-d', strtotime('-6 months'));
                //             $endDate = date('Y-m-d', strtotime('today'));
                //             break;
                //         case '1_year_ago':
                //             $startDate = date('Y-m-d', strtotime('-1 year'));
                //             $endDate = date('Y-m-d', strtotime('today'));
                //             break;
                //     }
                
                //     // Thêm điều kiện vào câu truy vấn SQL
                //     if (!empty($startDate) && !empty($endDate)) {
                //         $query .= " AND zf.Follow_Start_Date >= '$startDate' AND zf.Follow_Start_Date <= '$endDate'";
                //     }
                // }
            
                // if (!empty($linkedStatus)) {
                //     if ($linkedStatus === 'linked') {
                //         // Lấy những người đã có fk_wc_customer_id (không phải NULL)
                //         $query .= " AND zf.fk_wc_customer_id IS NOT NULL";
                //     } elseif ($linkedStatus === 'not_linked') {
                //         // Lấy những người chưa có fk_wc_customer_id (NULL)
                //         $query .= " AND zf.fk_wc_customer_id IS NULL";
                //     }
                // }
            
                // if (!empty($followStatus)) {
                //     if ($followStatus === 'followed') {
                //         // Lấy những người có Follow_Status = 1
                //         $query .= " AND zf.Follow_Status = 1";
                //     } elseif ($followStatus === 'unfollowed') {
                //         // Lấy những người có Follow_Status = 0
                //         $query .= " AND zf.Follow_Status = 0";
                //     }
                // }
            
                // // Thêm phần sắp xếp vào truy vấn
                // $query .= " ORDER BY zf.Follow_Start_Date DESC";
                // // $results = $wpdb->get_results($query);
                // $queryresults=$query;
            }
        ?>
        <!-- section fillter dữ liệu -->
        <div>
            <div style="max-width:98%; background-color: #F2F4F7; padding: 15px; margin-top:15px;margin-bottom:15px;">
                <div class="row">
                    <div class="col-6">
                        <form method="GET" class="filter-form" action="" id="filterForm">
                            <div class="form-group mb-2 d-flex flex-column" style="width:200px;">
                                <label for="dateRange" key="follow_date">Follow date</label>
                                <select class="form-control" id="dateRange" name="dateRange">
                                    <option value="" key="all_day">All day</option>
                                    <option value="today" key="today">Today</option>
                                    <option value="yesterday" key="yesterday">Yesterday</option>
                                    <option value="this_week" key="this_week">This week</option>
                                    <option value="last_week" key="last_week">Last week</option>
                                    <option value="this_month" key="this_month">This month</option>
                                    <option value="last_month" key="last_month">Last month</option>
                                    <option value="6_months_ago" key="_6_months_ago">6 months ago</option>
                                    <option value="1_year_ago" key="_1_year_ago">1 year ago</option>
                                </select>
                            </div>
                            
                            <div class="form-group mx-sm-3 mb-2 d-flex flex-column" style="width:200px;">
                                <label for="linkedStatus" key="link_status">Link status</label>
                                <select class="form-control" id="linkedStatus" name="linkedStatus">
                                    <option value="" key="all">All</option>
                                    <option value="linked" key="linked">Linked</option>
                                    <option value="not_linked" key="no_linkage">No linkage</option>
                                </select>
                            </div>
                
                            <div class="form-group mb-2 d-flex flex-column" style="width:200px;">
                                <label for="followStatus" key="follow_status">Follow status</label>
                                <select class="form-control" id="followStatus" name="followStatus">
                                    <option value="" key="all">All</option>
                                    <option value="followed" key="followed">Followed</option>
                                    <option value="unfollowed" key="unfollow">Unfollow</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-2 d-flex flex-column">
                                <label for="dateRange" style="color: #F2F4F7">...</label>
                                <button type="submit" class="btn btn-primary" name="fillter-btn" style="height: 30px; font-size: 13px; text-align: center;"><i class="fa-solid fa-filter"></i><span key="filter"> Filter</span></button>
                            </div>
                            <div class="form-group mb-2 d-flex flex-column">
                                <label for="dateRange" style="color: #F2F4F7">...</label>
                                <button type="button" class="btn btn-secondary mb-2" onclick="clearFilters()" id="clearFiltersButton" style="height: 30px; font-size: 13px; text-align: center;" key="unfilter">Unfilter</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6 text-end" style="padding-top:15px;padding-right:25px;">
                        <label for="followStatus" key="search">Search</label>
                        <input type="search" id="myInputTextField">
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end section fillter dữ liệu -->
        <div style="max-width:98%">
        <table id="follower-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th key="avatar">Avatar</th>
                    <th key="customer_name">Customer name</th>
                    <th key="follow_date">Follow date</th>
                    <th key="customer_linkage">Customer linkage</th>
                    <th key="address">Address</th>
                    <th key="follow_status">Follow status</th>
                    <th key="action">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                global $wpdb;
                if (!isset($_GET['fillter-btn'])) {
                    $query = "
                        SELECT zf.id, zf.Zalo_ID, zf.Zalo_Name, zf.Zalo_URL_Img, zf.Zalo_ID_By_App, zf.Follow_Status, zf.Follow_Start_Date, zf.Unfollow_Date, zf.fk_wc_customer_id, cl.first_name, cl.last_name, um.meta_value AS billing_address_1
                        FROM {$wpdb->prefix}zalo_followers AS zf
                        LEFT JOIN {$wpdb->prefix}wc_customer_lookup AS cl ON zf.fk_wc_customer_id = cl.customer_id
                        LEFT JOIN {$wpdb->prefix}usermeta AS um ON cl.user_id = um.user_id AND um.meta_key = 'billing_address_1'
                        ORDER BY zf.Follow_Start_Date DESC
                    ";
                }
                else{
                    $query=$queryresults;
                }
                // $follower_data = $wpdb->get_results($query);
                // if ($follower_data) {
                //     foreach ($follower_data as $follower) {
                //         $dot="";
                //         if($follower->Follow_Status==1)
                //             $dot="dot dot-success";
                //         else
                //             $dot="dot dot-danger";
                //         $customer_name="";
                //         if($follower->fk_wc_customer_id==null)
                //             $customer_name="Chưa liên kết";
                //         else
                //             $customer_name=$follower->first_name." ".$follower->last_name;
                //         $follow_date=date('d/m/Y', strtotime($follower->Follow_Start_Date));
                //         $billing_address='';
                //         if($follower->billing_address_1==null)
                //             $billing_address='--';
                //         else
                //             $billing_address=$follower->billing_address_1;
                //         $link_route_user_chat=admin_url("admin.php?page=follower-chat&id=$follower->Zalo_ID");
                //         $link_route_user_detail=admin_url("admin.php?page=customer-detail&username=$follower->Zalo_ID_By_App&avt=$follower->Zalo_URL_Img&fk_wc_user_id=$follower->fk_wc_customer_id&zalo_id=$follower->Zalo_ID");
                //         echo
                //         "<tr class='align-middle'>
                //             <td><img src='$follower->Zalo_URL_Img' alt='Avatar' class='rounded-circle' style='width: 45px;' alt='Avatar'></td>
                //             <td>$follower->Zalo_Name</td>
                //             <td>$follow_date</td>
                //             <td><a href='$link_route_user_detail'>$customer_name</a></td>
                //             <td>$billing_address</td>
                //             <td><div class='$dot'></div></td>
                //             <td>
                //                 <div class='dropdown'>
                //                     <button class='dropdown-item btn-action-menu' onclick='toggleDropdown($follower->id)'><i class='fas fa-ellipsis-v fa-lg'></i></button>
                //                     <div class='dropdown-content' id='myDropdown$follower->id'>
                //                         <a id='chat' href='$link_route_user_chat' data-id='$follower->Zalo_ID_By_App' class='col ml-3 dropdown-item' data-bs-toggle='tooltip' data-bs-placement='top' title='Lịch sử chat'><i class='fas fa-envelope mr-1 larger-icon'></i> Lịch sử chat</a>
                //                         <a id='link-user' data-id='$follower->Zalo_ID_By_App' data-name='$follower->Zalo_Name' data-avatar='$follower->Zalo_URL_Img' class='col ml-3 dropdown-item' data-bs-toggle='tooltip' data-bs-placement='top' title='Liên kết khách hàng'><i class='fa-solid fa-link'></i> Liên kết</a>
                //                         <a id='delete-user' data-id='' data-name='' data-avatar='' class='col ml-3 dropdown-item' data-bs-toggle='tooltip' data-bs-placement='top' title='Xóa zalo'><i class='fa-solid fa-trash'></i> Xóa zalo</a>
                //                     </div>
                //                 </div>

                                
                //             </td>
                //         </tr>";
                //     }
                    
                // }
                // else {
                //     echo "Không có dữ liệu người theo dõi.";
                // }
            ?>
            </tbody>
        </table>
        </div>
        <!-- Modal liên kết -->
        <div id="link-modal" class="modal fade mt-5" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h4 class="modal-title" id="standard-modalLabel">Liên kết khách hàng</h4>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center" >Thông tin tài khoản liên kết </h6>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <img id="avatar" src="" class="avatar-md rounded-circle text-center" alt="" style='width: 45px;'>
                            <br>
                            <span id="display-name" class="text-center"></span>
                        </div>
                        <hr>
                        <?php
                            global $wpdb;
                            // $customer_table = $wpdb->prefix . 'wc_customer_lookup';
                            // $customers = $wpdb->get_results("SELECT customer_id, first_name, last_name FROM $customer_table");
                            $customer_table = $wpdb->prefix . 'wc_customer_lookup';
                            $usermeta_table = $wpdb->prefix . 'usermeta';
                            $customers = $wpdb->get_results(
                                "SELECT c.customer_id, c.first_name, c.last_name, m.meta_value
                                FROM $customer_table c
                                LEFT JOIN $usermeta_table m ON c.user_id = m.user_id AND m.meta_key = 'billing_phone'"
                            );

                            echo "<select name='customer' id='select' class='select' style='z-index: 9999;' data-live-search='true'><option value=''>Chọn khách hàng</option>";
                                foreach($customers as $customer){
                                    echo"
                                        <option value='$customer->customer_id'>$customer->first_name $customer->last_name $customer->meta_value</option>
                                    ";
                                }
                            echo"</select>";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="btn-close" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="btn-link"> Liên kết</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc modal liên kết -->
        <!--Modal lịch sử chat-->
        <div id="chat-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scrollableModalTitle">
                            <div id="menu-chat" ></div>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <ul class="conversation-list chat-app-conversation" data-simplebar="init" style="max-height: 460px"><div class="simplebar-wrapper" style="margin: 0px -15px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 15px;">
                                                <div id="history"></div>
                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 905px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 233px; transform: translate3d(0px, 142px, 0px); display: block;"></div></div></ul>
                    </div>
                </div>
    
            </div>
            <!--bắt đầu section chat-->
            <section style="background-color: #eee;">
              <div class="container py-5">
            
                <div class="row d-flex justify-content-center">
                  <div class="col-md-10 col-lg-8 col-xl-6">
            
                    <div class="card" id="chat2">
                      <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
            
                        <div class="d-flex flex-row justify-content-start">
                          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                            alt="avatar 1" style="width: 45px; height: 100%;">
                          <div>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">How are you ...???
                            </p>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">What are you doing
                              tomorrow? Can we come up a bar?</p>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
                          </div>
                        </div>
            
                        <div class="divider d-flex align-items-center mb-4">
                          <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>
                        </div>
            
                        <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                          <div>
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Hiii, I'm good.</p>
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">How are you doing?</p>
                            <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Long time no see! Tomorrow
                              office. will
                              be free on sunday.</p>
                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>
                          </div>
                          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                            alt="avatar 1" style="width: 45px; height: 100%;">
                        </div>
            
            			<div class="d-flex flex-row justify-content-start">
                          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                            alt="avatar 1" style="width: 45px; height: 100%;">
                          <div>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">How are you ...???
                            </p>
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">What are you doing
                              tomorrow? Can we come up a bar?</p>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
                          </div>
                        </div>
            
                        
                        
                      </div>
                      
                    </div>
            
                  </div>
                </div>
            
              </div>
            </section>
            <!--kết thúc section chat-->
            
            
            
        </div>
        <!-- Kết thúc modal lịch sử chat-->
        
        
    </div>


    
</body>


<!-- js bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- js datatable -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!--js select2-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var apiUrl = "/wp-json/zalo-management/v1/check_license_key";
    var licenseKey = "<?php if(!empty($apikey)) echo $apikey; else echo "null"; ?>";
    if(licenseKey=="null"){
        alert("Please check license key and try again");
        window.location.href = '/wp-admin/admin.php?page=follower-setup';
    }
    // jQuery.ajax({
    //     type: "GET",
    //     url: apiUrl + "?license_key=" + licenseKey,
    //     success: function (response) {
    //         if (response.status === 200 && response.message === "Success") {
               
    //         } else {
    //             alert("Erro: " + response.message +". Please check license key and try again");
    //             window.location.href = '/wp-admin/admin.php?page=follower-setup';
    //         }
    //     },
    //     error: function (error) {
    //         // Xử lý lỗi trong quá trình gọi API
    //         console.log("Lỗi khi gọi API: " + JSON.stringify(error));
    //     }
    // });
</script>
<script>
    $(document).ready(function() {
        var dateRange = document.getElementById('dateRange').value;
        var linkedStatus = document.getElementById('linkedStatus').value;
        var followStatus = document.getElementById('followStatus').value;
        oTable = $('#follower-table').DataTable({
            // "bPaginate": false,
            // pagingType: "full_numbers", drawCallback: function () {
            //     $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            // },
            processing: true,
            serverSide: true,
            ajax:"/wp-json/zalo-management/v1/get-customer-data-list"+ '?dateRange=' + dateRange + '&linkedStatus=' + linkedStatus + '&followStatus=' + followStatus +'&fillter-btn=true',
            columns: [
                {data: 'Zalo_URL_Img'},
                {data: 'Zalo_Name'},
                {data: 'Follow_Start_Date'},
                {data: 'first_name'},
                {data: 'billing_address_1'},
                {data: 'dot'},
                {data: 'dropdown'},
            ],
            order:[2, 'DESC'],
            columnDefs: [
                {
                    targets: 0,
                    data:null,
                    sortable: false,
                },
                {
                    targets: 2,
                    // className: "text-left",
                },
                {
                    targets: 5,
                    sortable: false,
                },
                {
                    targets: -1,
                    data: null,
                    sortable: false,
                },
            ],
        });
        
        oTable.on('draw.dt',()=>{
            $("#follower-table_first a").eq(0).text('First');
            $('#follower-table_previous a').eq(0).text('Prev');
            $('#follower-table_next a').eq(0).text('Next');
            $("#follower-table_last a").eq(0).text('Last');
        })
        
        
        $('#myInputTextField').on('keypress input', function(event) {
            if (event.type === 'keypress' && (event.which == 13 || event.keyCode == 13)) {
                // Người dùng ấn phím "Enter" trên desktop
                event.preventDefault(); // Ngăn chặn sự kiện mặc định của phím "Enter"
                oTable.search($(this).val()).draw();
            }
            else if(event.type === 'keypress' && (event.which == 32 || event.keyCode == 32)){
                oTable.search($(this).val()).draw();
            }
            else if (event.type === 'input') {
                // Sự kiện "input" xảy ra trên thiết bị di động khi bạn bấm nút tìm kiếm
                if(this.value==''){
                    oTable.search($(this).val()).draw();
                    console.log("rỗng");
                }
            }
        });
        
        $('#select').select2({
            dropdownParent: "#link-modal" ,
            width: '100%',
            placeholder: 'Chọn khách hàng',
        }).on('select2:opening', function(e) {
            $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Nhập tên hoặc sđt khách hàng')
        });
        
    });
</script>
<script>
    function toggleDropdown(index) {
        const dropdownContent = document.getElementById("myDropdown" + index);
        const allDropdowns = document.querySelectorAll(".dropdown-content");
        // Đóng tất cả các dropdown trước khi mở dropdown mới
        allDropdowns.forEach((dropdown) => {
            if (dropdown !== dropdownContent && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
        dropdownContent.classList.toggle("show");
    }

    // Đóng dropdown khi click bất kỳ nơi nào trên trang
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-item')) {
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
<script>
    // Đặt sự kiện submit cho form
    document.getElementById('filterForm').addEventListener('submit', function (event) {
        event.preventDefault();
        // Lấy giá trị của các trường form
        var dateRange = document.getElementById('dateRange').value;
        var linkedStatus = document.getElementById('linkedStatus').value;
        var followStatus = document.getElementById('followStatus').value;
        // Xây dựng URL mới dựa trên giá trị của các trường form
        var baseUrl = '<?php echo admin_url();?>admin.php?page=follower-management';
        var newUrl = baseUrl + '&dateRange=' + dateRange + '&linkedStatus=' + linkedStatus + '&followStatus=' + followStatus +'&fillter-btn=true';
        window.location.href = newUrl;
    });
    // Kiểm tra xem các tham số đã tồn tại trong URL hay không
    var urlParams = new URLSearchParams(window.location.search);
    
    // Kiểm tra và thiết lập giá trị cho trường "dateRange"
    var dateRangeParam = urlParams.get('dateRange');
    if (dateRangeParam) {
        document.getElementById('dateRange').value = dateRangeParam;
    }
    
    // Kiểm tra và thiết lập giá trị cho trường "linkedStatus"
    var linkedStatusParam = urlParams.get('linkedStatus');
    if (linkedStatusParam) {
        document.getElementById('linkedStatus').value = linkedStatusParam;
    }
    
    // Kiểm tra và thiết lập giá trị cho trường "followStatus"
    var followStatusParam = urlParams.get('followStatus');
    if (followStatusParam) {
        document.getElementById('followStatus').value = followStatusParam;
    }
    
    var hasFilterParam = urlParams.has('fillter-btn');
    var clearFiltersButton = document.getElementById('clearFiltersButton');
    // Kiểm tra và hiển thị hoặc ẩn nút "Bỏ lọc" dựa vào kết quả
    if (hasFilterParam) {
        clearFiltersButton.style.display = 'block'; // Hiển thị nút "Bỏ lọc"
    } else {
        clearFiltersButton.style.display = 'none'; // Ẩn nút "Bỏ lọc"
    }
    
</script>
<script>
    function clearFilters() {
        // Làm sạch giá trị của các input/select box
        var baseUrl = '<?php echo admin_url();?>admin.php?page=follower-management';
        window.location.href = baseUrl;
    }
</script>
<script>
    // code xử lý modal link zalo
    $(document).on('click','#link-user',function (){
        var zaloid = $(this).attr('data-id');
        var zaloname = $(this).attr('data-name');
        var zaloavatar = $(this).attr('data-avatar');
        $('#link-modal').modal('show');
        $('#avatar').attr('src', zaloavatar);
        $('#display-name').text(zaloname);
        $('#btn-link').attr('data-id', zaloid);
        var options = {};
        $('#btn-close').on('click', function() {
            $('#link-modal').modal('hide');
        });
    });
    $(document).on('click', '#btn-link', function() {
        var id=$(this).attr('data-id');
        $('#loading-overlay').show();
        $('#link-modal').modal('hide');
        $.ajax({
            url: '/wp-json/zalo-management/v1/link-zalo/?id=' + id + '&customerId=' + $('#select').val(),
            method: 'GET',
            success: function(response) {
                // console.log('Đã liên kết khách hàng:', response);
                location.reload(true);
                // Các xử lý thành công khác
            },
            error: function(xhr, status, error) {
                location.reload(true);
                // console.log('Lỗi:', error);
                // Xử lý lỗi
            }
        });
    });
    // kết thúc code xử lý modal link zalo
    //bắt đầu code xử lý lấy lịch sử chat 
    $(document).on('click','#chattest',function () {
        var id=$(this).attr('data-id');
        var username="";
        $('#chat-modal').modal('show');
        $.ajax({
            url: '/wp-json/zalo-management/v1/profile-zalo/?id='+id,
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                var spinnerHTML = '<div class="spinner-container"><div></div></div>';
                $('#menu-chat').html(spinnerHTML);
            },
            success: function(response) {
                menu='';
                menu += '<div class="d-flex align-items-center py-1">';
                menu += '    <img src="' + response.avatar + '" class="me-2 rounded-circle" height="36" alt="Brandon Smith">';
                menu += '    <div class="flex-1">';
                menu += '        <h5 class="m-1 mt-0 mb-0 font-15">';
                menu += '            <div href="#" class="text-decoration-none">' + response.display_name + '</div>';
                menu += '        </h5>';
                menu += '    </div>';
                menu += '</div>';
                username=response.display_name;
                $('#menu-chat').html(menu);
            },
            complete: function() {
                $('#menu-chat .spinner-container').remove();
            },
            error: function(xhr, status, error) {
                // console.log(error);
            }
        });

        if (id) {
            $('#history').html('<div class="spinner"></div>');
            $.ajax({
                url: '/wp-json/zalo-management/v1/history-chat/?id='+id,
                method: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    var spinnerHTML = '<div class="spinner-container"><div class="spinner mt-lg-5 style="display: flex; align-items: center;justify-content: center;height: 100%; "></div></div>';
                    $('#history').html(spinnerHTML);
                },
                success: function(data) {
                    console.log(data);
                    var html='';
                    if (data.length===0){
                        html+='<h1 class="text-center"> Khách hàng chưa gửi tin nhắn zalo OA</h1>'
                    }
                var html = '';
                
                for (var i = 0; i < data.length; i++) {
                    var message = data[i];
                    var isFromAdmin = message.from_id === "1001576093731275020";
                    var alignmentClass = isFromAdmin ? "justify-content-end bg-light align-items-center" : "justify-content-start bg-light align-items-center";
                    var chatAvatarClass = isFromAdmin ? "ml-3" : "mr-3";
                    var messageTypeClass = message.type === "text" ? "conversation-text" : "conversation-post";
                    var textColorClass = isFromAdmin ? "text-dark" : "text-dark";
                
                    html += '<li class="clearfix mb-3">';
                    html += '    <div class="d-flex ' + alignmentClass + ' p-3 rounded">';
                    
                    if (!isFromAdmin) {
                        html += '        <img src="' + message.from_avatar + '" class="rounded-circle chat-avatar ' + chatAvatarClass + '" alt="' + message.from_display_name + '" width="45" height="45">';
                    }
                    
                    html += '        <div class="' + messageTypeClass + '">';
                    html += '            <div class="ctext-wrap ' + textColorClass + '">';
                    
                    // if (isFromAdmin) {
                    //     html += '                <i>' + message.from_display_name + '</i>';
                    // }
                    
                    if (message.type === "text") {
                        html += '                <p class="m-3">' + message.message + '</p>';
                    } else {
                        var links = message.links;
                        for (var j = 0; j < links.length; j++) {
                            html += '            <img src="' + links[j].thumb + '" class="rounded" style="width: 100%; height: 50%">';
                            html += '            <p>' + links[j].title + '</p>';
                            html += '            <p>' + links[j].description + '</p>';
                        }
                    }
                    
                    // if (!isFromAdmin) {
                    //     html += '                <i>' + message.from_display_name + '</i>';
                    // }
                    
                    html += '            </div>';
                    html += '        </div>';
                    
                    if (isFromAdmin) {
                        html += '        <img src="' + message.from_avatar + '" class="rounded-circle chat-avatar ' + chatAvatarClass + '" alt="' + message.from_display_name + '" width="45" height="45">';
                    }
                    
                    html += '    </div>';
                    html += '</li>';
                }
                $('#history').html(html);

                },
                complete: function() {
                    $('#history .spinner').remove();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            console.log('Không có id được truyền vào.');
        }
    });
    //kết thúc code xử lý lịch sử chat
</script>

</html>