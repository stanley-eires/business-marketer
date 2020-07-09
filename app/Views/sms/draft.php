<?=$this->extend("layouts/app")?>

<?=$this->section("content")?>
<div class="row ">
     <div class="col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area animated-underline-content">
                <ul class="nav nav-tabs justify-content-md-start justify-content-center mb-3" id="animateLine" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="animated-underline-sms-tab" data-toggle="tab" href="#animated-underline-sms" role="tab"><i class="flaticon-telephone"></i> SMS DRAFTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="animated-underline-email-tab" data-toggle="tab" href="#animated-underline-email" role="tab"><i class="flaticon-email-fill-2"></i> EMAIL DRAFTS</a>
                    </li>
                </ul>

                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="animated-underline-sms" role="tabpanel">
                        <div class="row">
                            <div class="col-md-5  layout-spacing">
                                <?php if(isset($edit)):?>
                                <?=form_open("",['class'=>"form-row"])?>
                                    <div class="form-group col-md-12 clearfix">
                                        <a href="<?=base_url('bulk/draft')?>" class="btn btn-secondary btn-rounded btn-sm float-right"><i class='flaticon-plus'></i> New Entry</a>
                                    </div>
                                    <!-- <input type="hidden" name="_method" value="PUT" /> -->
                                    <input type="hidden" name="id" value="<?=$edit->id?>" />
                                    <div class="form-group col-md-12">
                                        <label>Title</label>
                                        <input name="title" type="text" class="form-control <?= session('errors.title')?"is-invalid":""?>" maxlength="15" minlength="5" value="<?=$edit->title?>" >
                                        <code class="invalid-feedback"><?= session('errors.title') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label >Body</label>
                                        <textarea name="body" class="form-control <?= session('errors.body')?"is-invalid":""?>" rows="10"><?=$edit->body?></textarea>
                                        <code class="invalid-feedback"><?= session('errors.body') ?></code>
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Update <i class="flaticon-folder"></i></button>
                                    </div>
                                </form>
                                <?php else:?>
                                <?=form_open("",['class'=>"form-row"])?>
                                    <div class="form-group col-md-12">
                                        <label>Title</label>
                                        <input name="title" type="text" class="form-control <?= session('errors.title')?"is-invalid":""?>" maxlength="15" minlength="5" value="<?=old('title')?>" >
                                        <code class="invalid-feedback"><?= session('errors.title') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label >Body</label>
                                        <textarea name="body" class="form-control <?= session('errors.body')?"is-invalid":""?>" rows="10"><?=old('body')?></textarea>
                                        <code class="invalid-feedback"><?= session('errors.body') ?></code>
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save <i class="flaticon-folder"></i></button>
                                    </div>
                                </form>
                                <?php endif?>
                            </div>
                            <div class="col-md-6 mx-auto  layout-spacing">
                                <?=form_open("",["onsubmit"=>"return confirm('Sure you want to delete?')"])?>
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th class='text-nowrap'>S/N</th>
                                                <th class='text-nowrap'>Title</th>
                                                <th class='text-nowrap'>Last Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            foreach ($drafts as $key):?>
                                            <tr>
                                                <td><div class="custom-control custom-checkbox">
                                                    <input id="<?=$key->id?>" class="custom-control-input" type="checkbox" name="checkbox[]" value="<?=$key->id?>">
                                                    <label for="<?=$key->id?>" class="custom-control-label"><?=$i++?></label>
                                                </div></td>
                                                <td>
                                                    <a href="?id=<?=$key->id?>" class="d-block h6"><?=$key->title?></a>
                                                    <span class="text-muted d-none d-md-block"><?=ellipsize($key->body,70)?></span>
                                                </td>
                                                <td class="font-weight-light"><?=date("d/m/Y h:ia",strtotime($key->updated_at))?></td>
                                            </tr>
                                            <?php endforeach?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan='3'>
                                                    <div class="custom-control custom-checkbox d-flex align-item-end">
                                                        <input id="chkall" class="custom-control-input" type="checkbox" onchange="checkAll(event)">
                                                        <label for="chkall" class="custom-control-label"></label>
                                                        <button value="remove" name="action" class='btn btn-sm text-danger bg-white shadow-none' type="submit"><i class="flaticon-delete"></i> Delete</button>
                                                    </div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show " id="animated-underline-email" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6  layout-spacing">
                                <?php if(isset($edite)):?>
                                <?=form_open("bulk/email-draft",['class'=>"form-row"])?>
                                    <div class="form-group col-md-12 clearfix">
                                        <a href="<?=base_url('bulk/draft')?>#animated-underline-email" class="btn btn-secondary btn-rounded btn-sm float-right"><i class='flaticon-plus'></i> New Entry</a>
                                    </div>
                                    <!-- <input type="hidden" name="_method" value="PUT" /> -->
                                    <input type="hidden" name="id" value="<?=$edite->id?>" />
                                    <div class="form-group col-md-12">
                                        <label>Email Subject</label>
                                        <input name="title" type="text" class="form-control <?= session('errors.title')?"is-invalid":""?>" minlength="5" value="<?=$edite->title?>" >
                                        <code class="invalid-feedback"><?= session('errors.title') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label >Body</label>
                                        <textarea name="body" class="textarea form-control <?= session('errors.body')?"is-invalid":""?>" rows="10"><?=$edite->body?></textarea>
                                        <code class="invalid-feedback"><?= session('errors.body') ?></code>
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Update <i class="flaticon-folder"></i></button>
                                    </div>
                                </form>
                                <?php else:?>
                                <?=form_open("bulk/email-draft",['class'=>"form-row"])?>
                                    <div class="form-group col-md-12">
                                        <label>Email Subject</label>
                                        <input name="title" type="text" class="form-control <?= session('errors.title')?"is-invalid":""?>"  minlength="5" value="<?=old('title')?>" >
                                        <code class="invalid-feedback"><?= session('errors.title') ?></code>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label >Body</label>
                                        <textarea name="body" class="form-control textarea <?= session('errors.body')?"is-invalid":""?>" rows="10"><?=old('body')?></textarea>
                                        <code class="invalid-feedback"><?= session('errors.body') ?></code>
                                    </div>
                                    <div class="form-group col-md-12 clearfix">
                                        <button class="btn btn-gradient-primary btn-rounded float-right" type="submit">Save <i class="flaticon-folder"></i></button>
                                    </div>
                                </form>
                                <?php endif?>
                            </div>
                            <div class="col-md-6  layout-spacing">
                                <?=form_open("bulk/email-draft",["onsubmit"=>"return confirm('Sure you want to delete?')"])?>
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th class='text-nowrap'>S/N</th>
                                                <th class='text-nowrap'>Title</th>
                                                <th class='text-nowrap'>Last Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            foreach ($emaildrafts as $key):?>
                                            <tr>
                                                <td><div class="custom-control custom-checkbox">
                                                    <input id="<?=$key->id?>" class="custom-control-input" type="checkbox" name="checkbox[]" value="<?=$key->id?>">
                                                    <label for="<?=$key->id?>" class="custom-control-label"><?=$i++?></label>
                                                </div></td>
                                                <td>
                                                    <a href="?id=<?=$key->id?>&type=email#animated-underline-email" class="d-block h6"><?=$key->title?></a>
                                                    <span class="text-muted d-none d-md-block"><?=ellipsize($key->body,70)?></span>
                                                </td>
                                                <td class="font-weight-light"><?=date("d/m/Y h:ia",strtotime($key->updated_at))?></td>
                                            </tr>
                                            <?php endforeach?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan='3'>
                                                    <div class="custom-control custom-checkbox d-flex align-item-end">
                                                        <input id="chkalle" class="custom-control-input" type="checkbox" onchange="checkAll(event)">
                                                        <label for="chkalle" class="custom-control-label"></label>
                                                        <button value="remove" name="action" class='btn btn-sm text-danger bg-white shadow-none' type="submit"><i class="flaticon-delete"></i> Delete</button>
                                                    </div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->endSection()?>

Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam aliquid quis neque beatae deleniti expedita alias, hic id? Quasi ipsum, vel voluptate, consectetur facilis dignissimos accusantium ipsam repudiandae molestiae sapiente expedita consequuntur itaque assumenda fuga voluptas asperiores magnam. Nihil accusamus eaque officiis quos, eligendi suscipit sequi illo dolorem, quo totam fugiat est quia asperiores dolore natus dolores repudiandae atque iste magni optio. Laboriosam corporis, cupiditate quas inventore doloribus similique atque quos, exercitationem, earum consequatur optio perspiciatis quisquam facilis explicabo ea officiis beatae unde iure aliquid pariatur. In qui voluptates veritatis! Explicabo, mollitia! Sapiente quisquam quis quod sunt nisi cumque molestiae saepe natus doloremque itaque qui similique, voluptas sequi, excepturi, animi est sint eum pariatur tenetur ab accusamus! Tempore assumenda eum deleniti impedit dolores, accusantium vitae ipsum, harum debitis corrupti ducimus consequuntur beatae omnis, consectetur fugit. Dolorum aperiam eveniet nesciunt praesentium ducimus, reiciendis a eius veritatis exercitationem, illo magnam voluptates obcaecati enim libero vero tempore voluptatibus. Repellendus earum adipisci minima aliquid culpa pariatur doloribus non exercitationem, neque totam voluptates optio libero esse deleniti numquam illo! Minima nisi, harum quos nemo eligendi maiores cupiditate impedit doloremque possimus nesciunt ipsum soluta cumque eos iure, quis porro optio. Alias suscipit quos modi error similique. Hic sequi asperiores magnam expedita, deserunt ex suscipit accusantium ipsa, temporibus fugit molestiae reiciendis dolorum incidunt, voluptatem ad aspernatur soluta? Praesentium sequi cum labore optio commodi provident quaerat repudiandae, distinctio animi voluptatum ex eaque reprehenderit excepturi aut ratione aliquam. Perspiciatis, aut. Facere explicabo assumenda, illo eaque deleniti earum, rem iusto nulla quos pariatur, minus nobis vel iste! Debitis itaque quisquam quibusdam quas vitae sunt necessitatibus inventore laudantium! Illum quos voluptate incidunt dolorem veritatis possimus nihil tempora, vel expedita sunt id at et ullam fuga vero cum in saepe beatae, amet non debitis provident repellat sed vitae. Facere unde ea qui.