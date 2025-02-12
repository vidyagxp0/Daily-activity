{{--Intial Deviation --}}
<h4>Documents Analytics</h4>

<style>
  .sub-head {
    color: #bfd0f2;
    border-bottom: 2px solid #bfd0f2;
    padding-bottom: 5px;
    margin-bottom: 20px;
    font-weight: bold;
    font-size: 1.2rem;
  }
</style>

<script>
  // Initial change control
  fetch('/api/get-change-control-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('changeControlChart').getContext('2d');
      const deviationChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Change Control',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25 // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));


  // Initial global change control 
  fetch('/api/get-global-change-control-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('globalChangeControlChart').getContext('2d');
      const deviationChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Change Control',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25 // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));

  // Initial Action Item 
  fetch('/api/get-action-item-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('initialActionItemChart').getContext('2d');
      const deviationChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'ction Item',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25 // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>

<script>
  // Post categorization deviation
  fetch('/api/get-deviation-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('deviationChart').getContext('2d');
      const deviationChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Deviation',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25 // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>


<script>
  // Post Categorization Change Control
  fetch('/api/get-change-control-categorization-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('changeControlpostChart').getContext('2d');
      const deviationpostChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Change Control',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25  // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));


  // Post Categorization Global Change Control 
  fetch('/api/get-global-change-control-categorization-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('globalChangeControlpostChart').getContext('2d');
      const deviationpostChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Global Change Control',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25  // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));



  // Post Categorization Action Item
  fetch('/api/get-action-item-categorization-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('actionItempostChart').getContext('2d');
      const deviationpostChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Action Item',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25  // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>


<script>
  // Fetch data from Laravel API
  fetch('/api/get-categorization-data')
    .then(response => response.json())
    .then(data => {
      // Prepare data for the chart
      const categories = Object.keys(data);  // Major, Minor, Critical
      const counts = Object.values(data);  // Corresponding counts

      // Create the chart
      const ctx = document.getElementById('deviationpostChart').getContext('2d');
      const deviationpostChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
          labels: categories,
          datasets: [{
            label: 'Deviation',
            data: counts,
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12'], // Updated colors
            borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],   // Matching border colors
            borderWidth: 1,
            barThickness: 25  // Set the thickness of the bars
          }]
        },
        options: {
          responsive: true,
          indexAxis: 'x', // Vertical Bar Chart
          scales: {
            y: {
              beginAtZero: true, // Ensure the y-axis starts from zero
              title: {
                display: true,
                text: 'Count', // Label for the y-axis
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            // x: {
            //     title: {
            //         display: true,
            //         text: 'Deviation Type', // Label for the x-axis
            //         font: {
            //             size: 14,
            //             weight: 'bold'
            //         }
            //     }
            // }
          },
          plugins: {
            legend: {
              position: 'top',  // Position of legend
            }
          },
          maintainAspectRatio: false  // Disable aspect ratio to fit chart in the container
        }
      });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>

<div style="text-align: center; margin-bottom: 20px;">
  <h3>Site Wise Record Distribution</h3>
</div>
<div id="processCountsChart" style="width: 100%; height: 400px;"></div>

<script>
  function renderProcessCountsChart(data) {
    let series = [];
    let categories = data[0].processCounts.map(process => process.process);

    data.forEach(divisionData => {
      series.push({
        name: divisionData.division,
        data: divisionData.processCounts.map(pc => pc.count)
      });
    });

    var options = {
      series: series,
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '2%',
          endingShape: 'rounded'
        }
      },
      xaxis: {
        categories: categories
      },
      yaxis: {
        title: {
          text: 'Count'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " records";
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#processCountsChart"), options);
    chart.render();
  }

  fetch('/api/division-wise-process')
    .then(response => response.json())
    .then(data => {
      renderProcessCountsChart(data.body);
    });
</script>
<div class="col-lg-12">

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#overdueRecordDistributionBar"
        type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#overdueRecordDistributionPie"
        type="button" role="tab" aria-controls="profile" aria-selected="false">Pie</button>
    </li>
  </ul>

  <div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="overdueRecordDistributionBar" role="tabpanel"
      aria-labelledby="home45-tab">
      <div class="card border-0" style="">
        <div class="card-body">
          <h5 class="card-title">Overdue Record Distribution</h5>

          <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
            id="overdueRecordDistributionChart">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="overdueRecordDistributionPie" role="tabpanel" aria-labelledby="home45-tab">
      <div class="card border-0" style="">
        <div class="card-body">
          <h5 class="card-title">Overdue Record Distribution</h5>

          <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
            id="overdueRecordDistributionChartPie">

          </div>
        </div>
      </div>
    </div>

  </div>


</div>
{{-- DOCUMENT BY STATUS END --}}


<div id="chartContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  async function fetchFlowCounts() {
    try {
      const url = "/api/flow-counts";
      const res = await axios.get(url);

      if (res.data.status === 'ok') {
        const bodyData = res.data.body;

        const labels = bodyData.map(item => item.name);
        const series = bodyData.map(item => item.count);

        renderFlowChart(labels, series);
      } else {
        console.error("Error fetching data:", res.data.message);
      }

    } catch (err) {
      console.error("Error:", err.message);
    }
  }

  function renderFlowChart(labels, series) {
    var options = {
      chart: {
        type: 'bar',
        height: 350
      },
      series: [{
        name: 'Flow Count',
        data: series
      }],
      xaxis: {
        categories: labels,
        title: {
          text: 'Flow Types'
        }
      },
      yaxis: {
        title: {
          text: 'Count of Flows'
        }
      },
      title: {
        text: 'Flow Counts',
        align: 'center'
      }
    };

    var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
    chart.render();
  }

  document.addEventListener('DOMContentLoaded', fetchFlowCounts);
</script>


<!-- Container for the chart -->
{{-- ==========================Deviations================================ --}}

<div class="sub-head">
  Deviation
</div>
<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
  <!-- First Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Initial Deviation</h4>
    <canvas id="deviationChart"></canvas>
  </div>

  <!-- Second Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Post Categorization of Deviation</h4>
    <canvas id="deviationpostChart"></canvas>
  </div>
</div>
<div class="my-4 row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Deviation Delay and On Time</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="delayedCharts">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Deviation By Site</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="documentSiteCharts">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Deviation by Severity</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="deviationSeverityChart">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Deviation Stage Distribution</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="deviationStageDistribution">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- <div class="col-sm-6">
  <div class="card border-0" style="">
    <div class="card-body">
      <h5 class="card-title">Deviation By Classification</h5>

      <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
        id="deviationClassificationChart">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div> --}}

<div class="my-4 row">


  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Priority Levels (Deviation)</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="priorityLevelChartDeviation">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Deviation By Departments</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="deviationDepartmentChart">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- ==========================change control============= --}}
<div class="sub-head">
  Change Control
</div>
<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
  <!-- First Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Initial Change Control</h4>
    <canvas id="changeControlChart"></canvas>
  </div>

  <!-- Second Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Post Categorization of Change Control</h4>
    <canvas id="changeControlpostChart"></canvas>
  </div>
</div>





<div class="my-4 row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Change Control Delay and On Time</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="delayedChartsChangeControl">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Change Control By Site</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="documentSiteChartsChangeControl">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Priority Levels (Change Control)</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="priorityLevelChartChangeControl">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Global Change Control Stage Distribution</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="globalChangeControlStageDistribution">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{--Global Change Control graph starts--}}
<div class="sub-head">
  Global Change Control
</div>
<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
  <!-- First Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Initial Global Change Control</h4>
    <canvas id="globalChangeControlChart"></canvas>
  </div>

  <!-- Second Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Post Categorization of Global Change Control</h4>
    <canvas id="globalChangeControlpostChart"></canvas>
  </div>
</div>

<div class="my-4 row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Global Change Control Delay and On Time</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="delayedChartsGlobalChangeControl">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Global Change Control By Site</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="documentSiteChartsGlobalChangeControl">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Priority Levels (Global Change Control)</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="priorityLevelChartGlobalChangeControl">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Global Change Control Stage Distribution</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="changeControlStageDistribution">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{--Global Change Control graph ends--}}


{{--Action Item graph starts--}}
<div class="sub-head">
  Action Item
</div>
<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
  <!-- First Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Initial Action Item</h4>
    <canvas id="initialActionItemChart"></canvas>
  </div>

  <!-- Second Chart -->
  <div style="width: 45%; height: 400px;">
    <h4 style="text-align: center;">Post Categorization Action Item</h4>
    <canvas id="actionItempostChart"></canvas>
  </div>
</div>

{{--Action Item graph ends--}}






{{-- ================================================Extension================================================ --}}
<div class="sub-head">
  Extension
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Priority Levels (Extension)</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="priorityLevelChartextension">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
   function renderextensionPriorityLevelChart(lowData, mediumData, highData, months) {
      var options = {
        series: [{
          name: 'Low',
          data: lowData
        },
        {
          name: 'Medium',
          data: mediumData
        },
        {
          name: 'High',
          data: highData
        },
        ],
        chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: months,
        },
        yaxis: {
          title: {
            text: '# of Extension'
          }
        },
        fill: {
          opacity: 1,
          colors: ['#008FFB', '#00E396', '#FFBD00']
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " Extension "
            }
          }
        }
      };

      var priorityLevelChart = new ApexCharts(document.querySelector("#priorityLevelChartextension"), options);
      priorityLevelChart.render();
    }

    async function preparextensionPriorityLevelChart() {
      $('#priorityLevelChartextension > .spinner-border').show();

      try {
        const url = "{{ route('api.document_by_priority_extension.chart') }}"
        const res = await axios.get(url);


        if (res.data.status == 'ok') {
          let bodyData = res.data.body;
          let low = []
          let medium = []
          let high = []
          let labels = []

          for (const key in bodyData) {
            labels.push(bodyData[key].month)
            low.push(bodyData[key].low)
            medium.push(bodyData[key].medium)
            high.push(bodyData[key].high)
          }

          renderextensionPriorityLevelChart(low, medium, high, labels)
        }

      } catch (err) {
        console.log('Error in Extension chart', err.message);
      }

      $('#priorityLevelChartextension > .spinner-border').hide();
    }
