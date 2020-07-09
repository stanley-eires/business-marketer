<?=$this->extend("layouts/app")?>
<?=$this->section("content")?>
<div class="row">
    <?php if (isset($emails) || isset($phones)):?>
    <div class="col-md-6  layout-spacing">
        <div class="statbox widget box box-shadow">
            <h5 class="text-capitalize text-center"><?=$category?></h5>
            <div class="widget-content widget-content-area animated-underline-content">
                <ul class="nav nav-tabs justify-content-md-start justify-content-center mb-3" id="animateLine" role="tablist">
                    <?php if(isset($phones)):?>
                    <li class="nav-item">
                        <a href="#phone_tab" id="phone-tab" class="nav-link active" data-toggle="tab" role="tab">Phone</a>
                    </li>
                    <?php endif?>
                    <?php if(isset($emails)):?>
                     <li class="nav-item">
                        <a href="#email_tab" id="email-tab" class="nav-link " data-toggle="tab" role="tab">Email</a>
                    </li>
                    <?php endif?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="phone_tab" role="tabpanel">
                        <table class="table w-100 table-bordered" data-page-length='5'>
                            <thead class="">
                                <tr>
                                    <th>S/N</th>
                                    <th>Phones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($phones as $phone): ?>
                                <tr>
                                    <td><?=$i++?></td>
                                    <td><?=$phone?></td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                        <?=form_open("scrapper/save-contacts",["id"=>"phones"])?>
                            <input type="hidden" name="entry" value='<?=serialize($phones)?>'>
                            <div class="custom-control custom-switch">
                                <input id="save-group" class="custom-control-input" type="checkbox" name="" value="true" @change="show_save_recipient = $event.target.checked">
                                <label for="save-group" class="custom-control-label">Save recipients to group</label>
                            </div>
                            <div class="form-group col-md-12 cleafix" v-if="show_save_recipient">
                                <label class="d-block">Group</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="new" name="group" value="new_group" class="custom-control-input" checked @change="group_option = $event.target.id">
                                    <label class="custom-control-label" for="new">Create New Group</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="existing" name="group" value="existing_group" class="custom-control-input" @change="group_option = $event.target.id" required> 
                                    <label class="custom-control-label" for="existing">Use Existing</label>
                                </div>
                                <input v-if="group_option == 'new'" id="" class="form-control" type="text" placeholder="New Group Name" name="new_group_name" minlength="3" maxlength="15" required>
                                <select v-if="group_option == 'existing'"  class="form-control" name="id" required>
                                    <?php foreach(model("phonegroupmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->name?></option>
                                    <?php endforeach?>
                                </select>
                                <button type="submit" class="btn btn-rounded btn-primary mt-5 float-right">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade " id="email_tab" role="tabpanel">
                        <table class="table table-bordered datatable" data-page-length="5">
                            <thead class="">
                                <tr>
                                    <th>S/N</th>
                                    <th>Emails</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($emails as $email): ?>
                                <tr>
                                    <td><?=$i++?></td>
                                    <td><?=$email?></td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                        <?=form_open("scrapper/save-email-contacts",["id"=>"emails"])?>
                            <input type="hidden" name="entry" value='<?=serialize($emails)?>'>
                            <div class="custom-control custom-switch">
                                <input id="save-groupe" class="custom-control-input" type="checkbox" name="" value="true" @change="show_save_recipient = $event.target.checked">
                                <label for="save-groupe" class="custom-control-label">Save addresses to group</label>
                            </div>
                            <div class="form-group col-md-12 cleafix" v-if="show_save_recipient">
                                <label class="d-block">Group</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="newe" name="group" value="new_group" class="custom-control-input" checked @change="group_option = $event.target.id">
                                    <label class="custom-control-label" for="newe">Create New Group</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="existinge" name="group" value="existing_group" class="custom-control-input" @change="group_option = $event.target.id" required> 
                                    <label class="custom-control-label" for="existinge">Use Existing</label>
                                </div>
                                <input v-if="group_option == 'newe'" id="" class="form-control" type="text" placeholder="New Group Name" name="new_group_name" minlength="3" maxlength="15" required>
                                <select v-if="group_option == 'existinge'"  class="form-control" name="id" required>
                                    <?php foreach(model("emailgroupmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->name?></option>
                                    <?php endforeach?>
                                </select>
                                <button type="submit" class="btn btn-rounded btn-primary mt-5 float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif?>
    <div class="col-md-4  layout-spacing" >
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <?=form_open("",["class"=>"clearfix"])?>
                    <div class="form-group">
                        <label for="">Category</label>
                        <select id="" class="form-control text-capitalize" name="category">
                            <?php foreach (["investment","business","career","jobs","education","properties","nysc","romance","travel","computers","phones","ads"] as $key):?>
                            <option value="<?=$key?>" class="text-capitalize"><?=$key?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pages <i class="flaticon-question bs-tooltip" title="Higher number could results to more time / resource used by app"></i></label>
                        <select id="" class="form-control" name="pages">
                            <?php for ($i=1; $i <= 10; $i++):?> 
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor?>
                        </select>
                    </div>
                    <label for="">Harvest Type</label>
                    <div class="d-flex justify-content-start form-group">
                        
                        <div class="custom-control custom-checkbox">
                            <input id="email" class="custom-control-input" type="checkbox" name="email" value="true" checked>
                            <label for="email" class="custom-control-label">Email</label>
                        </div>
                        <div class="custom-control custom-checkbox ml-5">
                            <input id="phone" class="custom-control-input" type="checkbox" name="phone" value="true" checked>
                            <label for="phone" class="custom-control-label">Phone</label>
                        </div>
                    </div>
                    <details>
                        <summary>Advanced</summary>
                        <div class="ml-3">
                            <div class="form-group">
                                <label for="">RegEx Pattern For Email</label>
                                <input id="" class="form-control" type="text" name="email_pattern" value="/[\w]+@[\w]+\.com/i">
                            </div>
                            <div class="form-group">
                                <label for="">RegEx Pattern For Phone</label>
                                <input id="" class="form-control" type="text" name="phone_pattern" value="/(080|090|081|070)+[\d]{8}/">
                            </div>
                            </div>
                    </details>
                    <div class="form-check mt-2" id="terms">
                        <input id="my-input" class="form-check-input" type="checkbox" @change="term = $event.target.checked">
                        <label for="my-input" class="form-check-label small">I acknowledge that am only using this for educational purpose</label>
                        <button class="btn btn-rounded btn-gradient-primary float-right mt-3" :disabled="!term">Harvest</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
   
</div>
<script>
    new Vue({
        el:"#phones",
        data:{
            show_save_recipient: false,
            group_option:"new",
        }
    })
    new Vue({
        el:"#emails",
        data:{
            show_save_recipient: false,
            group_option:"newe",
        }
    })
     new Vue({
        el:"#terms",
        data:{
            term:false,
        }
    })

</script>
<?=$this->endSection()?>

