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
    $customer = new WC_Customer($user_id);
    // Kiểm tra xem khách hàng có tồn tại không
    if ($customer->get_id()) {
        // Lấy thông tin hồ sơ khách hàng
        $customer_data = $customer->get_data();
        $order_count = wc_get_customer_order_count($user_id);
        $total_spent = wc_get_customer_total_spent($user_id);
        // In thông tin khách hàng
    } else {
        echo "Không tìm thấy khách hàng với User ID này.";
    }
    // Lấy các thông tin cụ thể và lưu vào biến
    $user_id = $customer_data["id"];
    $email = $customer_data["email"];
    $first_name = $customer_data["first_name"];
    $last_name = $customer_data["last_name"];
    $display_name = $customer_data["display_name"];
    $role = $customer_data["role"];
    // Lưu thông tin địa chỉ thanh toán và giao hàng
    $billing_address = $customer_data["billing"];
    $shipping_address = $customer_data["shipping"];
    // Lấy đường dẫn tương đối đến thư mục "img" của plugin
    $img_url = plugins_url('img/', __FILE__);
    // Kết hợp đường dẫn tương đối với tên tệp hình ảnh bạn muốn sử dụng
    $icon_order = $img_url . 'icon-04.png';
    $icon_sales = $img_url . 'icon-02.png';
    $icon_point = $img_url . 'icon-05.png';
    $icon_promotion = $img_url . 'icon-03.png';
    // Truy vấn cơ sở dữ liệu để lấy tổng số điểm tích lũy của người dùng cụ thể
    $query = $wpdb->prepare(
        "SELECT SUM(point_amount) AS total_points
        FROM wp_reward_point_history
        WHERE fk_wc_customer_id = %d",
        $fk_wc_user_id
    );

    $total_points = $wpdb->get_var($query);
    // Hiển thị tổng số điểm tích lũy
    if ($total_points !== null) {
        $total_points= $total_points;
    } else {
        $total_points=0;
    }
    // Truy vấn SQL để tính tổng số lịch gửi đã gửi thành công cho khách hàng
    $query = $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}schedulesendingv2 WHERE fkCustomer = %d AND status = 1",
        $fk_wc_user_id
    );
    $total_successful_schedules = $wpdb->get_var($query);
    // Truy vấn SQL để lấy các tagname của khách hàng
    $query = $wpdb->prepare(
        "SELECT t.Name
        FROM {$wpdb->prefix}customer_tag AS ct
        INNER JOIN {$wpdb->prefix}tags AS t ON ct.fkTag = t.id
        WHERE ct.fkCustomer = %d",
        $fk_wc_user_id
    );
    // Thực thi truy vấn và lấy kết quả
    $tag_names = $wpdb->get_results($query);
    
    
    $homepage= admin_url("admin.php?page=follower-management");
    $link_route_user_detail=admin_url("admin.php?page=customer-detail&username=$username&avt=$avatar&fk_wc_user_id=$fk_wc_user_id&zalo_id=$zalo_id");
    $link_route_user_order=admin_url("admin.php?page=customer-order-list&username=$username&avt=$avatar&fk_wc_user_id=$fk_wc_user_id&zalo_id=$zalo_id");
    $link_route_user_chat=admin_url("admin.php?page=customer-chat-history&username=$username&avt=$avatar&fk_wc_user_id=$fk_wc_user_id&zalo_id=$zalo_id");
    
    
    
    // Đảm bảo bạn có dữ liệu POST từ form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy user_id của khách hàng từ form (biểu mẫu)
        $user_id = $_POST['user_id'];
    
        //Kiểm tra xem user_id có tồn tại và là một số nguyên hợp lệ không
        if (!empty($user_id) && is_numeric($user_id)) {
            // Khởi tạo một đối tượng khách hàng
            $customer = new WC_Customer($user_id);
    
            // Kiểm tra xem khách hàng có tồn tại không
            if ($customer->get_id()) {
                // Cập nhật thông tin của khách hàng dựa trên dữ liệu POST
                $customer->set_email($_POST['email']);
                $customer->set_first_name($_POST['first_name']);
                $customer->set_last_name($_POST['last_name']);
    
                // // Cập nhật địa chỉ thanh toán
                // $billing_address = $customer->get_billing_address();
                // $billing_address['address_1'] = $_POST['address_1'];
                // $billing_address['address_2'] = $_POST['address_2'];
                // $billing_address['city'] = $_POST['City'];
                // $billing_address['postcode'] = $_POST['postcode'];
                // $billing_address['country'] = $_POST['country'];
                // $billing_address['state'] = $_POST['state'];
                // $billing_address['email'] = $_POST['email'];
                // $billing_address['phone'] = $_POST['phone'];
                // $customer->set_billing_address($billing_address);
    
                // // Cập nhật địa chỉ giao hàng
                // $shipping_address = $customer->get_shipping_address();
                // $shipping_address['address_1'] = $_POST['shipping_address_1'];
                // $shipping_address['address_2'] = $_POST['shipping_address_2'];
                // $shipping_address['city'] = $_POST['shipping_city'];
                // $shipping_address['postcode'] = $_POST['shipping_postcode'];
                // $shipping_address['country'] = $_POST['shipping_country'];
                // $shipping_address['state'] = $_POST['shipping_state'];
                // $shipping_address['phone'] = $_POST['shipping_phone'];
                // $customer->set_shipping_address($shipping_address);
    
                // Lưu thông tin cập nhật
                $customer->save();
    
                echo "Thông tin khách hàng đã được cập nhật thành công.";
            } else {
                echo "Không tìm thấy khách hàng với User ID này.";
            }
        } else {
            echo "User ID không hợp lệ.";
        }
    }

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
    <!--<link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />-->
    <!--<link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />-->
    <!--<link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />-->
    <!--<link rel="stylesheet" href="../assets/css/demo.css" />-->
    <!--<link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />-->
    <!--<script src="../assets/vendor/js/helpers.js"></script>-->
    <!--<script src="../assets/js/config.js"></script>-->
