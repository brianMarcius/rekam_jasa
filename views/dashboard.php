<?php
    include ('config/conn.php');
    $tahun = date('Y');
    $sql = "SELECT count(idcust) customer, date_format(ins,'%c') bulan FROM `customer` where date_format(ins,'%Y')='$tahun' group by date_format(ins,'%c')";
    $query = mysqli_query($con,$sql);
    $data = array();
    while ($d = mysqli_fetch_array($query)) {
        $fetch = array();
        $fetch['bulan'] = $d['bulan'];
        $fetch['customer'] = $d['customer'];
        $data[] = $fetch;
    }


    $sql = "SELECT count(idcust) customer, date_format(exp,'%c') bulan FROM `customer` where date_format(exp,'%Y')='$tahun' group by date_format(exp,'%c')";
    $query = mysqli_query($con,$sql);
    $data1 = array();
    while ($d = mysqli_fetch_array($query)) {
        $fetch1 = array();
        $fetch1['bulan'] = $d['bulan'];
        $fetch1['customer'] = $d['customer'];
        $data1[] = $fetch1;
    }
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <center><h1 class="h3 mb-0 text-gray-800">Chart Customer</h1></center>
            <canvas id="myChart" width="4" height="1"></canvas>
        </div>
        <div class="card-body">
            
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script src="<?=base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<script>
    $(document).ready(function() {
        getDataCustomer();
    });
    function getDataCustomer(){
        $.ajax({
            url: '<?=base_url();?>config/function.php',
            method : "POST",
            data : {
                func : 'getInstallation',
            },
            dataType : "JSON",
            success : function(result){
                console.log(result);
                chartCustomer(result);
                
            }
        })
    }

    function chartCustomer(){
        
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Installation',
                    data: [
                        <?php
                        for ($i=1; $i <= 12; $i++) { 
                          $ada = "0, ";
                          foreach($data as $x){
                            if ($x['bulan']==$i) {
                              $ada = $x['customer'].", "; 
                              break;
                            }
                          }
                          echo $ada;
                        }
                    ?>
                    ],
                    backgroundColor: [
                        'rgba(0, 214, 82, 1)',
                    ],
                    borderColor: [
                        'rgba(0, 214, 82, 0.5)',
                    ],
                    borderWidth: 1
                },{
                    label: 'Non Actived',
                    data: [
                        <?php
                        for ($i=1; $i <= 12; $i++) { 
                          $ada = "0, ";
                          foreach($data1 as $x){
                            if ($x['bulan']==$i) {
                              $ada = $x['customer'].", "; 
                              break;
                            }
                          }
                          echo $ada;
                        }
                    ?>
                    ],
                    backgroundColor: [
                        'rgba(227, 54, 54, 1)',
                    ],
                    borderColor: [
                        'rgba(227, 54, 54, 0.5)',
                    ],
                    borderWidth: 1
                }
                
                
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

</script>
