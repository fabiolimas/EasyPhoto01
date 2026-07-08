// Sidebar toggle (mobile)
document.getElementById('menuBtn')?.addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle('open');
});

// Chart.js defaults
if (window.Chart) {
  Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
  Chart.defaults.font.size = 12;
  Chart.defaults.color = '#64748b';
}

// Orders chart (line)
const oc = document.getElementById('ordersChart');
if (oc && window.Chart) {
  const ctx = oc.getContext('2d');
  const grad = ctx.createLinearGradient(0, 0, 0, 260);
  grad.addColorStop(0, 'rgba(79,70,229,.28)');
  grad.addColorStop(1, 'rgba(79,70,229,0)');
  const grad2 = ctx.createLinearGradient(0, 0, 0, 260);
  grad2.addColorStop(0, 'rgba(139,92,246,.18)');
  grad2.addColorStop(1, 'rgba(139,92,246,0)');
  new Chart(oc, {
    type: 'line',
    data: {
      labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      datasets: [
        {
          label: 'Pedidos',
          data: [65,78,72,95,110,132,120,148,162,155,178,196],
          borderColor: '#4f46e5', backgroundColor: grad,
          borderWidth: 2.5, tension: .4, fill: true,
          pointRadius: 0, pointHoverRadius: 5, pointBackgroundColor: '#4f46e5'
        },
        {
          label: 'Finalizados',
          data: [50,60,65,80,92,115,110,130,145,140,160,180],
          borderColor: '#8b5cf6', backgroundColor: grad2,
          borderWidth: 2.5, tension: .4, fill: true,
          pointRadius: 0, pointHoverRadius: 5, pointBackgroundColor: '#8b5cf6'
        }
      ]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { display: true, position: 'top', align: 'end', labels: { boxWidth: 8, boxHeight: 8, usePointStyle: true, pointStyle: 'circle' } },
        tooltip: { backgroundColor: '#0f172a', padding: 10, cornerRadius: 8, displayColors: false }
      },
      scales: {
        x: { grid: { display: false }, border: { display: false } },
        y: { grid: { color: '#eef2f7' }, border: { display: false }, ticks: { padding: 8 } }
      }
    }
  });
}