</head>
<style>
    .card{
        min-width: 65vw !important;
    }
    .card-cus{
        margin-top:15px;
        border: 1px solid gainsboro;
        border-radius: 5px;
    }
    .div-card{
        @media (max-width: 576px){
            display: flex;
            flex-direction: column;
            width: 100%;
        }
    }
    .div-card-item{
        @media (max-width: 576px){
            width: 100%;
        }
    }
    .custom-color{
        background-color: #e5e5e5;
        color: black;
        border-radius: 5px;
        margin-left: 10px;
    }
    
    /*.card-body{*/
    /*    min-width: 65vw !important;*/
    /*}*/
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
              <h5 class="py-3 mb-4"><a href="<?php echo $link_dashboard; ?>" style="text-decoration: none;">Dashboard</a> / <a href="<?php echo $homepage; ?>" style="text-decoration: none;">Customers Integration</a> / Customer Details</h5>
                <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item" onClick="handleClick()">
                      <a class="nav-link active" href="javascript:void(0);"><i class="fa-regular fa-user"></i> <span key="General_Information">Thông tin chung</span></a>
                    </li>
                    <li class="nav-item custom-color">
                      <a class="nav-link" href="<?php echo $link_route_user_order; ?>"
                        ><i class="fa-solid fa-basket-shopping"></i> <span key="Orders">Đơn hàng</span></a
                      >
                    </li>
                    <li class="nav-item custom-color">
                      <a class="nav-link" href="<?php echo $link_route_user_chat; ?>"
                        ><i class="fa-solid fa-z"></i> <span key="Zalo_Interaction">Tương tác Zalo</span></a
                      >
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header" key="Detailed_Information">Thông tin chi tiết</h5>
                    
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="<?php echo $avatar; ?>"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar" />
                        <div class="button-wrapper">
                          <!--<label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">-->
                          <!--  <span class="d-none d-sm-block">Upload new photo</span>-->
                          <!--  <i class="bx bx-upload d-block d-sm-none"></i>-->
                          <!--  <input-->
                          <!--    type="file"-->
                          <!--    id="upload"-->
                          <!--    class="account-file-input"-->
                          <!--    hidden-->
                          <!--    accept="image/png, image/jpeg" />-->
                          <!--</label>-->
                          <!--<button type="button" class="btn btn-outline-secondary account-image-reset mb-4">-->
                          <!--  <i class="bx bx-reset d-block d-sm-none"></i>-->
                          <!--  <span class="d-none d-sm-block">Reset</span>-->
                          <!--</button>-->
                          <h5><?php echo $first_name." ".$last_name; ?></h5>
                          <div><i class="fa-solid fa-phone"></i><?php echo " ". $billing_address["phone"] ." ".$shipping_address["phone"] ;?> <br> <i class="fa-solid fa-envelope"></i><span style="max-width: 100%; word-break: break-word;"><?php echo " ". $email; ?></span></div>
                          <p class="text-muted mb-0"><span key="Customer_Card">Thẻ khách hàng:</span> 
                          <?php
                            if ($tag_names) {
                                // Lặp qua và hiển thị các tagname dưới dạng badge
                                foreach ($tag_names as $tag_name) {
                                    $random_color = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Tạo màu sắc ngẫu nhiên
                                    echo '<br><span class="badge" style="background-color: ' . $random_color . ';">' . $tag_name->Name . '</span>&nbsp;';
                                }
                            } else {
                                echo "<span key='no_tags'>Khách hàng này không có tag nào.</span>";
                            }
                          ?>
                          </p>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <!--bắt đầu thống kê các thông số-->
                    <div class="row div-card">
                        <div class="col-lg-3 col-3 mb-6 div-card-item">
                          <div class="card-cus">
                            <div class="card-body">
                              <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <!--hình ơ đây-->
                                    <img
                                    src="<?php echo $icon_order;?>"
                                    alt="Credit Card"
                                    class="rounded"
                                    width="50" height="50"/>
                                </div>
                                <div class="dropdown">
                                  <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt3"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                  </div>
                                </div>
                              </div>
                              <span class="fw-medium d-block mb-1" key="Order">Đơn hàng</span>
                              <h3 class="card-title mb-2"><?php echo $order_count; ?></h3>
                              <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>-->
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-3 mb-6 div-card-item">
                          <div class="card-cus">
                            <div class="card-body">
                              <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                  <img
                                    src="<?php echo $icon_sales;?>"
                                    alt="Credit Card"
                                    class="rounded" 
                                    width="50" height="50" />
                                </div>
                                <div class="dropdown">
                                  <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt6"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                  </div>
                                </div>
                              </div>
                              <span class="fw-medium d-block mb-1" key="Revenue">Doanh số</span>
                              <h3 class="card-title text-nowrap mb-1"><?php echo number_format($total_spent, 0, ",", ".") . " đ"; ?></h3>
                              <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-3 mb-6 div-card-item">
                          <div class="card-cus">
                            <div class="card-body">
                              <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                  <img
                                    src="<?php echo $icon_point;?>"
                                    alt="Credit Card"
                                    class="rounded" 
                                    width="50" height="50" />
                                </div>
                                <div class="dropdown">
                                  <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt6"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                  </div>
                                </div>
                              </div>
                              <span class="fw-medium d-block mb-1" key="Points">Điểm</span>
                              <h3 class="card-title text-nowrap mb-1"><?php echo $total_points; ?></h3>
                              <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-3 mb-6 div-card-item">
                          <div class="card-cus">
                            <div class="card-body">
                              <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                  <img
                                    src="<?php echo $icon_promotion;?>"
                                    alt="Credit Card"
                                    class="rounded"
                                    width="50" height="50" />
                                </div>
                                <div class="dropdown">
                                  <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt6"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                  </div>
                                </div>
                              </div>
                              <span class="fw-medium d-block mb-1" key="Advertisement">Tin quảng cáo</span>
                              <h3 class="card-title text-nowrap mb-1"><?php echo $total_successful_schedules; ?></h3>
                              <!--<small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                            </div>
                          </div>
                        </div>
                     </div>
                    <!--kết thúc thống kê-->
                    
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST">
                        <div class="row">
                          <!--<div class="mb-3 col-md-6">-->
                          <!--  <label for="firstName" class="form-label">Họ tên</label>-->
                          <!--  <input-->
                          <!--    class="form-control"-->
                          <!--    type="text"-->
                          <!--    id="firstName"-->
                          <!--    name="firstName"-->
                          <!--    value=""-->
                          <!--    readonly />-->
                          <!--</div>-->
                          <!--<div class="mb-3 col-md-6">-->
                          <!--  <label for="phone" class="form-label">Số điện thoại</label>-->
                          <!--  <input class="form-control" type="text" name="phone" id="phone" value="" readonly />-->
                          <!--</div>-->
                          <!--<div class="mb-3 col-md-6">-->
                          <!--  <label for="email" class="form-label">E-mail</label>-->
                          <!--  <input-->
                          <!--    class="form-control"-->
                          <!--    type="text"-->
                          <!--    id="email"-->
                          <!--    name="email"-->
                          <!--    value=""-->
                          <!--    placeholder="Email khách hàng"-->
                          <!--    readonly />-->
                          <!--</div>-->
                          <!--<div class="mb-3 col-md-6">-->
                            
                          <!--</div>-->
                          <h5 class="card-header mb-3"><span key="Billing_Address">Địa chỉ thanh toán</span> <a href="#billingAddressCollapse" data-bs-toggle="collapse"><i class="fa-solid fa-chevron-down"></i></a></h5>
                            <div id="billingAddressCollapse" class="row collapse">
                            <div class="mb-3 col-md-6">
                                <label for="first_name" class="form-label" key="First_Name">Họ</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo esc_attr($billing_address['first_name']); ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last_name" class="form-label" key="Last_Name">Tên</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo esc_attr($billing_address['last_name']); ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address_1" class="form-label" key="Address_Line_1">Địa chỉ 1</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address_1"
                                    name="address_1"
                                    placeholder="Address 1"
                                    value="<?php echo esc_attr($billing_address['address_1']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address_2" class="form-label" key="Address_Line_2">Địa chỉ 2</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address_2"
                                    name="address_2"
                                    placeholder="Address 2"
                                    value="<?php echo esc_attr($billing_address['address_2']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="city" class="form-label" key="City">Thành phố</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="city"
                                    name="city"
                                    placeholder="City"
                                    value="<?php echo esc_attr($billing_address['city']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="postcode" class="form-label">Postcode</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="postcode"
                                    name="postcode"
                                    placeholder="Postcode"
                                    maxlength="6"
                                    value="<?php echo esc_attr($billing_address['postcode']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="country" class="form-label" key="Country">Quốc gia</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="country"
                                    name="country"
                                    placeholder="Country"
                                    value="<?php echo esc_attr($billing_address['country']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="state"
                                    name="state"
                                    placeholder="State"
                                    value="<?php echo esc_attr($billing_address['state']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Email"
                                    value="<?php echo esc_attr($billing_address['email']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone" class="form-label" key="Phone_Number">Số điện thoại</label>
                                <input
                                    type="tel"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    placeholder="Phone"
                                    value="<?php echo esc_attr($billing_address['phone']); ?>"
                                />
                            </div>
                            </div>
                            <h5 class="card-header mb-3"><span key="Shipping_Address">Địa chỉ giao hàng</span><a href="#shippingAddressCollapse" data-bs-toggle="collapse"><i class="fa-solid fa-chevron-down"></i></a></h5>
                            <div id="shippingAddressCollapse" class="row collapse">
                            <div class="mb-3 col-md-6">
                                <label for="shipping_first_name" class="form-label" key="First_Name">Họ</label>
                                <input type="text" class="form-control" id="shipping_first_name" name="shipping_first_name" placeholder="First Name" value="<?php echo esc_attr($shipping_address['first_name']); ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_last_name" class="form-label" key="Last_Name">Tên</label>
                                <input class="form-control" type="text" id="shipping_last_name" name="shipping_last_name" placeholder="Last Name" value="<?php echo esc_attr($shipping_address['last_name']); ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_address_1" class="form-label" key="Address_Line_1">Địa chỉ 1</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="shipping_address_1"
                                    name="shipping_address_1"
                                    placeholder="Address 1"
                                    value="<?php echo esc_attr($shipping_address['address_1']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_address_2" class="form-label" key="Address_Line_2">Địa chỉ 2</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="shipping_address_2"
                                    name="shipping_address_2"
                                    placeholder="Address 2"
                                    value="<?php echo esc_attr($shipping_address['address_2']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_city" class="form-label" key="City">Thành phố</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="shipping_city"
                                    name="shipping_city"
                                    placeholder="City"
                                    value="<?php echo esc_attr($shipping_address['city']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_postcode" class="form-label">Postcode</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="shipping_postcode"
                                    name="shipping_postcode"
                                    placeholder="Postcode"
                                    maxlength="6"
                                    value="<?php echo esc_attr($shipping_address['postcode']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_country" class="form-label" key="Country">Quốc gia</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="shipping_country"
                                    name="shipping_country"
                                    placeholder="Country"
                                    value="<?php echo esc_attr($shipping_address['country']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_state" class="form-label">State</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="shipping_state"
                                    name="shipping_state"
                                    placeholder="State"
                                    value="<?php echo esc_attr($shipping_address['state']); ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shipping_phone" class="form-label" key="Phone_Number">Số điện thoại</label>
                                <input
                                    type="tel"
                                    class="form-control"
                                    id="shipping_phone"
                                    name="shipping_phone"
                                    placeholder="Phone"
                                    value="<?php echo esc_attr($shipping_address['phone']); ?>"
                                />
                            </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">
                        <!--<div class="mt-2">-->
                        <!--  <button type="submit" class="btn btn-primary me-2">Cập nhật</button>-->
                        <!--  <button type="reset" class="btn btn-outline-secondary">Hủy</button>-->
                        <!--</div>-->
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <!--<div class="card">-->
                  <!--  <h5 class="card-header">Xóa tài khoản?</h5>-->
                  <!--  <div class="card-body">-->
                  <!--    <div class="mb-3 col-12 mb-0">-->
                  <!--      <div class="alert alert-warning">-->
                  <!--        <h6 class="alert-heading mb-1">Bạn chắc chắn muốn xóa tài khoản này không?</h6>-->
                  <!--        <p class="mb-0">Một khi bạn xóa tài khoản, bạn sẽ không thể quay lại. Xin hãy chắc chắn.</p>-->
                  <!--      </div>-->
                  <!--    </div>-->
                  <!--    <form id="formAccountDeactivation" onsubmit="return false">-->
                  <!--      <div class="form-check mb-3">-->
                  <!--        <input-->
                  <!--          class="form-check-input"-->
                  <!--          type="checkbox"-->
                  <!--          name="accountActivation"-->
                  <!--          id="accountActivation" />-->
                  <!--        <label class="form-check-label" for="accountActivation"-->
                  <!--          >Tôi xác nhận việc xóa tài khoản này</label-->
                  <!--        >-->
                  <!--      </div>-->
                  <!--      <button type="submit" class="btn btn-danger deactivate-account">Xóa tài khoản</button>-->
                  <!--    </form>-->
                  <!--  </div>-->
                  <!--</div>-->
                </div>
              </div>
            </div>
            <!-- / Content -->

             <!--Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made by
                  <a href="#" target="_blank" class="footer-link fw-medium">MKC</a>
                </div>
                <div class="d-none d-lg-inline-block">
                  <a href="#" class="footer-link me-4" target="_blank">License</a>
                  <a href="#" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="#"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="#"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
             <!--/ Footer -->

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

</body>
</html>