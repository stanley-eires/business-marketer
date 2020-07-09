<?=$this->extend("layouts/app")?>
<?=$this->section("content")?>
<link href="<?=base_url("assets/css/design-css/design.css")?>" rel="stylesheet">
<link href="<?=base_url("plugins/treeview/default/style.min.css")?>" rel="stylesheet">
<link href="<?=base_url("assets/css/ui-kit/custom-tree_view.css")?>" rel="stylesheet" type="text/css" />
<div class="row ">
     <div class="col-md-10 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area animated-underline-content">
                <ul class="nav nav-tabs justify-content-md-start justify-content-center mb-3" id="animateLine" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="animated-underline-sms-tab" data-toggle="tab" href="#animated-underline-sms" role="tab"><i class="flaticon-telephone"></i> PHONE GROUP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="animated-underline-email-tab" data-toggle="tab" href="#animated-underline-email" role="tab"><i class="flaticon-email-fill-2"></i> EMAIL GROUP</a>
                    </li>
                </ul>

                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="animated-underline-sms" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if (isset($edit)):?>
                                <?=form_open("bulk/group", ['class'=>"form-row"])?>
                                    <input type="hidden" name="id" value="<?=$edit->id?>">
                                    <div class="form-group col-md-12 clearfix">
                                        <a href="<?=base_url('bulk/group')?>" class="btn btn-secondary btn-rounded btn-sm float-right"><i class='flaticon-plus'></i> New Entry</a>
                                    </div>
                                    <input type="hidden" name="_method" value="PUT" />
                                    <input type="hidden" name="id" value="<?=$edit->id?>" />
                                    <div class="form-group col-md-12">
                                        <label>Group Name</label>
                                        <input name="name" type="text" class="basic form-control <?= session('errors.title')?"is-invalid":""?>" maxlength="25" minlength="5" value="<?=$edit->name?>" >
                                        <code class="invalid-feedback"><?= session('errors.name') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label >Recipients</label>
                                        <select class="form-control tagging2" multiple="multiple" name="numbers[]" required ></select>
                                    
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Update <i class="flaticon-folder"></i></button>
                                        
                                    </div>
                                    <script>
                                        $(document).ready(()=>{
                                            <?php $a = "["; foreach (unserialize($edit->numbers) as $key) {
                                                $a .= "'$key',";
                                            }$a .= "]";?>
                                            let a = <?=$a?>;
                                            let data = [];
                                            a.forEach((num,index)=>{
                                                data.push({
                                                    id: num,
                                                    text:num,
                                                    selected:true
                                                })
                                            })
                                            $(".tagging2").select2({
                                                tags: true,
                                                data:data,
                                                tokenSeparators:[',',' ']
                                            });
                                        });
                                    </script>
                                </form>
                                <?php else:?>
                                <?=form_open_multipart("bulk/group", ['class'=>"form-row"])?>
                                    <div class="form-group col-md-12">
                                        <label>Group Name</label>
                                        <input name="name" type="text" class="form-control <?= session('errors.name')?"is-invalid":""?>" maxlength="15" minlength="5" value="<?=old('name')?>" required>
                                        <code class="invalid-feedback"><?= session('errors.name') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="d-block">Recipient Source</label>
                                        <div class="custom-control custom-radio custom-control-inline ">
                                            <input type="radio" id="manual" name="source" value="manual" class="custom-control-input" checked @change="source = $event.target.id">
                                            <label class="custom-control-label" for="manual">Manual Entry</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="upload" name="source" value="upload" class="custom-control-input" @change="source = $event.target.id" required> 
                                            <label class="custom-control-label" for="upload">Upload CSV</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12" v-if="source === 'manual'">
                                        <label >Recipients <code>Type valid phone number and hit enter key or comma or space</code></label>
                                        <select class="form-control tagging" multiple="multiple" name="numbers[]" required></select>
                                    </div>
                                    <div class="form-group col-md-12" v-if="source === 'upload'">
                                        <input type="file" class="small" name="csv_file" accept=".csv" required>
                                        <code class="">*must be in csv format</code>
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save Group <i class="flaticon-folder"></i></button>
                                    </div>
                                </form>
                                <?php endif?>
                            </div>
                            <?php if ($groups):?>
                            <div class="col-md-5 mx-auto layout-spacing">
                                <div class="treeview mb-4" data-role="treeview">
                                    <ul>
                                        <?php foreach ($groups as $key):?>
                                        <?php $numbers = unserialize($key->numbers);?>

                                        <li class="node collapsed">
                                            <div class="leaf w-100"><a title="Last Modified: <?=date("d/m/Y h:ia", strtotime($key->updated_at))?>" class="h6 text-uppercase bs-tooltip" href="?id=<?=$key->id?>"><?=$key->name.' ('.count($numbers).')'?></a><?=form_open("bulk/group", ['class'=>"d-inline","onsubmit"=>"return confirm('Are you sure you want to remove this group and all numbers associated with it?')"])?><input type="hidden" name="_method" value="DELETE" /><input type="hidden" name="id" value="<?=$key->id?>" /><button class="border-0 bg-transparent"><i class="flaticon-delete-1 text-right text-danger"></i></button></form></div>
                                            <span class="node-toggle"></span>
                                            <ul class="list-group list-group-flush" style='max-height:30vh;overflow-y:auto'>
                                                <?php foreach ($numbers as $phone):?>
                                                <li class="list-group-item"><span class="leaf"><?=$phone?></span></li>
                                                <?php endforeach?>
                                            </ul>
                                        </li>
                                        <?php endforeach?>
                                    </ul>
                                </div>
                            </div>
                            <?php else:?>
                            <div class="col-md-5 mx-auto layout-spacing jumbotron">
                                <h1 class="display-4">No Saved Group</h1>
                                <p class="lead">Saved group would appear here</p>
                            </div>
                            <?php endif?>
                        </div>
                    </div>
                    <div class="tab-pane fade show " id="animated-underline-email" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if (isset($edite)):?>
                                <?=form_open("bulk/email-group", ['class'=>"form-row"])?>
                                    <input type="hidden" name="id" value="<?=$edite->id?>">
                                    <div class="form-group col-md-12 clearfix">
                                        <a href="<?=base_url('bulk/group')?>#animated-underline-email" class="btn btn-secondary btn-rounded btn-sm float-right"><i class='flaticon-plus'></i> New Entry</a>
                                    </div>
                                    <input type="hidden" name="_method" value="PUT" />
                                    <div class="form-group col-md-12">
                                        <label>Group Name</label>
                                        <input name="name" type="text" class="basic form-control <?= session('errors.title')?"is-invalid":""?>" maxlength="25" minlength="5" value="<?=$edite->name?>" >
                                        <code class="invalid-feedback"><?= session('errors.name') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label >Recipients</label>
                                        <select class="form-control tagging2" multiple="multiple" name="address[]" required ></select>
                                    
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Update <i class="flaticon-folder"></i></button>
                                        
                                    </div>
                                    <script>
                                        $(document).ready(()=>{
                                            <?php $a = "["; foreach (unserialize($edite->address) as $key) {
                                                $a .= "'$key',";
                                            }$a .= "]";?>
                                            let a = <?=$a?>;
                                            let data = [];
                                            a.forEach((num,index)=>{
                                                data.push({
                                                    id: num,
                                                    text:num,
                                                    selected:true
                                                })
                                            })
                                            $(".tagging2").select2({
                                                tags: true,
                                                data:data,
                                                tokenSeparators:[',',' ']
                                            });
                                        });
                                    </script>
                                </form>
                                <?php else:?>
                                <?=form_open_multipart("bulk/email-group", ['class'=>"form-row"])?>
                                    <div class="form-group col-md-12">
                                        <label>Group Name</label>
                                        <input name="name" type="text" class="form-control <?= session('errors.name')?"is-invalid":""?>" maxlength="15" minlength="5" value="<?=old('name')?>" required>
                                        <code class="invalid-feedback"><?= session('errors.name') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="d-block">Recipient Source</label>
                                        <div class="custom-control custom-radio custom-control-inline ">
                                            <input type="radio" id="manual-e" name="source" value="manual" class="custom-control-input" checked @change="source = $event.target.id">
                                            <label class="custom-control-label" for="manual-e">Manual Entry</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="upload-e" name="source" value="upload" class="custom-control-input" @change="source = $event.target.id" required> 
                                            <label class="custom-control-label" for="upload-e">Upload CSV</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12" v-if="source === 'manual-e'">
                                        <label >Recipients <code>Type valid email address and hit enter key or comma or space</code></label>
                                        <select class="form-control tagging" multiple="multiple" name="address[]" required></select>
                                    </div>
                                    <div class="form-group col-md-12" v-if="source === 'upload-e'">
                                        <input type="file" class="small" name="csv_file" accept=".csv" required>
                                        <code class="">*must be in csv format</code>
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save Group <i class="flaticon-folder"></i></button>
                                    </div>
                                </form>
                                <?php endif?>
                            </div>
                            <?php if ($email_groups):?>
                            <div class="col-md-5 mx-auto layout-spacing">
                                <div class="treeview mb-4" data-role="treeview">
                                    <ul>
                                        <?php foreach ($email_groups as $key):?>
                                        <?php $address = unserialize($key->address);?>

                                        <li class="node collapsed">
                                            <div class="leaf w-100"><a title="Last Modified: <?=date("d/m/Y h:ia", strtotime($key->updated_at))?>" class="h6 text-uppercase bs-tooltip" href="?id=<?=$key->id?>&type=email#animated-underline-email"><?=$key->name.' ('.count($address).')'?></a><?=form_open("bulk/email-group", ['class'=>"d-inline","onsubmit"=>"return confirm('Are you sure you want to remove this group and all numbers associated with it?')"])?><input type="hidden" name="_method" value="DELETE" /><input type="hidden" name="id" value="<?=$key->id?>" /><button class="border-0 bg-transparent"><i class="flaticon-delete-1 text-right text-danger"></i></button></form></div>
                                            <span class="node-toggle"></span>
                                            <ul class="list-group list-group-flush" style='max-height:30vh;overflow-y:auto'>
                                                <?php foreach ($address as $email):?>
                                                <li class="list-group-item"><span class="leaf"><?=$email?></span></li>
                                                <?php endforeach?>
                                            </ul>
                                        </li>
                                        <?php endforeach?>
                                    </ul>
                                </div>
                            </div>
                            <?php else:?>
                            <div class="col-md-5 mx-auto layout-spacing jumbotron">
                                <h1 class="display-4">No Saved Group</h1>
                                <p class="lead">Saved group would appear here</p>
                            </div>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url("assets/js/design-js/design.js")?>"></script>
<script src="<?=base_url("plugins/treeview/jstree.min.js")?>"></script>
<script src="<?=base_url("plugins/treeview/custom-jstree.js")?>"></script>
<script>
    $(document).ready(()=>{
        $(".tagging").select2({
            tags: true,
            tokenSeparators:[',',' ']
        });
    });
</script>
<script>
    new Vue({
        el: "#animated-underline-sms",
        data: {
            source:"manual",
            show_save_recipient: false
        },
        beforeUpdate(){
            if(document.querySelector(".tagging")) $(".tagging").select2('destroy');
        },
        updated(){
             $(".tagging").select2({
            tags: true,
            tokenSeparators:[',',' ']
        });
        }
    })
    new Vue({
        el: "#animated-underline-email",
        data: {
            source:"manual-e",
            show_save_recipient: false
        },
        beforeUpdate(){
            if(document.querySelector(".tagging")) $(".tagging").select2('destroy');
        },
        updated(){
             $(".tagging").select2({
            tags: true,
            tokenSeparators:[',',' ']
        });
        }
    })
</script>
<?=$this->endSection()?>