</script>
  

  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Extension Stage Distribution</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="extensionStageDistribution">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
     function renderextensionStageDistributionChart(labels, series) {
      var options = {
        series: [{
          name: 'Change Control Stages',
          data: series
        }],
        chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: labels,
          title: {
            text: 'Extension Stages'
          }
        },
        yaxis: {
          title: {
            text: '# of Extension'
          }
        },
        fill: {
          opacity: 1,
          colors: ['#008FFB']
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " Extension";
            }
          } 
        }
      };

      var deviationStageChart = new ApexCharts(document.querySelector("#extensionStageDistribution"), options);
      deviationStageChart.render();
    }

    async function prepareextensionStageDistributionChart() {
      $('#extensionStageDistribution > .spinner-border').show();

      try {
        const url = "{{ route('api.extension_Stage_Distribution.chart') }}";
        const res = await axios.get(url);

        if (res.data.status === 'ok') {
          const bodyData = res.data.body;

          // Use the API's labels and series
          const labels = bodyData.labels;
          const series = bodyData.series;

          // Render the chart with the updated data
          renderextensionStageDistributionChart(labels, series);
        } else {
          console.error("Error fetching data:", res.data.message);
        }
      } catch (err) {
        console.error("Error in extension stage chart:", err.message);
      }

      $('#extensionStageDistribution > .spinner-border').hide();
    }
  </script>
</div>

<!-- CAPA Graph Starts -->

<div class="sub-head">
    CAPA
</div>
<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
    <div style="width: 45%; height: 400px;">
        <h4 style="text-align: center;">Initial Categorization</h4>
        <canvas id="capaInitialCategorization"></canvas>
    </div>
    <script>
      fetch('/api/capa-initial-categorization')
        .then(response => response.json())
        .then(data => {
          const categories = Object.keys(data);
          const counts = Object.values(data);

          const ctx = document.getElementById('capaInitialCategorization').getContext('2d');
          const capaInitialCategorization = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: categories,
              datasets: [{
                label: 'CAPA',
                data: counts,
                backgroundColor: ['#3498db', '#2ecc71', '#f39c12'],
                borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],
                borderWidth: 1,
                barThickness: 25
              }]
            },
            options: {
              responsive: true,
              indexAxis: 'x',
              scales: {
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Count',
                    font: {
                      size: 14,
                      weight: 'bold'
                    }
                  }
                },
              },
              plugins: {
                legend: {
                  position: 'top',
                }
              },
              maintainAspectRatio: false
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    </script>

    <div style="width: 45%; height: 400px;">
        <h4 style="text-align: center;">Post Categorization of CAPA</h4>
        <canvas id="capaPostCategorization"></canvas>
    </div>
    <script>
      fetch('/api/capa-post-categorization')
        .then(response => response.json())
        .then(data => {
          const categories = Object.keys(data);
          const counts = Object.values(data);

          const ctx = document.getElementById('capaPostCategorization').getContext('2d');
          const capaPostCategorization = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: categories,
              datasets: [{
                label: 'CAPA',
                data: counts,
                backgroundColor: ['#3498db', '#2ecc71', '#f39c12'],
                borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],
                borderWidth: 1,
                barThickness: 25
              }]
            },
            options: {
              responsive: true,
              indexAxis: 'x',
              scales: {
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Count',
                    font: {
                      size: 14,
                      weight: 'bold'
                    }
                  }
                },
              },
              plugins: {
                legend: {
                  position: 'top',
                }
              },
              maintainAspectRatio: false
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    </script>
</div>


