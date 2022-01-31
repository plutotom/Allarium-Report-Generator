// Globule variables @param agf_charts_average: post_id, scored_entries, ajax_url, average_score

// Take scored_entries and put each key into an array of labels
var labels = [];
for (var key in agf_charts_average.average_score) {
  labels.push(key);
}

var ctx = document.getElementById("myChart").getContext("2d");
var myChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: labels,
    datasets: [
      {
        label: "# of Votes",
        data: agf_charts_average.average_score,
        backgroundColor: [
          "rgb(244,171,50)",
          "rgb(236,113,118)",
          "rgb(91,99,162)",
          "rgb(26,78,106)",
        ],
        borderColor: [
          "rgb(244,171,50)",
          "rgb(236,113,118)",
          "rgb(91,99,162)",
          "rgb(26,78,106)",
        ],
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
