
document.addEventListener('DOMContentLoaded', function () {
  const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
  const Default = {
    scrollbarTheme: 'os-theme-light',
    scrollbarAutoHide: 'leave',
    scrollbarClickScroll: true,
  };
  const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
  const isMobile = window.innerWidth <= 992;
  if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined && !isMobile) {
    OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
      scrollbars: {
        theme: Default.scrollbarTheme,
        autoHide: Default.scrollbarAutoHide,
        clickScroll: Default.scrollbarClickScroll,
      },
    });
  }

  if (typeof Sortable !== 'undefined' && document.querySelector('.connectedSortable')) {
    new Sortable(document.querySelector('.connectedSortable'), {
      group: 'shared',
      handle: '.card-header',
    });

    const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
    cardHeaders.forEach((cardHeader) => {
      cardHeader.style.cursor = 'move';
    });
  }

  // ApexCharts (Salary Chart) Configuration
  const hourly_data = {
    hours: [4, 5, 2, 10, 7, 6, 9, 8, 7],
    salary_per_interval: [2000, 500, -1500, 4000, 1000, -500, 1500, 500, 1000],
  };
  
  let cumulative_salary = [];
  let current_total = 0;
  for (let i = 0; i < hourly_data.salary_per_interval.length; i++) {
      current_total += hourly_data.salary_per_interval[i];
      cumulative_salary.push(current_total);
  }

  const sales_chart_options = {
    series: [
      {
        name: 'Cumulative Salary Earned',
        type: 'column',
        data: cumulative_salary,
        yaxisIndex: 1,
      },
      {
        name: 'Working Hours (Line)',
        type: 'line',
        data: hourly_data.hours,
        yaxisIndex: 0,
      },
    ],
    chart: {
      height: 300,
      type: 'line',
      toolbar: {
        show: false,
      },
      stacked: false,
    },
    legend: {
      show: true,
      position: 'top',
    },
    colors: ['#20c997', '#0d6efd'],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: 'smooth',
      width: [0, 3]
    },
    yaxis: [
      {
        axisTicks: { show: true },
        axisBorder: { show: true, color: '#0d6efd' },
        labels: { style: { colors: '#0d6efd' } },
        title: { text: 'Working Hours (Hours)', style: { color: '#0d6efd', fontWeight: 600 } },
        min: 0,
      },
      {
        opposite: true, 
        axisTicks: { show: true },
        axisBorder: { show: true, color: '#20c997' },
        labels: { 
            style: { colors: '#20c997' }, 
            formatter: function (value) { return "$" + value } 
        },
        title: { text: 'Cumulative Salary/Revenue', style: { color: '#20c997', fontWeight: 600 } },
      }
    ],
    xaxis: {
      type: 'category', 
      categories: [
        '09:00 am',
        '10:00 am',
        '11:00 am',
        '12:00 pm',
        '01:00 pm',
        '02:00 pm',
        '03:00 pm',
        '04:00 pm', 
        '06:00 pm',
        '07:00 pm', 
        '08:00 pm', 
        '09:00 pm', 
      ],
    },
    tooltip: {
      x: {
      },
      y: {
        formatter: function (val, { seriesIndex }) {
          if (seriesIndex === 0) {
            return "$" + val.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          } else {
            return val + " hours";
          }
        }
      }
    },
  };

  if (typeof ApexCharts !== 'undefined' && document.querySelector('#revenue-chart')) {
    const sales_chart = new ApexCharts(
      document.querySelector('#revenue-chart'),
      sales_chart_options,
    );
    sales_chart.render();
  }

  // jsVectorMap (World Map) Initialization (Kept for compatibility, though hidden)
  if (typeof jsVectorMap !== 'undefined' && document.querySelector('#world-map')) {
    new jsVectorMap({
      selector: '#world-map', 
      map: 'world', 
    });
  }

  // Worker Status & List Logic 🆕
  const worker_data = [
    { name: 'Ejaz Aslam', job: 'Plumber', status: 'Busy' },
    { name: 'Asma Hatun', job: 'Cook', status: 'Available' },
    { name: 'Muhammad Ali', job: 'Electrician', status: 'Busy' },
    { name: 'Samina Bibi', job: 'Maid', status: 'Available' },
    { name: 'Munib ur Rehman', job: 'Cook', status: 'On Leave' },
    { name: 'Ameer Hamza', job: 'Electrcian', status: 'Busy' },
    { name: 'Razia Begum', job: 'Maid', status: 'Available' },
    { name: 'Ayesha', job: 'Maid', status: 'On Leave' },
  ];

  const workerListElement = document.getElementById('worker-status-list');
  const statusCounts = { available: 0, busy: 0, onleave: 0 };
  
  worker_data.forEach(worker => {
    let badgeClass = '';
    switch (worker.status) {
      case 'Available':
        badgeClass = 'bg-success';
        statusCounts.available++;
        break;
      case 'Busy':
        badgeClass = 'bg-warning';
        statusCounts.busy++;
        break;
      case 'On Leave':
        badgeClass = 'bg-danger';
        statusCounts.onleave++;
        break;
    }

    const listItem = document.createElement('li');
    listItem.className = 'list-group-item d-flex justify-content-between align-items-center text-dark';
    listItem.innerHTML = `
      <div class="fw-bold">${worker.name} <small class="text-secondary">(${worker.job})</small></div>
      <span class="badge ${badgeClass} rounded-pill">${worker.status}</span>
    `;
    workerListElement.appendChild(listItem);
  });

  // Update Summary Counts
  const totalWorkers = document.querySelector('.small-box.text-bg-primary h3');
  const totalCount = worker_data.length;
  if (totalWorkers) {
      totalWorkers.innerHTML = totalCount.toString();
  }

  document.getElementById('status-available').innerText = statusCounts.available.toString();
  document.getElementById('status-busy').innerText = statusCounts.busy.toString();
  document.getElementById('status-onleave').innerText = statusCounts.onleave.toString();
});