<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
    <div style="width: 45%; height: 400px;">
        <h4 style="text-align: center;">CAPA Delay and On Time</h4>
        <canvas id="delayedOntimeCapa"></canvas>
    </div>
    <script>
      fetch('/api/capa-ontime-delayed-records')
        .then(response => response.json())
        .then(data => {
          const ctx = document.getElementById('delayedOntimeCapa').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['On Time', 'Delayed'],
              datasets: [{
                label: 'CAPA',
                data: [data['On Time'], data['Delayed']],
                backgroundColor: ['#4caf50', '#f44336'],
                borderColor: ['#388e3c', '#d32f2f'],
                borderWidth: 1,
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                },
              },
              plugins: {
                legend: {
                  display: false,
                },
              },
            },
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    </script>

    <div style="width: 45%; height: 400px;">
        <h4 style="text-align: center;">CAPA by Site</h4>
        <canvas id="capaSiteRecords"></canvas>
    </div>
    <script>
      fetch('/api/capa-sitewise-records')
        .then(response => response.json())
        .then(data => {
          const divisions = data.map(item => item.division_name);
          const counts = data.map(item => item.count);

          const ctx = document.getElementById('capaSiteRecords').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: divisions, // Divisions on X-axis
              datasets: [{
                label: 'Records',
                data: counts, // Counts for each division
                backgroundColor: ['#42a5f5', '#66bb6a', '#ffa726', '#ab47bc', '#ef5350'], // Custom colors
                borderColor: ['#1e88e5', '#43a047', '#fb8c00', '#8e24aa', '#e53935'],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Count'
                  }
                }
              },
              plugins: {
                legend: {
                  display: false
                }
              }
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    </script>
</div>


<div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;margin-bottom:50px;">
    <div style="width: 45%; height: 400px;">
        <h4 style="text-align: center;">Priority Levels</h4>
        <canvas id="priorityLevel"></canvas>
    </div>
    <script>
      fetch('/api/capa-priority-records')
        .then(response => response.json())
        .then(data => {
          const categories = Object.keys(data);
          const counts = Object.values(data);

          const ctx = document.getElementById('priorityLevel').getContext('2d');
          const priorityLevel = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: categories,
              datasets: [{
                label: 'CAPA',
                data: counts,
                backgroundColor: ['#3498db', '#2ecc71', '#f39c12'],
                borderColor: ['#388e3c', '#fbc02d', '#d32f2f'],
                borderWidth: 1,
                barThickness: 25
              }]
            },
            options: {
              responsive: true,
              indexAxis: 'x',
              scales: {
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Count',
                    font: {
                      size: 14,
                      weight: 'bold'
                    }
                  }
                },
              },
              plugins: {
                legend: {
                  position: 'top',
                }
              },
              maintainAspectRatio: false
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    </script>


    <div style="width: 45%; height: 400px;">
        <h4 style="text-align: center;">CAPA by Status</h4>
        <canvas id="capaStatusRecords"></canvas>
    </div>
    <script>
      fetch('/api/capa-status-records') // Update this route to match your Laravel route
        .then(response => response.json())
        .then(data => {
          const statuses = Object.keys(data); // Status names
          const counts = Object.values(data); // Counts for each status

          const ctx = document.getElementById('capaStatusRecords').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: statuses, // Status names
              datasets: [{
                label: 'Records',
                data: counts, // Counts for each status
                backgroundColor: [
                  '#42a5f5', '#66bb6a', '#ffa726', '#ab47bc', '#ef5350', '#29b6f6', '#ff7043', '#8e24aa', '#c2185b'
                ],
                borderColor: [
                  '#1e88e5', '#43a047', '#fb8c00', '#8e24aa', '#e53935', '#039be5', '#ff7043', '#d32f2f', '#c2185b'
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              indexAxis: 'x', // Status names on X-axis
              scales: {
                x: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Status'
                  }
                },
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Count'
                  }
                }
              },
              plugins: {
                legend: {
                  display: false
                }
              }
            }
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    </script>



</div>



<!-- CAPA Graph Ends -->


<!-- {{-- ===================================Risk Managment================================ --}} -->

<div class="sub-head">
  Risk Management
</div>
<div class="my-4 row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Priority Levels (Risk Management)</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="priorityLevelChart">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Priority Levels (RCA)</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="priorityLevelChartRca">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<div class="my-4 row">
  <div class="col-sm-6">
    <div class="card border-0" style="">
      <div class="card-body">
        <h5 class="card-title">Processes</h5>

        <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
          id="processChart">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<hr>

<div class="my-4 row">

  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab4" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab2" data-bs-toggle="tab" data-bs-target="#hodAnalysisBar"
          type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab2" data-bs-toggle="tab" data-bs-target="#hodAnalysisPie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent2">

      <div class="tab-pane fade show active" id="hodAnalysisBar" role="tabpanel" aria-labelledby="home-tab">

        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending HOD Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingHODAnalysis">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>

          </div>
        </div>

      </div>

      <div class="tab-pane fade" id="hodAnalysisPie" role="tabpanel" aria-labelledby="profile">

        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending HOD Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingHODAnalysisPie">
            </div>

          </div>
        </div>

      </div>

    </div>

  </div>

  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab1" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab2" data-bs-toggle="tab" data-bs-target="#pendingTrainingBar"
          type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab2" data-bs-toggle="tab" data-bs-target="#pendingTrainingPie"
          type="button" role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent3">

      <div class="tab-pane fade show active" id="pendingTrainingBar" role="tabpanel" aria-labelledby="home-tab">

        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending Training Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingTrainingAnalysis">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="tab-pane fade" id="pendingTrainingPie" role="tabpanel" aria-labelledby="home-tab">

        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending Training Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingTrainingAnalysisPie">

            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

</div>

<div class="my-4 row">
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab3" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pendingReviewBar"
          type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pendingReviewPie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent4">

      <div class="tab-pane fade show active" id="pendingReviewBar" role="tabpanel" aria-labelledby="home-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending Review Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingReviewAnalysis">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="pendingReviewPie" role="tabpanel" aria-labelledby="home-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending Review Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingReviewAnalysisBar">

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- PENDING APPROVAL ANALYSIS START --}}
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab3" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pendingApprovalBar"
          type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pendingApprovalPie"
          type="button" role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent4">

      <div class="tab-pane fade show active" id="pendingApprovalBar" role="tabpanel" aria-labelledby="home23-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending Approval Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingApproveAnalysis">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="pendingApprovalPie" role="tabpanel" aria-labelledby="home23-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Pending Approval Analysis</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="pendingApproveAnalysisPie">

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
  {{-- PENDING APPROVAL ANALYSIS END --}}

