$(document).ready(function(){
  // Lấy dữ liệu từ thuộc tính HTML để vẽ biểu đồ
  var days = JSON.parse($('#data-statistics').attr('days'));
  var parameters = JSON.parse($('#data-statistics').attr('parameters'));

  $(function () {
      //---------------------
      //- VẼ BIỂU ĐỒ CỘT CHỒNG -
      // - Tạo dữ liệu biểu đồ cột từ days (nhãn) và parameters (doanh thu)
      // - Sử dụng Chart.js để vẽ biểu đồ cột chồng trên canvas #stackedBarChart
      // - Cấu hình responsive và trục X/Y để hỗ trợ chồng dữ liệu
      //---------------------
      var areaChartData = {
          labels  : days,
          datasets: [
              {
                  label               : 'Doanh Thu',
                  backgroundColor     : 'rgba(92,123,217,0.9)',
                  borderColor         : 'rgba(60,141,188,0.8)',
                  pointRadius         : false,
                  pointColor          : 'rgba(210, 214, 222, 1)',
                  pointStrokeColor    : '#c1c7d1',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data                : parameters
              },
          ]
      }

      // Tạo dữ liệu cho biểu đồ cột chồng
      var barChartData = $.extend(true, {}, areaChartData);
      var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
      var stackedBarChartData = $.extend(true, {}, barChartData);

      var stackedBarChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          scales: {
              xAxes: [{
                  stacked: true,
              }],
              yAxes: [{
                  stacked: true
              }]
          }
      }

      // Khởi tạo biểu đồ cột chồng
      new Chart(stackedBarChartCanvas, {
          type: 'bar',
          data: stackedBarChartData,
          options: stackedBarChartOptions
      });
  });

  //---------------------
  //- VẼ BIỂU ĐỒ TRÒN SẢN PHẨM BÁN CHẠY -
  // - Lấy dữ liệu từ thuộc tính label và data của #pieChart
  // - Sử dụng Chart.js để vẽ biểu đồ tròn trên canvas #pieChart
  // - Cấu hình màu nền cho từng phần và responsive
  //---------------------
  var lableBestSellProduct = JSON.parse($('#pieChart').attr('label'))
  var dataBestSellProduct = JSON.parse($('#pieChart').attr('data'))
  var donutData        = {
      labels: lableBestSellProduct,
      datasets: [
          {
              data: dataBestSellProduct,
              backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#CC6699', '#00DD00', '#001100', '#FFFF33'],
          }
      ]
  }

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData        = donutData;
  var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
  }

  // Khởi tạo biểu đồ tròn
  new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
  })

  //---------------------
  //- KHỞI TẠO DATERANGEPICKER -
  // - Lấy tham số reservation từ URL hoặc dùng ngày đầu/cuối tháng hiện tại
  // - Cấu hình DateRangePicker với ngôn ngữ tiếng Việt và giới hạn 30 ngày
  // - Gắn vào phần tử #reservation để chọn khoảng thời gian
  //---------------------
  let dateParam = getQueryParam('reservation')
  if (dateParam === null) {
      dateParam = getFirstAndLastDayOfCurrentMonth();
  }
  $('#reservation').daterangepicker(
      {
          locale: {
              format: 'DD/MM/YYYY',
              applyLabel: 'Áp dụng',
              cancelLabel: 'Hủy',
              monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
          },
          startDate: dateParam.firstDay,
          endDate: dateParam.lastDay,
          maxSpan: {
              "days": 30
          },
      }
  )

});

//--------------------
//- LẤY NGÀY ĐẦU VÀ CUỐI THÁNG HIỆN TẠI -
// - Trả về đối tượng chứa ngày đầu (firstDay) và ngày cuối (lastDay) của tháng hiện tại
// - Định dạng chuỗi: DD/MM/YYYY
//--------------------
function getFirstAndLastDayOfCurrentMonth() {
  const now = new Date();

  // Lấy năm và tháng hiện tại
  const year = now.getFullYear();
  const month = now.getMonth();

  // Ngày đầu tiên của tháng hiện tại
  const firstDay = new Date(year, month, 1);

  // Ngày cuối cùng của tháng hiện tại
  const lastDay = new Date(year, month + 1, 0);

  return {
      firstDay: firstDay.getDate() + '/' + (month + 1) + '/' + year,
      lastDay: lastDay.getDate() + '/' + (month + 1) + '/' + year
  };
}

//--------------------
//- LẤY THAM SỐ TỪ URL -
// - Lấy tham số (ví dụ: reservation) từ URL
// - Trả về đối tượng chứa firstDay và lastDay nếu tham số tồn tại, ngược lại trả về null
//--------------------
function getQueryParam(param) {
  const url = window.location.href;
  // Tạo một đối tượng URL từ chuỗi URL
  const urlObj = new URL(url);

  // Sử dụng phương thức searchParams để lấy giá trị của tham số
  const paramValue = urlObj.searchParams.get(param);

  if (paramValue === null) {
      return null;
  }

  return {
      firstDay: paramValue.split(' - ')[0],
      lastDay: paramValue.split(' - ')[1]
  };
}