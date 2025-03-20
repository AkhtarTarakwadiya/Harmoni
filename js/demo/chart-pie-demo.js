function fetchPieChartData(period = 'all') {
  // console.log("Fetching data for period:", period); // Debugging log

  fetch(`./ajax/fetch_engagement_pie_chart.php?period=${period}`)
      .then(response => response.json())
      .then(data => {
          // console.log("Response received:", data); // Debugging log

          if (data.error) {
              console.error("Error from backend:", data.error);
              return;
          }

          var ctx = document.getElementById("myPieChart").getContext("2d");

          // Destroy previous chart instance if it exists
          if (window.myPieChartInstance) {
              window.myPieChartInstance.destroy();
          }

          // Create a new pie chart
          window.myPieChartInstance = new Chart(ctx, {
              type: 'doughnut',
              data: {
                  labels: data.labels,
                  datasets: [{
                      data: data.data,
                      backgroundColor: data.colors,
                      hoverBackgroundColor: ["#2e59d9", "#17a673", "#b71c1c"],
                      hoverBorderColor: "rgba(234, 236, 244, 1)",
                  }],
              },
              options: {
                  maintainAspectRatio: false,
                  tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      caretPadding: 10,
                  },
                  legend: {
                      display: false
                  },
                  cutoutPercentage: 70,
              },
          });
      })
      .catch(error => console.error("Error loading pie chart data:", error));
}

// Fetch initial chart data
fetchPieChartData();

// Change chart when dropdown value changes
document.getElementById("engagementFilter").addEventListener("change", function () {
  // console.log("Dropdown changed to:", this.value); // Debugging log
  fetchPieChartData(this.value);
});