</div>

<div class="my-4 row">
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#docTypeBar" type="button"
          role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#docTypePie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="docTypeBar" role="tabpanel" aria-labelledby="home-tab">

        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Document Type Distribution</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentTypeDistribution">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="tab-pane fade" id="docTypePie" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Document Type Distribution</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentTypeDistributionBar">

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>

  {{-- REVIEW NEXT 6 MONTH START --}}
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#reviewSixBar" type="button"
          role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reviewSixPie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="reviewSixBar" role="tabpanel" aria-labelledby="home42-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Review in Next 6 Months</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentReviewSix">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="reviewSixPie" role="tabpanel" aria-labelledby="home42-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Review in Next 6 Months</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentReviewSixPie">

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
  {{-- REVIEW NEXT 6 MONTH END --}}


</div>

<div class="my-4 row">

  {{-- REVIEW NEXT 1 YEAR START --}}
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#reviewOneBar" type="button"
          role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reviewOnePie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="reviewOneBar" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Review in Next 1 Year</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentReviewOne">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="reviewOnePie" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Review in Next 1 Year</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentReviewOnePie">

            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
  {{-- REVIEW NEXT 1 YEAR END --}}

  {{-- REVIEW NEXT 2 YEAR START --}}
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#reviewTwoBar" type="button"
          role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reviewTwoPie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="reviewTwoBar" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Review in Next 2 Years</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentReviewTwo">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="reviewTwoPie" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Review in Next 2 Years</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentReviewTwoPie">

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
  {{-- REVIEW NEXT 2 YEAR END --}}
</div>

