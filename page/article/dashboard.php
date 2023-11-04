<?php 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    <style>
        .dashboard{
            background-color: #eeeff5;
            /* height: 100vh; */
            padding: 20px 40px;
            @media (max-width: 576px) {
                padding: 0px 10px;
                height: 100%;
            }
        }
        .content{
            @media (min-width: 851px) and (max-width: 1200px){
                flex-direction: column !important;
                gap: 10px
            }
        }
        .content-left{
            padding: 0px 40px;
            @media (max-width: 850px) {
                padding: 0px;
            }
            @media (min-width: 850px) and (max-width: 1200px) {
                padding: 0px;
                width: 100%;
            }
            /*@media (min-width: 851px) and (max-width: 990px){*/
            /*    padding: 0px !important;*/
            /*}*/
        }
        .content-right{
            @media (max-width: 1200px) {
                margin-top: 20px;
                width: 100%;
            }
        }
        .title-page{
            font-size: 20px;
            font-weight: 500;
        }
        .more-info{
            background-color: white;
            border-radius: 100%;
            padding: 0px 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        .top-dashboard-right{
            font-size: 14px;
            font-weight: 500;
            background-color: white;
            border-radius: 10px;
            padding: 0px 10px;
            display: flex;
            align-items: center;
        }
        .statistical{
            gap: 30px;
            justify-content: space-between;
            flex-wrap: nowrap;
            @media (max-width: 576px) {
                flex-wrap: wrap;
                margin: 0px 20px;
                gap: 30px;
            }
            @media (min-width: 577px) and (max-width: 1300px) {
                gap: 10px !important;
            }
        }
        .statistical-item{
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 22%;
            padding: 50px 10px;
            border-radius: 10px;
            min-height: 250px;
            @media (max-width: 576px) {
                width: 45%;
            }
            @media (max-width: 1300px){
                padding: 50px 10px;
            }
        }
        .article{
            @media (max-width: 1300px) {
                padding: 10px !important;
            }
        }
        .top-article{
            @media (max-width: 576px) {
                flex-direction: column !important;
            };
            /*@media (max-width: 1300px) {*/
            /*    flex-direction: column !important;*/
            /*}*/
        }
        .top-article-right{
            @media (max-width: 1300px) {
                /*padding: 0px !important;*/
                flex-wrap: wrap !important;
            }
        }
        .statistical-item-box{
            color: white;
            font-weight: 500;
            font-size: 14px;
        }
        .statistical-item-icon{
            background-color: rgba(24, 74, 155, 0.8);
            padding: 9px;
        }
        .chart-top{
            flex-wrap: wrap;
            @media (max-width: 576px) {
                flex-direction: column !important;
            }
        }
        .chart-top-left{
            /* background-color: white; */
            padding: 5px 10px;
            border-radius: 10px;
            @media (max-width: 576px) {
                padding-left: 0px !important;
            }
            @media (max-width: 1100px) {
                padding: 5px 0px !important;
            }
            /* box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.08); */
        }
        .chart-content{
            display: flex;
            justify-content: center;
            align-items: center;
            @media (max-width: 576px) {
                padding: 0px !important;
            }
        }
        .chart-item{
            width: 80%;
            height: 50%;
        }
        .article-item{
            width: 100%;
        }
        .list-article-stt{
            font-size: 16px;   
            display: flex;
            align-items: center;
        }
        .list-article-stt-item{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 25px;
            height: 25px;
        }
        .article{
            @media(max-width: 576px) {
                padding: 0px !important;
            }
        }
        .custom-tooltip {
        --bs-tooltip-bg: var(--bs-primary);
        --bs-tooltip-color: var(--bs-white);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="content row">
            <div class="content-left col-lg-8">
                <div class="top-dashboard d-flex flex-row justify-content-between">
                    <div class="top-dashboard-left d-flex flex-row gap-2 align-middle p-2">
                        <!-- <img src="../assets/mdi_blog.svg" alt=""> -->
                        <!--<select id="selectOption">-->
                        <!--    <option value="<?php echo admin_url();?>admin.php?page=main-menu">ZALO KHÁCH HÀNG</option>-->
                        <!--    <option value="<?php echo admin_url();?>admin.php?page=marketing-dashboard">CHIẾN DỊCH QUẢNG CÁO</option>-->
                        <!--    <option value="<?php echo admin_url();?>admin.php?page=article-dashboard" selected>BÀI VIẾT</option>-->
                        <!--</select>-->
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio1">Zalo</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2" key="advertisement">Quảng cáo</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio3" key="article">Bài viết</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio4" key="zns">ZNS</label>
                        </div>
                        <!--<span class="title-page">BÀI VIẾT</span>-->
                        <div class="more-info d-flex fw-medium rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Dashboard Quản lý bài viết">
                            
                            <span class="p-1 rounded-circle">
                                <i class="fa-solid fa-question"></i>
                                </span>
                        </div>
                    </div>
                    <!--<div class="top-dashboard-right">-->
                    <!--    <div class="top-dashboard-right d-flex flex-row gap-1">-->
                    <!--        <span>All</span>-->
                    <!--        <i class="fa-solid fa-chevron-down"></i>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                
            </div>
        </div>
    </div>
    <div id="zalo-connector-up-to-pro-version">
    </div>
</body>
<script>
    // Lắng nghe sự kiện click trên các nút radio
    document.getElementById("btnradio1").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=main-menu";
    });

    document.getElementById("btnradio2").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=marketing-dashboard";
    });

    document.getElementById("btnradio3").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=article-dashboard";
    });
    
    document.getElementById("btnradio4").addEventListener("click", function() {
        // Chuyển hướng đến liên kết tương ứng
        window.location.href = "<?php echo admin_url();?>admin.php?page=zns-dashboard";
    });
</script>
</html>