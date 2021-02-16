        <div class="row">
            <form action="" class="w-100">
                <div class="col-12 step step-1 active">
                    <h3 id="title">
                        <span id="choose-agenda">Choose a Agenda</span>
                    </h3>
                    <!--<div class="date-input" id="date-input"></div>-->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Reservation Description</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($agendas as $agenda): 
						    $date = explode(' ', $agenda->ReservationDateTime)[0];
							$dateFormat = str_replace('-', '', $date);?>
                            <tr>
                                <td><a style="color: #212529;text-decoration: none;"
                                        href="<?php echo base_url(); ?>agenda_booking/spots/<?php echo $dateFormat; ?>/<?php echo $agenda->id; ?>"><?php echo $agenda->ReservationDescription; ?></a>
                                </td>
                                <td><?php echo $date; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </form>
        </div>