<?php $this->load->view("template_header"); ?>

<h1> VMs requests </h1>

<?php echo form_open('vm_requests'); ?>

<div id="machines">
<div class="machine col-md-12">
<table class="auto table" id="machines_table">
    <thead>
        <tr>
            <th>Request No.</th>
            <th>Operating System</th>
            <th>Memory RAM</th>
            <th>Storage</th>
            <th>Number of VM</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($requests as $request):?>
        <tr>
            <td>
                <select name="key" style="width: 80px">
                <?php 
                   echo '<option>'.$request->id.'</option>'
                ?>
                </select>
            </td>
            <td>
                <select name="os" style="width: auto">
                <?php 
                    $oses = array(
                        'Windows Server 2008',
                        'Ubuntu Server',
                        'Windows Server 2003'
                    );
                        
                        foreach($oses as $os){
                            if($request->OS === $os)
                                echo'<option selected="selected">'.$os.'</option>';
                            else{
                             echo'<option>'.$os.'</option>';
                            }
                        }
                ?>
                </select>
            </td>
            <td>
                <select name="ram" style="width: 80px">
                <?php 
                    $rams = array(
                        2,
                        4,
                        8,
                        12,
                        16
                    );
                    
                        foreach($rams as $ram){
                            if($request->RAM == $ram)
                                echo'<option selected="selected">'.$ram.'</option>';
                            else{
                             echo'<option>'.$ram.'</option>';
                            }
                        }
                ?>    
                </select>
            </td>
            <td>
                <select name="hdd" style="width: 80px">
                <?php
                        $hdds = array(
                            8,
                            12,
                            16,
                            20,
                            24,
                            30
                        );
                        
                            foreach($hdds as $hdd){
                                if($request->storage == $hdd)
                                    echo'<option selected="selected">'.$hdd.'</option>';
                                else{
                                 echo'<option>'.$hdd.'</option>';
                                }
                            }
                  ?>
                </select>
            </td>
            <td>
                <select name="qty" style="width: 80px">
                    <?php
                        $gtys = array(
                            1,
                            2,
                            3,
                            4,
                            5,
                            6,
                            7,
                            8,
                            9
                        );
                        
                            foreach($gtys as $qty){
                                if($request->numb_vm == $qty)
                                    echo'<option selected="selected">'.$qty.'</option>';
                                else{
                                 echo'<option>'.$qty.'</option>';
                                }
                            }
                    ?>
                </select>
            </td>
            <td>
                <select name="status" style="width: auto">
                    <?php 
                    $status = array(
                            'PENDING',
                            'APPROVED',
                            'DENIED'
                        );
                        
                            foreach($status as $st){
                                if($request->status == $st)
                                    echo'<option value ='.$st.' selected="selected">'.$st.'</option>';
                                else{
                                 echo'<option value="'.$st.'">'.$st.'</option>';
                                }
                            }
                    ?>
                </select>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
</div>
<label for="usr">email address:</label>

<?php
    echo form_input(array(
        'id' => 'email_address',
        'name' => 'email_address',
        'type' => 'email',
        'placeholder' => 'email@example.com',
        'value' => set_value('email_address'),
        'title' => 'Email address'
    ));
?>

<!--<input  type="text" id="email_address" class="form-control"/>-->
<button id="submitRequests" type="button" class="btn btn-default pull-right">Submit</button>
</div>
<br>

<script>
$('#submitRequests').click(function(){
    console.log("Clicked submit");
    var data = getTableContent();
//    var email = getEmail(); //$("#emailInput").val();
    console.log("machines: ");
    console.log(data);
    var john_email = $("#email_address").val();
    if(isEmail(john_email)){
        uploadMachines(data);
//        //uploadEmail(email);
    }
    else 
        alert("Incorrect email");
});

//function uploadEmail(email){
//    $ajax({
//        type: "POST",
//        url: "./vm-request",
//        data: JSON.stringify(email),
//        dataType: "json",
//        success: function(response){
//            console.log("response");
//            console.log(response);
//        }
//    });
//}

function uploadMachines(machineList){
    $.ajax({
        type: "POST",
        url: "./vm-request",
        data: JSON.stringify(machineList),
        dataType: "json",
        success: function(response){
            console.log("response");
            console.log(response);
            if(response.success){
                //do page reload when success
                location.reload();
            }else{
                //show meassage when not success
                alert("Upload Failed");
            }
        }
    });
}

function getTableContent() {
    var data = [];
    var table = $('#machines_table tbody tr');
    for(var i = 0 ; i< table.length;i++){
        var row = table.eq(i);
        var key = row.find('[name="key"]').val();
        var os = row.find('[name="os"]').val();
        var ram = row.find('[name="ram"]').val();
        var hdd = row.find('[name="hdd"]').val();
        var qty = row.find('[name="qty"]').val();
        var status = row.find('[name="status"]').val();
        var obj = {
            "key":key,
            "os":os,
            "ram":ram,
            "hdd":hdd,
            "qty":qty,
            "status":status
        };
        data.push(obj);
    }
    return data;
}

//function getEmail(){
//    var data = [];
//    var email  = $("#emailInput").val();
//    var obj ={
//        "email":email
//    };
//    data.push(obj);
//    return data;
//}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
</script>
<?php echo form_close(); ?>



<?php $this->load->view("template_footer"); ?>




<!--
<?php 
    function generateSelect($name = '', $options = array(), $default = '') {
    $html = '<select name="'.$name.'">';
    foreach ($options as $option => $value) {
        if ($option == $default) {
            $html .= '<option value='.$value.' selected="selected">'.$option.'</option>';
        } else {
            $html .= '<option value='.$value.'>'.$option.'</option>';
        }
    }

    $html .= '</select>';
    return $html;
    $html = generateSelect('os', $oses, $request->OS); /*call statement*/
}
?>

    echo("<div>");
    
    echo form_label('email address: ');
     echo form_submit(array(
                         'id' => 'submitRequests',
                         'type' => 'Submit',
                         'class' => 'btn btn-info',
                         'value' => 'submit',
                         'class' => 'btn btn-default pull-right'
                         ));
  echo("</div>");
-->
