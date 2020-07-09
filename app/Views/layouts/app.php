<?php $project_name = env('project_name')??get_settings('project_name');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?=ucfirst($title)?> | <?=ucfirst($project_name)?></title>
    <!-- BEGIN GLOBAL MANDATORY STY LES -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link href="<?=base_url("bootstrap/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url("assets/css/plugins.css")?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url("summernote/summernote-bs4.css")?>">
    <script src="<?=base_url("assets/js/vue.min.js")?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url("DataTables/datatables.min.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("plugins/select2/select2.min.css")?>">
    <script src="<?=base_url("assets/js/libs/jquery-3.1.1.min.js")?>"></script>
    <script src="<?=base_url("summernote/summernote-bs4.min.js")?>"></script>
    <style>
        *{
			font-family:
			<?php
            switch (get_settings("site_font")) {
                case 'Pack-1':
                   echo "cursive";
                    break;
                case 'Pack-2':
                   echo "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
                    break;
                case 'Pack-3':
                    echo "'Courier New', Courier, monospace";
                    break;
                case 'Pack-4':
                    echo "'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif";
                    break;
                case 'Pack-5':
                    echo "Georgia, 'Times New Roman', Times, serif";
                    break;
                case 'Pack-6':
                    echo "Verdana, Geneva, Tahoma, sans-serif";
                    break;
                default:
                    echo "Arial, Helvetica, sans-serif";
                    break;
            }
            ?>
		}

        .processing{
            width:100%;
            height:100%;
            position: fixed;
            background-color: rgba(0,0,0,0.5);
            z-index:10000000;
            display:flex;
            align-items: center;
            justify-content: center;
            overflow:hidden;
            font-size: 5rem;
            color:white
        }
         .done{
            display:none
         }
    </style>
    <script>
        window.onbeforeunload = ()=>{
            document.querySelector("#loader_backdrop").classList.replace("done","processing")
        }
        document.addEventListener('readystatechange',()=>{
            if(document.readyState != "complete"){
                document.querySelector("#loader_backdrop").classList.replace("done","processing")
            }else{
                document.querySelector("#loader_backdrop").classList.replace("processing","done")
            }
        })
    </script>
    <script>
    $(document).ready(()=>{
        if(window.location.hash){
            hash = window.location.hash;
            elements = $('a[href="'+hash+'"]');
            if(elements.length === 0){
                $("ul.tabs li:first").addClass("active").show();
                $(".tab-pane:first").show();
            }
            else{elements.click();}
        }
        
    });
