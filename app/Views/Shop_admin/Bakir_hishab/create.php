<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>বাকির হিসাব</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Shop create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Shops create</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo session()->getFlashdata('message'); //echo  isset(newSession()->message) ? newSession()->message :''; ?>
                                </div>
                                <div class="col-md-5">
                                    <form action="<?php echo base_url('shop_admin/bakir_hishab/create_action'); ?>"
                                        method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="varchar">Account Holder</label>
                                            <select class="form-control" onchange="lonProvTransView(this.value)" name="loan_pro_id" id="status">
                                                <option value="0">Please Select</option>
                                                <?php echo getAllListInOption('loan_pro_id', 'loan_pro_id', 'name', 'loan_provider'); ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="int">Particulars </label>
                                            <textarea class="form-control" name="particulars" rows="3"
                                                placeholder="Particulars"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="longtext">Trangaction Type </label>
                                            <select class="form-control" name="trangaction_type" name="status"
                                                id="status"  onchange="changepaymenttype(this.value)">
                                                <option value="">Please Select</option>
                                                <option value="1">খরচ (Cr.)</option>
                                                <option value="2">জমা (Dr.)</option>
                                            </select>
                                        </div>
                                        <div class="form-group"  id="paymentloPo">
                                            <label for="paymentType">Payment Type</label>
                                            <select class="form-control" name="payment_type" onchange="checkBank(this.value)" id="paymentType">
                                                <option value="">Please Select</option>
                                                <option value="1">Chaque/Bank</option>
                                                <option value="2">Cash</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group" id="databankloPo">
                                            <label for="enum">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount"
                                                placeholder="Amount" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="enum">Image</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                placeholder="Image" required />
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <a href="<?php echo site_url('/') ?>" class="btn btn-danger">Cancel</a>
                                    </form>

                                </div>
                                <div class="col-7">
                                <div id="lonProvData"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function checkBank(id) {
        if (id == 1) {
            var view = '<div class="form-group"><label for="varchar">Bank </label><select class="form-control" name="bank_id"><option  required>Please select</option value=""></select></div><div class="form-group" id="chaque"><label for="int">Amount </label><input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" required /> </div>';

            $(".databank").html(view).show();
            $("#databankSup").html(view).show();
            $("#databankLc").html(view).show();
            $("#dataexpense").html(view).show();
            $("#databankloPo").html(view).show();
            $("#employee").html(view).show();
            $("#vatpayId").html(view).show();
            $("#sellerCommId").html(view).show();
            $("#deliBoy").html(view).show();
        }

        if (id == 3) {
            var view2 = '<div class="form-group" ><label>Cheque</label><input type="text" class="form-control" name="chequeNo" id="chequeNo" placeholder="Input Cheque No "></div><div class="form-group" ><label>Cheque Amount</label><input type="text" onchange="cheque()" class="form-control chequeAmount" name="chequeAmount" id="chequeAmount" placeholder="Input Cheque Amount " required ><b id="cheque_valid"></b></div>';
            $("#chaque").html(view2).show();
            $("#databankSup").html(view2).show();
        }

        if (id == 2) {
            var view3 = '<div class="form-group" id="chaque"><label for="int">Amount </label><input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" required /> </div>';
            $(".databank").html(view3).show();
            $("#databankSup").html(view3).show();
            $("#databankloPo").html(view3).show();
            $("#databankLc").html(view3).show();
            $("#dataexpense").html(view3).show();
            $("#employee").html(view3).show();
            $("#vatpayId").html(view3).show();

        }
    }

    //loan provider ledger view (start)
    function lonProvTransView(Id){
        $.ajax({
          type: "POST",
          url: "http://localhost/amar_bangla_old/shop_admin/index.php/transaction/lonProvData", 
          data: {lonProvId: Id}, 
          success: function(html){                    
            $("#lonProvData").html(html).show(); 
          }
        });
      }
      //loan provider ledger view (end)

      //transaction account holder payment type change (start)
     function changepaymenttype(Id)
     {
        if (Id == 2) {
          var view = '<div class="form-group"><label for="payment_type">Payment Type </label><select class="form-control" onchange="checkBank2(this.value)" name="payment_type" required><option value="" >Please Select</option><option value="1"  >Bank</option><option value="3"  >Chaque</option><option value="2" >Cash</option></select></div>'
          $("#paymentloPo").html(view).show();
        }else{
          view ='<div class="form-group" id="paymentloPo"><label for="payment_type">Payment Type </label><select class="form-control" onchange="checkBank(this.value)" name="payment_type"><option value="" >Please Select</option><option value="1"  >Chaque/Bank</option><option value="2" >Cash</option></select></div>';

          $("#paymentloPo").html(view).show();
          $("#paymentCus").html(view).show();
          $("#paymentsup").html(view).show();
        }
     }
     //transaction account holder payment type change (end)

</script>