<div class="my-4 row">

  {{-- ORIGINATOR DISTRIBUTION START --}}
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#originatorDistBar"
          type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#originatorDistPie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="originatorDistBar" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Originator Distribution</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentOriginatorDistribution">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="originatorDistPie" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Originator Distribution</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentOriginatorDistributionPie">

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
  {{-- ORIGINATOR DISTRIBUTION END --}}


  {{-- DOCUMENT BY STATUS START --}}
  <div class="col-sm-6">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#documentStatusBar"
          type="button" role="tab" aria-controls="home" aria-selected="true">Bar</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#documentStatusPie" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Pie</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="documentStatusBar" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Documents by status</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentCategoryChart">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="documentStatusPie" role="tabpanel" aria-labelledby="home45-tab">
        <div class="card border-0" style="">
          <div class="card-body">
            <h5 class="card-title">Documents by status</h5>

            <div class="card-text d-flex justify-content-center d-flex justify-content-center align-items-center h-100"
              id="documentCategoryChartPie">

            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
  {{-- DOCUMENT BY STATUS END --}}

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js"
  integrity="sha512-JSCFHhKDilTRRXe9ak/FJ28dcpOJxzQaCd3Xg8MyF6XFjODhy/YMCM8HW0TFDckNHWUewW+kfvhin43hKtJxAw=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>


  // Processes Charts start 
  function renderProcessChart(series, labels) {
    var options = {
      series,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var processChart = new ApexCharts(document.querySelector("#processChart"), options);
    processChart.render();
  }

  async function prepareProcessChart() {
    $('#processChart > .spinner-border').show();

    try {
      const url = "{{ route('api.process.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let series = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].classname)
          series.push(bodyData[key].count)
        }

        renderProcessChart(series, labels)
      }

    } catch (err) {
      console.log('Error in process chart', err.message);
    }

    $('#processChart > .spinner-border').hide();
  }
  // Processes Charts End

  // Document by status Charts Starts
  function renderDocumentCategoryChart(series, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: series
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          borderRadius: 4,
          borderRadiusApplication: 'end',
          horizontal: true,
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: labels,
      }
    };

    var barOptions = {
      series: series,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var documentCategoryChart = new ApexCharts(document.querySelector("#documentCategoryChart"), options);
    var documentCategoryChartPie = new ApexCharts(document.querySelector("#documentCategoryChartPie"), barOptions);
    documentCategoryChart.render();
    documentCategoryChartPie.render();
  }

  async function prepareDocumentCategoryChart() {
    $('#documentCategoryChart > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_status.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let series = []
        let labels = []

        for (const key in bodyData) {
          labels.push(key)
          series.push(bodyData[key])
        }

        renderDocumentCategoryChart(series, labels)
      }

    } catch (err) {
      console.log('Error in process chart', err.message);
    }

    $('#documentCategoryChart > .spinner-border').hide();
  }
  // Document by status Charts End

  // Classification of deviation start
  function renderClassificationDeviationChart(minorData, majorData, criticalData, months) {
    var options = {
      series: [
        {
          name: 'Minor',
          data: minorData
        },
        {
          name: 'Major',
          data: majorData
        },
        {
          name: 'Critical',
          data: criticalData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Deviations'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#FFBD00', '#FF2C00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations"
          }
        }
      }
    };

    var deviationClassificationChart = new ApexCharts(document.querySelector("#deviationClassificationChart"), options);
    deviationClassificationChart.render();
  }

  async function prepareClassificationDeviationChart() {
    $('#deviationClassificationChart > .spinner-border').show();

    try {
      const url = "{{ route('api.deviation.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let minor = []
        let major = []
        let critical = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          minor.push(bodyData[key].minor)
          major.push(bodyData[key].major)
          critical.push(bodyData[key].critical)
        }

        renderClassificationDeviationChart(minor, major, critical, labels)
      }

    } catch (err) {
      console.log('Error in deviation chart', err.message);
    }

    $('#deviationClassificationChart > .spinner-border').hide();
  }
  // Classification of deviation end

  // Departments wise deviation start
  function renderDeviationDepartmentChart(seriesData, labels) {
    var options = {
      series: seriesData,
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# of Deviations'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations"
          }
        }
      }
    };

    var deviationDepartmentChart = new ApexCharts(document.querySelector("#deviationDepartmentChart"), options);
    deviationDepartmentChart.render();
  }

  async function prepareDeviationDepartmentChart() {
    $('#deviationDepartmentChart > .spinner-border').show();

    try {
      const url = "{{ route('api.deviation_departments.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(key)
          seriesData[bodyData[key]['January']]
        }

        renderDeviationDepartmentChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in deviation department chart', err.message);
    }

    $('#deviationDepartmentChart > .spinner-border').hide();
  }
  // Departments wise deviation end

  // Originator Distribution start
  function renderDocumentOriginatorChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };



    var documentOriginatorDistribution = new ApexCharts(document.querySelector("#documentOriginatorDistribution"), options);
    var documentOriginatorDistributionPie = new ApexCharts(document.querySelector("#documentOriginatorDistributionPie"), barOptions);
    documentOriginatorDistribution.render();
    documentOriginatorDistributionPie.render();
  }

  async function prepareDocumentOriginatorChart() {
    $('#documentOriginatorDistribution > .spinner-border').show();

    try {
      const url = "{{ route('api.document.originator.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(bodyData[key]['originator_name'])
          seriesData.push(bodyData[key]['document_count'])
        }

        renderDocumentOriginatorChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document originator', err.message);
    }

    $('#documentOriginatorDistribution > .spinner-border').hide();
  }
  // Originator distribution end

  // Type Distribution start
  function renderDocumentTypeChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var documentTypeDistribution = new ApexCharts(document.querySelector("#documentTypeDistribution"), options);
    var documentTypeDistributionBar = new ApexCharts(document.querySelector("#documentTypeDistributionBar"), barOptions);
    documentTypeDistribution.render();
    documentTypeDistributionBar.render();
  }

  async function prepareDocumentTypeChart() {
    $('#documentTypeDistribution > .spinner-border').show();

    try {
      const url = "{{ route('api.document.type.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(bodyData[key]['document_type_name'])
          seriesData.push(bodyData[key]['document_count'])
        }

        renderDocumentTypeChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document originator', err.message);
    }

    $('#documentTypeDistribution > .spinner-border').hide();
  }
  // Type distribution end

  // Review six month start
  function renderDocumentSixChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents to be reviewed by this date"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };



    var documentReviewSix = new ApexCharts(document.querySelector("#documentReviewSix"), options);
    var documentReviewSixPie = new ApexCharts(document.querySelector("#documentReviewSixPie"), barOptions);
    documentReviewSix.render();
    documentReviewSixPie.render();
  }

  async function prepareDocumentSixChart() {
    $('#documentReviewSix > .spinner-border').show();

    try {
      const url = "{{ route('api.document.review.chart', 6) }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        bodyData.forEach(data => {
          seriesData.push(1);
          labels.push(data.next_review_date)
        });

        renderDocumentSixChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document originator', err.message);
    }

    $('#documentReviewSix > .spinner-border').hide();
  }
  // Review six month end

  // Review one year start
  function renderDocumentOneChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents to be reviewed by this date"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var documentReviewOne = new ApexCharts(document.querySelector("#documentReviewOne"), options);
    var documentReviewOnePie = new ApexCharts(document.querySelector("#documentReviewOnePie"), barOptions);
    documentReviewOne.render();
    documentReviewOnePie.render();
  }

  async function prepareDocumentOneChart() {
    $('#documentReviewOne > .spinner-border').show();

    try {
      const url = "{{ route('api.document.review.chart', 12) }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        bodyData.forEach(data => {
          seriesData.push(1);
          labels.push(data.next_review_date)
        });

        renderDocumentOneChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document one', err.message);
    }

    $('#documentReviewOne > .spinner-border').hide();
  }
  // Review one year end

  // Review two year start
  function renderDocumentTwoChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents to be reviewed by this date"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var documentReviewTwo = new ApexCharts(document.querySelector("#documentReviewTwo"), options);
    var documentReviewTwoPie = new ApexCharts(document.querySelector("#documentReviewTwoPie"), barOptions);
    documentReviewTwo.render();
    documentReviewTwoPie.render();
  }

  async function prepareDocumentTwoChart() {
    $('#documentReviewTwo > .spinner-border').show();

    try {
      const url = "{{ route('api.document.review.chart', 24) }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        bodyData.forEach(data => {
          seriesData.push(1);
          labels.push(data.next_review_date)
        });

        renderDocumentTwoChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document one', err.message);
    }

    $('#documentReviewTwo > .spinner-border').hide();
  }
  // Review two year end

  // Pending Review Analysis start
  function renderPendingReviewerChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents to be reviewed"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var pendingReviewAnalysis = new ApexCharts(document.querySelector("#pendingReviewAnalysis"), options);
    var pendingReviewAnalysisBar = new ApexCharts(document.querySelector("#pendingReviewAnalysisBar"), barOptions);
    pendingReviewAnalysis.render();
    pendingReviewAnalysisBar.render();
  }

  async function preparePendingReviewerChart() {
    $('#pendingReviewAnalysis > .spinner-border').show();

    try {
      const url = "{{ route('api.document.pending.reviewers.chart') }}"
      const res = await axios.get(url);

      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(key);
          seriesData.push(bodyData[key])
        }

        renderPendingReviewerChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document one', err.message);
    }

    $('#pendingReviewAnalysis > .spinner-border').hide();
  }
  // Pending Review Analysis end

  // Pending Approval Analysis start
  function renderPendingApproverChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents to be approved"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var pendingApproveAnalysis = new ApexCharts(document.querySelector("#pendingApproveAnalysis"), options);
    var pendingApproveAnalysisPie = new ApexCharts(document.querySelector("#pendingApproveAnalysisPie"), barOptions);
    pendingApproveAnalysis.render();
    pendingApproveAnalysisPie.render();
  }

  async function preparePendingApproverChart() {
    $('#pendingApproveAnalysis > .spinner-border').show();

    try {
      const url = "{{ route('api.document.pending.approvers.chart') }}"
      const res = await axios.get(url);

      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(key);
          seriesData.push(bodyData[key])
        }

        renderPendingApproverChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document one', err.message);
    }

    $('#pendingApproveAnalysis > .spinner-border').hide();
  }
  // Pending Approval Analysis end


  // Pending HOD Analysis start
  function renderPendingHODChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents pending HOD review"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var pendingHODAnalysis = new ApexCharts(document.querySelector("#pendingHODAnalysis"), options);
    var pendingHODAnalysisPie = new ApexCharts(document.querySelector("#pendingHODAnalysisPie"), barOptions);
    pendingHODAnalysis.render();
    pendingHODAnalysisPie.render();
  }

  async function preparePendingHODChart() {
    $('#pendingHODAnalysis > .spinner-border').show();

    try {
      const url = "{{ route('api.document.pending.hod.chart') }}"
      const res = await axios.get(url);

      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(key);
          seriesData.push(bodyData[key])
        }

        renderPendingHODChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document one', err.message);
    }

    $('#pendingHODAnalysis > .spinner-border').hide();
  }
  // Pending HOD Analysis end

  // Pending Training Analysis start
  function renderPendingTrainingChart(seriesData, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: seriesData
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: '# (documents)'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " documents pending HOD review"
          }
        }
      }
    };

    var barOptions = {
      series: seriesData,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var pendingTrainingAnalysis = new ApexCharts(document.querySelector("#pendingTrainingAnalysis"), options);
    var pendingTrainingAnalysisPie = new ApexCharts(document.querySelector("#pendingTrainingAnalysisPie"), barOptions);
    pendingTrainingAnalysis.render();
    pendingTrainingAnalysisPie.render();
  }

  async function preparePendingTrainingChart() {
    $('#pendingTrainingAnalysis > .spinner-border').show();

    try {
      const url = "{{ route('api.document.pending.training.chart') }}"
      const res = await axios.get(url);

      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let labels = []
        let seriesData = []

        for (const key in bodyData) {
          labels.push(key);
          seriesData.push(bodyData[key])
        }

        renderPendingTrainingChart(seriesData, labels)
      }

    } catch (err) {
      console.log('Error in document one', err.message);
    }

    $('#pendingTrainingAnalysis > .spinner-border').hide();
  }
  // Pending Training Analysis end

  // Severity Level start
  function renderSeverityChart(negligibleData, moderateData, majorData, fatalData, months) {
    var options = {
      series: [{
        name: 'Negligible',
        data: negligibleData
      },
      {
        name: 'Moderate',
        data: moderateData
      },
      {
        name: 'Major',
        data: majorData
      },
      {
        name: 'Fatal',
        data: fatalData
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Deviations'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396', '#FFBD00', '#FF2C00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations"
          }
        }
      }
    };

    var deviationSeverityChart = new ApexCharts(document.querySelector("#deviationSeverityChart"), options);
    deviationSeverityChart.render();
  }

  async function prepareSeverityDeviationChart() {
    $('#deviationSeverityChart > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_severity.chart') }}"
      const res = await axios.get(url);

      console.log('res', res.data)


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let negligible = []
        let moderate = []
        let major = []
        let fatal = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          negligible.push(bodyData[key].negligible)
          moderate.push(bodyData[key].moderate)
          major.push(bodyData[key].major)
          fatal.push(bodyData[key].fatal)
        }

        renderSeverityChart(negligible, moderate, major, fatal, labels)
      }

    } catch (err) {
      console.log('Error in deviation chart', err.message);
    }

    $('#deviationSeverityChart > .spinner-border').hide();
  }
  // Severity Level deviation end

  // Priority Level start
  function renderPriorityLevelChart(lowData, mediumData, highData, months) {
    var options = {
      series: [{
        name: 'Low',
        data: lowData
      },
      {
        name: 'Medium',
        data: mediumData
      },
      {
        name: 'High',
        data: highData
      },
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Risk Management'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396', '#FFBD00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " risk_managements"
          }
        }
      }
    };

    var priorityLevelChart = new ApexCharts(document.querySelector("#priorityLevelChart"), options);
    priorityLevelChart.render();
  }

  async function preparePriorityLevelChart() {
    $('#priorityLevelChart > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_priority.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let low = []
        let medium = []
        let high = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          low.push(bodyData[key].low)
          medium.push(bodyData[key].medium)
          high.push(bodyData[key].high)
        }

        renderPriorityLevelChart(low, medium, high, labels)
      }

    } catch (err) {
      console.log('Error in Risk Managment chart', err.message);
    }

    $('#priorityLevelChart > .spinner-border').hide();
  }
  // Priority Level deviation end



  // Priority Level Deviation start
  function renderDeviationPriorityLevelChart(lowData, mediumData, highData, months) {
    var options = {
      series: [{
        name: 'Low',
        data: lowData
      },
      {
        name: 'Medium',
        data: mediumData
      },
      {
        name: 'High',
        data: highData
      },
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Deviation'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396', '#FFBD00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations"
          }
        }
      }
    };

    var priorityLevelChart = new ApexCharts(document.querySelector("#priorityLevelChartDeviation"), options);
    priorityLevelChart.render();
  }

  async function prepareDeviationPriorityLevelChart() {
    $('#priorityLevelChartDeviation > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_priority_deviation.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let low = []
        let medium = []
        let high = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          low.push(bodyData[key].low)
          medium.push(bodyData[key].medium)
          high.push(bodyData[key].high)
        }

        renderDeviationPriorityLevelChart(low, medium, high, labels)
      }

    } catch (err) {
      console.log('Error in Risk Managment chart', err.message);
    }

    $('#priorityLevelChartDeviation > .spinner-border').hide();
  }
  // Priority Level deviation end


  // Priority Level Change Control start
  function renderChangeControlPriorityLevelChart(lowData, mediumData, highData, months) {
    var options = {
      series: [{
        name: 'Low',
        data: lowData
      },
      {
        name: 'Medium',
        data: mediumData
      },
      {
        name: 'High',
        data: highData
      },
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Change Control'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396', '#FFBD00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " Change Control"
          }
        }
      }
    };

    var priorityLevelChart = new ApexCharts(document.querySelector("#priorityLevelChartChangeControl"), options);
    priorityLevelChart.render();
  }

  async function prepareChangeControlPriorityLevelChart() {
    $('#priorityLevelChartChangeControl > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_priority_change_control.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let low = []
        let medium = []
        let high = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          low.push(bodyData[key].low)
          medium.push(bodyData[key].medium)
          high.push(bodyData[key].high)
        }

        renderChangeControlPriorityLevelChart(low, medium, high, labels)
      }

    } catch (err) {
      console.log('Error in Risk Managment chart', err.message);
    }

    $('#priorityLevelChartChangeControl > .spinner-border').hide();
  }
  // Priority Level Change Control end


  // Priority Level Change Change Control start
  function renderGlobalChangeControlPriorityLevelChart(lowData, mediumData, highData, months) {
    var options = {
      series: [{
        name: 'Low',
        data: lowData
      },
      {
        name: 'Medium',
        data: mediumData
      },
      {
        name: 'High',
        data: highData
      },
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Global Change Control'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396', '#FFBD00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " Global Change Control"
          }
        }
      }
    };

    var priorityLevelChart = new ApexCharts(document.querySelector("#priorityLevelChartGlobalChangeControl"), options);
    priorityLevelChart.render();
  }

  async function prepareChangeGlobalControlPriorityLevelChart() {
    $('#priorityLevelChartGlobalChangeControl > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_priority_global_change_control.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let low = []
        let medium = []
        let high = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          low.push(bodyData[key].low)
          medium.push(bodyData[key].medium)
          high.push(bodyData[key].high)
        }

        renderGlobalChangeControlPriorityLevelChart(low, medium, high, labels)
      }

    } catch (err) {
      console.log('Error in Risk Managment chart', err.message);
    }

    $('#priorityLevelChartGlobalChangeControl > .spinner-border').hide();
  }
  // Priority Level Global Change Control end


  // deviationStageDistribution start
  function renderDeviationStageDistributionChart(labels, series) {
    var options = {
      series: [{
        name: 'Deviation Stages',
        data: series
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
        title: {
          text: 'Deviation Stages'
        }
      },
      yaxis: {
        title: {
          text: '# of Deviation'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations";
          }
        }
      }
    };

    var deviationStageChart = new ApexCharts(document.querySelector("#deviationStageDistribution"), options);
    deviationStageChart.render();
  }

  async function prepareDeviationStageDistributionChart() {
    $('#deviationStageDistribution > .spinner-border').show();

    try {
      const url = "{{ route('api.deviationStageDistribution.chart') }}";
      const res = await axios.get(url);

      if (res.data.status === 'ok') {
        const bodyData = res.data.body;

        // Use the API's labels and series
        const labels = bodyData.labels;
        const series = bodyData.series;

        // Render the chart with the updated data
        renderDeviationStageDistributionChart(labels, series);
      } else {
        console.error("Error fetching data:", res.data.message);
      }
    } catch (err) {
      console.error("Error in deviation stage chart:", err.message);
    }

    $('#deviationStageDistribution > .spinner-border').hide();
  }
  // deviationStageDistribution end


  // changeStageDistribution start
  function renderChangeControlStageDistributionChart(labels, series) {
    var options = {
      series: [{
        name: 'Change Control Stages',
        data: series
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
        title: {
          text: 'Change Control Stages'
        }
      },
      yaxis: {
        title: {
          text: '# of Change Control'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " change controls";
          }
        }
      }
    };

    var deviationStageChart = new ApexCharts(document.querySelector("#changeControlStageDistribution"), options);
    deviationStageChart.render();
  }

  async function prepareChangeControlStageDistributionChart() {
    $('#changeControlStageDistribution > .spinner-border').show();

    try {
      const url = "{{ route('api.changeControlStageDistribution.chart') }}";
      const res = await axios.get(url);

      if (res.data.status === 'ok') {
        const bodyData = res.data.body;

        // Use the API's labels and series
        const labels = bodyData.labels;
        const series = bodyData.series;

        // Render the chart with the updated data
        renderChangeControlStageDistributionChart(labels, series);
      } else {
        console.error("Error fetching data:", res.data.message);
      }
    } catch (err) {
      console.error("Error in deviation stage chart:", err.message);
    }

    $('#changeControlStageDistribution > .spinner-border').hide();
  }
  // changeStageDistribution end


  // globalchangeStageDistribution start
  function renderGlobalChangeControlStageDistributionChart(labels, series) {
    var options = {
      series: [{
        name: 'Global Change Control Stages',
        data: series
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: labels,
        title: {
          text: 'Global Change Control Stages'
        }
      },
      yaxis: {
        title: {
          text: '# of Global Change Control'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " global change controls";
          }
        }
      }
    };

    var deviationStageChart = new ApexCharts(document.querySelector("#globalChangeControlStageDistribution"), options);
    deviationStageChart.render();
  }

  async function prepareGlobalChangeControlStageDistributionChart() {
    $('#globalChangeControlStageDistribution > .spinner-border').show();

    try {
      const url = "{{ route('api.globalChangeControlStageDistribution.chart') }}";
      const res = await axios.get(url);

      if (res.data.status === 'ok') {
        const bodyData = res.data.body;

        // Use the API's labels and series
        const labels = bodyData.labels;
        const series = bodyData.series;

        // Render the chart with the updated data
        renderGlobalChangeControlStageDistributionChart(labels, series);
      } else {
        console.error("Error fetching data:", res.data.message);
      }
    } catch (err) {
      console.error("Error in deviation stage chart:", err.message);
    }

    $('#globalChangeControlStageDistribution > .spinner-border').hide();
  }
  // globalchangeStageDistribution end



  // Priority Level start

  function renderPriorityLevelChartRca(lowData, mediumData, highData, months) {
    var options = {
      series: [{
        name: 'Low',
        data: lowData
      },
      {
        name: 'Medium',
        data: mediumData
      },
      {
        name: 'High',
        data: highData
      },
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of RCA'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396', '#FFBD00', '#FF2C00']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " root_cause_analysis"
          }
        }
      }
    };

    var priorityLevelChartRca = new ApexCharts(document.querySelector("#priorityLevelChartRca"), options);
    priorityLevelChartRca.render();
  }

  async function preparePriorityLevelChartRca() {
    $('#priorityLevelChartRca > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_priority_rca.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let low = []
        let medium = []
        let high = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          low.push(bodyData[key].low)
          medium.push(bodyData[key].medium)
          high.push(bodyData[key].high)
        }

        renderPriorityLevelChartRca(low, medium, high, labels)
      }

    } catch (err) {
      console.log('Error in RCA chart', err.message);
    }

    $('#priorityLevelChartRca > .spinner-border').hide();
  }
  // Priority Level deviation end


  // Delayed Data Chart Start

  function renderDelayedCharts(delayed, onTime, months) {
    var options = {
      series: [{
        name: 'Delay',
        data: delayed
      },
      {
        name: 'On Time',
        data: onTime
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Deviations'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations"
          }
        }
      }
    };

    var delayedCharts = new ApexCharts(document.querySelector("#delayedCharts"), options);
    delayedCharts.render();
  }

  async function preparedelayedCharts() {
    $('#delayedCharts > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_delayed.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let delayed = []
        let onTime = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          delayed.push(bodyData[key].delayed)
          onTime.push(bodyData[key].onTime)
        }

        renderDelayedCharts(delayed, onTime, labels)
      }

    } catch (err) {
      console.log('Error in RCA chart', err.message);
    }

    $('#delayedCharts > .spinner-border').hide();
  }

  // Delayed Data Chart Ends


  // ChangeControl Delayed Data Chart Start

  function renderChangeControlDelayedCharts(delayed, onTime, months) {
    var options = {
      series: [{
        name: 'Delay',
        data: delayed
      },
      {
        name: 'On Time',
        data: onTime
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Change Control'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " change controls"
          }
        }
      }
    };

    var delayedCharts = new ApexCharts(document.querySelector("#delayedChartsChangeControl"), options);
    delayedCharts.render();
  }

  async function prepareChangeControlDelayedCharts() {
    $('#delayedChartsChangeControl > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_delayedChangeControl.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let delayed = []
        let onTime = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          delayed.push(bodyData[key].delayed)
          onTime.push(bodyData[key].onTime)
        }

        renderChangeControlDelayedCharts(delayed, onTime, labels)
      }

    } catch (err) {
      console.log('Error in RCA chart', err.message);
    }

    $('#delayedChartsChangeControl > .spinner-border').hide();
  }

  // ChangeControl Delayed Data Chart Ends


  // GlobalChangeControl Delayed Data Chart Start

  function renderGlobalChangeControlDelayedCharts(delayed, onTime, months) {
    var options = {
      series: [{
        name: 'Delay',
        data: delayed
      },
      {
        name: 'On Time',
        data: onTime
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Global Change Control'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " Global change controls"
          }
        }
      }
    };
    

    var delayedCharts = new ApexCharts(document.querySelector("#delayedChartsGlobalChangeControl"), options);
    delayedCharts.render();
  }

  async function prepareGlobalChangeControlDelayedCharts() {
    $('#delayedChartsGlobalChangeControl > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_delayedGlobalChangeControl.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let delayed = []
        let onTime = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          delayed.push(bodyData[key].delayed)
          onTime.push(bodyData[key].onTime)
        }

        renderGlobalChangeControlDelayedCharts(delayed, onTime, labels)
      }

    } catch (err) {
      console.log('Error in RCA chart', err.message);
    }

    $('#delayedChartsGlobalChangeControl > .spinner-border').hide();
  }

  // GlobalChangeControl Delayed Data Chart Ends


  // Document by Site Chart Start

  function renderSiteCharts(corporateDate, plantData, months) {
    var options = {
      series: [{
        name: 'Corporate',
        data: corporateDate
      },
      {
        name: 'Plant',
        data: plantData
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of Deviations'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " deviations"
          }
        }
      }
    };

    var documentSiteCharts = new ApexCharts(document.querySelector("#documentSiteCharts"), options);
    documentSiteCharts.render();
  }

  async function prepareSiteCharts() {
    $('#documentSiteCharts > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_site.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let corporate = []
        let plant = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          corporate.push(bodyData[key].corporate)
          plant.push(bodyData[key].plant)
        }

        renderSiteCharts(corporate, plant, labels)
      }

    } catch (err) {
      console.log('Error in Deviations chart', err.message);
    }

    $('#documentSiteCharts > .spinner-border').hide();
  }


  // Document by Site change control Chart Start

  function renderSiteChangeControlCharts(corporateDate, plantData, months) {
    var options = {
      series: [{
        name: 'Corporate',
        data: corporateDate
      },
      {
        name: 'Plant',
        data: plantData
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of ChangeControl'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " ChangeControl"
          }
        }
      }
    };
    

    var documentSiteCharts = new ApexCharts(document.querySelector("#documentSiteChartsChangeControl"), options);
    documentSiteCharts.render();
  }

  async function prepareSiteChangeControlCharts() {
    $('#documentSiteChartsChangeControl > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_siteChangeControl.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let corporate = []
        let plant = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          corporate.push(bodyData[key].corporate)
          plant.push(bodyData[key].plant)
        }

        renderSiteChangeControlCharts(corporate, plant, labels)
      }

    } catch (err) {
      console.log('Error in Deviations chart', err.message);
    }

    $('#documentSiteChartsChangeControl > .spinner-border').hide();
  }

