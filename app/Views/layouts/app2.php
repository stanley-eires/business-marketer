<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?=ucfirst($title)?> </title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link href="<?=base_url("bootstrap/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url("assets/css/plugins.css")?>" rel="stylesheet" type="text/css" />
    <script src="<?=base_url("assets/js/libs/jquery-3.1.1.min.js")?>"></script>

    <style>
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
</head>
<body>
    <div class="processing" id="loader_backdrop">
        <i class="flaticon-spinner-of-dots spin"></i>
    </div>
    <div style="position:fixed;min-height:200px;z-index:100000;top:0;right:0">
        <?= session('notification')??""?>
    </div>

     <?=$this->renderSection("content")?>
             <script src="<?=base_url("bootstrap/js/popper.min.js")?>"></script>
    <script src="<?=base_url("bootstrap/js/bootstrap.min.js")?>"></script>
    <script>$('.toast').toast("show");</script>
</body>
</html>