
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .dashboard{
            background-color: #eeeff5;
            padding: 20px 40px;
            @media (max-width: 450px) {
                padding: 0px;
            }
        }
        .content-left{
            padding: 0px 40px;
            @media (max-width: 576px) {
                padding: 0px 20px !important;
            }
        }
        .title-page{
            font-size: 20px;
            font-weight: 500;
            text-overflow: ellipsis;
            overflow: hidden;
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
            @media (max-width: 576px){
                padding: 0px; !important;
            }
            @media (min-width: 1200px) and (max-width: 1400px){
                padding: 0px; !important;
            }
        }
        .statistical{
            /* gap: 30px; */
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
        }
        .statistical-item{
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 30%;
            aspect-ratio: 2/3;
            padding: 50px 10px;
            border-radius: 10px;
            @media (max-width: 576px;){
                padding: 30px 10px !important;
            }
            @media (min-width: 1200px) and (max-width: 1400px){
                padding: 30px 10px !important;
            }
        }
        .statistical-item-box{
            color: white;
            font-weight: 500;
            font-size: 14px;
        }
        .statistical-item-icon{
            background-color: rgba(24, 74, 155, 0.8);
            padding: 15px;
            font-size: 25px;
        }
        .chart-top-left{
            background-color: white;
            padding: 5px 10px;
            border-radius: 10px;
            box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.08);
        }
        .chart-content{
            display: flex;
            justify-content: center;
            align-items: center;
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
        .content-right{
            width: 48%;
            @media(max-width: 1200px){
                width: calc(100% - 56px);
                margin: 20px 40px;
            }
            @media(min-width: 577px) and (max-width: 1200px){
                width: calc(100% - 56px);
                margin: 20px 40px;
            }
            @media(max-width: 576px){
                width: calc(100%);
                margin: 20px 0px;
            }
        }
        .marketing-item{
            width: 100%;
            height: 120px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            background-color: #F5F7FB;
        }
       
        /*.marketing_processing::-webkit-scrollbar {*/
        /*    display: none;*/
        /*}*/
        .list-item{
            display: flex; 
            flex-direction: column; 
            gap: 16px;
        }
        .titletab{
            @media (max-width: 777px){
                font-size: 14px !important;
            }
        }
        .qc{
            @media (max-width: 777px){
                display: none !important;
            }
            
        }
        .top-dashboard{
            @media (max-width: 576px){
                flex-direction: column !important;
            }
            @media (min-width: 1200px) and (max-width: 1400px){
                flex-direction: column !important;
            }
            
        }
        .marketing_processing{
            @media (max-width: 1400px){
                max-height: 700px !important;
            }
        }
        .marketing_upcoming{
            @media (max-width: 1400px){
                max-height: 700px !important;
            }
        }
        .sizeIMG{
            width: 100%;
            height: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="dashboard ">
        <div class="content row">
            <div class="content-left col-xl-6 col-12">
                <div class="top-dashboard d-flex flex-row justify-content-between">
                    <div class="top-dashboard-left d-flex flex-row gap-2 align-middle p-2">
                        <!-- <img src="./mdi_blog.svg" alt="">/ -->
                        <!--<select id="selectOption">-->
                        <!--    <option value="<?php echo admin_url();?>admin.php?page=main-menu">ZALO KHÁCH HÀNG</option>-->
                        <!--    <option value="<?php echo admin_url();?>admin.php?page=marketing-dashboard" selected>CHIẾN DỊCH QUẢNG CÁO</option>-->
                        <!--    <option value="<?php echo admin_url();?>admin.php?page=article-dashboard">BÀI VIẾT</option>-->
                        <!--</select>-->
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                            <label class="btn btn-outline-primary titletab" for="btnradio1">Zalo</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked>
                            <label class="btn btn-outline-primary titletab" for="btnradio2" key="advertisement">Quảng cáo</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label class="btn btn-outline-primary titletab" for="btnradio3" key="article">Bài viết</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                            <label class="btn btn-outline-primary titletab" for="btnradio4" key="zns">ZNS</label>                            
                        </div>
                        <!--<span class="title-page">Quảng Cáo-->
                        </span>
                        <div class="more-info d-flex qc">
                            <i class="fa-solid fa-question"></i>
                        </div>
                    </div>
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