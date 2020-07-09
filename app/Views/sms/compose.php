<?=$this->extend("layouts/app")?>

<?=$this->section("content")?>

<div class="row ">
     <div class="col-md-8 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area animated-underline-content">
                
                <ul class="nav nav-tabs justify-content-md-start justify-content-center mb-3" id="animateLine" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="animated-underline-sms-tab" data-toggle="tab" href="#animated-underline-sms" role="tab"><i class="flaticon-telephone"></i> SMS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="animated-underline-email-tab" data-toggle="tab" href="#animated-underline-email" role="tab"><i class="flaticon-email-fill-2"></i> EMAIL</a>
                    </li>
                </ul>

                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="animated-underline-sms" role="tabpanel">
                        <?=form_open_multipart("", ["class"=>"form-row"])?>
                            <div class="form-group col-md-12">
                                <label class="d-block">Recipient Source</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="manual" name="source" value="manual" class="custom-control-input" checked @change="source = $event.target.id">
                                    <label class="custom-control-label" for="manual">Manual Entry</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="upload" name="source" value="upload" class="custom-control-input" @change="source = $event.target.id">
                                    <label class="custom-control-label" for="upload">Upload CSV</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="group" name="source" value="group" class="custom-control-input" @change="source = $event.target.id">
                                    <label class="custom-control-label" for="group">Phone Group</label>
                                </div>
                            </div>
                            <div class="form-group col-md-12" v-if="source === 'manual'">
                                <label >Recipients <code>Type valid phone number and hit enter key or comma or space</code></label>
                                <select class="form-control tagging" multiple="multiple" name="recipients[]" required></select>
                            </div>
                            <div class="form-group col-md-12" v-if="source === 'upload'">
                                <input type="file" class="small" name="csv_file" accept=".csv" required>
                                <code class="">*must be in csv format</code>
                            </div>
                            <div class="form-group col-md-12" v-if="source === 'group'">
                                <select  class="form-control" name="group_id" required>
                                    <?php foreach (model("phonegroupmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->name?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="custom-control custom-switch" v-show="source !== 'group'">
                                <input id="save-group" class="custom-control-input" type="checkbox" value="true" @change="show_save_recipient = $event.target.checked">
                                <label for="save-group" class="custom-control-label">Save recipients to group</label>
                            </div>
                            <div class="form-group col-md-12" v-if="show_save_recipient && source !== 'group'">
                                <label class="d-block">Group</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="new" name="group" value="new" class="custom-control-input" checked @change="group_option = $event.target.id">
                                    <label class="custom-control-label" for="new">Create New Group</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="existing" name="group" value="existing" class="custom-control-input" @change="group_option = $event.target.id">
                                    <label class="custom-control-label" for="existing">Use Existing</label>
                                </div>
                                <input v-if="group_option === 'new'" name="new_group_name" class="form-control" type="text" placeholder="New Group Name" required maxlength="15" minlength="3">
                                <select v-if="group_option === 'existing'"  id="" class="form-control" name="group_id" required>
                                    <?php foreach (model("phonegroupmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->name?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="d-block">Message</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="write_new" name="message_source" value="write_new" class="custom-control-input" checked @change="message_source = $event.target.id">
                                    <label class="custom-control-label" for="write_new">Write New</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="from_draft" name="message_source" value="from_draft" class="custom-control-input" @change="message_source = $event.target.id">
                                    <label class="custom-control-label" for="from_draft">Load From Draft</label>
                                </div>
                                <select v-if="message_source === 'from_draft'"  class="form-control" name="draft_id" required>
                                    <?php foreach (model("draftmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->title?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group col-md-12" v-if="message_source === 'write_new'">
                                <label >Text Message</label>
                                <textarea class="form-control" rows="5" name="message" required></textarea>
                                <div class="custom-control custom-switch ">
                                    <input id="show_save_draft" class="custom-control-input" type="checkbox" name="show_save_draft" @change="show_save_draft = $event.target.checked">
                                    <label for="show_save_draft" class="custom-control-label">Save a copy as draft</label>
                                </div>
                                <div v-if="show_save_draft">
                                    <div class="custom-control custom-radio custom-control-inline ">
                                        <input type="radio" id="new_draft" name="draft_source" value="new_draft" class="custom-control-input" checked @change="draft_source = $event.target.id">
                                        <label class="custom-control-label" for="new_draft">New Draft</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline ">
                                        <input type="radio" id="existing_draft" name="draft_source" value="existing_draft" class="custom-control-input" @change="draft_source = $event.target.id">
                                        <label class="custom-control-label" for="existing_draft">Update Draft</label>
                                    </div>
                                    <input v-if="draft_source === 'new_draft'" name="new_draft_name" class="form-control" required type="text" placeholder="New Draft Title">
                                    <select v-if="draft_source == 'existing_draft'" class=" form-control" name="save_draft_id" required>
                                        <?php foreach (model("draftmodel")->findall() as $key):?>
                                        <option value="<?=$key->id?>"><?=$key->title?></option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12 clearfix">
                                <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Send <i class="flaticon-send"></i></button>
                            </div>
                        </form> 
                    </div>
                    <div class="tab-pane fade" id="animated-underline-email" role="tabpanel">
                        <?=form_open_multipart("bulk/send-email", ["class"=>"form-row"])?>
                            <div class="form-group col-md-12">
                                <label class="d-block">Recipient Source</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="manual-e" name="source" value="manual" class="custom-control-input" checked @change="source = $event.target.id">
                                    <label class="custom-control-label" for="manual-e">Manual Entry</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="upload-e" name="source" value="upload" class="custom-control-input" @change="source = $event.target.id">
                                    <label class="custom-control-label" for="upload-e">Upload CSV</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="group-e" name="source" value="group" class="custom-control-input" @change="source = $event.target.id">
                                    <label class="custom-control-label" for="group-e">Email Group</label>
                                </div>
                            </div>
                            <div class="form-group col-md-12" v-if="source === 'manual-e'">
                                <label >Recipients <code>Type valid email address and hit enter key or comma or space</code></label>
                                <select class="form-control tagging" multiple="multiple" name="recipients[]" required></select>
                            </div>
                            <div class="form-group col-md-12" v-if="source === 'upload-e'">
                                <input type="file" class="small" name="csv_file" accept=".csv" required>
                                <code class="">*must be in csv format</code>
                            </div>
                            <div class="form-group col-md-12" v-if="source === 'group-e'">
                                <select  class="form-control" name="group_id" required>
                                    <?php foreach (model("emailgroupmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->name?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="custom-control custom-switch" v-show="source !== 'group-e'">
                                <input id="save-group-e" class="custom-control-input" type="checkbox" value="true" @change="show_save_recipient = $event.target.checked">
                                <label for="save-group-e" class="custom-control-label">Save recipients to group</label>
                            </div>
                            <div class="form-group col-md-12" v-if="show_save_recipient && source !== 'group-e'">
                                <label class="d-block">Group</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="new-e" name="group" value="new" class="custom-control-input" checked @change="group_option = $event.target.id">
                                    <label class="custom-control-label" for="new-e">Create New Group</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="existing-e" name="group" value="existing" class="custom-control-input" @change="group_option = $event.target.id">
                                    <label class="custom-control-label" for="existing-e">Use Existing</label>
                                </div>
                                <input v-if="group_option === 'new-e'" name="new_group_name" class="form-control" type="text" placeholder="New Group Name" required maxlength="15" minlength="3">
                                <select v-if="group_option === 'existing-e'"  id="" class="form-control" name="group_id" required>
                                    <?php foreach (model("emailgroupmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->name?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="d-block">Message</label>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="write_new-e" name="message_source" value="write_new" class="custom-control-input" checked @change="message_source = $event.target.id">
                                    <label class="custom-control-label" for="write_new-e">Write New</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline ">
                                    <input type="radio" id="from_draft-e" name="message_source" value="from_draft" class="custom-control-input" @change="message_source = $event.target.id">
                                    <label class="custom-control-label" for="from_draft-e">Load From Draft</label>
                                </div>
                                <select v-if="message_source === 'from_draft-e'"  class="form-control" name="draft_id" required>
                                    <?php foreach (model("emaildraftmodel")->findall() as $key):?>
                                    <option value="<?=$key->id?>"><?=$key->title?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="col-md-12" v-if="message_source === 'write_new-e'">
                            <div class="form-group">
                                <label for="">Mail Subject</label>
                                <input  class="form-control" type="text" name="subject" required>
                            </div>
                                <div class="form-group">
                                    <label for="">Mail Body</label>
                                    <textarea class="form-control textarea" rows="5" name="message" required></textarea>
                                </div>
                                
                                <div class="custom-control custom-switch ">
                                    <input id="show_save_draft" class="custom-control-input" type="checkbox" name="show_save_draft" @change="show_save_draft = $event.target.checked">
                                    <label for="show_save_draft" class="custom-control-label">Save a copy as draft</label>
                                </div>
                                <div v-if="show_save_draft">
                                    <div class="custom-control custom-radio custom-control-inline ">
                                        <input type="radio" id="new_draft-e" name="draft_source" value="new_draft" class="custom-control-input" checked @change="draft_source = $event.target.id">
                                        <label class="custom-control-label" for="new_draft-e">New Draft</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline ">
                                        <input type="radio" id="existing_draft-e" name="draft_source" value="existing_draft" class="custom-control-input" @change="draft_source = $event.target.id">
                                        <label class="custom-control-label" for="existing_draft-e">Update Draft</label>
                                    </div>
                                    <input v-if="draft_source === 'new_draft-e'" name="new_draft_name" class="form-control" required type="text" placeholder="New Draft Title">
                                    <select v-if="draft_source == 'existing_draft-e'" class=" form-control" name="save_draft_id" required>
                                        <?php foreach (model("emaildraftmodel")->findall() as $key):?>
                                        <option value="<?=$key->id?>"><?=$key->title?></option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12 clearfix">
                                <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Send <i class="flaticon-send"></i></button>
                            </div>
                        </form> 
                    </div>
                </div>

            </div>
        </div>
    </div>           
</div>
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
            show_save_recipient: false,
            group_option:"new",
            message_source:"write_new",
            show_save_draft:false,
            draft_source:"new_draft"
        },
        methods: {
             
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
            show_save_recipient: false,
            group_option:"new-e",
            message_source:"write_new-e",
            show_save_draft:false,
            draft_source:"new_draft-e"
        },
        methods: {
             
        },

        beforeUpdate(){
            if(document.querySelector(".tagging")) $(".tagging").select2('destroy');
        },
        updated(){
             $(".tagging").select2({
                tags: true,
                tokenSeparators:[',',' ']
            });
            $('.textarea').summernote({
                height:400
            });
        }
    })

</script>
<?=$this->endSection()?>


