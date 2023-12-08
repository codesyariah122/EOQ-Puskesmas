let ctx = document.getElementById("myChart").getContext("2d");
let labels = []; // Label sumbu X
let data = []; // Data sumbu Y
let chart, label;

function initializeChart() {
  chart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: label,
          data: data,
          backgroundColor: "rgba(75, 192, 192, 0.2)",
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}

function runChart() {
  // Lakukan permintaan AJAX ke endpoint Anda untuk mendapatkan data grafik
  $.ajax({
    url: "/dashboard/chart/laporan-pembelian",
    method: "GET",
    success: function (response) {
      response.data.forEach((item) => {
        const dataPoint = `${item.jumlah} - ${item.nm_obat}`;
        data.push(item.jumlah);
        labels.push(item.nm_obat);
        label = `Jumlah Pembelian`;
      });

      monthlyData = response.monthlyData;

      // Hapus grafik yang ada
      if (chart) {
        chart.destroy();
      }

      initializeChart();

      const chartUpdateEvent = new Event("chart-updated");
      document.dispatchEvent(chartUpdateEvent);
    },
  });
}

if (pagePath === "admin") {
  initializeChart();
  runChart();
}

// Atur interval untuk mengupdate grafik
// setInterval(runChart, 5000);
