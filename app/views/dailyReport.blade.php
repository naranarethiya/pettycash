<?php $date=date('d M Y',strtotime($date)); ?>
 <section class="padder m-t bg-white">
      <div class="row">
        <div class="col-xs-6" style="text-align:center"><h3>{{$date}}</h3></div>
        <div class="col-xs-6" style="text-align:center">
			<h3><?php echo date('l',strtotime($date)); ?></h3>
		</div>
      </div>

      <div class="line"></div>
      <div class="row">
      		<!--<div class="col-xs-6">-->
      <table>
        <tr>
          <td style="width:49%" valign="top">
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
              <td colspan="2"><strong>Total Credit + Opening Balance </strong></td>
              <td><strong>{{$total_creadit + $openingBalance}}/-</strong></td>
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
          </td>
          <td style="width:1%"></td>
          <td style="width:50%">
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
                        echo'<td><b>'.$row->expense_type.'</b> - '.$row->note.'</td>';
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
                              <tr><td colspan="2"><b>'.$row->source.' - '.$row->branche.'</b></td></tr>
                              <tr>
                                <td><b>'.$row->expense_type.'</b> - '.$row->note.'</td>
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
              <td><strong>{{$total_debit}}/-</strong></td>
              <td><strong>Total Debit</strong></td>
            </tr>
          </tbody>
        </table>
          </td>
        </tr>
      </table>

    <!--</div>-->
     <!--<div class="col-xs-6">-->
      	
    <!--</div>-->
      </div>
      <div class="row">
             <div class="col-xs-11"></div>
             <div class="col-xs-1">
                <button onclick="window.print();" class="btn btn-danger printNono">PRINT</button>
             </div>
        </div>
</section>

<style type="text/css" media="print">
  table { page-break-inside:auto }
  @page {
  size: auto;   /* auto is the current printer page size */
  margin: 2mm;  /* this affects the margin in the printer settings */
  }
  body {
  background-color:#FFFFFF;
  margin: 5px;  /* the margin on the content before printing */
  }
  .printNono {
  display: none !important;
  }
  .nav-primary {
  width:1px;
  display: none !important;
  visibility:hidden;
  }
  tr.row_table {
    page-break-inside: avoid;
  }
  tr {
    page-break-inside: auto;
  }
</style>