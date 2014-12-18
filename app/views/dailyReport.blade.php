 <section class="padder m-t bg-white">
      <div class="row">
        <div class="col-xs-3"></div>
        <?php $date=date('d M Y',strtotime($date)); ?>
        <div class="col-xs-6" style="text-align:center"><h3>{{$date}}</h3></div>
        <div class="col-xs-3"></div>
      </div>

      <div class="line"></div>
      <div class="row">
      		<div class="col-xs-6">
      	<table class="table table-bordered">
          <thead>
          	<tr>
              <th colspan="3" style="text-align:center">Credit</th>
          	</tr>
            <tr>
              <th width="60">SR. NO.</th>
              <th style="text-align:center">PARTICULARS</th>
              <th width="100">AMOUNT</th>
            </tr>
          </thead>
          <tbody>
          	<?php $i=1; $total_creadit=0; $total_debit=0;?>
          	@foreach($data as $row)
          		@if($row->type=="receipt")
	          		<tr>
	          			<td>{{$i}}</td>
	          			<td>{{$row->source}} <br/> {{$row->main_note}}</td>
	          			<td>{{$row->total_amount}}</td>
	          		</tr>
	          		<?php $total_creadit+=$row->total_amount; ?>
	      			<?php $i++; ?>
      			@else 
      				<?php $total_debit+=$row->amount; ?>
          		@endif

          	@endforeach

          	<tr>
      			<td colspan="2"><strong>Opening Balance</strong></td>
      			<td><strong>{{$openingBalance}}/-</strong></td>
      		</tr>
          		<tr>
          			<td colspan="2"><strong>Total Credit</strong></td>
          			<td><strong>{{$total_creadit}}/-</strong></td>
          		</tr>
          		<tr>
          			<td colspan="2"><strong>Total Debit</strong></td>
          			<td><strong>{{$total_debit}}/-</strong></td>
          		</tr>
          		<tr>
          			<td colspan="2"><strong>Closing Balance</strong></td>
          			<td><strong>{{$closingBalance}}/-</strong></td>
          		</tr>
          	</tbody>
        </table>
    </div>
     <div class="col-xs-6">
      	<table class="table table-bordered">
          <thead>
          	<tr>
              <th colspan="3" style="text-align:center">Debit</th>
          	</tr>
            <tr>
              <th width="60">AMOUNT</th>
              <th style="text-align:center">PARTICULARS</th>
            </tr>
          </thead>
          <tbody>
          	<?php 
              $i=0; 
              $tid=0;
            ?>
          	@foreach($data as $row)
          		@if($row->type=="expense")
                  <?php 
                    if($tid==$row->tid) {
                      echo"<tr>";
                        echo'<td>'.$row->expense_type.', '.$row->note.'</td>';
                        echo"<td>".$row->amount."</td>";
                      echo"</tr>";
                    }
                    else {
                      if($i!='0') {
                        echo"</table>";
                      }
                        echo'<tr>
                          <td> '.$row->total_amount.' </td>
                          <td style="padding:0px">
                            <table class="table table-bordered">
                              <tr><td colspan="2"><b>'.$row->source.'</b></td></tr>
                              <tr>
                                <td>'.$row->expense_type.', '.$row->note.'</td>
                                <td width="20%">'.$row->amount.'</td>
                              </tr>
                          </td>
                        </tr>';
                      $tid=$row->tid;
                      }
                  ?>
	      			<?php $i++; ?>
          		@endif
          	@endforeach
          </table>
			<tr>
				<td><strong>Total Debit</strong></td>
				<td style="text-align:right;padding-right:47px"><strong>{{$total_debit}}/-</strong></td>
			</tr>
          	</tbody>
        </table>
    </div>
      </div>
      <div class="row">
             <div class="col-xs-11"></div>
             <div class="col-xs-1">
                <button onclick="window.print();" class="btn btn-danger printNono">PRINT</button>
             </div>
        </div>
</section>

 <style type="text/css" media="print">
	@page 
	{
	size: auto;   /* auto is the current printer page size */
	margin: 1mm;  /* this affects the margin in the printer settings */
	}

	body 
	{
	background-color:#FFFFFF;
	margin: 5px;  /* the margin on the content before printing */
	}
   .printNono {
          display: None;
       }

	</style>