// Document by Site change control Chart ends


  // Document by Site global change control Chart Start

  function renderSiteGlobalChangeControlCharts(corporateDate, plantData, months) {
    var options = {
      series: [{
        name: 'Corporate',
        data: corporateDate
      },
      {
        name: 'Plant',
        data: plantData
      }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: months,
      },
      yaxis: {
        title: {
          text: '# of GlobalChangeControl'
        }
      },
      fill: {
        opacity: 1,
        colors: ['#008FFB', '#00E396']
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " GlobalChangeControl"
          }
        }
      }
    };

    console.log('<<<<<<<<<', options);
    

    var documentSiteCharts = new ApexCharts(document.querySelector("#documentSiteChartsGlobalChangeControl"), options);
    documentSiteCharts.render();
  }

  async function prepareSiteGlobalChangeControlCharts() {
    $('#documentSiteChartsGlobalChangeControl > .spinner-border').show();

    try {
      const url = "{{ route('api.document_by_siteGlobalChangeControl.chart') }}"
      const res = await axios.get(url);


      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let corporate = []
        let plant = []
        let labels = []

        for (const key in bodyData) {
          labels.push(bodyData[key].month)
          corporate.push(bodyData[key].corporate)
          plant.push(bodyData[key].plant)
        }

        renderSiteGlobalChangeControlCharts(corporate, plant, labels)
      }

    } catch (err) {
      console.log('Error in Deviations chart', err.message);
    }

    $('#documentSiteChartsGlobalChangeControl > .spinner-border').hide();
  }

