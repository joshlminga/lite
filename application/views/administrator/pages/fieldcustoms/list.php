            <section id="content">
                <div class="container">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <h2><?= ucwords('Customfields'); ?> <small>click manage icon to get Field lists</small></h2>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($dataList)): ?>                                
                        <div class="table-responsive">
                            <div class="buld-action">
                                <!-- Notification -->
                                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                            </div>
                            <table id="data-table-command-manage" class="table table-striped table-vmiddle">
                                <thead>
                                    <tr>                                        
                                        <?php 
                                            $array = get_object_vars($dataList[0]);
                                            $ths = array_keys($array);
                                        ?>
                                        <?php for ($i=0; $i < count($ths); $i++): ?>
                                            <?php if ($i==0): ?>
                                            <th data-column-id="id" data-type="numeric">ID</th>
                                            <?php else: ?>
                                            <th data-column-id="<?= $ths[$i]; ?>" data-order="desc">
                                                <?= ucwords(str_replace("_", " ",$ths[$i]));?>                                                    
                                            </th>
                                            <?php endif ?>
                                        <?php endfor ?>
                                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i=0; $i < count((array)$dataList); $i++): ?>
                                    <tr>
                                        <?php for ($k=0; $k < count($ths); $k++):  $key = $ths[$k];?>
                                            <?php $active_column = strtolower($this->plural->singularize($Module)).'_'.'flg'; ?>
                                            <?php if ($key == 'status' || $key == $active_column): ?>
                                                    <?php if ($dataList[$i]->$key == 1): ?>
                                                        <td> Active </td>
                                                    <?php else: ?>
                                                       <td> Deactivated </td>
                                                    <?php endif ?>
                                            <?php else: ?> 
                                                <td><?= $dataList[$i]->$key; ?></td>
                                            <?php endif ?>                                                  
                                        <?php endfor ?>
                                    </tr>
                                    <?php endfor ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <div class="buld-action">
                                <div class="row mag-0">
                                    <hr>
                                        <p class="text-center"><strong>This request current has no data</strong></p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                    </div>
                    
                </div>
            </section>
