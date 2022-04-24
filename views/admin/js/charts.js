$(document).ready(function () {
  $.ajax({
    method: "POST",
    url: "/dwpSocialWeb/controller/AdminViewController.php",
    data: { option: "admin-dashboard" },
  })
    .done(function (data) {
      var graphData = $.parseJSON(data);
      var pieChartLabels = [];
      var pieChartValues = [];
      var lineChartLabels = [];
      var lineChartValues = [];
      console.log(graphData);
      for (var i = 0; i < graphData[0].length; i++) {
        pieChartLabels.push(graphData[0][i]["category_name"]);
        pieChartValues.push(graphData[0][i]["total_posts"]);
      }
      for (var i = 0; i < graphData[1].length; i++) {
        lineChartLabels.push(graphData[1][i]["Month"]);
        lineChartValues.push(graphData[1][i]["num_users"]);
      }
      newChart(pieChartLabels, pieChartValues, "pie", "myPieChart", "Posts per categories");
      newChart(lineChartLabels, lineChartValues, "bar", "myLineChart", "New users");
    })
    .fail(function (error) {
      console.log(error);
    });
});

function newChart(chartLabels, charValues, type, name, label) {
  const chartData = {
    labels: chartLabels,
    datasets: [
      {
        label: label,
        data: charValues,
        backgroundColor: colors,
        hoverOffset: 4,
      },
    ],
  };

  const configChart = {
    type: type,
    data: chartData,
  };

  const pieChart = new Chart(document.getElementById(name), configChart);
}

const colors = [
  "#fafa6e",
  "#e0f470",
  "#c7ed73",
  "#aee678",
  "#97dd7d",
  "#81d581",
  "#6bcc86",
  "#56c28a",
  "#42b98d",
  "#2eaf8f",
  "#18a48f",
  "#009a8f",
  "#00908d",
  "#008589",
  "#007b84",
  "#0c707d",
  "#196676",
  "#215c6d",
  "#275263",
  "#2a4858",
];
