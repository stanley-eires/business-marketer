<?=$this->extend("layouts/app2")?>
<?=$this->section("content")?>
    <link href="<?=base_url("assets/css/login.css")?>" rel="stylesheet" type="text/css" />
    <?=form_open("login",["class"=>"form-login"])?>
        <div class="row">
            
            <div class="col-md-12 text-center mb-4">
                <a href="" class="h2 text-lowercase text-white" style="font-variant: small-caps;"><i class="flaticon-settings-3"></i> <?=env('project_name')??get_settings('project_name')?> </a>
            </div>

            <div class="col-md-12">

                <label for="inputEmail" class="sr-only">Email address</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="icon-inputEmail"><i class="flaticon-user-7"></i> </span>
                    </div>
                    <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" minlength="3"  required value="<?=old("username")?>">
                </div>

                <label for="inputPassword" class="sr-only">Password</label>                
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="icon-inputPassword"><i class="flaticon-key-2"></i> </span>
                    </div>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" minlength="6" required >
                </div>

                <button class="btn btn-lg btn-gradient-warning btn-block btn-rounded mb-4 mt-5" type="submit">Login</button>

                <div class="forgot-pass text-center">
                    <a href="#">Private Use Only</a>
                </div>

            </div>

        </div>
    </form>   
<?=$this->endSection()?>

