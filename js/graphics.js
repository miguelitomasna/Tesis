// Función para obtener los datos de los usuarios
function cargarUsuariosGrafico() {
    fetch('../models/M_Create_User.php', {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        // Contar los usuarios por rol
        const roles = {};
        data.forEach(usuario => {
            if (roles[usuario.rol]) {
                roles[usuario.rol]++;
            } else {
                roles[usuario.rol] = 1;
            }
        });

        // Crear los datos para el gráfico de barras
        const barChartData = {
            labels: Object.keys(roles),
            datasets: [{
                label: 'Usuarios por Rol',
                data: Object.values(roles),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Crear el gráfico de barras
        const ctxBar = document.getElementById('usuariosBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Crear los datos para el gráfico circular
        const pieChartData = {
            labels: Object.keys(roles),
            datasets: [{
                label: 'Distribución de Roles',
                data: Object.values(roles),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Crear el gráfico circular
        const ctxPie = document.getElementById('usuariosPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: pieChartData
        });

        // Crear los datos para el gráfico de porcentaje (Doughnut)
        const doughnutChartData = {
            labels: Object.keys(roles),
            datasets: [{
                label: 'Porcentaje de Roles',
                data: Object.values(roles),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Crear el gráfico de Doughnut (porcentaje)
        const ctxDoughnut = document.getElementById('usuariosDoughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: doughnutChartData
        });

        // Crear los datos para el gráfico de línea (o histograma)
        const lineChartData = {
            labels: Object.keys(roles),
            datasets: [{
                label: 'Usuarios por Rol (Línea)',
                data: Object.values(roles),
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        };

        // Crear el gráfico de líneas
        const ctxLine = document.getElementById('usuariosLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: lineChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error al cargar los datos de los usuarios:', error);
    });
}

// Función para obtener los datos de las solicitudes
function cargarSolicitudesGrafico() {
    fetch('../models/M_Create_Solicitudes.php', {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        // Obtener la cantidad de solicitudes
        const cantidadSolicitudes = data.cantidad_solicitudes;

        // Crear los datos para el gráfico de barras (cantidad de solicitudes)
        const barChartData = {
            labels: ['Solicitudes'],
            datasets: [{
                label: 'Cantidad de Solicitudes',
                data: [cantidadSolicitudes],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Crear el gráfico de barras
        const ctxBar = document.getElementById('solicitudesBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error al cargar las solicitudes:', error);
    });
}

// Llamar a la función para cargar ambos gráficos al cargar la página
window.onload = function() {
    cargarUsuariosGrafico();
    cargarSolicitudesGrafico();
};
