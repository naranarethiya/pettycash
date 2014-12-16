 <section class="padder m-t bg-white">
      <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6" style="text-align:center"><h3>DEBIT VOUCHER</h3></div>
        <div class="col-xs-3"></div>
      </div>

      <div class="row">
        <div class="col-xs-6">
            <p class="m-t m-b">
              Pay to : 
              <strong>{{$data[0]->source}}</strong>
              <br>Branch :
              <strong>{{$data[0]->branche}}</strong>
            </p>
        </div>
        <div class="col-xs-6 text-right">
          <p class="m-t m-b">
            Trans. No. :
              <strong>TRANS-{{$data[0]->tid}}</strong>
              <br>Date :
              <?php $date=date('d, M Y',strtotime($data[0]->date)); ?>
              <strong>{{$date}}</strong>
            </p>

        </div>

      </div>

        <div class="line"></div>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="90">SR. No.</th>
              <th style="text-align:center">PARTICULAR</th>
              <th width="100">RS. (INR) </th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; ?>
            @foreach($data as $row)
            <tr>
              <td>{{$i}}</td>

              <td>{{$row->expense_type}} <br/> {{$row->note}}</td>

              <td>{{$row->amount}}</td>
            </tr>
            <?php $i++; ?>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>TOTAL AMT.</th>
              <th>{{convert_number_to_words(round($data[0]->total_amount))}}</th>
              <th>
                <strong>{{$data[0]->total_amount}}/-</strong>
              </th>
            </tr>
          </tfoot>
        </table>
        <div class="line"></div>
        <div class="row">
            <div class="col-xs-5">
              <strong>Prepared by :</strong> <input class="txtBox" type="textbox" /><span style="dispaly:none" class="txtBoxValue"></span><br/><br/>

              <strong>Approved by :</strong> <input class="txtBox2" type="textbox" /><span style="dispaly:none" class="txtBoxValue2"></span>
            </div>
            <div class="col-xs-3"></div>
            <div class="col-xs-4">
              <strong>Reciever's Signature :</strong>
            </div>
            
        </div>
        <div class="row">
             <div class="col-xs-11"></div>
             <div class="col-xs-1">
                <button onclick="window.print();" class="btn btn-danger printNono">PRINT</button>
             </div>
        </div>
        <br/><br/><br/>
</section>
 <style type="text/css" media="print">
        @page 
        {
            size: auto;   /* auto is the current printer page size */
            margin: 1mm;  /* this affects the margin in the printer settings */
        }
		input[type='textbox'] {
			display:none;
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
<script>
  $(function() {
        $('.txtBoxValue').on('click', function() {
            $(this).hide();
            $('.txtBox').show();
        });
    
        $('.txtBox').on('blur', function() {
            var that = $(this);
            $('.txtBoxValue').text(that.val().toUpperCase()).show();
            that.hide();
        });

        $('.txtBoxValue2').on('click', function() {
            $(this).hide();
            $('.txtBox2').show();
        });
    
        $('.txtBox2').on('blur', function() {
            var that = $(this);
            $('.txtBoxValue2').text(that.val().toUpperCase()).show();
            that.hide();
        });
    });
</script>