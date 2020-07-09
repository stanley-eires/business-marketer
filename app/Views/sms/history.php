<?=$this->extend("layouts/app")?>

<?=$this->section("content")?>
<div class="row ">
     <div class="col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area animated-underline-content">
                <ul class="nav nav-tabs justify-content-md-start justify-content-center mb-3" id="animateLine" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="animated-underline-sms-tab" data-toggle="tab" href="#animated-underline-sms" role="tab"><i class="flaticon-telephone"></i> SMS HISTORY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="animated-underline-email-tab" data-toggle="tab" href="#animated-underline-email" role="tab"><i class="flaticon-email-fill-2"></i> EMAIL HISTORY</a>
                    </li>
                </ul>
                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="animated-underline-sms" role="tabpanel">
                        <div class="row ">
                            <?php if (isset($more)):?>
                            <div class="col-md-6">
                                <div style="overflow:auto">
                                    <details open> 
                                        <summary>Numbers</summary>
                                            <ul class="list-group list-group-flush ml-3 text-secondary mt-1" style='max-height:25vh;overflow-y:auto'>
                                            <?php foreach (unserialize($more->phone) as $key) :?>
                                                <li class='list-group-action list-group-item m-0 p-0 border-0'><?=$key?></li>
                                            <?php endforeach?>
                                        </ul>
                                    </details> 
                                    <details open>
                                        <summary>Message</summary>
                                        
                                        <?php parse_str(parse_url($more->api_call,PHP_URL_QUERY),$response)?>
                                        <p class='ml-3 text-secondary mt-1'><?=$response["message"]?></p>
                                    </details> 
                                    <details>
                                        <summary>API Call</summary>
                                        <p style="overflow-wrap:break-word;" class='ml-3 mt-1 text-secondary'><?=$more->api_call?></p>
                                    </details> 
                                    <details open>
                                        <summary>Status</summary>
                                        <p class='ml-3 mt-1 text-secondary'><?=$more->status?> | <?=$more->response?></p>
                                    </details> 
                                </div>
                            </div>  
                            <?php endif?>         
                            <div class="col-md-6">
                                <div class="table-responsive-sm ">
                                    <?=form_open("",["onsubmit"=>"return confirm('Sure you want to delete?')"])?>
                                        <input type="hidden" name="_method" value="DELETE" />
                                            
                                        <table class="table small">
                                            <thead>
                                                <tr>
                                                    <th class='text-nowrap'>S/N</th>
                                                    <th class='text-nowrap'>Status</th>
                                                    <th class='text-nowrap'>Gateway</th>
                                                    <th class='text-nowrap'>Total Recepients</th> 
                                                    <th class='text-nowrap'>Time Sent</th> 
                                                    <th class='text-nowrap'></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i = 1;
                                                foreach ($history as $key):?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input id="<?=$key->id?>" class="custom-control-input" type="checkbox" name="checkbox[]" value="<?=$key->id?>">
                                                            <label for="<?=$key->id?>" class="custom-control-label"><?=$i++?></label>
                                                        </div>
                                                    </td>
                                                    <td><?=$key->status?>
                                                        <span class='d-block text-nowrap text-info'>[ <?=$key->response ?> ]</span>
                                                    </td>
                                                    <td><?=$key->gateway?>
                                                    </td>
                                                    <td class='text-center'><?=count(unserialize($key->phone))?></td>
                                                    <td><?=date("F d Y h:ia",strtotime($key->created_at))?></td>
                                                    <td><a href="?id=<?=$key->id?>" class=''><i class="flaticon-right-arrow-12   "></i></a></td>
                                                </tr>
                                                <?php endforeach?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan='6'>
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
                    </div>
                    <div class="tab-pane fade" id="animated-underline-email" role="tabpanel">
                        <div class="row ">
                            <?php if (isset($moree)):?>
                            <div class="col-md-5">
                                <div style="overflow:auto">
                                    <details open> 
                                        <summary>Addresses</summary>
                                        <ul class="list-group ml-3 text-secondary mt-1" style='max-height:25vh;overflow-y:auto'>
                                            
                                            <?php foreach (unserialize($moree->address) as $key) :?>
                                                <li class='list-group-item m-0 p-0 border-0'><?=$key?></li>
                                            <?php endforeach?>
                                        </ul>
                                    </details> 
                                    <details open>
                                        <summary>Subject</summary>
                                        <p class='ml-3 text-secondary mt-1'><?=$moree->subject?></p>
                                    </details> 
                                    <details >
                                        <summary>Message</summary>
                                        <div class='ml-3 text-secondary mt-1'><?=$moree->message?></div>
                                    </details> 
                                    <details open>
                                        <summary>Additional Info.</summary>
                                        <ul class='ml-3 mt-1 text-secondary list-unstyled'>
                                            <li>
                                                <span>Status</span>
                                                <span class="badge badge-light small"><?=$moree->status?></span>
                                            </li>
                                            <?php foreach (unserialize($moree->meta) as $key => $value) :?>
                                                <li>
                                                    <span><?=$key?></span>
                                                    <span class="badge badge-light small"><?=$value?></span>
                                                </li>
                                            <?php endforeach?>
                                        </ul>
                                    </details> 
                                </div>
                            </div>  
                            <?php endif?>         
                            <div class="col-md-7">
                                <div class="table-responsive-sm ">
                                    <?=form_open("bulk/email-history",["onsubmit"=>"return confirm('Sure you want to delete?')"])?>
                                        <input type="hidden" name="_method" value="DELETE" />
                                            
                                        <table class="table small">
                                            <thead>
                                                <tr>
                                                    <th class='text-nowrap'>S/N</th>
                                                    <th class='text-nowrap'>Subject</th>
                                                    <th class='text-nowrap'>Status</th>
                                                    <th class='text-nowrap'>Total Recepients</th> 
                                                    <th class='text-nowrap'>Time Sent</th> 
                                                    <th class='text-nowrap'></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i = 1;
                                                foreach ($historye as $key):?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input id="<?=$key->id?>" class="custom-control-input" type="checkbox" name="checkbox[]" value="<?=$key->id?>">
                                                            <label for="<?=$key->id?>" class="custom-control-label"><?=$i++?></label>
                                                        </div>
                                                    </td>
                                                    <td><?=$key->subject?>
                                                        <span class="text-muted d-none d-md-block"><?=ellipsize($key->message,70)?></span>
                                                    </td>
                                                    <td><?=$key->status?>
                                                    
                                                    </td>
                                                    <td class='text-center'><?=count(unserialize($key->address))?></td>
                                                    <td><?=date("F d Y h:ia",strtotime($key->created_at))?></td>
                                                    <td><a href="?id=<?=$key->id?>&type=email#animated-underline-email" class=''><i class="flaticon-right-arrow-12   "></i></a></td>
                                                </tr>
                                                <?php endforeach?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan='6'>
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
</div>
<?=$this->endSection()?>