// Document by Site change global control Chart ends

  function renderOverdueRecordDistributionChart(series, labels) {
    var options = {
      series: [
        {
          name: 'Documents',
          data: series
        }
      ],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          distributed: true,
          borderRadius: 4,
          borderRadiusApplication: 'end',
          horizontal: false,
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: labels,
      },
      yaxis: {
        title: {
          text: 'Count'
        }
      }
    };

    var barOptions = {
      series: series,
      chart: {
        width: 450,
        type: 'pie',
      },
      labels,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var documentCategoryChart = new ApexCharts(document.querySelector("#overdueRecordDistributionChart"), options);
    var documentCategoryChartPie = new ApexCharts(document.querySelector("#overdueRecordDistributionChartPie"), barOptions);
    documentCategoryChart.render();
    documentCategoryChartPie.render();
  }

  async function prepareOverdueRecordDistributionChart() {
    $('#overdueRecordDistributionChart > .spinner-border').show();

    try {
      const url = "{{ route('api.overdue_records_by_process_chart.chart') }}"
      const res = await axios.get(url);




      if (res.data.status == 'ok') {
        let bodyData = res.data.body;
        let series = []
        let labels = []

        for (const key in bodyData) {
          labels.push(key)
          series.push(bodyData[key])
        }

        renderOverdueRecordDistributionChart(series, labels)
      }

    } catch (err) {
      console.log('Error in process chart', err.message);
    }

    $('#overdueRecordDistributionChart > .spinner-border').hide();
  }
  // Document by status Charts End

  // prepareProcessChart()
  // prepareDocumentCategoryChart()
  prepareOverdueRecordDistributionChart();
  prepareProcessChart();
  prepareDocumentCategoryChart();
  prepareClassificationDeviationChart();
  prepareDeviationDepartmentChart();
  prepareDocumentOriginatorChart();
  prepareDocumentTypeChart();
  prepareDocumentSixChart();
  prepareDocumentOneChart();
  prepareDocumentTwoChart();
  preparePendingReviewerChart();
  preparePendingApproverChart();
  preparePendingHODChart();
  preparePendingTrainingChart();
  prepareSeverityDeviationChart();
  preparePriorityLevelChart();
  prepareDeviationPriorityLevelChart();
  prepareDeviationStageDistributionChart();
  prepareChangeControlStageDistributionChart();
  prepareChangeControlPriorityLevelChart();
  preparePriorityLevelChartRca();
  preparedelayedCharts();
  prepareChangeControlDelayedCharts();
  prepareGlobalChangeControlDelayedCharts();
  prepareSiteCharts();
  prepareSiteChangeControlCharts();
    preparextensionPriorityLevelChart();
    prepareextensionStageDistributionChart();
  prepareSiteGlobalChangeControlCharts();
  prepareChangeGlobalControlPriorityLevelChart();
  prepareGlobalChangeControlStageDistributionChart();

</script>