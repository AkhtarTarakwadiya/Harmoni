// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Fetch engagement data dynamically
fetch("./ajax/fetch_engagement_pie_chart.php") // Ensure the correct path
  .then(response => response.json())
  .then(data => {
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: data.labels, // ["Likes", "Comments", "Shares"]
        datasets: [{
          data: data.data, // [total_likes, total_comments, total_shares]
          backgroundColor: data.colors, // ['#4e73df', '#1cc88a', '#e74a3b']
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
          display: false // Hide legend (removes Likes, Comments, Shares text)
        },
        cutoutPercentage: 70, // Adjusted for better visibility
      },
    });
  })
  .catch(error => console.error("Error loading pie chart data:", error));
