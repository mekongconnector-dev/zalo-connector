<?php
session_start();
global $wpdb;
    if($_SERVER["REQUEST_METHOD"] == 'GET'){
        $id = $_GET['m'];
        $marketingCampaign = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}marketingcampaign WHERE UUID='$id'",ARRAY_A);
        if($marketingCampaign[0] == null){
            $_SESSION['warning'] = 'chiến dịch không tồn tại vui lòng xem lại';
            $page_index = admin_url('admin.php?page=marketing-management');
            header('Location: ' . $page_index);
        }
        $count_schedulesending = $wpdb->get_results("SELECT 
        COUNT(*) AS total_records,
        SUM(CASE WHEN {$wpdb->prefix}schedulesendingv2.Status = 0 THEN 1 ELSE 0 END) AS count_status_0,
        SUM(CASE WHEN {$wpdb->prefix}schedulesendingv2.Status = 1 THEN 1 ELSE 0 END) AS count_status_1,
        SUM(CASE WHEN {$wpdb->prefix}schedulesendingv2.Status = 2 THEN 1 ELSE 0 END) AS count_status_2,
        SUM(CASE WHEN {$wpdb->prefix}schedulesendingv2.Status = 3 THEN 1 ELSE 0 END) AS count_status_3,
        SUM(CASE WHEN {$wpdb->prefix}schedulesendingv2.Status = 4 THEN 1 ELSE 0 END) AS count_status_4,
        SUM(CASE WHEN {$wpdb->prefix}schedulesendingv2.Status = 5 THEN 1 ELSE 0 END) AS count_status_5

    FROM 
    {$wpdb->prefix}schedulesendingv2 JOIN {$wpdb->prefix}wc_customer_lookup ON  {$wpdb->prefix}schedulesendingv2.fkCustomer =  {$wpdb->prefix}wc_customer_lookup.customer_id WHERE UUID='$id' ;");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- Jquery Toast css -->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css"/>-->

    <!-- Sweet Alert-->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

    <!-- Plugins css -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">-->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>-->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css">-->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/dropify/sass/dropify.css" rel="stylesheet" type="text/css">-->

    <!-- App css -->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet"/>-->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet"/>-->

    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet"/>-->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"/>-->

    <!-- Custom theme -->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/scss/theme-custom.css" rel="stylesheet" type="text/css"/>-->

    <!-- icons -->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- datatable -->
    <style>
        .pointer {
            cursor: pointer;
        }
        .dropify-wrapper {
            height: 250px !important;
            border-radius: 15px;
        }
        .dropdown-toggle::after{
            content:unset;
        }
        .dropify-wrapper .file-icon p {
            font-size: 16px !important;
        }
        .dataTables_processing {
            right: 1000px;
        }
        .card-header{
            background-color: white;
        }
        .active-link{
            font-weight: bold;
        }
        tr.odd td{
            background-color: rgb(242,242,242);
        }
        tr.odd{
            background-color: rgb(242,242,242);
        }
        div.dataTables_processing>div:last-child {
            position: relative;
            width: 80px;
            height: 15px;
            margin: 1em auto;
        }
        div.dataTables_processing>div:last-child>div:nth-child(1) {
            left: 8px;
            animation:datatables-loader-1 .6s infinite; 
        }
        
        div.dataTables_processing>div:last-child>div:nth-child(2) {
            left: 8px;
            animation:datatables-loader-2 .6s infinite; 
        }
        
        div.dataTables_processing>div:last-child>div:nth-child(3) {
            left: 32px;
            animation: datatables-loader-2 .6s infinite
        }
        
        div.dataTables_processing>div:last-child>div:nth-child(4) {
            left: 56px;
            animation: datatables-loader-3 .6s infinite
        }
        
        @keyframes datatables-loader-1 {
            0% {
                transform: scale(0)
            }
        
            100% {
                transform: scale(1)
            }
        }
        
        @keyframes datatables-loader-3 {
            0% {
                transform: scale(1)
            }
        
            100% {
                transform: scale(0)
            }
        }
        
        @keyframes datatables-loader-2 {
            0% {
                transform: translate(0, 0)
            }
        
            100% {
                transform: translate(24px, 0)
            }
        }
        div.dataTables_processing>div:last-child>div {
            position: absolute;
            top: 0;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: rgb(13, 110, 253);
            /*background: rgb(var(--dt-row-selected));*/
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }
    </style>
    <!--    css     -->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
</head>

<body class="loading"
      data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>
<div class="container-fluid">
    <!-- start page title -->
    <!-- <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                    <h5 class="m-0 text-dark text-uppercase">
                        Danh sách lịch gửi quảng cáo
                    </h5>
                <div class="page-title-right">
                </div>
            </div>
        </div>
    </div> -->

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="min-width: 100%;">
                <!-- <div class="card-header"> -->
                    
                <!-- </div> -->
                <div class="card-body">
                    <h5> <a href="<?php echo admin_url('admin.php?page=marketing-dashboard');?>">Dashboard</a> / <a href="<?php echo admin_url('admin.php?page=marketing-management');?>">Campaigns</a> / Calendar list</h5>
                    <div class="row" style="margin-bottom:10px; background-color: #F2F4F7; padding: 16px 0px; margin: 10px 0px;">
                        <div class="col-sm-12 col-md-6">
                            <div>
                                <a class="<?php if(!isset($_GET['status']))
                                                echo 'active-link';
                                            ?>" href="<?php echo admin_url('admin.php?page=marketing-calendar&m='.$id)  ?>"><span key="All">All</span> (<?php echo $count_schedulesending[0]->total_records; ?>)</a> | 
                                <a class="<?php if(isset($_GET['status']) && $_GET['status'] == 0)
                                                echo 'active-link';
                                            ?>" href="<?php echo admin_url('admin.php?page=marketing-calendar&m='.$id.'&status=0')  ?>"> <span key="unsent">unsent</span> (<?php echo $count_schedulesending[0]->count_status_0; ?>)</a> | 
                                <a class="<?php if(isset($_GET['status']) && $_GET['status'] == 4)
                                                echo 'active-link';
                                            ?>" href="<?php echo admin_url('admin.php?page=marketing-calendar&m='.$id.'&status=4')  ?>"><span key="cancelled">cancelled</span> (<?php echo $count_schedulesending[0]->count_status_4; ?>)</a> | 
                                <a class="<?php if(isset($_GET['status']) && $_GET['status'] == 1)
                                                echo 'active-link';
                                            ?>" href="<?php echo admin_url('admin.php?page=marketing-calendar&m='.$id.'&status=1')  ?>"><span key="sent">sent</span> (<?php echo $count_schedulesending[0]->count_status_1; ?>)</a> | 
                                <a class="<?php if(isset($_GET['status']) && $_GET['status'] == 5)
                                                echo 'active-link';
                                            ?>" href="<?php echo admin_url('admin.php?page=marketing-calendar&m='.$id.'&status=5')  ?>"> <span key="error">error</span>  (<?php echo $count_schedulesending[0]->count_status_5; ?>)</a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6" style="display: flex; justify-content:end; align-items:end;">
                            <form action="" id="form-action">
                                <select id="action" name="action" style="min-height: 40px;">
                                        <option value="1" key="send">Send</option>
                                        <option value="2" key="cancel">Cancel</option>
                                        <option value="3" key="Remove">Romove</option>
                                        
                                </select>
                                <button type="submit" class='btn btn-primary' key="Action">
                                    action
                                </button>
                            </form>
                        </div>
                    </div>
                    <table id="datatable" class="text-center table table-hover dt-responsive nowrap w-100">
                        <thead>
                        <tr class="text-center">
                            <th><input type="checkbox" name="choose" id="select-all">Choose</th>
                            <th key="code">Code</th>
                            <th key="Customer_name">Customer Name</th>
                            <th>Email</th>
                            <th key="Start_Date">Send date</th>
                            <th key="Send_Time">Send time</th>
                            <th key="Status">Status</th>
                            <th key="Action">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
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
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        $("#datatable").DataTable({-->
<!--            scrollCollapse: !0,-->
<!--            language: {-->
<!--                paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"},-->
<!--                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json',-->
<!--            },-->
<!--            pagingType: "full_numbers", drawCallback: function () {-->
<!--                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")-->
<!--            },-->
<!--        });-->
<!--    });-->
<!--</script>-->
<script>
    function confirmDelete($this) {
        let language = localStorage.getItem('lang')
        if (language == 'vi'){
            Swal.fire({
                title: "Bạn có chắc chắn muốn xóa?",
                text: "Thao tác này sẽ không thể khôi phục lại!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-confirm mt-2",
                cancelButtonClass: "btn btn-cancel ml-2 mt-2",
                confirmButtonText: "Vâng, tiếp tục xóa!",
                cancelButtonText: "Hủy",
            }).then(function(t) {
                if (t.value) {
                    console.log('huhu',$($this).data('href'))
                    window.location.href = $($this).data('href')
                }
            });
        } else {
            Swal.fire({
                title: "Are you sure you want to delete?",
                text: "This operation cannot be undone!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-confirm mt-2",
                cancelButtonClass: "btn btn-cancel ml-2 mt-2",
                confirmButtonText: "Yes, continue deleting!",
                cancelButtonText: "Cancel",
            }).then(function(t) {
                if (t.value) {
                    console.log('huhu',$($this).data('href'))
                    window.location.href = $($this).data('href')
                }
            });
        }

    }

    $(document).ready(function () {
        $('.menuitem-active').removeClass('right-bar-enabled');

        $(document).ready(function () {
            !function (p) {
                function t() {
                }

                t.prototype.send = function (t, i, o, e, n, a, s, r) {
                    var c = {
                        heading: t,
                        text: i,
                        position: o,
                        loaderBg: e,
                        icon: n,
                        hideAfter: a = a || 3e3,
                        stack: s = s || 1
                    };
                    r && (c.showHideTransition = r),
                        p.toast().reset("all"),
                        p.toast(c)
                },
                    p.NotificationApp = new t,
                    p.NotificationApp.Constructor = t
            }(window.jQuery),
                function (i) {
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo 'i.NotificationApp.send("Thất bại", "' . $_SESSION['error'] . '", "top-right", "#ffffff", "error", 3000, 1, "slide");';
                        unset($_SESSION['error']);
                    } elseif (isset($_SESSION['warning'])) {
                        echo 'i.NotificationApp.send("Cảnh báo", "' . $_SESSION['warning'] . '", "top-right", "#ffffff", "warning", 3000, 1, "slide");';
                        unset($_SESSION['warning']);
                    } elseif (isset($_SESSION['success'])) {
                        echo 'i.NotificationApp.send("Thành công", "' . $_SESSION['success'] . '", "top-right", "#ffffff", "success", 3000, 1, "slide");';
                        unset($_SESSION['success']);
                    }
                    ?>
                }(window.jQuery);

            $(".parsley-form input").on('change', function () {
                if ($('.parsley-form').parsley().isValid() === true) {
                    $('.parsley-form').find('button[type=submit]').prop('disabled', false);
                }
            })
        });
    });
