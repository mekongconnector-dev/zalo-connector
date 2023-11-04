<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Jquery Toast css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css"/>

    <!-- Sweet Alert-->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

    <!-- Plugins css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css">
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/dropify/sass/dropify.css" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet"/>

    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet"/>

    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"/>

    <!-- Custom theme -->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/scss/theme-custom.css" rel="stylesheet" type="text/css"/>

    <!-- icons -->
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>

    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/vendor.min.js"></script>

    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/js/app.min.js"></script>



    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>    
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css"/>    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        /*.dataTables_filter {*/
        /*    display: none;*/
        /*}*/
        .card{
            @media (max-width: 1024px) {
                margin-top: 0px;
            }
        }
        .card-body{
            @media (max-width: 1024px) {
                padding: 0px;
            }
        }
        #limit-text {
            white-space: nowrap;         
            overflow: hidden;            
            text-overflow: ellipsis;     
            max-width: 200px;            
        }
        .dropdown-toggle::after{ 
            content:unset; 
        }
        .action_view {            
            border: 1px solid #99a5b5;
            border-radius: 4px;            
            width: 24px;
            display:flex;            
            align-items: center;
            justify-content: center;        
        }
        tr.odd {
          background-color: rgb(242, 242, 242) !important;
        }
       tr.odd td{
          background-color: rgb(242, 242, 242) !important;
        }
        
        div.dataTables_processing>div:last-child {
            position: relative;
            width: 60px;
            height: 10px;
            margin: 0.25em auto;
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
        .text-add{
            @media(max-width: 576px){
                display: none;
            }
        }
    </style>
</head>
<body> 
    <div class="row article">
        <div class="col-12">
            <div class="card card-custom" style="min-width: 99%">
                <div class="card-body" style="min-width: 99%">
                    <div class="table-responsive">
                        <div style="background-color: white; max-width: 100%; height: auto;" class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex flex-column align-items-start w-100">
                                <div class="d-flex flex-column justify-content-between w-100">
                                    <div class="d-flex flex-row py-2">
                                        <h5 style="font-size: 1.25rem !important;"><a href="<?php echo admin_url('admin.php?page=article-dashboard')?>">Dashboard</a></h5>
                                        <h5 class="px-2" style="font-size: 1.25rem !important">/</h5>
                                        <h5 style="font-size: 1.25rem !important" key="article_management">Quản lí bài viết</h5>
                                    </div>
                                   
                                </div>
                                
                                <div class="sort mt-1 d-flex align-items-center justify-content-between w-100 py-2 px-3" style="background-color: #F5F6F8">
                                   
                                </div>
                            </div>
                        </div>
                        <div id="zalo-connector-up-to-pro-version">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="https://zalo-connect.s3.ap-southeast-1.amazonaws.com/assets/libs/dropify/js/dropify.js"></script>
</html>
