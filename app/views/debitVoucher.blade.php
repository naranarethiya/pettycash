 <section class="padder m-t bg-white">
      <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6" style="text-align:center"><h2>DEBIT VOUCHER</h2></div>
        <div class="col-xs-3"></div>
      </div>

      <div class="row">
        <div class="col-xs-6">
            <p class="m-t m-b">
              Pay to :
              <strong>{{$data->source}}</strong>
              <br>Branch :
              <strong>{{$data->branche}}</strong>
            </p>
        </div>
        <div class="col-xs-6 text-right">
          <p class="m-t m-b">
            Trans.No. :
              <strong>{{$data->tid}}</strong>
              <br>Date :
              <?php $date=date('d/m/Y',strtotime($data->date)); ?>
              <strong>{{$date}}</strong>
            </p>

        </div>

      </div>

        <div class="line"></div>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="60">SR.</th>
              <th style="text-align:center">PARTICULAR</th>
              <th width="100">RS. </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>

              <td>{{$data->note}}</td>

              <td>{{$data->amount}}</td>
            </tr>
            <tr>
              <td colspan="2" class="text-right">
                <strong>
                  Total
                </strong>
              </td>
              <td>
                <strong>{{$data->amount}}</strong>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="line"></div>
        <div class="row">
            <div class="col-xs-4">
              <strong>Prepared by :</strong><br/><br/>

              <strong>Approved by :</strong>
            </div>
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
              <strong>Reciever's Signature :</strong>
            </div>
        </div><br/><br/><br/>
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
