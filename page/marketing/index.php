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
                     <h5><a href="<?php echo admin_url('admin.php?page=marketing-dashboard') ?>">Dashboard</a> / Campaigns</h5>
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<!-- App js -->
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/app.min.js"></script>

<script>
</script>

<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
</body>
</html>