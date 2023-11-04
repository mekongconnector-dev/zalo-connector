        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.4.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
         <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
         
        <style>
        .dataTables_wrapper .dataTables_length select{
            padding-right: 20px;
        }
        .custom-icon {
            font-size: 24px; /* Tăng kích thước */
            color: gray; /* Đổi thành màu đen */
        }
        #custom-breadcrumb {
            padding: 10px; /* Khoảng cách giữa các breadcrumb items */
            border-radius: 5px; /* Đường viền bo tròn */
            font-family: Arial, sans-serif; /* Font chữ */
        }
        
        #custom-breadcrumb .breadcrumb-item {
            font-size: 18px; /* Kích thước font chữ của các breadcrumb items */
        }
        
        #custom-breadcrumb .breadcrumb-item a {
            color: #007bff; /* Màu của các liên kết */
        }
        
        #custom-breadcrumb .breadcrumb-item.active {
            color: #333; /* Màu của breadcrumb item hiện tại */
        }

        </style>
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
    td{
        vertical-align: middle;
    }
</style>
    
        <div class="wrap">              
                <div class="d-flex justify-content-between align-items-center"  style="max-width:100%; background-color: #F2F4F7; padding: 15px; margin-top:15px;margin-bottom:15px;">
                    <?php $link_dashboard=admin_url("admin.php?page=main-menu"); ?>
                     <h5><a href="<?php echo $link_dashboard; ?>" style="text-decoration: none;">Dashboard</a>  / Tags</h5>
                    <div class="d-flex justify-content-end align-items-center">
                    </div>
                </div>
                <hr>
                
        </div>
        <div id="zalo-connector-up-to-pro-version">
        </div>
        <!-- Modal thêm tag -->
        
        <!-- Modal edit -->
        

        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script> 
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> 
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.js"></script>
    
        