 <section class="padder m-t bg-white">
      <div class="row">
        <div class="col-xs-3"></div>
        <?php $date=date('d/m/Y',strtotime($date)); ?>
        <div class="col-xs-6" style="text-align:center"><h2>{{$date}}</h2></div>
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
              <th width="60">SR.</th>
              <th style="text-align:center">PARTICULAR</th>
              <th width="100">AMOUNT</th>
            </tr>
          </thead>
          <tbody>
          	<?php $i=1; $total_creadit=0; $total_debit=0;?>
          	@foreach($data as $row)
          		@if($row->type=="receipt")
	          		<tr>
	          			<td>{{$i}}</td>
	          			<td>{{$row->source}} <br/> {{$row->note}}</td>
	          			<td>{{$row->amount}}</td>
	          		</tr>
	          		<?php $total_creadit+=$row->amount; ?>
	      			<?php $i++; ?>
      			@else 
      				<?php $total_debit+=$row->amount; ?>
          		@endif

          	@endforeach

          	<tr>
      			<td colspan="2"><strong>Opening Balance</strong></td>
      			<td><strong>{{$openingBalance}}</strong></td>
      		</tr>
          		<tr>
          			<td colspan="2"><strong>Total Credit</strong></td>
          			<td><strong>{{$total_creadit}}</strong></td>
          		</tr>
          		<tr>
          			<td colspan="2"><strong>Total Debit</strong></td>
          			<td><strong>{{$total_debit}}</strong></td>
          		</tr>
          		<tr>
          			<td colspan="2"><strong>Closing Balance</strong></td>
          			<td><strong>{{$closingBalance}}</strong></td>
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
              <th width="60">SR.</th>
              <th style="text-align:center">PARTICULAR</th>
              <th width="100">AMOUNT</th>
            </tr>
          </thead>
          <tbody>
          	<?php $i=1; ?>
          	@foreach($data as $row)
          		@if($row->type=="expense")
	          		<tr>
	          			<td>{{$i}}</td>
	          			<td>{{$row->source}} <br/>{{$row->note}}</td>
	          			<td>{{$row->amount}}</td>
	          		</tr>
	      			<?php $i++; ?>
          		@endif
          	@endforeach
          	</tbody>
        </table>
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
	</style>