</script>
</head>
<body class="default-sidebar">
    <div class="processing" id="loader_backdrop">
        <i class="flaticon-spinner-of-dots spin"></i>
    </div>
    <div style="position:fixed;min-height:200px;z-index:100000;top:0;right:0">
        <?= session('notification')??""?>
    </div>

    <!-- Tab Mobile View Header -->
    <header class="tabMobileView header navbar fixed-top d-lg-none">
        <div class="nav-toggle">
            <a href="javascript:void(0);" class="nav-link sidebarCollapse" data-placement="bottom">
                <i class="flaticon-menu-line-2"></i>
            </a>
            <a href="" class="h2 text-lowercase" style="font-variant: small-caps;"><i class="flaticon-settings-3"></i> <?=$project_name?>  </a>
        </div>
    </header>
    
    <!-- Tab Mobile View Header -->

    <!--  BEGIN NAVBAR  -->
    <header class="header navbar fixed-top navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse d-none d-lg-block" data-placement="bottom"><i class="flaticon-menu-line-2"></i></a>
        <!-- <ul class="navbar-nav flex-row ml-auto">


            <li class="nav-item dropdown app-dropdown  mr-4">
            </li>


            <li class="nav-item dropdown user-profile-dropdown mr-5 mr-lg-0 order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="flaticon-user-12"></span>
                </a>
                <div class="dropdown-menu  position-absolute" aria-labelledby="userProfileDropdown">
                    <a class="dropdown-item" href="">
                        <i class="mr-1 flaticon-user-6"></i> <span>My Profile</span>
                    </a>
                    <a class="dropdown-item" href="">
                        <i class="mr-1 flaticon-calendar-bold"></i> <span>My Schedule</span>
                    </a>
                    <a class="dropdown-item" href="">
                        <i class="mr-1 flaticon-email-fill-1"></i> <span>My Inbox</span>
                    </a>
                    <a class="dropdown-item" href="">
                        <i class="mr-1 flaticon-lock-2"></i> <span>Lock Screen</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="">
                        <i class="mr-1 flaticon-power-button"></i> <span>Log Out</span>
                    </a>
                </div>
            </li>
        </ul> -->
    </header>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>

        <!--  BEGIN SIDEBAR  -->

        <div class="sidebar-wrapper sidebar-theme">
            
            <div id="dismiss" class="d-lg-none"><i class="flaticon-cancel-12"></i></div>
            
            <nav id="sidebar">

                <ul class="navbar-nav theme-brand flex-row  d-none d-lg-flex">
                    <li class="nav-item d-none ">
                        <a href="" class="navbar-brand" style="font-variant: small-caps;">
                            <i class="flaticon-settings-3"></i> <?=$project_name?>
                        </a>
                        <p class="border-underline"></p>
                    </li>
                    <li class="nav-item theme-text">
                        <a href="" class="nav-link text-lowercase" style="font-variant: small-caps;"><i class="flaticon-settings-3"></i> <?=$project_name?> </a>
                    </li>
                </ul>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li></li>
                    <li class="menu">
                        <a href="#scrapper" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="flaticon-globe"></i>
                                <span>Web Scrapper</span>
                            </div>
                            <div>
                                <i class="flaticon-right-arrow"></i>
                            </div>
                        </a>
                        <ul class="submenu list-unstyled" id="scrapper" data-parent="#accordionExample">
                            <li class="<?=$title == "Nairaland"?"active":""?>">
                                <a href="<?=base_url("scrapper/nairaland")?>"> Nairaland </a>
                             </li>
                            
                        </ul>
                    </li>
                    <li class="menu">
                        <a href="#sms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="flaticon-mailbox"></i>
                                <span>Bulk Sender</span>
                            </div>
                            <div>
                                <i class="flaticon-right-arrow"></i>
                            </div>
                        </a>
                        <ul class="  submenu list-unstyled" id="sms" data-parent="#accordionExample">
                            <li class="<?=$title == "compose"?"active":""?>">
                                <a href="<?=base_url("bulk")?>"> Compose </a>
                             </li>
                            <li class="<?=$title=="Draft"?"active":""?>">
                                <a href="<?=base_url("bulk/draft")?>"> Draft </a>
                            </li>
                            <li class="<?=$title=="History"?"active":""?>">
                                <a href="<?=base_url("bulk/history")?>"> Message History </a>
                            </li>
                            <li class="<?=$title=="Group"?"active":""?>">
                                <a href="<?=base_url("bulk/group")?>"> Group </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu <?=$title=="Settings"?"active":""?>">
                        <a href="<?=base_url("bulk/settings")?>" class="dropdown-toggle ">
                            <div class="">
                                <i class="flaticon-settings-7"></i>
                                <span>Settings</span>
                            </div>
                            <div>
                                <i class="flaticon-right-arrow"></i>
                            </div>
                        </a>
                    </li>
                    <li class="menu <?=$title=="Settings"?"active":""?>">
                        <a href="<?= base_url('logout')?>" onclick='return confirm("Are you sure you want to logout?")' class="dropdown-toggle ">
                            <div class="">
                                <i class="flaticon-logout"></i>
                                <span>Logout</span>
                            </div>
                            <div>
                                <i class="flaticon-right-arrow"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="container">
                <div class="page-header pb-0">
                    <div class="page-title mb-0 mt-n3 mt-md-3">
                        <h3 class="text-capitalize"><?=$title?></h3>
                        <div class="crumbs">
                            <ul id="breadcrumbs" class="breadcrumb mb-0">
                                <li><a href=""><i class="flaticon-home-fill"></i></a></li>
                                <?php foreach (explode("/", uri_string()) as $key):?>
                                    <li><a href="#"><?=$key?></a></li>
                                <?php endforeach?>
                            </ul>
                        </div>
                    </div>
                </div>


                <!-- CONTENT AREA -->
                 <?=$this->renderSection("content")?>
                 

                <!-- CONTENT AREA -->

            </div>
        </div>
        <!--  END CONTENT PART  -->
    </div>
    
    <!-- END MAIN CONTAINER -->

    <!--  BEGIN FOOTER  -->
    <footer class="footer-section theme-footer">

        <div class="footer-section-1  sidebar-theme">
            
        </div>

        <div class="footer-section-2 container-fluid">
            <div class="row">
                <div class="col-xl-5 col-md-6 col-sm-6 col-12">
                    <ul class="list-inline mb-0 d-flex justify-content-sm-end justify-content-center mr-sm-3 ml-sm-0 mx-3">
                        <li class="list-inline-item  mr-3">
                            <p class="bottom-footer">&#xA9; <?=date("Y")?> <a target="_blank" href="#">Ajecrypto</a></p>
                        </li>
                        <li class="list-inline-item align-self-center">
                            <div class="scrollTop"><i class="flaticon-up-arrow-fill-1"></i></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--  END FOOTER  -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

    <script src="<?=base_url("bootstrap/js/popper.min.js")?>"></script>
    <script src="<?=base_url("bootstrap/js/bootstrap.min.js")?>"></script>
    <script src="<?=base_url("plugins/scrollbar/jquery.mCustomScrollbar.concat.min.js")?>"></script>
    <script src="<?=base_url("assets/js/app.js")?>"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="<?=base_url("assets/js/custom.js")?>"></script>
    <script src="<?=base_url("DataTables/datatables.min.js")?>"></script>
    <script src="<?=base_url("plugins/select2/select2.min.js")?>"></script>
    
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script>
        $('.toast').toast("show");
        checkAll = (e)=>{
            let state = e.target.checked;
            let nodes = document.querySelectorAll("td input[type='checkbox']");
            for(let i of nodes){i.checked = state;}
        }
        $('table').DataTable({
            "language": {
                "paginate": { "previous": "<i class='flaticon-arrow-left-1'></i>", "next": "<i class='flaticon-arrow-right'></i>" },
            },
            select:true,
            dom:"Bfrtip",
            buttons:['csv','print']
        });
        $('.textarea').summernote({
           maxHeight:200
       });

        
    </script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>