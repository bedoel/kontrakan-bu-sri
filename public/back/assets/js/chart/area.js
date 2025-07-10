document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById("transaksiChart");
    if (!ctx) return;

    const bulan = JSON.parse(ctx.dataset.labels);
    const data = JSON.parse(ctx.dataset.values);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Total Transaksi (Rp)',
                data: data,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 3,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                },
                y: {
                    ticks: {
                        callback: function (value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)"
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: "#6e707e",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 15,
                    callbacks: {
                        label: function (tooltipItem) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.raw);
                        }
                    }
                }
            }
        }
    });
});
