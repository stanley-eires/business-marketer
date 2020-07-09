<?=$this->extend("layouts/app")?>

<?=$this->section("content")?>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            <details class='col-12' open>
                <summary class="lead">General </summary>
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        
                        <?=form_open("bulk/settings")?>
                            <div class="form-group">
                                <label for="" class='font-weight-bolder'>Login Username <i class="flaticon-question bs-tooltip" title="Username used in logging into this portal"></i></label>
                                <input type="text" name="username" class="form-control" value="<?=get_settings("username")?>" required>
                            </div>
                            <div class="form-group">
                                <label for="" class='font-weight-bolder'>Project Name <i class="flaticon-question bs-tooltip" title="A text-based name for the project"></i></label>
                                <input type="text" name="project_name" class="form-control" value="<?=get_settings("project_name")?>" required>
                            </div>
                            <div class="form-group">
                                <label for="" class='font-weight-bolder'>Theme Font Pack <i class="flaticon-question bs-tooltip" title="The font family pack to choose from. May vary depending on the fonts available on machine"></i></label>
                                <select class="form-control" name="site_font">
                                    <?php for ($i=1; $i <= 6 ; $i++):?> 
                                        <option <?=get_settings("site_font") == "Pack-$i"?"selected":""?>>Pack-<?=$i?></option>
                                    <?php endfor?>
                                </select>
                            </div>
                            <div class="form-group col-md-12 clearfix">
                                <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save <i class="flaticon-folder"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </details>
            <details class='col-12 mt-md-3' open>
                <summary class="lead">Password Update </summary>
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <?=form_open("bulk/password-update")?>
                            <div class="form-group">
                                <label for=""> Current Password</label><input class="form-control" minlength="6" placeholder="Password" required="required" type="password" name='current_password'>
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label><input class="form-control" minlength="6" placeholder="Password" required="required" type="password" name='password'>
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password</label><input class="form-control" placeholder="Confirm Password" required="required" type="password" name='confirm_password'>
                            </div>
                            <div class="form-group col-md-12 clearfix">
                                <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Update <i class="flaticon-folder"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </details>
        </div>
    </div>
    <div class="col-md-4">
        <details open>
            <summary class="lead">SMS Gateway Configuration <small class="small">- Goshen</small></summary>
            <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                
                <?=form_open("bulk/settings")?>
                    <div class="form-group">
                      <label for="" class='font-weight-bolder'>Unit <i class="flaticon-question bs-tooltip" title="Total unit left on your Goshen account"></i></label>
                      <input type="text" class="form-control bg-transparent" value="<?=$unit?>" readonly disabled>
                    </div>
                    <div class="form-group">
                      <label for="" class='font-weight-bolder'>Goshen Username <i class="flaticon-question bs-tooltip" title="Username you use in logging into Goshen"></i></label>
                      <input type="text" name="goshen_username" class="form-control" value="<?=get_settings("goshen_username")?>" required>
                    </div>
                    <div class="form-group">
                      <label for="" class='font-weight-bolder'>Goshen Password <i class="flaticon-question bs-tooltip" title="Password you use in logging into Goshen"></i></label>
                      <input type="text" name="goshen_password" class="form-control" value="<?=get_settings("goshen_password")?>" required>
                    </div>
                    <div class="form-group">
                      <label for="" class='font-weight-bolder'>Sender ID <i class="flaticon-question bs-tooltip" title="This should never be a number and avoid using names of company that you dont own. Operator frowns at this and this could affect you message deliveribility"></i></label>
                      <input type="text" name="sender_id" class="form-control" value="<?=get_settings("sender_id")?>" required minlength="3" maxlength="11">
                    </div>
                    <div class="form-group">
                      <label for="" class='font-weight-bolder'>Signature <i class="flaticon-question bs-tooltip" title="Would be appended to the end of every message. This could increase the number of pages"></i></label>
                      <textarea name="sms_signature" class="form-control"><?=get_settings("sms_signature")?></textarea>
                    </div>
                    <div class="form-group col-md-12 clearfix">
                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save <i class="flaticon-folder"></i></button>
                    </div>
                </form>
            </div>
        </div>
        </details>
    </div>
    <div class="col-md-4">
        <details open>
            <summary class="lead">Mailer Configuration <small class="small"></small></summary>
            <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                
                <?=form_open("bulk/settings")?>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="">Mailer Protocol</label>
                                <select class="form-control" name="mailer_type" id="">
                                <option <?= get_settings('mailer_type') == "isSMTP"?"selected":"" ?> value="isSMTP">SMTP</option>
                                <option <?= get_settings('mailer_type') == "isMail"?"selected":"" ?> value="isMail">Mail</option>
                                <option <?= get_settings('mailer_type') == "isSendMail"?"selected":"" ?> value="isSendMail">SendMail</option>
                                </select>
                            </div>
                            <div class="form-group col-md-7">
                              <label for="">Sender Name</label>
                              <input id="" class="form-control" type="text" name="sender_name" value="<?= get_settings('sender_name')?>">
                            </div>
                        </div>
                          <div class="row">
                            <div class="form-group col-md-9">
                              <label for="">Host</label>
                              <input id="" class="form-control" type="text" name="host" value="<?= get_settings('host')?>">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="">Port</label>
                              <input id="" class="form-control" type="number" name="port" value="<?= get_settings('port')?>">
                            </div>
                          </div>
                            <div class="form-group">
                            <label for="">Username</label>
                            <input id="" class="form-control" type="text" name="smtp_username" value="<?= get_settings('smtp_username')?>">
                          </div>
                            <div class="form-group">
                            <label for="">Password</label>
                            <input id="" class="form-control" type="text" name="smtp_password" value="<?= get_settings('smtp_password')?>">
                          </div>
                          <div class="row">
                            <div class="form-group col-md-6">
                              <label for="">SMTPAuth</label>
                              <select id="" class="form-control" name="smtp_auth">
                                <option <?= get_settings('smtp_auth') == "true"?"selected":"" ?>>true</option>
                                <option <?= get_settings('smtp_auth') == "false"?"selected":"" ?>>false</option>
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="">SMTPSecure</label>
                              <select id="" class="form-control" name="smtp_secure">
                                <option <?= get_settings('smtp_secure') == "ssl"?"selected":"" ?>>ssl</option>
                                <option <?= get_settings('smtp_secure') == "tls"?"selected":"" ?>>tls</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="" class='font-weight-bolder'>Signature <i class="flaticon-question bs-tooltip" title="Would be appended to the end of every message. "></i></label>
                            <textarea name="email_signature" class="form-control"><?=get_settings("email_signature")?></textarea>
                        </div>
                        <div class="form-group col-md-12 clearfix">
                            <a class='float-left btn btn-link ' type="button" href="<?=route_to("test-mail")?>">Test Mail</a>
                            <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save <i class="flaticon-folder"></i></button>
                        </div>
                </form>
            </div>
        </div>
        </details>
    </div>
</div>
<?=$this->endSection()?>