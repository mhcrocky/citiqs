

<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="background: none;" class="card p-4">

                    <div class="card-body">

                    
                    
                        <div class="row">


                            <!-- Events Select Box -->
                            <div class="col-md-9">
                                <select id="events" name="events" onchange="getEventGraph()"
                                        style="background-color: #f4f3f3 !important; border-radius: 0px !important;font-weight: 510;"
                                        class="form-control w-100 mb-5" required>
                                    <?php if(is_array($events) && count($events) > 0): ?>
                                        <?php foreach($events as $event): ?>
                                            <option class="font-weight-bold" value="<?php echo $event['id']; ?>"><?php echo date('d/m/Y', strtotime($event['StartDate'])); ?> - <?php echo $event['eventname']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- End Events Select Box -->

                            <!-- Datetime Picker Box -->
                            <div class="col-md-3">
                                <input style="border-radius: 0px !important;" onchange="getEventGraph()" class="form-control mb-2 w-100" type="text" name="datetimes" />
                            </div>
                            <!-- Datetime Picker Box -->



                            <!-- Graph -->
                            <div id="graph" style="background: #fff; visibility: hidden" class="w-100">
                                <?php echo isset($graph) ? $graph : ''; ?>
                            </div>
                            <!-- End Graph -->

                            
                        
                        </div>




                    </div>

                </div>
            </div>
        </div>
    </div>
</main>