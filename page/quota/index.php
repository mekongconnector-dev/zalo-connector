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
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>-->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css">-->
    <!--<link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/dropify/sass/dropify.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .dataTables_scrollBody {
            min-height: 150px;
        }
        .pointer {
            cursor: pointer;
        }
        .card{
            width: 100%;
            min-width: 100%;
        }
        .card-body {
            width: 100%;
        }
        .dataTables_processing {
            min-width: unset;
        }
        #calendar{
            position: relative;
        }
        #calendar .tooltiptext{
            visibility: hidden;
            width: 60px;
            height: 20px;
            font-size: 12px;
            background-color: black;
            color: #fff;
            text-align: center;
            /* padding: 5px 0; */
            border-radius: 6px;
            z-index: 1;
            left: -19px;
            top: 30px;
            /* top: -100px; */
            /* Position the tooltip text - see examples below! */
            position: absolute;
        }
        #calendar:hover .tooltiptext{
            visibility: visible;
        }
        #detail{
            position: relative;
        }
        #detail .tooltiptext{
            visibility: hidden;
            width: 60px;
            height: 20px;
            font-size: 12px;
            background-color: black;
            color: #fff;
            text-align: center;
            /* padding: 5px 0; */
            border-radius: 6px;
            z-index: 1;
            left: -15px;
            top: 30px;
            /* top: -100px; */
            /* Position the tooltip text - see examples below! */
            position: absolute;
        }
        #detail:hover .tooltiptext{
            visibility: visible;
        }
        #edit{
            position: relative;
        }
        #edit .tooltiptext{
            visibility: hidden;
            width: 60px;
            height: 20px;
            font-size: 12px;
            background-color: black;
            color: #fff;
            text-align: center;
            /* padding: 5px 0; */
            border-radius: 6px;
            z-index: 1;
            left: -15px;
            top: 30px;
            /* top: -100px; */
            /* Position the tooltip text - see examples below! */
            position: absolute;
        }
        #edit:hover .tooltiptext{
            visibility: visible;
        }
        #delete{
            position: relative;
        }
        #delete .tooltiptext{
            visibility: hidden;
            width: 60px;
            height: 20px;
            font-size: 12px;
            background-color: black;
            color: #fff;
            text-align: center;
            /* padding: 5px 0; */
            border-radius: 6px;
            z-index: 1;
            left: -15px;
            top: 30px;
            /* top: -100px; */
            /* Position the tooltip text - see examples below! */
            position: absolute;
        }
        #delete:hover .tooltiptext{
            visibility: visible;
        }
        .title-right{
            display: flex;
            justify-content: end;
            align-items: end;
        }
        .active-link{
            font-weight: bold;
        }
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
        .dot.dot-error{
            background-color: red;
        }
        .dropdown{
            display:flex;
            justify-content:center;
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
        .dataTables_processing.card{
            padding:0px !important;
        }
        .card-header{
            background-color: white;
        }
        .active-link{
            font-weight: bold;
        }
        .action_view{
            border: 1px solid #99a5b5;
            border-radius: 4px;
            width: 24px;
            display:flex;
            align-items: center;
            justify-content: center;
        }
        .text-center{
            text-align:center;
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
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    
</head>

<body class="loading"
      data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>
<div class="container-fluid">
<!-- start page title -->
    <!-- <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h5 class="m-0 text-dark">
                    Chiến dịch quảng cáo
                </h5>
                <div class="page-title-right">
                <a class="btn btn-sm btn-primary float-right" href="<?php echo admin_url('admin.php?page=marketing-create'); ?>">
                    <i class="fe-plus-square mr-1"></i>tọa chiến dịch mới
                </a>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="z-index: 0;">
                <div class="card-body" >
                     <h5><a href="<?php echo admin_url('admin.php?page=marketing-dashboard') ?>">Dashboard</a> / Quotation</h5>
                    <div class="row" style="margin-bottom: 10px; background-color: #F2F4F7; padding:16px 0px; margin: 10px 0px;">
                        
                    </div>
                    
                </div>
                <div id="zalo-connector-up-to-pro-version">
                </div>
            </div>
        </div>
    </div>
    
    </div>
<!-- end page title -->
</div>




<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/vendor.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/select2/js/select2.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/jquery-toast-plugin/jquery.toast.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/selectize/js/standalone/selectize.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/dropify/js/dropify.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>-->

<!-- App js -->
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/app.min.js"></script>

<script>
        $(document).ready(function () {          
            const total_records = <?php 
            if(!isset($_GET['status'])) 
                echo $count_marketing[0]->total_records;
            if(isset($_GET['status']) &&  $_GET['status'] == 1)
                echo $count_marketing[0]->count_status_1;
            if(isset($_GET['status']) &&  $_GET['status'] == 0)
                echo $count_marketing[0]->count_status_0;
            ?>;
            
            const queryString = window.location.search;
            console.log(queryString);
            var dataTable = $("#datatable").DataTable({
                language: {
                    processing:`<div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                </div>`,
                },
                pagingType: "full_numbers", drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                },
                processing: true,
                serverSide: true,
                ajax: "../wp-json/zalo-management/v1/get-quota-data" + queryString,
                columns: [
                    {data: 'id'},
                    {data: 'quotationName'},
                    {data: 'creationDate', type: 'date'},
                    {data: 'Status'},
                    {data: 'Active'},
                ],
                order:[0, 'desc'],
                columnDefs: [
                    {
                        targets: 1,
                        className: "text-left",
                    },
                    {
                        targets: 3,
                        className: "text-center",
                        sortable: false,
                    },
                    {
                        targets: 4,
                        className: "text-center",
                        sortable: false,
                    },
        
                ],
            });
            dataTable.on('draw.dt',()=>{
                
                $("#datatable_first a").eq(0).text('First');
                $('#datatable_previous a').eq(0).text('Prev');
                $('#datatable_next a').eq(0).text('Next');
                $("#datatable_last a").eq(0).text('Last');
                // $('#datatable_filter label').eq(0).html('Search: <input type="search" class="form-control form-control-sm" placeholder="Nhập tìm kiếm..." aria-controls="datatable">')
                // $('#datatable_length label').eq(0).html('Show <select name="datatable_length" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> data')
            })
            
             // $('#datatable_length label').eq(0).html('Show <select name="datatable_length" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> data')
            $('.dataTables_filter input').unbind().bind('keyup', function(event) {
            if (event.type === 'keyup' && (event.which == 13 || event.keyCode == 13) || (event.which == 32 || event.keyCode == 32)) {
                // Người dùng ấn phím "Enter" trên desktop
                event.preventDefault(); // Ngăn chặn sự kiện mặc định của phím "Enter"
                dataTable.search($(this).val()).draw();
            } else if (event.type === 'keyup') {
                // Sự kiện "input" xảy ra trên thiết bị di động khi bạn bấm nút tìm kiếm
                if(event.target.value == ''){
                    dataTable.search($(this).val()).draw();
                    console.log("rỗng");
                }
            }
            
        })
        });
        
      
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
            }).then(function (t) {
                if (t.value) {
                    window.location.href = $($this).data('href')
                }
            });
        }else {
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
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
</body>
</html>