</script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script>
    const checkall = document.getElementById('select-all');
    checkall.addEventListener('change',function(e){
        const checkbox = document.querySelectorAll('.check-schedule');
        // console.log(checkbox);
        checkbox.forEach(element => {
            // console.log(element);
            element.checked = e.target.checked
        });
    })
    function addQueryArgs(url, args) {
        var queryString = Object.keys(args)
            .map(function(key) {
                return key + "=" + encodeURIComponent(args[key]);
            })
            .join("&");

        if (url.indexOf("?") === -1) {
            return url + "?" + queryString;
        } else {
            return url + "&" + queryString;
        }
    }
    const formAction = document.getElementById('form-action');
    formAction.addEventListener('submit',function(e){
        e.preventDefault()
        const checkbox = document.querySelectorAll('.check-schedule');
        const ids = [];
        checkbox.forEach(function(checkbox) {
            if(checkbox.checked)
            ids.push(checkbox.value)
        })
        var payload = {
            ids: [ids],
        } 
        const action = document.getElementById('action')
        let customPageUrl =''
        if(action.value == 1)
        customPageUrl = "<?php echo admin_url('admin.php?page=send-calendar'); ?>";
        if(action.value == 2)
        customPageUrl = "<?php echo admin_url('admin.php?page=active-calendar'); ?>";
        if(action.value == 3)
        customPageUrl = "<?php echo admin_url('admin.php?page=delete-calendar'); ?>";

        customPageUrl = addQueryArgs(customPageUrl, payload);
        // Chuyển hướng đến trang tùy chỉnh với payload.
        window.location.href = customPageUrl;
    })

    
    $(document).ready(function () {
        const queryString = window.location.search;
        var datatable = $("#datatable").DataTable({
            pagingType: "full_numbers", drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            },
            language: {
                 processing:`<div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                            </div>`,
            },
            processing: true,
            serverSide: true,
            ajax:"../wp-json/calendar-api/v1/mtdata" + queryString,
            columns: [
                {data: 'Choose'},
                {data: 'PrimaryKey'},
                {data: 'last_name'},
                {data: 'email'},
                {data: 'SendDate', type: 'date'},
                {data: 'SendTime', type: 'date'},
                {data: 'Status'},
                {data: 'Active'},
            ],
            order:[4, 'asc'],
            columnDefs: [
                {
                    targets: 0,
                    data:null,
                    sortable: false,
                },
                {
                    targets: 2,
                    className: "text-left",
                },
                {
                    targets: -1,
                    data: null,
                    sortable: false,
                },
            ],
        });
        datatable.on('draw.dt',()=>{
            $("#datatable_first a").eq(0).text('First');
            $('#datatable_previous a').eq(0).text('Prev');
            $('#datatable_next a').eq(0).text('Next');
            $("#datatable_last a").eq(0).text('Last');
           
        })
        $('.dataTables_filter input').unbind().bind('keyup', function(event) {
         
            if (event.type === 'keyup' && (event.which == 13 || event.keyCode == 13) || (event.which == 32 || event.keyCode == 32)) {
                // Người dùng ấn phím "Enter" trên desktop
                event.preventDefault(); // Ngăn chặn sự kiện mặc định của phím "Enter"
                datatable.search($(this).val()).draw();
            } else if (event.type === 'keyup') {
                // Sự kiện "input" xảy ra trên thiết bị di động khi bạn bấm nút tìm kiếm
                if(event.target.value == ''){
                    datatable.search($(this).val()).draw();
                    console.log("rỗng");
                }
            }
            
        })
    });
</script>
</body>
</html>
