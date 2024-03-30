 <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <p>
         &copy; Copyright <a href="">DB Store</a> - Đã đăng ký bản quyền.
        </p>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    <script type="text/javascript">
       $(document).ready(function(){
            day365();
            var chart = new Morris.Bar({
                // ID of the element in which to draw the chart
                element: 'myfirstchart',
                parseTime: false,
                // The name of the data record attribute that contains x-values.
                xkey: 'date',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['revenue', 'quantity'],
                // Labels for the ykeys -- will be displayed when you hover over the chart.
                labels: ['Doanh thu', 'Số lượng']
            });

            $('.btn-locngay').click(function(){
                var from_date = $('.date_from').val();
                var from_to = $('.date_to').val();
                $.ajax({
                    url: "../ajax/thongke.php",
                    type: 'post',
                    dataType: "JSON",
                    cache: false,
                    data:{from_date:from_date, from_to:from_to},
                    success:function(data){
                        chart.setData(data); // Fix the variable name here
                    }
                });
            })

            $('.select-thongke').change(function(){
                var thoigian = $(this).val();
                if(thoigian == '7ngay'){ // thời gian theo ngày
                    var text = '7 ngày qua';
                }else if(thoigian == '30ngay'){ 
                    var text = '30 ngày qua';
                }else if(thoigian == '90ngay'){ 
                    var text = '90 ngày qua';
                }else {
                    var text = '365 ngày qua';
                }
                $('#text-date').text(text);
                $.ajax({
                    url: "../ajax/thongke.php",
                    type: 'post',
                    dataType: "JSON",
                    cache: false,
                    data:{thoigian:thoigian},
                    success:function(data){
                        chart.setData(data); // Fix the variable name here
                    }
                });
            })

            function day365(){
                var text = '365 ngày qua';
                $('#text-date').text(text); // mặc định dữ liệu thống kê theo 365 ngày
                $.ajax({
                    url: "../ajax/thongke.php",
                    method: 'POST',
                    dataType: "JSON",
                    cache: false,
                    success:function(data){
                        chart.setData(data); // Fix the variable name here
                    }
                });
            }
        });

    </script>

</body>
</html>
